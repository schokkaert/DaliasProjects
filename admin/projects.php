<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

const DALIA_ADMIN_PROJECTS_FILE = MAATLAS_ADMIN_STORAGE_DIR . '/projects.php';
const DALIA_ADMIN_PROJECT_IMAGE_UPLOAD_DIR = __DIR__ . '/../Images/projecten';
const DALIA_ADMIN_PROJECT_IMAGE_WEB_DIR = './Images/projecten';

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

function dalia_admin_project_images(array $project): array
{
    $items = [];
    $hero = trim((string) ($project['hero'] ?? ''));
    $gallery = is_array($project['gallery'] ?? null) ? $project['gallery'] : [];

    foreach ([$hero, ...array_map('strval', $gallery)] as $asset) {
        $asset = trim($asset);
        if ($asset === '') {
            continue;
        }

        if (!isset($items[$asset])) {
            $items[$asset] = [
                'src' => $asset,
                'is_hero' => false,
                'in_gallery' => false,
                'is_local' => dalia_admin_project_asset_path($asset) !== null,
            ];
        }

        if ($asset === $hero) {
            $items[$asset]['is_hero'] = true;
        }

        if (in_array($asset, $gallery, true)) {
            $items[$asset]['in_gallery'] = true;
        }
    }

    return array_values($items);
}

function dalia_admin_project_image_payload(string $action, int $index, string $asset): string
{
    return $action . '|' . $index . '|' . base64_encode($asset);
}

function dalia_admin_parse_project_image_payload(string $payload): ?array
{
    $parts = explode('|', $payload, 3);
    if (count($parts) !== 3) {
        return null;
    }

    [$action, $indexRaw, $assetEncoded] = $parts;
    $index = filter_var($indexRaw, FILTER_VALIDATE_INT);
    $asset = base64_decode($assetEncoded, true);
    if ($index === false || $asset === false || $asset === '') {
        return null;
    }

    return [
        'action' => $action,
        'index' => $index,
        'asset' => $asset,
    ];
}

function dalia_admin_project_image_exists(array $project, string $asset): bool
{
    foreach (dalia_admin_project_images($project) as $image) {
        if (($image['src'] ?? '') === $asset) {
            return true;
        }
    }

    return false;
}

function dalia_admin_project_remove_image(array $project, string $asset): array
{
    $project['gallery'] = array_values(array_filter(
        is_array($project['gallery'] ?? null) ? $project['gallery'] : [],
        static fn (mixed $item): bool => trim((string) $item) !== trim($asset)
    ));

    if (trim((string) ($project['hero'] ?? '')) === trim($asset)) {
        $project['hero'] = $project['gallery'][0] ?? '';
    }

    return $project;
}

function dalia_admin_project_set_hero(array $project, string $asset): array
{
    $asset = trim($asset);
    if ($asset === '') {
        return $project;
    }

    if (!in_array($asset, is_array($project['gallery'] ?? null) ? $project['gallery'] : [], true)) {
        $project['gallery'] = array_values(array_filter([
            $asset,
            ...(is_array($project['gallery'] ?? null) ? $project['gallery'] : []),
        ]));
    }

    $project['hero'] = $asset;
    return $project;
}

function dalia_admin_project_cleanup_asset_if_unused(string $asset, array $projects): void
{
    $key = dalia_admin_project_local_asset_key($asset);
    if ($key === null) {
        return;
    }

    foreach ($projects as $project) {
        if (!is_array($project)) {
            continue;
        }

        foreach (array_keys(dalia_admin_project_local_assets($project)) as $usedKey) {
            if ($usedKey === $key) {
                return;
            }
        }
    }

    $path = dalia_admin_project_asset_path($asset);
    if ($path !== null && is_file($path)) {
        @unlink($path);
    }
}

function dalia_admin_project_open_image(string $path): array
{
    $info = @getimagesize($path);
    if ($info === false) {
        throw new RuntimeException('Afbeelding kon niet worden gelezen.');
    }

    $mime = (string) ($info['mime'] ?? '');
    $image = match ($mime) {
        'image/jpeg' => @imagecreatefromjpeg($path),
        'image/png' => @imagecreatefrompng($path),
        'image/webp' => @imagecreatefromwebp($path),
        default => false,
    };

    if ($image === false) {
        throw new RuntimeException('Afbeelding kon niet worden geopend voor bewerking.');
    }

    return [$image, $mime];
}

