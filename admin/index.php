<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

$currentAdmin = maatlas_admin_require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        maatlas_admin_require_csrf();
        $action = (string) ($_POST['action'] ?? '');

        if ($action !== 'save_settings') {
            throw new RuntimeException('Onbekende actie.');
        }

        $heroVideoUrl = trim((string) ($_POST['heroVideoUrl'] ?? ''));
        $heroPosterUrl = trim((string) ($_POST['heroPosterUrl'] ?? ''));
        $pageTitleBarHeight = filter_var($_POST['pageTitleBarHeight'] ?? null, FILTER_VALIDATE_INT);
        $pageTitleBarRadiusLeft = filter_var($_POST['pageTitleBarRadiusLeft'] ?? null, FILTER_VALIDATE_INT);
        $pageTitleBarRadiusRight = filter_var($_POST['pageTitleBarRadiusRight'] ?? null, FILTER_VALIDATE_INT);
        $contactSenderEmail = trim((string) ($_POST['contact_sender_email'] ?? ''));
        $publicEmail = trim((string) ($_POST['public_email'] ?? ''));
        $privacyEmail = trim((string) ($_POST['privacy_email'] ?? ''));
        $publicPhone = trim((string) ($_POST['public_phone'] ?? ''));
        $addressLine1 = trim((string) ($_POST['contact_address_line_1'] ?? ''));
        $addressLine2 = trim((string) ($_POST['contact_address_line_2'] ?? ''));
        $mapsEmbedUrl = trim((string) ($_POST['maps_embed_url'] ?? ''));
        $mapsLinkUrl = trim((string) ($_POST['maps_link_url'] ?? ''));

        if ($heroVideoUrl !== '' && !preg_match('~\.(mp4|webm|mov)(\?.*)?$~i', $heroVideoUrl)) {
            throw new RuntimeException('Gebruik een directe .mp4, .webm of .mov videolink.');
        }

        if ($heroPosterUrl !== '' && !preg_match('~^(https?://|/|\\./|[A-Za-z0-9_-]+/)~', $heroPosterUrl)) {
            throw new RuntimeException('Gebruik een geldige poster-URL of lokaal pad.');
        }

        if ($pageTitleBarHeight === false || $pageTitleBarHeight < 44 || $pageTitleBarHeight > 140) {
            throw new RuntimeException('Gebruik voor de titelbalkhoogte een geheel getal tussen 44 en 140 pixels.');
        }

        if ($pageTitleBarRadiusLeft === false || $pageTitleBarRadiusLeft < 0 || $pageTitleBarRadiusLeft > 80) {
            throw new RuntimeException('Gebruik voor de linker afronding een geheel getal tussen 0 en 80 pixels.');
        }

        if ($pageTitleBarRadiusRight === false || $pageTitleBarRadiusRight < 0 || $pageTitleBarRadiusRight > 80) {
            throw new RuntimeException('Gebruik voor de rechter afronding een geheel getal tussen 0 en 80 pixels.');
        }

        foreach ([$contactSenderEmail, $publicEmail, $privacyEmail] as $email) {
            if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new RuntimeException('Gebruik geldige e-mailadressen bij de mailinstellingen.');
            }
        }

        foreach ([$mapsEmbedUrl, $mapsLinkUrl] as $url) {
            if ($url !== '' && !preg_match('~^https?://~i', $url)) {
                throw new RuntimeException('Gebruik volledige Google Maps links die starten met http:// of https://.');
            }
        }

        $postedSocials = [];
        $labels = $_POST['social_label'] ?? [];
        $urls = $_POST['social_url'] ?? [];
        $active = $_POST['social_active'] ?? [];

        if (!is_array($labels) || !is_array($urls)) {
            throw new RuntimeException('De social instellingen konden niet worden gelezen.');
        }

        foreach ($labels as $index => $label) {
            $name = trim((string) $label);
            $url = trim((string) ($urls[$index] ?? ''));
            if ($name === '') {
                continue;
            }

            if ($url !== '' && !preg_match('~^https?://~i', $url)) {
                throw new RuntimeException('Gebruik volledige social links die starten met http:// of https://.');
            }

            $postedSocials[] = [
                'label' => $name,
                'url' => $url,
                'active' => isset($active[$index]),
            ];
        }

        maatlas_admin_save_settings([
            'heroVideoUrl' => $heroVideoUrl,
            'heroPosterUrl' => $heroPosterUrl ?: MAATLAS_ADMIN_DEFAULT_HERO_IMAGE,
            'pageTitleBarHeight' => $pageTitleBarHeight,
            'pageTitleBarRadiusLeft' => $pageTitleBarRadiusLeft,
            'pageTitleBarRadiusRight' => $pageTitleBarRadiusRight,
            'contact_sender_email' => $contactSenderEmail,
            'public_email' => $publicEmail,
            'privacy_email' => $privacyEmail,
            'public_phone' => $publicPhone,
            'contact_address_line_1' => $addressLine1,
            'contact_address_line_2' => $addressLine2,
            'maps_embed_url' => $mapsEmbedUrl,
            'maps_link_url' => $mapsLinkUrl,
            'socials' => $postedSocials,
        ]);

        maatlas_admin_flash('Site-instellingen opgeslagen.', 'success');
        maatlas_admin_redirect('./');
    } catch (Throwable $exception) {
        maatlas_admin_flash($exception->getMessage(), 'error');
        maatlas_admin_redirect('./');
    }
}

