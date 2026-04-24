<?php
declare(strict_types=1);

const MAATLAS_ADMIN_STORAGE_DIR = __DIR__ . '/storage';
const MAATLAS_ADMIN_ADMINS_FILE = MAATLAS_ADMIN_STORAGE_DIR . '/admins.php';
const MAATLAS_ADMIN_SETTINGS_FILE = MAATLAS_ADMIN_STORAGE_DIR . '/settings.php';
const MAATLAS_ADMIN_SESSION_DIR = MAATLAS_ADMIN_STORAGE_DIR . '/sessions';
const MAATLAS_ADMIN_TEMP_PASSWORD_HASH = '$2y$10$1o6Eri3VXdY17P43kivrj.SVwgqCiALcEI.lJtOL1PRsGzR6hUwiO';
const MAATLAS_ADMIN_DEFAULT_HERO_IMAGE = 'https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/23413f2c-1b56-4540-b1da-c6d19755084a/Chateaux+real+estate+%2844+van+86%29.jpg';
const MAATLAS_ADMIN_DEFAULT_LINKEDIN = 'https://be.linkedin.com/company/diss-europe-bv';

function maatlas_admin_bootstrap_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    maatlas_admin_ensure_storage();

    $savePath = session_save_path();
    if ($savePath === '' || !is_dir($savePath) || !is_writable($savePath)) {
        session_save_path(MAATLAS_ADMIN_SESSION_DIR);
    }

    $secure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    session_name('maatlas_admin');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $secure,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function maatlas_admin_ensure_storage(): void
{
    foreach ([MAATLAS_ADMIN_STORAGE_DIR, MAATLAS_ADMIN_SESSION_DIR] as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
    }
}

function maatlas_admin_e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function maatlas_admin_redirect(string $target): never
{
    header('Location: ' . $target);
    exit;
}

function maatlas_admin_flash(?string $message = null, string $type = 'info'): ?array
{
    if ($message !== null) {
        $_SESSION['maatlas_admin_flash'] = ['message' => $message, 'type' => $type];
        return null;
    }

    $flash = $_SESSION['maatlas_admin_flash'] ?? null;
    unset($_SESSION['maatlas_admin_flash']);

    return is_array($flash) ? $flash : null;
}

function maatlas_admin_old_input(?array $data = null): array
{
    if ($data !== null) {
        $_SESSION['maatlas_admin_old_input'] = $data;
        return $data;
    }

    $stored = $_SESSION['maatlas_admin_old_input'] ?? [];
    unset($_SESSION['maatlas_admin_old_input']);

    return is_array($stored) ? $stored : [];
}

function maatlas_admin_old_input_value(array $input, string $key, string $default = ''): string
{
    return trim((string) ($input[$key] ?? $default));
}

function maatlas_admin_compose_full_name(string $firstName, string $lastName, string $fallback = ''): string
{
    $fullName = trim($firstName . ' ' . $lastName);
    return $fullName !== '' ? $fullName : trim($fallback);
}

function maatlas_admin_split_full_name(string $fullName): array
{
    $normalized = preg_replace('~\s+~', ' ', trim($fullName)) ?? '';
    if ($normalized === '') {
        return ['first_name' => '', 'last_name' => ''];
    }

    $parts = explode(' ', $normalized);
    if (count($parts) === 1) {
        return ['first_name' => $parts[0], 'last_name' => ''];
    }

    $firstName = array_shift($parts) ?: '';
    return ['first_name' => $firstName, 'last_name' => implode(' ', $parts)];
}

function maatlas_admin_csrf_token(): string
{
    if (empty($_SESSION['maatlas_admin_csrf'])) {
        $_SESSION['maatlas_admin_csrf'] = bin2hex(random_bytes(32));
    }

    return (string) $_SESSION['maatlas_admin_csrf'];
}

