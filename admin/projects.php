<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

const DALIA_ADMIN_PROJECTS_FILE = MAATLAS_ADMIN_STORAGE_DIR . '/projects.php';

function dalia_admin_project_slug(string $value): string
{
    $slug = strtolower(trim($value));
    $slug = preg_replace('~[^a-z0-9]+~', '-', $slug) ?: '';
    return trim($slug, '-');
}

function dalia_admin_project_lines(mixed $value): array
{
    if (is_array($value)) {
        $items = $value;
    } else {
        $items = preg_split('~\R+~', (string) $value) ?: [];
    }

    return array_values(array_filter(array_map(
        static fn (mixed $item): string => trim((string) $item),
        $items
    )));
}

function dalia_admin_project_group_labels(): array
{
    return [
        'current' => 'Lopend',
        'future' => 'Toekomstig',
        'realized' => 'Gerealiseerd',
    ];
}

function dalia_admin_empty_project(int $index): array
{
    $number = $index + 1;

    return [
        'slug' => 'nieuw-project-' . $number,
        'group' => 'current',
        'title' => 'Nieuw project ' . $number,
        'location' => '',
        'type' => '',
        'status' => '',
        'sales_start' => '',
        'highlight' => '',
        'sales_office' => '',
        'sales_url' => '',
        'summary' => '',
        'quote' => '',
        'context' => '',
        'hero' => '',
        'gallery' => [],
        'active' => false,
    ];
}

function dalia_admin_project_local_asset_relative_path(string $value): ?string
{
    $normalized = str_replace('\\', '/', trim($value));
    if ($normalized === '' || preg_match('~^https?://~i', $normalized)) {
        return null;
    }

    $normalized = preg_replace('~^(\./|/)+~', '', $normalized) ?? '';
    if ($normalized === '' || str_contains($normalized, '../')) {
        return null;
    }

    if (!preg_match('~^(Images|Webimages)/~i', $normalized)) {
        return null;
    }

    return $normalized;
}

function dalia_admin_project_local_asset_key(string $value): ?string
{
    $relativePath = dalia_admin_project_local_asset_relative_path($value);
    return $relativePath !== null ? strtolower($relativePath) : null;
}

function dalia_admin_project_asset_path(string $value): ?string
{
    $relativePath = dalia_admin_project_local_asset_relative_path($value);
    if ($relativePath === null) {
        return null;
    }

    $root = realpath(__DIR__ . '/..');
    if ($root === false) {
        return null;
    }

    $path = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relativePath);
    $directory = realpath(dirname($path));
    if ($directory === false) {
        return null;
    }

    $rootNormalized = str_replace('\\', '/', $root);
    $directoryNormalized = str_replace('\\', '/', $directory);
    if (!str_starts_with($directoryNormalized, $rootNormalized)) {
        return null;
    }

    return $path;
}

function dalia_admin_project_local_assets(array $project): array
{
    $assets = [];
    $gallery = is_array($project['gallery'] ?? null) ? $project['gallery'] : [];

    foreach ([trim((string) ($project['hero'] ?? '')), ...array_map('strval', $gallery)] as $asset) {
        $key = dalia_admin_project_local_asset_key($asset);
        if ($key !== null) {
            $assets[$key] = $asset;
        }
    }

    return $assets;
}

function dalia_admin_delete_project_assets(array $project, array $otherProjects): void
{
    $protected = [];
    foreach ($otherProjects as $otherProject) {
        if (!is_array($otherProject)) {
            continue;
        }

        foreach (array_keys(dalia_admin_project_local_assets($otherProject)) as $key) {
            $protected[$key] = true;
        }
    }

    foreach (dalia_admin_project_local_assets($project) as $key => $asset) {
        if (isset($protected[$key])) {
            continue;
        }

        $path = dalia_admin_project_asset_path($asset);
        if ($path !== null && is_file($path)) {
            @unlink($path);
        }
    }
}

function dalia_admin_normalize_project(array $project, int $index): ?array
{
    $title = trim((string) ($project['title'] ?? ''));
    if ($title === '') {
        return null;
    }

    $slug = dalia_admin_project_slug((string) ($project['slug'] ?? $title));
    if ($slug === '') {
        $slug = 'project-' . ($index + 1);
    }

    $group = trim((string) ($project['group'] ?? 'current'));
    if (!in_array($group, ['current', 'future', 'realized'], true)) {
        $group = 'current';
    }

    return [
        'slug' => $slug,
        'group' => $group,
        'title' => $title,
        'location' => trim((string) ($project['location'] ?? '')),
        'type' => trim((string) ($project['type'] ?? '')),
        'status' => trim((string) ($project['status'] ?? '')),
        'sales_start' => trim((string) ($project['sales_start'] ?? '')),
        'highlight' => trim((string) ($project['highlight'] ?? '')),
        'sales_office' => trim((string) ($project['sales_office'] ?? '')),
        'sales_url' => trim((string) ($project['sales_url'] ?? '')),
        'summary' => trim((string) ($project['summary'] ?? '')),
        'quote' => trim((string) ($project['quote'] ?? '')),
        'context' => trim((string) ($project['context'] ?? '')),
        'hero' => trim((string) ($project['hero'] ?? '')),
        'gallery' => dalia_admin_project_lines($project['gallery'] ?? []),
        'active' => !empty($project['active']),
    ];
}