$settings = maatlas_admin_read_settings();
$heroVideoPreview = trim((string) ($settings['heroVideoUrl'] ?? ''));
$heroPosterPreview = trim((string) ($settings['heroPosterUrl'] ?? MAATLAS_ADMIN_DEFAULT_HERO_IMAGE)) ?: MAATLAS_ADMIN_DEFAULT_HERO_IMAGE;
$admins = maatlas_admin_read_admins();
$activeAdmins = maatlas_admin_active_real_admin_count($admins);
$pendingAdmins = count(array_filter(
    $admins,
    static fn (array $admin): bool => empty($admin['active']) && !empty($admin['activation_token_hash'])
));
$csrf = maatlas_admin_csrf_token();

maatlas_admin_render_header('Admin', $currentAdmin);
?>
<section class="admin-stats">
  <article class="admin-stat">
    <span>Actief</span>
    <strong><?= maatlas_admin_e($activeAdmins) ?></strong>
    <small>Beheeraccounts</small>
  </article>
  <article class="admin-stat">
    <span>Uitnodigingen</span>
    <strong><?= maatlas_admin_e($pendingAdmins) ?></strong>
    <small>Wacht op bevestiging</small>
  </article>
  <article class="admin-stat">
    <span>Socials</span>
    <strong><?= maatlas_admin_e(count($settings['socials'])) ?></strong>
    <small>Kanalen in instellingen</small>
  </article>
  <article class="admin-stat">
    <span>Sessie</span>
    <strong>OK</strong>
    <small>PHP beveiligd</small>
  </article>
</section>

<nav class="admin-nav" aria-label="Admin navigatie">
  <a class="btn btn--secondary btn--small" href="./administrators.php">Beheerders</a>
  <a class="btn btn--secondary btn--small" href="./projects.php">Projecten beheren</a>
  <a class="btn btn--secondary btn--small" href="./personnel.php">Personeel</a>
  <a class="btn btn--secondary btn--small" href="../contact.php">Contact bekijken</a>
</nav>