function maatlas_admin_require_csrf(): void
{
    $sessionToken = (string) ($_SESSION['maatlas_admin_csrf'] ?? '');
    $postedToken = (string) ($_POST['csrf'] ?? '');

    if ($sessionToken === '' || $postedToken === '' || !hash_equals($sessionToken, $postedToken)) {
        http_response_code(400);
        exit('Ongeldig verzoek.');
    }
}

function maatlas_admin_storage_read(string $file, array $fallback): array
{
    maatlas_admin_ensure_storage();

    if (!file_exists($file)) {
        maatlas_admin_storage_write($file, $fallback);
        return $fallback;
    }

    $data = require $file;
    return is_array($data) ? $data : $fallback;
}

function maatlas_admin_storage_write(string $file, array $data): void
{
    maatlas_admin_ensure_storage();
    $php = "<?php\nreturn " . var_export($data, true) . ";\n";
    file_put_contents($file, $php, LOCK_EX);
}

function maatlas_admin_seed_settings(): array
{
    return [
        'heroVideoUrl' => '',
        'heroPosterUrl' => MAATLAS_ADMIN_DEFAULT_HERO_IMAGE,
        'pageTitleBarHeight' => 72,
        'pageTitleBarRadiusLeft' => 18,
        'pageTitleBarRadiusRight' => 18,
        'contact_sender_email' => '',
        'public_email' => 'info@daliasprojects.be',
        'privacy_email' => '',
        'public_phone' => 'Jens 0499/10.50.11',
        'contact_address_line_1' => '',
        'contact_address_line_2' => '',
        'maps_embed_url' => '',
        'maps_link_url' => '',
        'socials' => [
            [
                'label' => 'LinkedIn',
                'url' => MAATLAS_ADMIN_DEFAULT_LINKEDIN,
                'active' => true,
            ],
            [
                'label' => 'Facebook',
                'url' => '',
                'active' => false,
            ],
            [
                'label' => 'Instagram',
                'url' => '',
                'active' => false,
            ],
        ],
    ];
}

function maatlas_admin_clamp_int(mixed $value, int $default, int $min, int $max): int
{
    $intValue = filter_var($value, FILTER_VALIDATE_INT);
    if ($intValue === false) {
        return $default;
    }

    return max($min, min($max, $intValue));
}

function maatlas_admin_normalize_social(array $social): ?array
{
    $label = trim((string) ($social['label'] ?? ''));
    $url = trim((string) ($social['url'] ?? ''));
    $active = filter_var($social['active'] ?? ($url !== ''), FILTER_VALIDATE_BOOLEAN);

    if ($label === '') {
        return null;
    }

    if ($url !== '' && !preg_match('~^https?://~i', $url)) {
        $url = '';
        $active = false;
    }

    return [
        'label' => $label,
        'url' => $url,
        'active' => $active && $url !== '',
    ];
}

function maatlas_admin_normalize_settings(array $settings): array
{
    $seed = maatlas_admin_seed_settings();
    $socials = [];

    foreach (($settings['socials'] ?? $seed['socials']) as $social) {
        if (!is_array($social)) {
            continue;
        }

        $normalized = maatlas_admin_normalize_social($social);
        if ($normalized !== null) {
            $socials[] = $normalized;
        }
    }

    $known = array_column($socials, null, 'label');
    foreach ($seed['socials'] as $social) {
        if (!isset($known[$social['label']])) {
            $socials[] = $social;
        }
    }

    return [
        'heroVideoUrl' => trim((string) ($settings['heroVideoUrl'] ?? $seed['heroVideoUrl'])),
        'heroPosterUrl' => trim((string) ($settings['heroPosterUrl'] ?? $seed['heroPosterUrl'])) ?: $seed['heroPosterUrl'],
        'pageTitleBarHeight' => maatlas_admin_clamp_int($settings['pageTitleBarHeight'] ?? $seed['pageTitleBarHeight'], $seed['pageTitleBarHeight'], 44, 140),
        'pageTitleBarRadiusLeft' => maatlas_admin_clamp_int($settings['pageTitleBarRadiusLeft'] ?? $seed['pageTitleBarRadiusLeft'], $seed['pageTitleBarRadiusLeft'], 0, 80),
        'pageTitleBarRadiusRight' => maatlas_admin_clamp_int($settings['pageTitleBarRadiusRight'] ?? $seed['pageTitleBarRadiusRight'], $seed['pageTitleBarRadiusRight'], 0, 80),
        'contact_sender_email' => trim((string) ($settings['contact_sender_email'] ?? $seed['contact_sender_email'])),
        'public_email' => trim((string) ($settings['public_email'] ?? $seed['public_email'])),
        'privacy_email' => trim((string) ($settings['privacy_email'] ?? $seed['privacy_email'])),
        'public_phone' => trim((string) ($settings['public_phone'] ?? $seed['public_phone'])),
        'contact_address_line_1' => trim((string) ($settings['contact_address_line_1'] ?? $seed['contact_address_line_1'])),
        'contact_address_line_2' => trim((string) ($settings['contact_address_line_2'] ?? $seed['contact_address_line_2'])),
        'maps_embed_url' => trim((string) ($settings['maps_embed_url'] ?? $seed['maps_embed_url'])),
        'maps_link_url' => trim((string) ($settings['maps_link_url'] ?? $seed['maps_link_url'])),
        'socials' => $socials,
    ];
}