function dalia_admin_project_prepare_alpha(GdImage $image, string $mime): void
{
    if ($mime === 'image/png' || $mime === 'image/webp') {
        imagealphablending($image, false);
        imagesavealpha($image, true);
    }
}

function dalia_admin_project_save_image(GdImage $image, string $path, string $mime): void
{
    dalia_admin_project_prepare_alpha($image, $mime);

    $saved = match ($mime) {
        'image/jpeg' => imagejpeg($image, $path, 90),
        'image/png' => imagepng($image, $path, 6),
        'image/webp' => imagewebp($image, $path, 90),
        default => false,
    };

    if ($saved === false) {
        throw new RuntimeException('Afbeelding kon niet worden opgeslagen.');
    }
}

function dalia_admin_project_rotate_image(string $asset, int $degrees): void
{
    $path = dalia_admin_project_asset_path($asset);
    if ($path === null || !is_file($path)) {
        throw new RuntimeException('Alleen lokale projectafbeeldingen kunnen worden gedraaid.');
    }

    [$image, $mime] = dalia_admin_project_open_image($path);
    $background = ($mime === 'image/png' || $mime === 'image/webp') ? imagecolorallocatealpha($image, 0, 0, 0, 127) : 0;
    $rotated = imagerotate($image, $degrees, $background);
    if ($rotated === false) {
        imagedestroy($image);
        throw new RuntimeException('Afbeelding kon niet worden gedraaid.');
    }

    dalia_admin_project_prepare_alpha($rotated, $mime);
    dalia_admin_project_save_image($rotated, $path, $mime);
    imagedestroy($image);
    imagedestroy($rotated);
}

function dalia_admin_project_crop_image(string $asset, float $ratio): void
{
    $path = dalia_admin_project_asset_path($asset);
    if ($path === null || !is_file($path)) {
        throw new RuntimeException('Alleen lokale projectafbeeldingen kunnen worden gecropt.');
    }

    [$image, $mime] = dalia_admin_project_open_image($path);
    $width = imagesx($image);
    $height = imagesy($image);
    if ($width < 2 || $height < 2) {
        imagedestroy($image);
        throw new RuntimeException('Afbeelding is te klein om te croppen.');
    }

    $currentRatio = $width / $height;
    if ($currentRatio > $ratio) {
        $cropWidth = (int) round($height * $ratio);
        $cropHeight = $height;
        $srcX = (int) floor(($width - $cropWidth) / 2);
        $srcY = 0;
    } else {
        $cropWidth = $width;
        $cropHeight = (int) round($width / $ratio);
        $srcX = 0;
        $srcY = (int) floor(($height - $cropHeight) / 2);
    }

    $cropped = imagecrop($image, [
        'x' => $srcX,
        'y' => $srcY,
        'width' => max(1, $cropWidth),
        'height' => max(1, $cropHeight),
    ]);

    if ($cropped === false) {
        imagedestroy($image);
        throw new RuntimeException('Afbeelding kon niet worden gecropt.');
    }

    dalia_admin_project_prepare_alpha($cropped, $mime);
    dalia_admin_project_save_image($cropped, $path, $mime);
    imagedestroy($image);
    imagedestroy($cropped);
}