<section class="admin-settings-layout">
  <aside class="admin-settings-menu" aria-label="Instellingen menu">
    <p class="eyebrow">Rubrieken</p>
    <a href="#homepage-film">Homepage film</a>
    <a href="#titelbalk">Titelbalk</a>
    <a href="#contactgegevens">Contactgegevens</a>
    <a href="./projects.php">Projecten beheren</a>
    <a href="./personnel.php">Personeel</a>
    <a href="#socials">Social media</a>
    <a href="#adminmails">Adminmails</a>
    <a href="#opslaan">Opslaan</a>
  </aside>

  <article class="admin-card admin-settings-panel">
    <p class="eyebrow">Site-instellingen</p>
    <h2>Homepage, contact, socials en mailafzender</h2>
    <form method="post" class="admin-form admin-form--single" data-floating-submit>
      <input type="hidden" name="action" value="save_settings" />
      <input type="hidden" name="csrf" value="<?= maatlas_admin_e($csrf) ?>" />

      <fieldset id="homepage-film" class="admin-fieldset--media admin-settings-section">
        <legend>Achtergrondfilm homepage</legend>
        <div class="admin-media-preview">
          <?php if ($heroVideoPreview !== ''): ?>
            <video muted loop playsinline controls preload="metadata" poster="<?= maatlas_admin_e($heroPosterPreview) ?>">
              <source src="<?= maatlas_admin_e($heroVideoPreview) ?>" />
            </video>
          <?php else: ?>
            <img src="<?= maatlas_admin_e($heroPosterPreview) ?>" alt="Huidige homepage poster" />
          <?php endif; ?>
          <div>
            <strong><?= $heroVideoPreview !== '' ? 'Video actief als hero-achtergrond' : 'Geen video ingesteld' ?></strong>
            <p>
              <?= $heroVideoPreview !== '' ? 'De homepage gebruikt deze film als bewegende achtergrond. De poster blijft fallback.' : 'De homepage toont nu enkel de poster-afbeelding. Voeg een directe videolink toe om een movie te tonen.' ?>
            </p>
          </div>
        </div>
        <label>
          Movie URL
          <input type="text" name="heroVideoUrl" value="<?= maatlas_admin_e($settings['heroVideoUrl'] ?? '') ?>" placeholder="/Webimages/homepage-film.mp4" />
        </label>
        <p class="admin-help">Gebruik een directe link naar een .mp4, .webm of .mov bestand. Laat leeg om alleen de poster te tonen.</p>
        <label>
          Poster-afbeelding fallback
          <input type="text" name="heroPosterUrl" value="<?= maatlas_admin_e($settings['heroPosterUrl'] ?? '') ?>" placeholder="/Webimages/poster.jpg" />
        </label>
        <p class="admin-help">Deze afbeelding wordt getoond tijdens laden, bij fout of wanneer bezoekers minder beweging verkiezen.</p>
      </fieldset>

      <fieldset id="titelbalk" class="admin-settings-section">
        <legend>Titelbalk onder de header</legend>
        <label>
          Hoogte titelbalk
          <input type="number" name="pageTitleBarHeight" min="44" max="140" step="1" value="<?= maatlas_admin_e($settings['pageTitleBarHeight'] ?? 72) ?>" />
        </label>
        <label>
          Afronding links onderaan
          <input type="number" name="pageTitleBarRadiusLeft" min="0" max="80" step="1" value="<?= maatlas_admin_e($settings['pageTitleBarRadiusLeft'] ?? 18) ?>" />
        </label>
        <label>
          Afronding rechts onderaan
          <input type="number" name="pageTitleBarRadiusRight" min="0" max="80" step="1" value="<?= maatlas_admin_e($settings['pageTitleBarRadiusRight'] ?? 18) ?>" />
        </label>
        <p class="admin-help">De bovenkant blijft altijd recht zodat de balk visueel aan de header hangt. Alleen de onderste linker- en rechterhoek zijn instelbaar.</p>
      </fieldset>

      <fieldset id="contactgegevens" class="admin-settings-section">
        <legend>Contactgegevens</legend>
        <label>
          Telefoonnummer
          <input type="text" name="public_phone" value="<?= maatlas_admin_e($settings['public_phone'] ?? '') ?>" placeholder="Jens 0499/10.50.11" />
        </label>
        <label>
          Adresregel 1
          <input type="text" name="contact_address_line_1" value="<?= maatlas_admin_e($settings['contact_address_line_1'] ?? '') ?>" placeholder="Niet tonen op de publieke site" />
        </label>
        <label>
          Adresregel 2
          <input type="text" name="contact_address_line_2" value="<?= maatlas_admin_e($settings['contact_address_line_2'] ?? '') ?>" placeholder="Niet tonen op de publieke site" />
        </label>
        <p class="admin-help">Telefoon en e-mail worden getoond. Het adres wordt momenteel niet op de publieke site weergegeven.</p>
      </fieldset>

      <fieldset id="google-maps" class="admin-settings-section">
        <legend>Google Maps contactpagina</legend>
        <label>
          Google Maps embed URL
          <input type="url" name="maps_embed_url" value="<?= maatlas_admin_e($settings['maps_embed_url'] ?? '') ?>" placeholder="https://www.google.com/maps?q=...&output=embed" />
        </label>
        <label>
          Google Maps link
          <input type="url" name="maps_link_url" value="<?= maatlas_admin_e($settings['maps_link_url'] ?? '') ?>" placeholder="https://www.google.com/maps/search/?api=1&query=..." />
        </label>
        <p class="admin-help">Gebruik bij voorkeur een embed-link met output=embed. De link opent Google Maps in een nieuw venster.</p>
      </fieldset>

      <fieldset id="socials" class="admin-fieldset--socials admin-settings-section">
        <legend>Socials contactpagina</legend>
        <div class="admin-social-block">
          <?php foreach ($settings['socials'] as $index => $social): ?>
            <div class="admin-social-row">
              <label>
                Kanaal
                <input type="text" name="social_label[<?= maatlas_admin_e($index) ?>]" value="<?= maatlas_admin_e($social['label'] ?? '') ?>" />
              </label>
              <label>
                Link
                <input type="url" name="social_url[<?= maatlas_admin_e($index) ?>]" value="<?= maatlas_admin_e($social['url'] ?? '') ?>" placeholder="https://..." />
              </label>
              <label class="admin-check">
                <input type="checkbox" name="social_active[<?= maatlas_admin_e($index) ?>]" <?= !empty($social['active']) ? 'checked' : '' ?> />
                Tonen
              </label>
            </div>
          <?php endforeach; ?>
        </div>
        <p class="admin-help">Geverifieerd gevonden: LinkedIn van DISS Europe. Facebook en Instagram blijven leeg tot er betrouwbare profielen zijn.</p>
      </fieldset>

      <fieldset id="adminmails" class="admin-settings-section">
        <legend>Adminmails</legend>
        <label>
          Afzender e-mail
          <input type="email" name="contact_sender_email" value="<?= maatlas_admin_e($settings['contact_sender_email'] ?? '') ?>" placeholder="info@daliasprojects.be" />
        </label>
        <label>
          Publieke e-mail
          <input type="email" name="public_email" value="<?= maatlas_admin_e($settings['public_email'] ?? '') ?>" placeholder="info@daliasprojects.be" />
        </label>
        <label>
          Privacy e-mail
          <input type="email" name="privacy_email" value="<?= maatlas_admin_e($settings['privacy_email'] ?? '') ?>" placeholder="privacy@daliaprojects.be" />
        </label>
        <p class="admin-help">Mail gebruikt eerst afzender e-mail, daarna publieke of privacy e-mail, daarna info@daliasprojects.be.</p>
      </fieldset>

      <div id="opslaan" class="button-row admin-settings-section">
        <button class="btn btn--primary" type="submit">Instellingen opslaan</button>
      </div>
    </form>
  </article>
</section>
<?php
maatlas_admin_render_footer();