function dalia_admin_project_stat_count(array $projects, string $group): int
{
    return count(array_filter(
        $projects,
        static fn (array $project): bool => (($project['group'] ?? 'current') === $group)
    ));
}

$currentAdmin = maatlas_admin_require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        maatlas_admin_require_csrf();
        $storedProjects = maatlas_admin_storage_read(DALIA_ADMIN_PROJECTS_FILE, []);

        if (isset($_POST['add_project'])) {
            $storedProjects[] = dalia_admin_empty_project(count($storedProjects));
            maatlas_admin_storage_write(DALIA_ADMIN_PROJECTS_FILE, $storedProjects);
            maatlas_admin_flash('Nieuw project toegevoegd. Vul de gegevens aan en sla op.', 'success');
            maatlas_admin_redirect('./projects.php#project-' . (count($storedProjects) - 1));
        }

        if (isset($_POST['toggle_project'])) {
            $index = filter_var($_POST['toggle_project'], FILTER_VALIDATE_INT);
            if ($index === false || !isset($storedProjects[$index])) {
                throw new RuntimeException('Project kon niet worden gevonden.');
            }

            $storedProjects[$index]['active'] = empty($storedProjects[$index]['active']);
            maatlas_admin_storage_write(DALIA_ADMIN_PROJECTS_FILE, $storedProjects);
            maatlas_admin_flash(!empty($storedProjects[$index]['active']) ? 'Project geactiveerd.' : 'Project gedeactiveerd.', 'success');
            maatlas_admin_redirect('./projects.php#project-' . $index);
        }

        if (isset($_POST['delete_project'])) {
            $index = filter_var($_POST['delete_project'], FILTER_VALIDATE_INT);
            if ($index === false || !isset($storedProjects[$index])) {
                throw new RuntimeException('Project kon niet worden gevonden.');
            }

            $project = $storedProjects[$index];
            $otherProjects = $storedProjects;
            unset($otherProjects[$index]);
            dalia_admin_delete_project_assets($project, $otherProjects);

            array_splice($storedProjects, $index, 1);
            maatlas_admin_storage_write(DALIA_ADMIN_PROJECTS_FILE, array_values($storedProjects));
            maatlas_admin_flash('Project verwijderd. Niet-gedeelde lokale projectbeelden zijn ook verwijderd.', 'success');
            maatlas_admin_redirect('./projects.php');
        }

        $rawProjects = $_POST['projects'] ?? [];
        if (!is_array($rawProjects)) {
            throw new RuntimeException('Projecten konden niet worden gelezen.');
        }

        $projects = [];
        foreach ($rawProjects as $index => $project) {
            if (!is_array($project)) {
                continue;
            }

            $normalized = dalia_admin_normalize_project($project, (int) $index);
            if ($normalized !== null) {
                $projects[] = $normalized;
            }
        }

        maatlas_admin_storage_write(DALIA_ADMIN_PROJECTS_FILE, $projects);
        maatlas_admin_flash('Projecten opgeslagen.', 'success');
        maatlas_admin_redirect('./projects.php');
    } catch (Throwable $exception) {
        maatlas_admin_flash($exception->getMessage(), 'error');
        maatlas_admin_redirect('./projects.php');
    }
}

$projects = maatlas_admin_storage_read(DALIA_ADMIN_PROJECTS_FILE, []);
$csrf = maatlas_admin_csrf_token();
$groupLabels = dalia_admin_project_group_labels();
$activeProjectCount = count(array_filter(
    $projects,
    static fn (array $project): bool => !empty($project['active'])
));
$inactiveProjectCount = count($projects) - $activeProjectCount;

maatlas_admin_render_header('Projecten beheren', $currentAdmin);
?>
<nav class="admin-nav" aria-label="Admin navigatie">
  <a class="btn btn--secondary btn--small" href="./">Instellingen</a>
  <a class="btn btn--secondary btn--small" href="./administrators.php">Beheerders</a>
  <a class="btn btn--secondary btn--small" href="../projecten.php">Portfolio bekijken</a>
</nav>

