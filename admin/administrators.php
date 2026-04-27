<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

function maatlas_admin_invitation_expired(array $admin): bool
{
    $expires = (string) ($admin['activation_expires_at'] ?? '');
    return $expires !== '' && strtotime($expires) !== false && strtotime($expires) < time();
}

function maatlas_admin_send_activation_link(array $admin, string $token): bool
{
    $link = maatlas_admin_base_url() . '/activate.php?token=' . rawurlencode($token);
    $body = "Hallo " . ($admin['full_name'] ?: $admin['username']) . ",\n\n"
        . "Er is een beheeraccount voor je aangemaakt op de website van Daliasprojects.\n"
        . "Kies je wachtwoord via deze activatielink:\n\n"
        . $link . "\n\n"
        . "Deze link is 7 dagen geldig.\n";

    return maatlas_admin_send_mail((string) $admin['email'], 'Activeer je Daliasprojects beheeraccount', $body);
}

function maatlas_admin_send_direct_notice(array $admin): bool
{
    $body = "Hallo " . ($admin['full_name'] ?: $admin['username']) . ",\n\n"
        . "Er is een actieve beheeraccount voor je aangemaakt op de website van Daliasprojects.\n"
        . "Het wachtwoord wordt om veiligheidsredenen niet per e-mail verzonden.\n";

    return maatlas_admin_send_mail((string) $admin['email'], 'Je Daliasprojects beheeraccount is aangemaakt', $body);
}

function maatlas_admin_require_unique_username(array $admins, string $username): void
{
    if (!maatlas_admin_username_available($admins, $username)) {
        throw new RuntimeException('Deze gebruikersnaam is al in gebruik.');
    }
}

