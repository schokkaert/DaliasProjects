<?php
declare(strict_types=1);

const DALIA_ASSET_VERSION = '20260424-page-title-admin';
const DALIA_ROOT = __DIR__ . '/..';
const DALIA_STORAGE_DIR = DALIA_ROOT . '/admin/storage';
const DALIA_SETTINGS_FILE = DALIA_STORAGE_DIR . '/settings.php';
const DALIA_PROJECTS_FILE = DALIA_STORAGE_DIR . '/projects.php';
const DALIA_PERSONNEL_FILE = DALIA_STORAGE_DIR . '/personnel.php';

function dalia_e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function dalia_storage_read(string $file, array $fallback = []): array
{
    if (!file_exists($file)) {
        return $fallback;
    }

    $data = require $file;
    return is_array($data) ? $data : $fallback;
}

function dalia_default_settings(): array
{
    return [
        'heroVideoUrl' => '/Webimages/dalia-hero-building-timelapse.mp4',
        'heroPosterUrl' => '/Webimages/dalia-hero-building-timelapse-poster.jpg',
        'pageTitleBarHeight' => 72,
        'pageTitleBarRadiusLeft' => 18,
        'pageTitleBarRadiusRight' => 18,
        'public_email' => 'info@daliasprojects.be',
        'public_phone' => 'Jens 0499/10.50.11',
        'socials' => [
            ['label' => 'LinkedIn', 'url' => 'https://be.linkedin.com/company/diss-europe-bv', 'active' => true],
        ],
    ];
}

function dalia_settings(): array
{
    return array_replace_recursive(dalia_default_settings(), dalia_storage_read(DALIA_SETTINGS_FILE, []));
}

function dalia_setting_int(array $settings, string $key, int $default, int $min, int $max): int
{
    $value = filter_var($settings[$key] ?? null, FILTER_VALIDATE_INT);
    if ($value === false) {
        return $default;
    }

    return max($min, min($max, $value));
}

function dalia_page_title_bar_settings(): array
{
    $settings = dalia_settings();

    return [
        'height' => dalia_setting_int($settings, 'pageTitleBarHeight', 72, 44, 140),
        'radiusLeft' => dalia_setting_int($settings, 'pageTitleBarRadiusLeft', 18, 0, 80),
        'radiusRight' => dalia_setting_int($settings, 'pageTitleBarRadiusRight', 18, 0, 80),
    ];
}

function dalia_page_title_bar_style(array $settings): string
{
    return sprintf(
        '--page-title-height:%dpx;--page-title-radius-left:%dpx;--page-title-radius-right:%dpx;',
        (int) ($settings['height'] ?? 72),
        (int) ($settings['radiusLeft'] ?? 18),
        (int) ($settings['radiusRight'] ?? 18)
    );
}

function dalia_contact(): array
{
    $settings = dalia_settings();
    return [
        'email' => trim((string) ($settings['public_email'] ?? 'info@daliasprojects.be')),
        'phone' => trim((string) ($settings['public_phone'] ?? 'Jens 0499/10.50.11')),
    ];
}

function dalia_phone_href(string $phone): string
{
    $normalized = preg_replace('~[^\d+]~', '', str_replace('(0)', '', $phone)) ?: '';
    return $normalized !== '' ? 'tel:' . $normalized : '#';
}

function dalia_socials(): array
{
    $settings = dalia_settings();
    $socials = [];
    foreach (($settings['socials'] ?? []) as $social) {
        if (!is_array($social) || empty($social['active']) || trim((string) ($social['url'] ?? '')) === '') {
            continue;
        }
        $socials[] = [
            'label' => trim((string) ($social['label'] ?? 'Social')),
            'url' => trim((string) ($social['url'] ?? '')),
        ];
    }

    return $socials;
}

function dalia_projects(): array
{
    return array_values(array_filter(
        dalia_storage_read(DALIA_PROJECTS_FILE, []),
        static fn (mixed $project): bool => is_array($project) && !empty($project['active'])
    ));
}

function dalia_project_group(array $project): string
{
    $group = strtolower(trim((string) ($project['group'] ?? '')));
    if (in_array($group, ['current', 'future', 'realized'], true)) {
        return $group;
    }

    $status = strtolower((string) ($project['status'] ?? ''));
    if (str_contains($status, 'verkocht')) {
        return 'realized';
    }
    if (str_contains($status, 'verwacht') || str_contains($status, 'binnenkort')) {
        return 'future';
    }
    return 'current';
}

function dalia_projects_by_group(string $group): array
{
    return array_values(array_filter(
        dalia_projects(),
        static fn (array $project): bool => dalia_project_group($project) === $group
    ));
}

function dalia_project_by_slug(string $slug): ?array
{
    foreach (dalia_projects() as $project) {
        if (($project['slug'] ?? '') === $slug) {
            return $project;
        }
    }

    $current = dalia_projects_by_group('current');
    return $current[0] ?? null;
}

