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

$currentAdmin = maatlas_admin_require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        maatlas_admin_require_csrf();
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

maatlas_admin_render_header('Projecten beheren', $currentAdmin);
?>
<nav class="admin-nav" aria-label="Admin navigatie">
  <a class="btn btn--secondary btn--small" href="./">Instellingen</a>
  <a class="btn btn--secondary btn--small" href="./administrators.php">Beheerders</a>
  <a class="btn btn--secondary btn--small" href="../projecten.php">Portfolio bekijken</a>
</nav>

<section class="admin-settings-layout">
  <aside class="admin-settings-menu" aria-label="Projecten menu">
    <p class="eyebrow">Projecten</p>
    <?php foreach ($projects as $index => $project): ?>
      <a href="#project-<?= maatlas_admin_e($index) ?>"><?= maatlas_admin_e($project['title'] ?? 'Project') ?></a>
    <?php endforeach; ?>
    <a href="#opslaan">Opslaan</a>
  </aside>

  <article class="admin-card admin-settings-panel">
    <p class="eyebrow">Portfolio</p>
    <h2>Lopende, toekomstige en gerealiseerde projecten</h2>
    <p class="admin-help">De groep bepaalt waar de tegel verschijnt. Alleen lopende projecten klikken door naar een detailpagina.</p>

    <form method="post" class="admin-form admin-form--single admin-project-form" data-floating-submit>
      <input type="hidden" name="csrf" value="<?= maatlas_admin_e($csrf) ?>" />

      <?php foreach ($projects as $index => $project): ?>
        <fieldset id="project-<?= maatlas_admin_e($index) ?>" class="admin-settings-section admin-project-fieldset">
          <legend><?= maatlas_admin_e($project['title'] ?? 'Project') ?></legend>
          <input type="hidden" name="projects[<?= maatlas_admin_e($index) ?>][slug]" value="<?= maatlas_admin_e($project['slug'] ?? '') ?>" />
          <div class="admin-project-grid">
            <label>
              Groep
              <select name="projects[<?= maatlas_admin_e($index) ?>][group]">
                <?php foreach (['current' => 'Lopend', 'future' => 'Toekomstig', 'realized' => 'Gerealiseerd'] as $value => $label): ?>
                  <option value="<?= maatlas_admin_e($value) ?>" <?= (($project['group'] ?? '') === $value) ? 'selected' : '' ?>><?= maatlas_admin_e($label) ?></option>
                <?php endforeach; ?>
              </select>
            </label>
            <label>
              Titel
              <input type="text" name="projects[<?= maatlas_admin_e($index) ?>][title]" value="<?= maatlas_admin_e($project['title'] ?? '') ?>" required />
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
            <label>
              Belangrijke info
              <input type="text" name="projects[<?= maatlas_admin_e($index) ?>][highlight]" value="<?= maatlas_admin_e($project['highlight'] ?? '') ?>" />
            </label>
            <label>
              Info en verkoop
              <input type="text" name="projects[<?= maatlas_admin_e($index) ?>][sales_office]" value="<?= maatlas_admin_e($project['sales_office'] ?? '') ?>" />
            </label>
            <label>
              Externe verkooplink
              <input type="url" name="projects[<?= maatlas_admin_e($index) ?>][sales_url]" value="<?= maatlas_admin_e($project['sales_url'] ?? '') ?>" placeholder="https://www.sbcvastgoed.be/" />
            </label>
            <label>
              Render / hoofdbeeld
              <input type="text" name="projects[<?= maatlas_admin_e($index) ?>][hero]" value="<?= maatlas_admin_e($project['hero'] ?? '') ?>" />
            </label>
          </div>
          <label>
            Korte omschrijving
            <textarea name="projects[<?= maatlas_admin_e($index) ?>][summary]" rows="3"><?= maatlas_admin_e($project['summary'] ?? '') ?></textarea>
          </label>
          <label>
            Projectomschrijving detailpagina
            <textarea name="projects[<?= maatlas_admin_e($index) ?>][quote]" rows="4"><?= maatlas_admin_e($project['quote'] ?? '') ?></textarea>
          </label>
          <label>
            Context detailpagina
            <textarea name="projects[<?= maatlas_admin_e($index) ?>][context]" rows="4"><?= maatlas_admin_e($project['context'] ?? '') ?></textarea>
          </label>
          <label>
            Slideshow beelden, 1 URL per regel
            <textarea name="projects[<?= maatlas_admin_e($index) ?>][gallery]" rows="4"><?= maatlas_admin_e(implode("\n", is_array($project['gallery'] ?? null) ? $project['gallery'] : [])) ?></textarea>
          </label>
          <label class="admin-check">
            <input type="checkbox" name="projects[<?= maatlas_admin_e($index) ?>][active]" <?= !empty($project['active']) ? 'checked' : '' ?> />
            Tonen op de site
          </label>
        </fieldset>
      <?php endforeach; ?>

      <div id="opslaan" class="button-row admin-settings-section">
        <button class="btn btn--primary" type="submit">Projecten opslaan</button>
      </div>
    </form>
  </article>
</section>
<?php
maatlas_admin_render_footer();
