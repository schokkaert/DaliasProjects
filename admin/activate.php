<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

$token = trim((string) ($_GET['token'] ?? $_POST['token'] ?? ''));
$admins = maatlas_admin_read_admins();
$targetAdmin = $token !== '' ? maatlas_admin_find_by_token($admins, $token) : null;
$tokenValid = false;
$message = '';

if ($targetAdmin) {
    $expires = strtotime((string) ($targetAdmin['activation_expires_at'] ?? ''));
    $tokenValid = $expires !== false && $expires >= time() && empty($targetAdmin['active']);
    if (!$tokenValid) {
        $message = 'Deze activatielink is verlopen of niet meer geldig.';
    }
} else {
    $message = 'Deze activatielink is ongeldig.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        maatlas_admin_require_csrf();

        if (!$targetAdmin || !$tokenValid) {
            throw new RuntimeException('Deze activatielink is niet geldig.');
        }

        $password = (string) ($_POST['password'] ?? '');
        $repeat = (string) ($_POST['password_repeat'] ?? '');

        if ($password !== $repeat) {
            throw new RuntimeException('De wachtwoorden komen niet overeen.');
        }

        $passwordError = maatlas_admin_validate_password($password, (string) $targetAdmin['username']);
        if ($passwordError !== null) {
            throw new RuntimeException($passwordError);
        }

        $index = maatlas_admin_find_admin_index($admins, (string) $targetAdmin['id']);
        if ($index === null) {
            throw new RuntimeException('Beheerder niet gevonden.');
        }

        $admins[$index]['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        $admins[$index]['active'] = true;
        $admins[$index]['activation_token_hash'] = null;
        $admins[$index]['activation_expires_at'] = null;
        $admins[$index]['updated_at'] = gmdate('c');
        $admins[$index]['last_login'] = gmdate('c');
        maatlas_admin_save_admins($admins);
        maatlas_admin_login_admin($admins[$index]);
        maatlas_admin_flash('Je account is geactiveerd.', 'success');
        maatlas_admin_redirect('./');
    } catch (Throwable $exception) {
        maatlas_admin_flash($exception->getMessage(), 'error');
        maatlas_admin_redirect('./activate.php?token=' . rawurlencode($token));
    }
}

$csrf = maatlas_admin_csrf_token();
maatlas_admin_render_header('Account activeren');
?>
<section class="admin-auth-grid">
  <article class="admin-card admin-card--login">
    <p class="eyebrow">Activatie</p>
    <h2>Kies je wachtwoord</h2>
    <?php if (!$tokenValid): ?>
      <p class="lead"><?= maatlas_admin_e($message) ?></p>
      <div class="button-row">
        <a class="btn btn--secondary" href="./login.php">Naar login</a>
      </div>
    <?php else: ?>
      <p class="lead">Activeer het account voor <?= maatlas_admin_e($targetAdmin['full_name']) ?>.</p>
      <form method="post" class="admin-form">
        <input type="hidden" name="csrf" value="<?= maatlas_admin_e($csrf) ?>" />
        <input type="hidden" name="token" value="<?= maatlas_admin_e($token) ?>" />
        <label>
          Wachtwoord
          <input type="password" name="password" autocomplete="new-password" required minlength="12" />
        </label>
        <label>
          Herhaal wachtwoord
          <input type="password" name="password_repeat" autocomplete="new-password" required minlength="12" />
        </label>
        <div class="button-row">
          <button class="btn btn--primary" type="submit">Account activeren</button>
        </div>
      </form>
    <?php endif; ?>
  </article>
</section>
<?php
maatlas_admin_render_footer();