function dalia_admin_upload_project_images(string $field, string $projectTitle): array
{
    if (empty($_FILES[$field]) || !is_array($_FILES[$field])) {
        throw new RuntimeException('Geen afbeeldingen geselecteerd.');
    }

    $names = $_FILES[$field]['name'] ?? [];
    $tmpNames = $_FILES[$field]['tmp_name'] ?? [];
    $errors = $_FILES[$field]['error'] ?? [];

    if (!is_array($names) || !is_array($tmpNames) || !is_array($errors)) {
        throw new RuntimeException('Uploadgegevens konden niet worden gelezen.');
    }

    if (!is_dir(DALIA_ADMIN_PROJECT_IMAGE_UPLOAD_DIR)) {
        mkdir(DALIA_ADMIN_PROJECT_IMAGE_UPLOAD_DIR, 0775, true);
    }

    $saved = [];
    foreach ($names as $position => $_name) {
        $error = (int) ($errors[$position] ?? UPLOAD_ERR_NO_FILE);
        if ($error === UPLOAD_ERR_NO_FILE) {
            continue;
        }

        if ($error !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Een projectafbeelding kon niet worden opgeladen.');
        }

        $tmp = (string) ($tmpNames[$position] ?? '');
        $info = @getimagesize($tmp);
        if ($info === false) {
            throw new RuntimeException('Gebruik geldige jpg-, png- of webp-afbeeldingen.');
        }

        $mime = (string) ($info['mime'] ?? '');
        $extension = match ($mime) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            default => throw new RuntimeException('Gebruik jpg, png of webp voor projectafbeeldingen.'),
        };

        $fileName = dalia_admin_project_slug($projectTitle ?: 'project') . '-' . date('YmdHis') . '-' . $position . '.' . $extension;
        $target = DALIA_ADMIN_PROJECT_IMAGE_UPLOAD_DIR . '/' . $fileName;
        if (!move_uploaded_file($tmp, $target)) {
            throw new RuntimeException('Projectafbeelding kon niet worden bewaard.');
        }

        $saved[] = DALIA_ADMIN_PROJECT_IMAGE_WEB_DIR . '/' . $fileName;
    }

    if ($saved === []) {
        throw new RuntimeException('Geen afbeeldingen geselecteerd.');
    }

    return $saved;
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

        if (isset($_POST['project_image_action'])) {
            $payload = dalia_admin_parse_project_image_payload((string) $_POST['project_image_action']);
            if ($payload === null) {
                throw new RuntimeException('Afbeeldingsactie kon niet worden gelezen.');
            }

            $index = (int) $payload['index'];
            $asset = (string) $payload['asset'];
            $action = (string) $payload['action'];
            if (!isset($storedProjects[$index]) || !is_array($storedProjects[$index])) {
                throw new RuntimeException('Project voor afbeelding kon niet worden gevonden.');
            }

            $project = $storedProjects[$index];
            if ($action !== 'upload' && !dalia_admin_project_image_exists($project, $asset)) {
                throw new RuntimeException('Afbeelding hoort niet bij dit project.');
            }

            switch ($action) {
                case 'upload':
                    $uploaded = dalia_admin_upload_project_images('project_upload_' . $index, (string) ($project['title'] ?? 'project'));
                    $project['gallery'] = array_values(array_filter([
                        ...(is_array($project['gallery'] ?? null) ? $project['gallery'] : []),
                        ...$uploaded,
                    ]));
                    if (trim((string) ($project['hero'] ?? '')) === '' && isset($uploaded[0])) {
                        $project['hero'] = $uploaded[0];
                    }
                    $storedProjects[$index] = $project;
                    maatlas_admin_storage_write(DALIA_ADMIN_PROJECTS_FILE, $storedProjects);
                    maatlas_admin_flash(count($uploaded) . ' projectafbeelding(en) toegevoegd.', 'success');
                    maatlas_admin_redirect('./projects.php#project-' . $index);

                case 'set_hero':
                    $storedProjects[$index] = dalia_admin_project_set_hero($project, $asset);
                    maatlas_admin_storage_write(DALIA_ADMIN_PROJECTS_FILE, $storedProjects);
                    maatlas_admin_flash('Hoofdbeeld bijgewerkt.', 'success');
                    maatlas_admin_redirect('./projects.php#project-' . $index);

                case 'delete_image':
                    $storedProjects[$index] = dalia_admin_project_remove_image($project, $asset);
                    dalia_admin_project_cleanup_asset_if_unused($asset, $storedProjects);
                    maatlas_admin_storage_write(DALIA_ADMIN_PROJECTS_FILE, $storedProjects);
                    maatlas_admin_flash('Afbeelding verwijderd uit het project.', 'success');
                    maatlas_admin_redirect('./projects.php#project-' . $index);

                case 'rotate_left':
                    dalia_admin_project_rotate_image($asset, 90);
                    maatlas_admin_flash('Afbeelding naar links gedraaid.', 'success');
                    maatlas_admin_redirect('./projects.php#project-' . $index);

                case 'rotate_right':
                    dalia_admin_project_rotate_image($asset, -90);
                    maatlas_admin_flash('Afbeelding naar rechts gedraaid.', 'success');
                    maatlas_admin_redirect('./projects.php#project-' . $index);

                case 'crop_landscape':
                    dalia_admin_project_crop_image($asset, 16 / 9);
                    maatlas_admin_flash('Afbeelding gecropt naar 16:9.', 'success');
                    maatlas_admin_redirect('./projects.php#project-' . $index);

                case 'crop_square':
                    dalia_admin_project_crop_image($asset, 1.0);
                    maatlas_admin_flash('Afbeelding vierkant gecropt.', 'success');
                    maatlas_admin_redirect('./projects.php#project-' . $index);

                default:
                    throw new RuntimeException('Onbekende afbeeldingsactie.');
            }
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
$currentProjectCount = dalia_admin_project_stat_count($projects, 'current');
$futureProjectCount = dalia_admin_project_stat_count($projects, 'future');
$realizedProjectCount = dalia_admin_project_stat_count($projects, 'realized');

maatlas_admin_render_header('Projecten beheren', $currentAdmin);
?>
<nav class="admin-nav" aria-label="Admin navigatie">
  <a class="btn btn--secondary btn--small" href="./">Instellingen</a>
  <a class="btn btn--secondary btn--small" href="./administrators.php">Beheerders</a>
  <a class="btn btn--secondary btn--small" href="../projecten.php">Portfolio bekijken</a>
</nav>

<section class="admin-stats">
  <article class="admin-stat admin-stat--soft">
    <span>Projecten</span>
    <strong><?= maatlas_admin_e(count($projects)) ?></strong>
    <small>Totaal in beheer</small>
  </article>
  <article class="admin-stat admin-stat--soft">
    <span>Publicatie</span>
    <strong><?= maatlas_admin_e($activeProjectCount) ?></strong>
    <small>Zichtbaar op de site</small>
    <div class="admin-stat__meta">
      <span class="admin-pill is-on">Actief <?= maatlas_admin_e($activeProjectCount) ?></span>
      <span class="admin-pill is-off">Uit <?= maatlas_admin_e($inactiveProjectCount) ?></span>
    </div>
  </article>
  <article class="admin-stat admin-stat--soft admin-stat--wide">
    <span>Projectgroepen</span>
    <strong><?= maatlas_admin_e($currentProjectCount) ?></strong>
    <small>Lopend is een groep, niet een publicatiestatus</small>
    <div class="admin-stat__meta">
      <span class="admin-pill">Lopend <?= maatlas_admin_e($currentProjectCount) ?></span>
      <span class="admin-pill">Toekomstig <?= maatlas_admin_e($futureProjectCount) ?></span>
      <span class="admin-pill">Gerealiseerd <?= maatlas_admin_e($realizedProjectCount) ?></span>
    </div>
  </article>
</section>

<section class="admin-settings-layout">
  <aside class="admin-settings-menu" aria-label="Projecten menu">
    <p class="eyebrow">Projecten</p>
    <div class="admin-settings-menu__group">
      <p class="admin-settings-menu__title">Beheer</p>
      <div class="admin-project-menu-summary">
        <span class="admin-pill is-on">Actief <?= maatlas_admin_e($activeProjectCount) ?></span>
        <span class="admin-pill is-off">Uit <?= maatlas_admin_e($inactiveProjectCount) ?></span>
        <span class="admin-pill">Lopend <?= maatlas_admin_e($currentProjectCount) ?></span>
        <span class="admin-pill">Toekomstig <?= maatlas_admin_e($futureProjectCount) ?></span>
        <span class="admin-pill">Gerealiseerd <?= maatlas_admin_e($realizedProjectCount) ?></span>
      </div>
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
      <p class="admin-help">Snel beheer van projecten. Lange beschrijvingen en galerij zitten per project in een uitklapdeel.</p>
      <div class="admin-project-toolbar__actions">
        <form method="post">
          <input type="hidden" name="csrf" value="<?= maatlas_admin_e($csrf) ?>" />
          <button class="btn btn--primary btn--small" type="submit" name="add_project" value="1">Nieuw project</button>
        </form>
      </div>
    </div>

    <form method="post" enctype="multipart/form-data" class="admin-form admin-form--single admin-project-form" data-floating-submit>
      <input type="hidden" name="csrf" value="<?= maatlas_admin_e($csrf) ?>" />

      <?php foreach ($projects as $index => $project): ?>
        <?php
          $isActive = !empty($project['active']);
          $group = (string) ($project['group'] ?? 'current');
          $groupLabel = $groupLabels[$group] ?? 'Lopend';
          $title = trim((string) ($project['title'] ?? 'Project'));
          $location = trim((string) ($project['location'] ?? ''));
          $projectImages = dalia_admin_project_images($project);
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
                <?= $isActive ? 'Verberg op site' : 'Toon op site' ?>
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

          <section class="admin-project-images">
            <div class="admin-project-images__head">
              <strong>Projectbeelden</strong>
              <span class="admin-muted">Miniaturen met snelle acties</span>
            </div>
            <div class="admin-project-upload">
              <label class="admin-project-upload__field">
                Beelden toevoegen
                <input type="file" name="project_upload_<?= maatlas_admin_e($index) ?>[]" accept="image/png,image/jpeg,image/webp" multiple />
              </label>
              <button class="btn btn--secondary btn--small" type="submit" name="project_image_action" value="<?= maatlas_admin_e(dalia_admin_project_image_payload('upload', $index, '__upload__')) ?>" formnovalidate>Upload</button>
            </div>

            <?php if ($projectImages === []): ?>
              <p class="admin-muted">Nog geen projectbeelden.</p>
            <?php else: ?>
              <div class="admin-project-image-grid">
                <?php foreach ($projectImages as $image): ?>
                  <?php
                    $src = (string) ($image['src'] ?? '');
                    $isLocal = !empty($image['is_local']);
                    $preview = preg_match('~^https?://~i', $src) ? $src : '../' . ltrim($src, './');
                    $label = basename(parse_url($src, PHP_URL_PATH) ?: $src);
                  ?>
                  <article class="admin-project-image-card">
                    <div class="admin-project-image-card__media">
                      <img src="<?= maatlas_admin_e($preview) ?>" alt="<?= maatlas_admin_e($title !== '' ? $title : 'Projectbeeld') ?>" loading="lazy" />
                    </div>
                    <div class="admin-project-image-card__body">
                      <div class="admin-project-image-card__badges">
                        <?php if (!empty($image['is_hero'])): ?><span class="admin-pill is-on">Hoofdbeeld</span><?php endif; ?>
                        <?php if (!empty($image['in_gallery'])): ?><span class="admin-pill">Galerij</span><?php endif; ?>
                        <span class="admin-pill <?= $isLocal ? 'is-on' : 'is-off' ?>"><?= $isLocal ? 'Lokaal' : 'Extern' ?></span>
                      </div>
                      <p class="admin-project-image-card__name"><?= maatlas_admin_e($label) ?></p>
                      <div class="admin-actions admin-actions--image">
                        <?php if (empty($image['is_hero'])): ?>
                          <button class="btn btn--secondary btn--small" type="submit" name="project_image_action" value="<?= maatlas_admin_e(dalia_admin_project_image_payload('set_hero', $index, $src)) ?>" formnovalidate>Maak hoofdbeeld</button>
                        <?php endif; ?>
                        <?php if ($isLocal): ?>
                          <button class="btn btn--secondary btn--small" type="submit" name="project_image_action" value="<?= maatlas_admin_e(dalia_admin_project_image_payload('rotate_left', $index, $src)) ?>" formnovalidate>↺</button>
                          <button class="btn btn--secondary btn--small" type="submit" name="project_image_action" value="<?= maatlas_admin_e(dalia_admin_project_image_payload('rotate_right', $index, $src)) ?>" formnovalidate>↻</button>
                          <button class="btn btn--secondary btn--small" type="submit" name="project_image_action" value="<?= maatlas_admin_e(dalia_admin_project_image_payload('crop_landscape', $index, $src)) ?>" formnovalidate>Crop 16:9</button>
                          <button class="btn btn--secondary btn--small" type="submit" name="project_image_action" value="<?= maatlas_admin_e(dalia_admin_project_image_payload('crop_square', $index, $src)) ?>" formnovalidate>Crop 1:1</button>
                        <?php endif; ?>
                        <button class="btn btn--danger btn--small" type="submit" name="project_image_action" value="<?= maatlas_admin_e(dalia_admin_project_image_payload('delete_image', $index, $src)) ?>" formnovalidate onclick="return confirm('Deze afbeelding verwijderen uit het project?');">Verwijder</button>
                      </div>
                    </div>
                  </article>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </section>

          <details class="admin-project-extra">
            <summary>Beschrijving, detailtekst en galerij</summary>
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
          </details>
        </fieldset>
      <?php endforeach; ?>

      <?php if ($projects === []): ?>
        <div class="admin-project-empty admin-settings-section">
          <p>Er zijn nog geen projecten. Voeg eerst een nieuw project toe.</p>
          <button class="btn btn--primary btn--small" type="submit" name="add_project" value="1" formnovalidate>Nieuw project</button>
        </div>
      <?php endif; ?>

      <div id="opslaan" class="button-row admin-settings-section">
        <button class="btn btn--primary" type="submit" data-floating-submit-source>Projecten opslaan</button>
      </div>
    </form>
  </article>
</section>
<?php
maatlas_admin_render_footer();