function maatlas_admin_read_settings(): array
{
    return maatlas_admin_normalize_settings(
        maatlas_admin_storage_read(MAATLAS_ADMIN_SETTINGS_FILE, maatlas_admin_seed_settings())
    );
}

function maatlas_admin_save_settings(array $settings): void
{
    maatlas_admin_storage_write(MAATLAS_ADMIN_SETTINGS_FILE, maatlas_admin_normalize_settings($settings));
}

function maatlas_admin_public_settings(): array
{
    $settings = maatlas_admin_read_settings();
    $settings['socials'] = array_values(array_filter(
        $settings['socials'],
        static fn (array $social): bool => !empty($social['active']) && trim((string) ($social['url'] ?? '')) !== ''
    ));

    return $settings;
}

function maatlas_admin_empty_admins(): array
{
    return [];
}

function maatlas_admin_temporary_admin(): array
{
    $now = gmdate('c');

    return [
        'id' => 'temp-admin',
        'username' => 'admin',
        'first_name' => 'Tijdelijke',
        'last_name' => 'beheerder',
        'full_name' => 'Tijdelijke beheerder',
        'email' => '',
        'role' => 'superadmin',
        'active' => true,
        'temporary' => true,
        'password_hash' => MAATLAS_ADMIN_TEMP_PASSWORD_HASH,
        'activation_token_hash' => null,
        'activation_expires_at' => null,
        'created_at' => $now,
        'updated_at' => $now,
        'last_login' => null,
    ];
}

function maatlas_admin_normalize_admin(array $admin): ?array
{
    $username = trim((string) ($admin['username'] ?? ''));
    if ($username === '') {
        return null;
    }

    $role = (string) ($admin['role'] ?? 'admin');
    if (!in_array($role, ['admin', 'superadmin'], true)) {
        $role = 'admin';
    }

    $active = filter_var($admin['active'] ?? false, FILTER_VALIDATE_BOOLEAN);
    $temporary = filter_var($admin['temporary'] ?? false, FILTER_VALIDATE_BOOLEAN);
    $nameParts = maatlas_admin_split_full_name(trim((string) ($admin['full_name'] ?? $admin['name'] ?? '')));
    $firstName = trim((string) ($admin['first_name'] ?? $nameParts['first_name'] ?? ''));
    $lastName = trim((string) ($admin['last_name'] ?? $nameParts['last_name'] ?? ''));
    $fullName = maatlas_admin_compose_full_name($firstName, $lastName, (string) ($admin['full_name'] ?? $admin['name'] ?? $username));

    return [
        'id' => trim((string) ($admin['id'] ?? '')) ?: 'admin-' . bin2hex(random_bytes(6)),
        'username' => $username,
        'first_name' => $firstName,
        'last_name' => $lastName,
        'full_name' => $fullName !== '' ? $fullName : $username,
        'email' => trim((string) ($admin['email'] ?? '')),
        'role' => $role,
        'active' => $active,
        'temporary' => $temporary,
        'password_hash' => trim((string) ($admin['password_hash'] ?? '')),
        'activation_token_hash' => $admin['activation_token_hash'] ?? null,
        'activation_expires_at' => $admin['activation_expires_at'] ?? null,
        'password_reset_token_hash' => $admin['password_reset_token_hash'] ?? null,
        'password_reset_expires_at' => $admin['password_reset_expires_at'] ?? null,
        'created_at' => (string) ($admin['created_at'] ?? gmdate('c')),
        'updated_at' => (string) ($admin['updated_at'] ?? gmdate('c')),
        'last_login' => $admin['last_login'] ?? null,
    ];
}