$currentAdmin = maatlas_admin_require_login();
$setupMode = !empty($currentAdmin['temporary']);
$csrf = maatlas_admin_csrf_token();
$setupOldInput = $setupMode ? maatlas_admin_old_input() : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        maatlas_admin_require_csrf();
        $action = (string) ($_POST['action'] ?? '');
        $admins = maatlas_admin_read_admins();

        if ($setupMode) {
            if ($action !== 'create_setup_admin') {
                throw new RuntimeException('Maak eerst een echte beheerder aan.');
            }

            $username = trim((string) ($_POST['username'] ?? ''));
            $firstName = trim((string) ($_POST['first_name'] ?? ''));
            $lastName = trim((string) ($_POST['last_name'] ?? ''));
            $email = trim((string) ($_POST['email'] ?? ''));
            $password = (string) ($_POST['password'] ?? '');
            $passwordRepeat = (string) ($_POST['password_repeat'] ?? '');
            $fullName = maatlas_admin_compose_full_name($firstName, $lastName);

            if ($username === '' || $firstName === '' || $lastName === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new RuntimeException('Vul gebruikersnaam, voornaam, achternaam en een geldig e-mailadres in.');
            }

            if ($password !== $passwordRepeat) {
                throw new RuntimeException('De wachtwoorden komen niet overeen.');
            }

            $passwordError = maatlas_admin_validate_password($password, $username);
            if ($passwordError !== null) {
                throw new RuntimeException($passwordError);
            }

            $realAdmins = array_values(array_filter($admins, static fn (array $admin): bool => empty($admin['temporary'])));
            maatlas_admin_require_unique_username($realAdmins, $username);

            $now = gmdate('c');
            $newAdmin = [
                'id' => 'admin-' . bin2hex(random_bytes(6)),
                'username' => $username,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'full_name' => $fullName,
                'email' => $email,
                'role' => 'superadmin',
                'active' => true,
                'temporary' => false,
                'password_hash' => password_hash($password, PASSWORD_DEFAULT),
                'activation_token_hash' => null,
                'activation_expires_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
                'last_login' => $now,
            ];

            maatlas_admin_save_admins([$newAdmin]);
            maatlas_admin_login_admin($newAdmin);
            maatlas_admin_flash('Eerste echte beheerder aangemaakt. De tijdelijke admin/admin is verwijderd.', 'success');
            maatlas_admin_redirect('./');
        }

        if (!in_array($currentAdmin['role'] ?? '', ['admin', 'superadmin'], true)) {
            throw new RuntimeException('Je hebt onvoldoende rechten voor beheerdersbeheer.');
        }

        if ($action === 'create_admin') {
            $username = trim((string) ($_POST['username'] ?? ''));
            $fullName = trim((string) ($_POST['full_name'] ?? ''));
            $email = trim((string) ($_POST['email'] ?? ''));
            $role = (string) ($_POST['role'] ?? 'admin');
            $activationMethod = (string) ($_POST['activation_method'] ?? 'invite');
            $password = (string) ($_POST['password'] ?? '');
            $passwordRepeat = (string) ($_POST['password_repeat'] ?? '');

            if ($username === '' || $fullName === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new RuntimeException('Vul gebruikersnaam, volledige naam en een geldig e-mailadres in.');
            }

            if (!in_array($role, ['admin', 'superadmin'], true)) {
                $role = 'admin';
            }

            maatlas_admin_require_unique_username($admins, $username);

            $now = gmdate('c');
            $newAdmin = [
                'id' => 'admin-' . bin2hex(random_bytes(6)),
                'username' => $username,
                'full_name' => $fullName,
                'email' => $email,
                'role' => $role,
                'active' => false,
                'temporary' => false,
                'password_hash' => '',
                'activation_token_hash' => null,
                'activation_expires_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
                'last_login' => null,
            ];

            if ($activationMethod === 'direct') {
                if ($password !== $passwordRepeat) {
                    throw new RuntimeException('De wachtwoorden komen niet overeen.');
                }

                $passwordError = maatlas_admin_validate_password($password, $username);
                if ($passwordError !== null) {
                    throw new RuntimeException($passwordError);
                }

                $newAdmin['active'] = true;
                $newAdmin['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
                $admins[] = $newAdmin;
                maatlas_admin_save_admins($admins);
                $mailSent = maatlas_admin_send_direct_notice($newAdmin);
                maatlas_admin_flash($mailSent ? 'Beheerder direct geactiveerd en verwittigd.' : 'Beheerder direct geactiveerd. Mail kon lokaal niet worden verzonden.', $mailSent ? 'success' : 'info');
                maatlas_admin_redirect('./administrators.php');
            }

            [$token, $hash] = maatlas_admin_make_activation_token();
            $newAdmin['activation_token_hash'] = $hash;
            $newAdmin['activation_expires_at'] = gmdate('c', time() + 7 * 24 * 60 * 60);
            $admins[] = $newAdmin;
            maatlas_admin_save_admins($admins);
            $mailSent = maatlas_admin_send_activation_link($newAdmin, $token);
            maatlas_admin_flash($mailSent ? 'Uitnodiging verstuurd.' : 'Uitnodiging aangemaakt. Mail kon lokaal niet worden verzonden.', $mailSent ? 'success' : 'info');
            maatlas_admin_redirect('./administrators.php');
        }

        if ($action === 'toggle_admin') {
            $adminId = trim((string) ($_POST['admin_id'] ?? ''));
            $index = maatlas_admin_find_admin_index($admins, $adminId);
            if ($index === null || !empty($admins[$index]['temporary'])) {
                throw new RuntimeException('Beheerder niet gevonden.');
            }

            if ($adminId === ($currentAdmin['id'] ?? '')) {
                throw new RuntimeException('Je kunt je eigen account niet uitschakelen.');
            }

            if (!empty($admins[$index]['active']) && maatlas_admin_active_real_admin_count($admins) <= 1) {
                throw new RuntimeException('De laatste actieve beheerder kan niet gedeactiveerd worden.');
            }

            $admins[$index]['active'] = empty($admins[$index]['active']);
            if (!empty($admins[$index]['active'])) {
                $admins[$index]['activation_token_hash'] = null;
                $admins[$index]['activation_expires_at'] = null;
            }
            $admins[$index]['updated_at'] = gmdate('c');
            maatlas_admin_save_admins($admins);
            maatlas_admin_flash('Status bijgewerkt.', 'success');
            maatlas_admin_redirect('./administrators.php');
        }

        if ($action === 'delete_admin') {
            $adminId = trim((string) ($_POST['admin_id'] ?? ''));
            $index = maatlas_admin_find_admin_index($admins, $adminId);
            if ($index === null || !empty($admins[$index]['temporary'])) {
                throw new RuntimeException('Beheerder niet gevonden.');
            }

            if ($adminId === ($currentAdmin['id'] ?? '')) {
                throw new RuntimeException('Je kunt jezelf niet verwijderen.');
            }

            if (!empty($admins[$index]['active']) && maatlas_admin_active_real_admin_count($admins) <= 1) {
                throw new RuntimeException('De laatste actieve beheerder kan niet verwijderd worden.');
            }

            array_splice($admins, $index, 1);
            maatlas_admin_save_admins($admins);
            maatlas_admin_flash('Beheerder verwijderd.', 'success');
            maatlas_admin_redirect('./administrators.php');
        }

        if ($action === 'reset_password') {
            $adminId = trim((string) ($_POST['admin_id'] ?? ''));
            $password = (string) ($_POST['password'] ?? '');
            $index = maatlas_admin_find_admin_index($admins, $adminId);
            if ($index === null || !empty($admins[$index]['temporary'])) {
                throw new RuntimeException('Beheerder niet gevonden.');
            }

            $passwordError = maatlas_admin_validate_password($password, (string) $admins[$index]['username']);
            if ($passwordError !== null) {
                throw new RuntimeException($passwordError);
            }

            $admins[$index]['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
            $admins[$index]['active'] = true;
            $admins[$index]['activation_token_hash'] = null;
            $admins[$index]['activation_expires_at'] = null;
            $admins[$index]['updated_at'] = gmdate('c');
            maatlas_admin_save_admins($admins);
            maatlas_admin_flash('Wachtwoord opnieuw gehasht en opgeslagen.', 'success');
            maatlas_admin_redirect('./administrators.php');
        }

        if ($action === 'resend_activation') {
            $adminId = trim((string) ($_POST['admin_id'] ?? ''));
            $index = maatlas_admin_find_admin_index($admins, $adminId);
            if ($index === null || !empty($admins[$index]['active']) || empty($admins[$index]['activation_token_hash'])) {
                throw new RuntimeException('Er is geen verlopen uitnodiging gevonden.');
            }

            if (!maatlas_admin_invitation_expired($admins[$index])) {
                throw new RuntimeException('Deze uitnodiging is nog geldig.');
            }

            [$token, $hash] = maatlas_admin_make_activation_token();
            $admins[$index]['activation_token_hash'] = $hash;
            $admins[$index]['activation_expires_at'] = gmdate('c', time() + 7 * 24 * 60 * 60);
            $admins[$index]['updated_at'] = gmdate('c');
            $targetAdmin = $admins[$index];
            maatlas_admin_save_admins($admins);
            $mailSent = maatlas_admin_send_activation_link($targetAdmin, $token);
            maatlas_admin_flash($mailSent ? 'Nieuwe activatiemail verstuurd.' : 'Nieuwe token aangemaakt. Mail kon lokaal niet worden verzonden.', $mailSent ? 'success' : 'info');
            maatlas_admin_redirect('./administrators.php');
        }

        throw new RuntimeException('Onbekende actie.');
    } catch (Throwable $exception) {
        if ($setupMode && $action === 'create_setup_admin') {
            maatlas_admin_old_input([
                'username' => trim((string) ($_POST['username'] ?? '')),
                'first_name' => trim((string) ($_POST['first_name'] ?? '')),
                'last_name' => trim((string) ($_POST['last_name'] ?? '')),
                'email' => trim((string) ($_POST['email'] ?? '')),
            ]);
        }
        maatlas_admin_flash($exception->getMessage(), 'error');
        maatlas_admin_redirect($setupMode ? './administrators.php?setup=1' : './administrators.php');
    }
}