<section class="admin-stats">
  <article class="admin-stat">
    <span>Projecten</span>
    <strong><?= maatlas_admin_e(count($projects)) ?></strong>
    <small>Totaal in beheer</small>
  </article>
  <article class="admin-stat">
    <span>Actief</span>
    <strong><?= maatlas_admin_e($activeProjectCount) ?></strong>
    <small>Zichtbaar op de site</small>
  </article>
  <article class="admin-stat">
    <span>Gedeactiveerd</span>
    <strong><?= maatlas_admin_e($inactiveProjectCount) ?></strong>
    <small>Verborgen voor bezoekers</small>
  </article>
  <article class="admin-stat">
    <span>Lopend</span>
    <strong><?= maatlas_admin_e(dalia_admin_project_stat_count($projects, 'current')) ?></strong>
    <small>Projecten in uitvoering</small>
  </article>
</section>

<section class="admin-settings-layout">
  <aside class="admin-settings-menu" aria-label="Projecten menu">
    <p class="eyebrow">Projecten</p>
    <div class="admin-settings-menu__group">
      <p class="admin-settings-menu__title">Beheer</p>
      <?php if ($projects === []): ?>
        <p class="admin-muted">Nog geen projecten beschikbaar.</p>
      <?php else: ?>
        <?php foreach ($projects as $index => $project): ?>
          <?php $isActive = !empty($project['active']); ?>
          <a class="admin-project-menu-link <?= $isActive ? 'is-on' : 'is-off' ?>" href="#project-<?= maatlas_admin_e($index) ?>">
            <span class="admin-project-menu-link__name"><?= maatlas_admin_e($project['title'] ?? 'Project') ?></span>
            <span class="admin-pill <?= $isActive ? 'is-on' : 'is-off' ?>"><?= $isActive ? 'Actief' : 'Uit' ?></span>
          </a>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    <a href="#opslaan">Opslaan</a>
  </aside>

  <article class="admin-card admin-settings-panel">
    <p class="eyebrow">Portfolio</p>
    <h2>Projecten beheren</h2>
    <div class="admin-project-toolbar">
      <p class="admin-help">Compact beheer voor aanmaken, activeren, deactiveren en verwijderen. Bij verwijderen worden niet-gedeelde lokale beelden uit <code>Images/</code> of <code>Webimages/</code> ook mee verwijderd.</p>
      <div class="admin-project-toolbar__actions">
        <form method="post">
          <input type="hidden" name="csrf" value="<?= maatlas_admin_e($csrf) ?>" />
          <button class="btn btn--primary btn--small" type="submit" name="add_project" value="1">Nieuw project</button>
        </form>
      </div>
    </div>

    <form method="post" class="admin-form admin-form--single admin-project-form" data-floating-submit>
      <input type="hidden" name="csrf" value="<?= maatlas_admin_e($csrf) ?>" />

      <?php foreach ($projects as $index => $project): ?>
        <?php
          $isActive = !empty($project['active']);
          $group = (string) ($project['group'] ?? 'current');
          $groupLabel = $groupLabels[$group] ?? 'Lopend';
          $title = trim((string) ($project['title'] ?? 'Project'));
          $location = trim((string) ($project['location'] ?? ''));
        ?>
        <fieldset id="project-<?= maatlas_admin_e($index) ?>" class="admin-settings-section admin-project-fieldset admin-project-card <?= $isActive ? 'is-active' : 'is-inactive' ?>">
          <legend><?= maatlas_admin_e($title !== '' ? $title : 'Project') ?></legend>
          <input type="hidden" name="projects[<?= maatlas_admin_e($index) ?>][slug]" value="<?= maatlas_admin_e($project['slug'] ?? '') ?>" />
          <input type="hidden" name="projects[<?= maatlas_admin_e($index) ?>][active]" value="<?= $isActive ? '1' : '0' ?>" />

          <div class="admin-project-card__top">
            <div class="admin-project-card__summary">
              <div class="admin-project-card__badges">
                <span class="admin-pill <?= $isActive ? 'is-on' : 'is-off' ?>"><?= $isActive ? 'Actief op site' : 'Gedeactiveerd' ?></span>
                <span class="admin-pill"><?= maatlas_admin_e($groupLabel) ?></span>
              </div>
              <h3><?= maatlas_admin_e($title !== '' ? $title : 'Project') ?></h3>
              <p><?= maatlas_admin_e($location !== '' ? $location : 'Nog geen locatie ingevuld') ?></p>
            </div>
            <div class="admin-actions admin-actions--project">
              <button class="btn btn--secondary btn--small" type="submit" name="toggle_project" value="<?= maatlas_admin_e($index) ?>" formnovalidate>
                <?= $isActive ? 'Deactiveer' : 'Activeer' ?>
              </button>
              <button class="btn btn--danger btn--small" type="submit" name="delete_project" value="<?= maatlas_admin_e($index) ?>" formnovalidate onclick="return confirm('Project verwijderen? Niet-gedeelde lokale projectbeelden worden ook verwijderd.');">
                Verwijder
              </button>
            </div>
          </div>

          <div class="admin-project-grid admin-project-grid--meta">
            <label>
              Titel
              <input type="text" name="projects[<?= maatlas_admin_e($index) ?>][title]" value="<?= maatlas_admin_e($project['title'] ?? '') ?>" required />
            </label>
            <label>
              Groep
              <select name="projects[<?= maatlas_admin_e($index) ?>][group]">
                <?php foreach ($groupLabels as $value => $label): ?>
                  <option value="<?= maatlas_admin_e($value) ?>" <?= (($project['group'] ?? '') === $value) ? 'selected' : '' ?>><?= maatlas_admin_e($label) ?></option>
                <?php endforeach; ?>
              </select>
            </label>
            <label>
              Locatie
              <input type="text" name="projects[<?= maatlas_admin_e($index) ?>][location]" value="<?= maatlas_admin_e($project['location'] ?? '') ?>" />
            </label>
            <label>
              Type
              <input type="text" name="projects[<?= maatlas_admin_e($index) ?>][type]" value="<?= maatlas_admin_e($project['type'] ?? '') ?>" />
            </label>
            <label>
              Status
              <input type="text" name="projects[<?= maatlas_admin_e($index) ?>][status]" value="<?= maatlas_admin_e($project['status'] ?? '') ?>" />
            </label>
            <label>
              Start verkoop
              <input type="text" name="projects[<?= maatlas_admin_e($index) ?>][sales_start]" value="<?= maatlas_admin_e($project['sales_start'] ?? '') ?>" />
            </label>
          </div>

          <div class="admin-project-grid admin-project-grid--details">
            <label>
              Belangrijke info
              <input type="text" name="projects[<?= maatlas_admin_e($index) ?>][highlight]" value="<?= maatlas_admin_e($project['highlight'] ?? '') ?>" />
            </label>
            <label>
              Info en verkoop
              <input type="text" name="projects[<?= maatlas_admin_e($index) ?>][sales_office]" value="<?= maatlas_admin_e($project['sales_office'] ?? '') ?>" />
            </label>
            <label class="admin-project-field--wide">
              Externe verkooplink
              <input type="url" name="projects[<?= maatlas_admin_e($index) ?>][sales_url]" value="<?= maatlas_admin_e($project['sales_url'] ?? '') ?>" placeholder="https://www.sbcvastgoed.be/" />
            </label>
            <label class="admin-project-field--wide">
              Render / hoofdbeeld
              <input type="text" name="projects[<?= maatlas_admin_e($index) ?>][hero]" value="<?= maatlas_admin_e($project['hero'] ?? '') ?>" placeholder="/Images/project.jpg of https://..." />
            </label>
          </div>

          <div class="admin-project-grid admin-project-grid--text">
            <label>
              Korte omschrijving
              <textarea name="projects[<?= maatlas_admin_e($index) ?>][summary]" rows="2"><?= maatlas_admin_e($project['summary'] ?? '') ?></textarea>
            </label>
            <label>
              Projectomschrijving detailpagina
              <textarea name="projects[<?= maatlas_admin_e($index) ?>][quote]" rows="3"><?= maatlas_admin_e($project['quote'] ?? '') ?></textarea>
            </label>
            <label>
              Context detailpagina
              <textarea name="projects[<?= maatlas_admin_e($index) ?>][context]" rows="3"><?= maatlas_admin_e($project['context'] ?? '') ?></textarea>
            </label>
            <label>
              Slideshow beelden, 1 URL of pad per regel
              <textarea name="projects[<?= maatlas_admin_e($index) ?>][gallery]" rows="3"><?= maatlas_admin_e(implode("\n", is_array($project['gallery'] ?? null) ? $project['gallery'] : [])) ?></textarea>
            </label>
          </div>
        </fieldset>
      <?php endforeach; ?>

      <?php if ($projects === []): ?>
        <div class="admin-project-empty admin-settings-section">
          <p>Er zijn nog geen projecten. Voeg eerst een nieuw project toe.</p>
          <button class="btn btn--primary btn--small" type="submit" name="add_project" value="1" formnovalidate>Nieuw project</button>
        </div>
      <?php endif; ?>

      <div id="opslaan" class="button-row admin-settings-section">
        <button class="btn btn--primary" type="submit">Projecten opslaan</button>
      </div>
    </form>
  </article>
</section>
<?php
maatlas_admin_render_footer();