function maatlas_admin_real_admin_exists(array $admins): bool
{
    foreach ($admins as $admin) {
        if (empty($admin['temporary'])) {
            return true;
        }
    }

    return false;
}

function maatlas_admin_read_admins(): array
{
    $stored = maatlas_admin_storage_read(MAATLAS_ADMIN_ADMINS_FILE, maatlas_admin_empty_admins());
    $admins = [];

    foreach ($stored as $admin) {
        if (!is_array($admin)) {
            continue;
        }

        $normalized = maatlas_admin_normalize_admin($admin);
        if ($normalized !== null) {
            $admins[] = $normalized;
        }
    }

    if (!maatlas_admin_real_admin_exists($admins)) {
        $admins = [maatlas_admin_temporary_admin()];
        maatlas_admin_save_admins($admins);
    }

    return $admins;
}

function maatlas_admin_save_admins(array $admins): void
{
    $normalized = [];
    foreach ($admins as $admin) {
        if (!is_array($admin)) {
            continue;
        }

        $item = maatlas_admin_normalize_admin($admin);
        if ($item !== null) {
            $normalized[] = $item;
        }
    }

    maatlas_admin_storage_write(MAATLAS_ADMIN_ADMINS_FILE, $normalized);
}

function maatlas_admin_find_admin_index(array $admins, string $id): ?int
{
    foreach ($admins as $index => $admin) {
        if (($admin['id'] ?? '') === $id) {
            return $index;
        }
    }

    return null;
}

function maatlas_admin_find_by_username(array $admins, string $username): ?array
{
    foreach ($admins as $admin) {
        if (strcasecmp((string) ($admin['username'] ?? ''), $username) === 0) {
            return $admin;
        }
    }

    return null;
}

function maatlas_admin_find_by_token(array $admins, string $token): ?array
{
    $hash = hash('sha256', $token);
    foreach ($admins as $admin) {
        $stored = (string) ($admin['activation_token_hash'] ?? '');
        if ($stored !== '' && hash_equals($stored, $hash)) {
            return $admin;
        }
    }

    return null;
}

function maatlas_admin_find_by_password_reset_token(array $admins, string $token): ?array
{
    $hash = hash('sha256', $token);
    foreach ($admins as $admin) {
        $stored = (string) ($admin['password_reset_token_hash'] ?? '');
        if ($stored !== '' && hash_equals($stored, $hash)) {
            return $admin;
        }
    }

    return null;
}

function maatlas_admin_find_by_username_or_email(array $admins, string $value): ?array
{
    foreach ($admins as $admin) {
        if (!empty($admin['temporary']) || empty($admin['active'])) {
            continue;
        }

        if (strcasecmp((string) ($admin['username'] ?? ''), $value) === 0 || strcasecmp((string) ($admin['email'] ?? ''), $value) === 0) {
            return $admin;
        }
    }

    return null;
}

function maatlas_admin_username_available(array $admins, string $username): bool
{
    foreach ($admins as $admin) {
        if (strcasecmp((string) ($admin['username'] ?? ''), $username) === 0) {
            return false;
        }
    }

    return true;
}

