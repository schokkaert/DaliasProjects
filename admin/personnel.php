<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

const DALIA_ADMIN_PERSONNEL_FILE = MAATLAS_ADMIN_STORAGE_DIR . '/personnel.php';
const DALIA_ADMIN_PERSONNEL_UPLOAD_DIR = __DIR__ . '/../Images/medewerkers';
const DALIA_ADMIN_PERSONNEL_WEB_DIR = './Images/medewerkers';

function dalia_admin_person_slug(string $value): string
{
    $slug = strtolower(trim($value));
    $slug = preg_replace('~[^a-z0-9]+~', '-', $slug) ?: '';
    return trim($slug, '-');
}

function dalia_admin_personnel_roles(): array
{
    return [
        'Erkend vastgoedmakelaar',
        'Stagiair',
        'Vastgoedmakelaar',
        'Bemiddelaar',
        'Bestuurder',
        'Office Support',
        'Sociale Media',
    ];
}

function dalia_admin_upload_photo(string $field, string $fallback, string $name): string
{
    if (empty($_FILES[$field]) || !is_array($_FILES[$field]) || (int) ($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return $fallback;
    }

    if ((int) $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Foto kon niet worden opgeladen.');
    }

    $tmp = (string) $_FILES[$field]['tmp_name'];
    $info = @getimagesize($tmp);
    if ($info === false) {
        throw new RuntimeException('Gebruik een geldig afbeeldingsbestand.');
    }

    $mime = (string) ($info['mime'] ?? '');
    $extension = match ($mime) {
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        default => throw new RuntimeException('Gebruik jpg, png of webp voor personeelsfoto’s.'),
    };

    if (!is_dir(DALIA_ADMIN_PERSONNEL_UPLOAD_DIR)) {
        mkdir(DALIA_ADMIN_PERSONNEL_UPLOAD_DIR, 0775, true);
    }

    $fileName = dalia_admin_person_slug($name ?: 'medewerker') . '-' . date('YmdHis') . '.' . $extension;
    $target = DALIA_ADMIN_PERSONNEL_UPLOAD_DIR . '/' . $fileName;
    if (!move_uploaded_file($tmp, $target)) {
        throw new RuntimeException('Foto kon niet worden bewaard.');
    }

    return DALIA_ADMIN_PERSONNEL_WEB_DIR . '/' . $fileName;
}

function dalia_admin_normalize_person(array $person, int $index): ?array
{
    $name = trim((string) ($person['name'] ?? ''));
    if ($name === '') {
        return null;
    }

    $roles = $person['roles'] ?? [];
    if (!is_array($roles)) {
        $roles = [];
    }
    $allowed = dalia_admin_personnel_roles();
    $roles = array_values(array_intersect($allowed, array_map('strval', $roles)));

    $photo = trim((string) ($person['photo'] ?? ''));
    $photo = dalia_admin_upload_photo('photo_' . $index, $photo, $name);

    return [
        'id' => dalia_admin_person_slug((string) ($person['id'] ?? $name)) ?: 'persoon-' . ($index + 1),
        'name' => $name,
        'roles' => $roles,
        'biv' => trim((string) ($person['biv'] ?? '')),
        'phone' => trim((string) ($person['phone'] ?? '')),
        'email' => trim((string) ($person['email'] ?? '')),
        'photo' => $photo,
        'active' => !empty($person['active']),
    ];
}

$currentAdmin = maatlas_admin_require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        maatlas_admin_require_csrf();
        $rawPeople = $_POST['people'] ?? [];
        if (!is_array($rawPeople)) {
            throw new RuntimeException('Personeelsgegevens konden niet worden gelezen.');
        }

        $people = [];
        foreach ($rawPeople as $index => $person) {
            if (!is_array($person)) {
                continue;
            }
            $normalized = dalia_admin_normalize_person($person, (int) $index);
            if ($normalized !== null) {
                $people[] = $normalized;
            }
        }

        maatlas_admin_storage_write(DALIA_ADMIN_PERSONNEL_FILE, $people);
        maatlas_admin_flash('Personeel opgeslagen.', 'success');
        maatlas_admin_redirect('./personnel.php');
    } catch (Throwable $exception) {
        maatlas_admin_flash($exception->getMessage(), 'error');
        maatlas_admin_redirect('./personnel.php');
    }
}

$people = maatlas_admin_storage_read(DALIA_ADMIN_PERSONNEL_FILE, []);
$roles = dalia_admin_personnel_roles();
$csrf = maatlas_admin_csrf_token();

