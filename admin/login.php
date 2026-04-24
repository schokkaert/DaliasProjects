<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

$currentAdmin = maatlas_admin_current_admin();
if ($currentAdmin) {
    maatlas_admin_redirect(!empty($currentAdmin['temporary']) ? './administrators.php?setup=1' : './');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        maatlas_admin_require_csrf();

        $username = trim((string) ($_POST['username'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        if ($username === '' || $password === '') {
            throw new RuntimeException('Vul je gebruikersnaam en wachtwoord in.');
        }

        $admin = maatlas_admin_authenticate($username, $password);
        if (!$admin) {
            throw new RuntimeException('Onjuiste gegevens of account niet actief.');
        }

        maatlas_admin_login_admin($admin);
        maatlas_admin_flash('Je bent aangemeld.', 'success');
        maatlas_admin_redirect(!empty($admin['temporary']) ? './administrators.php?setup=1' : './');
    } catch (Throwable $exception) {
        maatlas_admin_flash($exception->getMessage(), 'error');
        maatlas_admin_redirect('./login.php');
    }
}

$csrf = maatlas_admin_csrf_token();
maatlas_admin_render_header('Aanmelden');
?>
<section class="admin-auth-grid">
  <article class="admin-card admin-card--login">
    <p class="eyebrow">Toegang</p>
    <h2>Admin login</h2>
    <p class="lead">Gebruik een actieve beheeraccount om de beveiligde omgeving te openen.</p>
    <form method="post" class="admin-form">
      <input type="hidden" name="csrf" value="<?= maatlas_admin_e($csrf) ?>" />
      <label>
        Gebruikersnaam
        <input type="text" name="username" autocomplete="username" required />
      </label>
      <label>
        Wachtwoord
        <input type="password" name="password" autocomplete="current-password" required />
      </label>
      <div class="button-row">
        <button class="btn btn--primary" type="submit">Inloggen</button>
        <a class="btn btn--secondary" href="./reset-password.php">Wachtwoord vergeten?</a>
      </div>
    </form>
    <p class="admin-note">Bij eerste setup is de tijdelijke login admin / admin. Daarna moet meteen een echte beheerder worden aangemaakt.</p>
  </article>
  <aside class="admin-card admin-card--notes">
    <p class="eyebrow">Beveiliging</p>
    <h2>Server-side beheer</h2>
    <ul class="admin-list">
      <li>PHP-sessies met fallbackmap onder admin/storage/sessions</li>
      <li>CSRF-token op elke POST-actie</li>
      <li>Wachtwoorden via password_hash en password_verify</li>
      <li>Activatietokens alleen als SHA-256 hash opgeslagen</li>
    </ul>
  </aside>
</section>
<?php
maatlas_admin_render_footer();