function maatlas_admin_current_admin(): ?array
{
    $id = (string) ($_SESSION['maatlas_admin_id'] ?? '');
    if ($id === '') {
        return null;
    }

    $admins = maatlas_admin_read_admins();
    $index = maatlas_admin_find_admin_index($admins, $id);
    if ($index === null || empty($admins[$index]['active'])) {
        unset($_SESSION['maatlas_admin_id']);
        return null;
    }

    return $admins[$index];
}

function maatlas_admin_is_setup_session(): bool
{
    $admin = maatlas_admin_current_admin();
    return is_array($admin) && !empty($admin['temporary']);
}

function maatlas_admin_require_login(): array
{
    $admin = maatlas_admin_current_admin();
    if (!$admin) {
        maatlas_admin_redirect('./login.php');
    }

    if (!empty($admin['temporary'])) {
        $script = basename((string) ($_SERVER['SCRIPT_NAME'] ?? ''));
        if ($script !== 'administrators.php' && $script !== 'logout.php') {
            maatlas_admin_redirect('./administrators.php?setup=1');
        }
    }

    return $admin;
}

function maatlas_admin_login_admin(array $admin): void
{
    session_regenerate_id(true);
    $_SESSION['maatlas_admin_id'] = (string) $admin['id'];
}

function maatlas_admin_authenticate(string $username, string $password): ?array
{
    $admins = maatlas_admin_read_admins();
    $admin = maatlas_admin_find_by_username($admins, $username);

    if (!$admin || empty($admin['active']) || trim((string) ($admin['password_hash'] ?? '')) === '') {
        return null;
    }

    if (!password_verify($password, (string) $admin['password_hash'])) {
        return null;
    }

    $index = maatlas_admin_find_admin_index($admins, (string) $admin['id']);
    if ($index !== null) {
        $admins[$index]['last_login'] = gmdate('c');
        $admins[$index]['updated_at'] = gmdate('c');
        maatlas_admin_save_admins($admins);
        $admin = $admins[$index];
    }

    return $admin;
}

function maatlas_admin_role_label(string $role): string
{
    return $role === 'superadmin' ? 'Superadmin' : 'Admin';
}

function maatlas_admin_status_label(array $admin): string
{
    if (!empty($admin['active'])) {
        return 'actief';
    }

    if (!empty($admin['activation_token_hash'])) {
        return 'wacht op bevestiging';
    }

    return 'inactief';
}

function maatlas_admin_format_datetime(mixed $value): string
{
    $raw = trim((string) $value);
    if ($raw === '') {
        return 'Nog niet';
    }

    $timestamp = strtotime($raw);
    if ($timestamp === false) {
        return $raw;
    }

    return date('d/m/Y H:i', $timestamp);
}

function maatlas_admin_active_real_admin_count(array $admins): int
{
    $count = 0;
    foreach ($admins as $admin) {
        if (empty($admin['temporary']) && !empty($admin['active'])) {
            $count++;
        }
    }

    return $count;
}

function maatlas_admin_validate_password(string $password, string $username): ?string
{
    if (strlen($password) < 12) {
        return 'Gebruik een wachtwoord van minstens 12 tekens.';
    }

    if (strcasecmp($password, 'admin') === 0 || strcasecmp($password, $username) === 0) {
        return 'Gebruik geen voorspelbaar wachtwoord zoals admin of de gebruikersnaam.';
    }

    return null;
}

function maatlas_admin_make_activation_token(): array
{
    $token = bin2hex(random_bytes(32));
    return [$token, hash('sha256', $token)];
}

function maatlas_admin_base_url(): string
{
    $host = (string) ($_SERVER['HTTP_HOST'] ?? '');
    if ($host === '') {
        return 'http://localhost/admin';
    }

    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $script = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? '/admin/index.php'));
    $dir = rtrim(dirname($script), '/');

    return $scheme . '://' . $host . ($dir === '' ? '' : $dir);
}