maatlas_admin_render_header('Personeel', $currentAdmin);
?>
<nav class="admin-nav" aria-label="Admin navigatie">
  <a class="btn btn--secondary btn--small" href="./">Instellingen</a>
  <a class="btn btn--secondary btn--small" href="./projects.php">Projecten beheren</a>
  <a class="btn btn--secondary btn--small" href="../over.php#personeel">Personeel bekijken</a>
</nav>

<section class="admin-settings-layout">
  <aside class="admin-settings-menu" aria-label="Personeel menu">
    <p class="eyebrow">Personeel</p>
    <?php foreach ($people as $index => $person): ?>
      <a href="#person-<?= maatlas_admin_e($index) ?>"><?= maatlas_admin_e($person['name'] ?? 'Persoon') ?></a>
    <?php endforeach; ?>
    <a href="#opslaan">Opslaan</a>
  </aside>

  <article class="admin-card admin-settings-panel">
    <p class="eyebrow">Over ons</p>
    <h2>Personeel beheren</h2>
    <p class="admin-help">Upload een foto, kies functies en vul contactgegevens in. Functies worden op de site met koppeltekens weergegeven.</p>

    <form method="post" enctype="multipart/form-data" class="admin-form admin-form--single admin-project-form" data-floating-submit>
      <input type="hidden" name="csrf" value="<?= maatlas_admin_e($csrf) ?>" />

      <?php foreach ($people as $index => $person): ?>
        <?php $selectedRoles = is_array($person['roles'] ?? null) ? $person['roles'] : []; ?>
        <fieldset id="person-<?= maatlas_admin_e($index) ?>" class="admin-settings-section admin-project-fieldset">
          <legend><?= maatlas_admin_e($person['name'] ?? 'Persoon') ?></legend>
          <input type="hidden" name="people[<?= maatlas_admin_e($index) ?>][id]" value="<?= maatlas_admin_e($person['id'] ?? '') ?>" />
          <input type="hidden" name="people[<?= maatlas_admin_e($index) ?>][photo]" value="<?= maatlas_admin_e($person['photo'] ?? '') ?>" />
          <div class="admin-person-preview">
            <div class="admin-person-preview__photo">
              <img src="../<?= maatlas_admin_e(ltrim((string) ($person['photo'] ?? ''), './')) ?>" alt="<?= maatlas_admin_e($person['name'] ?? '') ?>" />
            </div>
            <div>
              <strong><?= maatlas_admin_e($person['name'] ?? '') ?></strong>
              <p><?= maatlas_admin_e(implode(' - ', array_filter([...$selectedRoles, !empty($person['biv']) ? 'BIV ' . $person['biv'] : '']))) ?></p>
            </div>
          </div>
          <div class="admin-project-grid">
            <label>
              Naam
              <input type="text" name="people[<?= maatlas_admin_e($index) ?>][name]" value="<?= maatlas_admin_e($person['name'] ?? '') ?>" required />
            </label>
            <label>
              BIV
              <input type="text" name="people[<?= maatlas_admin_e($index) ?>][biv]" value="<?= maatlas_admin_e($person['biv'] ?? '') ?>" placeholder="519 939" />
            </label>
            <label>
              Telefoon
              <input type="text" name="people[<?= maatlas_admin_e($index) ?>][phone]" value="<?= maatlas_admin_e($person['phone'] ?? '') ?>" />
            </label>
            <label>
              E-mail
              <input type="email" name="people[<?= maatlas_admin_e($index) ?>][email]" value="<?= maatlas_admin_e($person['email'] ?? '') ?>" />
            </label>
            <label>
              Foto upload
              <input type="file" name="photo_<?= maatlas_admin_e($index) ?>" accept="image/png,image/jpeg,image/webp" />
            </label>
          </div>
          <div class="admin-role-grid">
            <?php foreach ($roles as $role): ?>
              <label class="admin-check">
                <input type="checkbox" name="people[<?= maatlas_admin_e($index) ?>][roles][]" value="<?= maatlas_admin_e($role) ?>" <?= in_array($role, $selectedRoles, true) ? 'checked' : '' ?> />
                <?= maatlas_admin_e($role) ?>
              </label>
            <?php endforeach; ?>
          </div>
          <label class="admin-check">
            <input type="checkbox" name="people[<?= maatlas_admin_e($index) ?>][active]" <?= !empty($person['active']) ? 'checked' : '' ?> />
            Tonen op de site
          </label>
        </fieldset>
      <?php endforeach; ?>

      <div id="opslaan" class="button-row admin-settings-section">
        <button class="btn btn--primary" type="submit">Personeel opslaan</button>
      </div>
    </form>
  </article>
</section>
<?php
maatlas_admin_render_footer();
