<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

function maatlas_admin_send_password_reset_link(array $admin, string $token): bool
{
    $link = maatlas_admin_base_url() . '/reset-password.php?token=' . rawurlencode($token);
    $body = "Hallo " . ($admin['full_name'] ?: $admin['username']) . ",\n\n"
        . "Er werd een wachtwoordreset aangevraagd voor je Daliasprojects beheeraccount.\n"
        . "Kies een nieuw wachtwoord via deze link:\n\n"
        . $link . "\n\n"
        . "Deze link is 2 uur geldig. Heb je dit niet aangevraagd, dan mag je deze mail negeren.\n";

    return maatlas_admin_send_mail((string) $admin['email'], 'Reset je Daliasprojects adminwachtwoord', $body);
}

$currentAdmin = maatlas_admin_current_admin();
if ($currentAdmin) {
    maatlas_admin_redirect('./');
}

$token = trim((string) ($_GET['token'] ?? $_POST['token'] ?? ''));
$admins = maatlas_admin_read_admins();
$targetAdmin = $token !== '' ? maatlas_admin_find_by_password_reset_token($admins, $token) : null;
$tokenValid = false;
$message = '';

if ($token !== '') {
    if ($targetAdmin) {
        $expires = strtotime((string) ($targetAdmin['password_reset_expires_at'] ?? ''));
        $tokenValid = $expires !== false && $expires >= time() && !empty($targetAdmin['active']);
        if (!$tokenValid) {
            $message = 'Deze resetlink is verlopen of niet meer geldig.';
        }
    } else {
        $message = 'Deze resetlink is ongeldig.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        maatlas_admin_require_csrf();
        $action = (string) ($_POST['action'] ?? '');

        if ($action === 'request_reset') {
            $login = trim((string) ($_POST['login'] ?? ''));
            if ($login === '') {
                throw new RuntimeException('Vul je gebruikersnaam of e-mailadres in.');
            }

            $admin = maatlas_admin_find_by_username_or_email($admins, $login);
            if ($admin) {
                [$resetToken, $resetHash] = maatlas_admin_make_activation_token();
                $index = maatlas_admin_find_admin_index($admins, (string) $admin['id']);
                if ($index !== null) {
                    $admins[$index]['password_reset_token_hash'] = $resetHash;
                    $admins[$index]['password_reset_expires_at'] = gmdate('c', time() + 2 * 60 * 60);
                    $admins[$index]['updated_at'] = gmdate('c');
                    maatlas_admin_save_admins($admins);
                    maatlas_admin_send_password_reset_link($admins[$index], $resetToken);
                }
            }

            maatlas_admin_flash('Als dit account bestaat en actief is, werd er een resetlink per e-mail verstuurd.', 'success');
            maatlas_admin_redirect('./login.php');
        }

        if ($action === 'set_password') {
            if (!$targetAdmin || !$tokenValid) {
                throw new RuntimeException('Deze resetlink is niet geldig.');
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
            $admins[$index]['password_reset_token_hash'] = null;
            $admins[$index]['password_reset_expires_at'] = null;
            $admins[$index]['updated_at'] = gmdate('c');
            $admins[$index]['last_login'] = gmdate('c');
            maatlas_admin_save_admins($admins);
            maatlas_admin_login_admin($admins[$index]);
            maatlas_admin_flash('Je wachtwoord is gewijzigd.', 'success');
            maatlas_admin_redirect('./');
        }

        throw new RuntimeException('Onbekende actie.');
    } catch (Throwable $exception) {
        maatlas_admin_flash($exception->getMessage(), 'error');
        maatlas_admin_redirect($token !== '' ? './reset-password.php?token=' . rawurlencode($token) : './reset-password.php');
    }
}

$csrf = maatlas_admin_csrf_token();
maatlas_admin_render_header('Wachtwoord resetten');
?>
<section class="admin-auth-grid">
  <article class="admin-card admin-card--login">
    <p class="eyebrow">Toegang</p>
    <?php if ($token !== ''): ?>
      <h2>Kies een nieuw wachtwoord</h2>
      <?php if (!$tokenValid): ?>
        <p class="lead"><?= maatlas_admin_e($message) ?></p>
        <div class="button-row">
          <a class="btn btn--secondary" href="./reset-password.php">Nieuwe reset aanvragen</a>
          <a class="btn btn--secondary" href="./login.php">Naar login</a>
        </div>
      <?php else: ?>
        <p class="lead">Kies een nieuw wachtwoord voor <?= maatlas_admin_e($targetAdmin['full_name'] ?: $targetAdmin['username']) ?>.</p>
        <form method="post" class="admin-form">
          <input type="hidden" name="csrf" value="<?= maatlas_admin_e($csrf) ?>" />
          <input type="hidden" name="action" value="set_password" />
          <input type="hidden" name="token" value="<?= maatlas_admin_e($token) ?>" />
          <label>
            Nieuw wachtwoord
            <input type="password" name="password" autocomplete="new-password" required minlength="12" />
          </label>
          <label>
            Herhaal wachtwoord
            <input type="password" name="password_repeat" autocomplete="new-password" required minlength="12" />
          </label>
          <div class="button-row">
            <button class="btn btn--primary" type="submit">Wachtwoord opslaan</button>
          </div>
        </form>
      <?php endif; ?>
    <?php else: ?>
      <h2>Wachtwoord vergeten?</h2>
      <p class="lead">Vul je gebruikersnaam of e-mailadres in. Als het account actief is, sturen we een resetlink.</p>
      <form method="post" class="admin-form">
        <input type="hidden" name="csrf" value="<?= maatlas_admin_e($csrf) ?>" />
        <input type="hidden" name="action" value="request_reset" />
        <label>
          Gebruikersnaam of e-mailadres
          <input type="text" name="login" autocomplete="username" required />
        </label>
        <div class="button-row">
          <button class="btn btn--primary" type="submit">Resetlink versturen</button>
          <a class="btn btn--secondary" href="./login.php">Terug naar login</a>
        </div>
      </form>
    <?php endif; ?>
  </article>
  <aside class="admin-card admin-card--notes">
    <p class="eyebrow">Beveiliging</p>
    <h2>Geen wachtwoorden in e-mail</h2>
    <ul class="admin-list">
      <li>De resetlink is 2 uur geldig.</li>
      <li>Alleen de SHA-256 hash van de reset-token wordt opgeslagen.</li>
      <li>Het nieuwe wachtwoord wordt opnieuw gehasht opgeslagen.</li>
    </ul>
  </aside>
</section>
<?php
maatlas_admin_render_footer();