function maatlas_admin_mail_sender(): string
{
    $settings = maatlas_admin_read_settings();
    foreach (['contact_sender_email', 'public_email', 'privacy_email'] as $key) {
        $email = trim((string) ($settings[$key] ?? ''));
        if ($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $email;
        }
    }

    return 'info@daliasprojects.be';
}

function maatlas_admin_send_mail(string $to, string $subject, string $body): bool
{
    if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    $from = maatlas_admin_mail_sender();
    $headers = [
        'From: Dalia Projects <' . $from . '>',
        'Reply-To: ' . $from,
        'Content-Type: text/plain; charset=UTF-8',
    ];

    return mail($to, $subject, $body, implode("\r\n", $headers));
}

function maatlas_admin_current_script(): string
{
    return basename((string) ($_SERVER['SCRIPT_NAME'] ?? 'index.php'));
}

function maatlas_admin_dashboard_label(): string
{
    return 'Admin overzicht';
}

function maatlas_admin_breadcrumb_label(string $title): string
{
    return $title === 'Admin' ? maatlas_admin_dashboard_label() : $title;
}

function maatlas_admin_render_header(string $title, ?array $currentAdmin = null): void
{
    $admin = $currentAdmin ?? maatlas_admin_current_admin();
    $flash = maatlas_admin_flash();
    $currentLabel = maatlas_admin_breadcrumb_label($title);
    $isDashboard = maatlas_admin_current_script() === 'index.php';
    ?>
<!doctype html>
<html lang="nl-BE">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= maatlas_admin_e($title) ?> - Dalia Projects Admin</title>
    <meta name="robots" content="noindex, nofollow" />
    <link rel="icon" type="image/png" href="../Webimages/Logo.png" />
    <link rel="stylesheet" href="../styles.css?v=20260422-personnel" />
    <link rel="stylesheet" href="./admin.css?v=20260422-personnel" />
  </head>
  <body class="admin-app">
    <header class="admin-topbar">
      <div class="admin-shell admin-topbar__inner">
        <div>
          <p class="eyebrow">Dalia Projects</p>
          <h1><?= maatlas_admin_e($title) ?></h1>
        </div>
        <?php if ($admin): ?>
          <div class="admin-topbar__user">
            <span><?= maatlas_admin_e($admin['full_name'] ?: $admin['username']) ?></span>
            <small><?= maatlas_admin_e(maatlas_admin_role_label((string) $admin['role'])) ?></small>
            <div class="admin-topbar__actions">
              <?php if (!$isDashboard): ?>
                <a class="btn btn--secondary btn--small" href="./">Admin home</a>
              <?php endif; ?>
              <a class="btn btn--primary btn--small" href="../index.php">Bekijk site</a>
              <a class="btn btn--secondary btn--small" href="./logout.php">Uitloggen</a>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </header>
    <main class="admin-shell admin-main">
      <nav class="admin-breadcrumb" aria-label="Breadcrumb">
        <?php if ($isDashboard): ?>
          <span class="admin-breadcrumb__current"><?= maatlas_admin_e($currentLabel) ?></span>
        <?php else: ?>
          <a href="./"><?= maatlas_admin_e(maatlas_admin_dashboard_label()) ?></a>
          <span class="admin-breadcrumb__separator">/</span>
          <span class="admin-breadcrumb__current"><?= maatlas_admin_e($currentLabel) ?></span>
        <?php endif; ?>
      </nav>
      <?php if ($admin): ?>
        <aside class="admin-session-indicator" aria-label="Aangemelde gebruiker">
          <span>Aangemeld als</span>
          <strong><?= maatlas_admin_e($admin['full_name'] ?: $admin['username']) ?></strong>
          <small><?= maatlas_admin_e(maatlas_admin_role_label((string) $admin['role'])) ?></small>
        </aside>
      <?php endif; ?>
      <?php if ($flash && ($flash['type'] ?? 'info') === 'error'): ?>
        <div class="admin-modal-backdrop" data-admin-modal-backdrop>
          <div class="admin-modal" role="alertdialog" aria-modal="true" aria-labelledby="admin-modal-title">
            <div class="admin-modal__header">
              <p class="eyebrow">Controleer de velden</p>
              <button class="admin-modal__close" type="button" aria-label="Popup sluiten" data-admin-modal-close>&times;</button>
            </div>
            <h2 id="admin-modal-title">Opslaan is niet gelukt</h2>
            <p class="admin-modal__message"><?= maatlas_admin_e($flash['message'] ?? '') ?></p>
            <div class="button-row">
              <button class="btn btn--primary" type="button" data-admin-modal-close>Sluiten</button>
            </div>
          </div>
        </div>
      <?php elseif ($flash): ?>
        <div class="admin-alert admin-alert--<?= maatlas_admin_e($flash['type'] ?? 'info') ?>">
          <?= maatlas_admin_e($flash['message'] ?? '') ?>
        </div>
      <?php endif; ?>
    <?php
}