$admins = maatlas_admin_read_admins();
$realAdmins = array_values(array_filter($admins, static fn (array $admin): bool => empty($admin['temporary'])));

maatlas_admin_render_header($setupMode ? 'Eerste setup' : 'Beheerders', $currentAdmin);
?>
<?php if ($setupMode): ?>
  <section class="admin-auth-grid">
    <article class="admin-card admin-card--login">
      <p class="eyebrow">Eerste setup</p>
      <h2>Maak de eerste echte beheerder aan</h2>
      <p class="lead">Na het opslaan wordt de tijdelijke admin/admin automatisch verwijderd en word je ingelogd als superadmin.</p>
      <form method="post" class="admin-form" data-floating-submit>
        <input type="hidden" name="action" value="create_setup_admin" />
        <input type="hidden" name="csrf" value="<?= maatlas_admin_e($csrf) ?>" />
        <label>
          Gebruikersnaam
          <input type="text" name="username" autocomplete="username" value="<?= maatlas_admin_e(maatlas_admin_old_input_value($setupOldInput, 'username')) ?>" required />
        </label>
        <div class="admin-form-row admin-form-row--two">
          <label>
            Voornaam
            <input type="text" name="first_name" autocomplete="given-name" value="<?= maatlas_admin_e(maatlas_admin_old_input_value($setupOldInput, 'first_name')) ?>" required />
          </label>
          <label>
            Achternaam
            <input type="text" name="last_name" autocomplete="family-name" value="<?= maatlas_admin_e(maatlas_admin_old_input_value($setupOldInput, 'last_name')) ?>" required />
          </label>
        </div>
        <label>
          E-mailadres
          <input type="email" name="email" autocomplete="email" value="<?= maatlas_admin_e(maatlas_admin_old_input_value($setupOldInput, 'email')) ?>" required />
        </label>
        <label>
          Veilig wachtwoord
          <input type="password" name="password" autocomplete="new-password" required minlength="12" />
        </label>
        <label>
          Herhaal wachtwoord
          <input type="password" name="password_repeat" autocomplete="new-password" required minlength="12" />
        </label>
        <div class="button-row">
          <button class="btn btn--primary" type="submit">Eerste beheerder aanmaken</button>
        </div>
      </form>
    </article>
  </section>