function dalia_gallery(array $project): array
{
    $gallery = is_array($project['gallery'] ?? null) ? $project['gallery'] : [];
    $gallery = array_values(array_filter(array_map('strval', $gallery)));
    if (!$gallery && !empty($project['hero'])) {
        $gallery[] = (string) $project['hero'];
    }
    return $gallery;
}

function dalia_personnel(): array
{
    return array_values(array_filter(
        dalia_storage_read(DALIA_PERSONNEL_FILE, []),
        static fn (mixed $person): bool => is_array($person) && !empty($person['active'])
    ));
}

function dalia_url(string $page): string
{
    return './' . $page . '.php';
}

function dalia_page_banner_title(string $activeNav, string $pageTitle, string $bodyPage = ''): string
{
    if ($bodyPage === 'project') {
        $projectTitle = trim((string) preg_split('/\s+[|—-]\s+/u', $pageTitle, 2)[0]);
        return $projectTitle !== '' ? $projectTitle : 'Project';
    }

    $titles = [
        'home' => 'Home',
        'projecten' => 'Projecten',
        'over' => 'Over ons',
        'grond-gezocht' => 'Grond te koop?',
        'contact' => 'Contact',
    ];

    if (isset($titles[$activeNav])) {
        return $titles[$activeNav];
    }

    $fallbackTitle = trim((string) preg_split('/\s+[|—-]\s+/u', $pageTitle, 2)[0]);
    return $fallbackTitle !== '' ? $fallbackTitle : 'Dalia Projects';
}

function dalia_social_icon(string $label): string
{
    $normalized = strtolower($label);
    if (str_contains($normalized, 'linkedin')) {
        return '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M5.1 8.8H1.4V21h3.7V8.8ZM3.3 3C2.1 3 1.2 3.9 1.2 5s.9 2 2.1 2 2.1-.9 2.1-2-.9-2-2.1-2ZM21.8 14.2c0-3.7-2-5.7-4.8-5.7-2.2 0-3.2 1.2-3.8 2.1V8.8H9.6V21h3.7v-6.1c0-1.6.3-3.2 2.3-3.2s2 1.9 2 3.3v6h3.7v-6.8Z"></path></svg>';
    }
    return '<span>' . dalia_e(substr($label, 0, 2)) . '</span>';
}

function dalia_render_project_tile(array $project): void
{
    $group = dalia_project_group($project);
    $isCurrent = $group === 'current';
    $tag = $isCurrent ? 'a' : 'article';
    $href = $isCurrent ? ' href="./project.php?slug=' . rawurlencode((string) ($project['slug'] ?? '')) . '"' : ' aria-label="Projecttegel"';
    $secondary = $group === 'future'
        ? 'Start verkoop: ' . ((string) ($project['sales_start'] ?? '') ?: 'Timing volgt')
        : ($group === 'realized' ? 'Verkocht' : (string) ($project['type'] ?? ''));
    ?>
    <<?= $tag ?> class="portfolio-tile portfolio-tile--<?= dalia_e($group) ?>"<?= $href ?> data-reveal>
      <div class="portfolio-tile__media">
        <img src="<?= dalia_e($project['hero'] ?? '') ?>" alt="<?= dalia_e($project['title'] ?? 'Project') ?>" loading="lazy" />
        <span class="portfolio-tile__badge"><?= dalia_e($group === 'realized' ? 'Verkocht' : ($project['status'] ?? '')) ?></span>
      </div>
      <div class="portfolio-tile__body">
        <span><?= dalia_e($secondary) ?></span>
        <h3><?= dalia_e($project['title'] ?? '') ?></h3>
        <p><?= dalia_e($project['location'] ?? '') ?></p>
        <?php if ($isCurrent): ?><strong>Bekijk project</strong><?php endif; ?>
      </div>
    </<?= $tag ?>>
    <?php
}

function dalia_render_person_card(array $person): void
{
    $roles = is_array($person['roles'] ?? null) ? $person['roles'] : [];
    $roleLine = implode(' - ', array_filter([...$roles, !empty($person['biv']) ? 'BIV ' . $person['biv'] : '']));
    ?>
    <article class="person-card" data-reveal>
      <div class="person-card__photo">
        <img src="<?= dalia_e($person['photo'] ?? './Webimages/Logo.png') ?>" alt="<?= dalia_e($person['name'] ?? '') ?>" loading="lazy" />
      </div>
      <div class="person-card__body">
        <h3><?= dalia_e($person['name'] ?? '') ?></h3>
        <p class="person-card__roles"><?= dalia_e($roleLine) ?></p>
        <?php if (!empty($person['phone'])): ?>
          <a class="person-card__contact person-card__contact--phone" href="<?= dalia_e(dalia_phone_href((string) $person['phone'])) ?>"><?= dalia_e($person['phone']) ?></a>
        <?php endif; ?>
        <?php if (!empty($person['email'])): ?>
          <a class="person-card__contact person-card__contact--mail" href="mailto:<?= dalia_e($person['email']) ?>"><?= dalia_e($person['email']) ?></a>
        <?php endif; ?>
      </div>
    </article>
    <?php
}