function maatlas_admin_render_footer(): void
{
    ?>
    </main>
    <script>
      document.querySelectorAll('[data-admin-modal-close]').forEach((button) => {
        button.addEventListener('click', () => {
          const backdrop = document.querySelector('[data-admin-modal-backdrop]');
          if (backdrop) backdrop.remove();
        });
      });

      const adminModalBackdrop = document.querySelector('[data-admin-modal-backdrop]');
      if (adminModalBackdrop) {
        adminModalBackdrop.addEventListener('click', (event) => {
          if (event.target === adminModalBackdrop) {
            adminModalBackdrop.remove();
          }
        });
      }

      document.querySelectorAll('[data-floating-submit]').forEach((form) => {
        if (form.querySelector('.admin-floating-submit')) return;

        const submit = form.querySelector('button[type="submit"], input[type="submit"]');
        if (!submit) return;

        const dock = document.createElement('div');
        dock.className = 'admin-floating-submit';

        const button = document.createElement('button');
        button.type = 'button';
        button.className = submit.className || 'btn btn--primary';
        button.textContent = submit.textContent.trim() || submit.value || 'Opslaan';
        button.addEventListener('click', () => form.requestSubmit(submit));

        dock.appendChild(button);
        form.appendChild(dock);
      });

      document.querySelectorAll('input[type="password"]').forEach((input) => {
        if (input.closest('.admin-password-field')) return;

        const wrapper = document.createElement('span');
        wrapper.className = 'admin-password-field';
        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(input);

        const toggle = document.createElement('button');
        toggle.type = 'button';
        toggle.className = 'admin-password-toggle';
        toggle.setAttribute('aria-label', 'Wachtwoord tonen');
        toggle.setAttribute('aria-pressed', 'false');
        toggle.innerHTML = '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 5c5.1 0 8.6 4.3 9.7 6.1.3.5.3 1.1 0 1.6C20.6 14.5 17.1 19 12 19s-8.6-4.5-9.7-6.3a1.5 1.5 0 0 1 0-1.6C3.4 9.3 6.9 5 12 5Zm0 2C8 7 5.1 10.3 4.1 11.9 5.1 13.5 8 17 12 17s6.9-3.5 7.9-5.1C18.9 10.3 16 7 12 7Zm0 2.2a2.8 2.8 0 1 1 0 5.6 2.8 2.8 0 0 1 0-5.6Zm0 2a.8.8 0 1 0 0 1.6.8.8 0 0 0 0-1.6Z"></path></svg>';

        toggle.addEventListener('click', () => {
          const isVisible = input.type === 'text';
          input.type = isVisible ? 'password' : 'text';
          toggle.setAttribute('aria-label', isVisible ? 'Wachtwoord tonen' : 'Wachtwoord verbergen');
          toggle.setAttribute('aria-pressed', String(!isVisible));
          wrapper.classList.toggle('is-visible', !isVisible);
        });

        wrapper.appendChild(toggle);
      });
    </script>
  </body>
</html>
    <?php
}

maatlas_admin_bootstrap_session();