<?php else: ?>
  <nav class="admin-nav" aria-label="Admin navigatie">
    <a class="btn btn--secondary btn--small" href="./">Instellingen</a>
    <a class="btn btn--secondary btn--small" href="./logout.php">Uitloggen</a>
  </nav>

  <section class="admin-grid">
    <article class="admin-card admin-card--wide">
      <div class="admin-card__head">
        <div>
          <p class="eyebrow">Overzicht</p>
          <h2>Beheeraccounts</h2>
        </div>
      </div>
      <div class="table-wrap">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Gebruikersnaam</th>
              <th>Naam</th>
              <th>Rol</th>
              <th>Status</th>
              <th>Laatste login</th>
              <th>Acties</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($realAdmins as $admin): ?>
              <?php $expired = maatlas_admin_invitation_expired($admin); ?>
              <tr>
                <td><?= maatlas_admin_e($admin['username']) ?></td>
                <td>
                  <strong><?= maatlas_admin_e($admin['full_name']) ?></strong>
                  <div class="admin-muted"><?= maatlas_admin_e($admin['email']) ?></div>
                </td>
                <td><?= maatlas_admin_e(maatlas_admin_role_label((string) $admin['role'])) ?></td>
                <td>
                  <span class="admin-pill <?= !empty($admin['active']) ? 'is-on' : ($expired ? 'is-expired' : 'is-off') ?>">
                    <?= maatlas_admin_e(maatlas_admin_status_label($admin)) ?>
                  </span>
                  <?php if ($expired): ?><div class="admin-muted">Uitnodiging verlopen</div><?php endif; ?>
                </td>
                <td><?= maatlas_admin_e(maatlas_admin_format_datetime($admin['last_login'] ?? null)) ?></td>
                <td>
                  <div class="admin-actions">
                    <form method="post">
                      <input type="hidden" name="action" value="toggle_admin" />
                      <input type="hidden" name="csrf" value="<?= maatlas_admin_e($csrf) ?>" />
                      <input type="hidden" name="admin_id" value="<?= maatlas_admin_e($admin['id']) ?>" />
                      <button class="btn btn--secondary btn--small" type="submit" <?= ($admin['id'] === ($currentAdmin['id'] ?? '')) ? 'disabled' : '' ?>>
                        <?= !empty($admin['active']) ? 'Deactiveer' : 'Activeer' ?>
                      </button>
                    </form>
                    <?php if ($expired): ?>
                      <form method="post">
                        <input type="hidden" name="action" value="resend_activation" />
                        <input type="hidden" name="csrf" value="<?= maatlas_admin_e($csrf) ?>" />
                        <input type="hidden" name="admin_id" value="<?= maatlas_admin_e($admin['id']) ?>" />
                        <button class="btn btn--secondary btn--small" type="submit">Mail opnieuw</button>
                      </form>
                    <?php endif; ?>
                    <form method="post" onsubmit="return confirm('Beheerder verwijderen?');">
                      <input type="hidden" name="action" value="delete_admin" />
                      <input type="hidden" name="csrf" value="<?= maatlas_admin_e($csrf) ?>" />
                      <input type="hidden" name="admin_id" value="<?= maatlas_admin_e($admin['id']) ?>" />
                      <button class="btn btn--secondary btn--small" type="submit" <?= ($admin['id'] === ($currentAdmin['id'] ?? '')) ? 'disabled' : '' ?>>Verwijder</button>
                    </form>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </article>

    <article class="admin-card">
      <p class="eyebrow">Toevoegen</p>
      <h2>Nieuwe beheerder</h2>
      <form method="post" class="admin-form">
        <input type="hidden" name="action" value="create_admin" />
        <input type="hidden" name="csrf" value="<?= maatlas_admin_e($csrf) ?>" />
        <label>
          Gebruikersnaam
          <input type="text" name="username" autocomplete="username" required />
        </label>
        <label>
          Volledige naam
          <input type="text" name="full_name" autocomplete="name" required />
        </label>
        <label>
          E-mailadres
          <input type="email" name="email" autocomplete="email" required />
        </label>
        <label>
          Rol
          <select name="role">
            <option value="admin">Admin</option>
            <option value="superadmin">Superadmin</option>
          </select>
        </label>
        <label>
          Activatiemethode
          <select name="activation_method">
            <option value="invite">Activatie pas na bevestiging via e-mail</option>
            <option value="direct">Direct activeren</option>
          </select>
        </label>
        <label>
          Startwachtwoord bij directe activatie
          <input type="password" name="password" autocomplete="new-password" minlength="12" />
        </label>
        <label>
          Herhaal startwachtwoord
          <input type="password" name="password_repeat" autocomplete="new-password" minlength="12" />
        </label>
        <p class="admin-help">Bij activatie via e-mail kiest de nieuwe beheerder zelf een wachtwoord. Bij directe activatie wordt het wachtwoord niet gemaild.</p>
        <div class="button-row">
          <button class="btn btn--primary" type="submit">Beheerder toevoegen</button>
        </div>
      </form>
    </article>

    <article class="admin-card">
      <p class="eyebrow">Onderhoud</p>
      <h2>Wachtwoord wijzigen</h2>
      <form method="post" class="admin-form">
        <input type="hidden" name="action" value="reset_password" />
        <input type="hidden" name="csrf" value="<?= maatlas_admin_e($csrf) ?>" />
        <label>
          Beheerder
          <select name="admin_id" required>
            <option value="">Kies beheerder</option>
            <?php foreach ($realAdmins as $admin): ?>
              <option value="<?= maatlas_admin_e($admin['id']) ?>"><?= maatlas_admin_e($admin['full_name'] . ' - ' . $admin['username']) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <label>
          Nieuw wachtwoord
          <input type="password" name="password" autocomplete="new-password" required minlength="12" />
        </label>
        <div class="button-row">
          <button class="btn btn--secondary" type="submit">Wachtwoord opslaan</button>
        </div>
      </form>
    </article>
  </section>
<?php endif; ?>
<?php
maatlas_admin_render_footer();
