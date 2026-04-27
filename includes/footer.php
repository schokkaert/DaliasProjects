<?php
declare(strict_types=1);

require_once __DIR__ . '/site.php';

$contact = dalia_contact();
$socials = dalia_socials();
?>
    <footer class="site-footer" id="site-footer">
      <div class="site-footer__inner container">
        <div class="site-footer__column site-footer__brand">
          <strong>Daliasprojects</strong>
          <p>Belgische vastgoedontwikkeling met focus op vertrouwen, kwaliteit en langetermijnwaarde.</p>
        </div>
        <div class="site-footer__column">
          <strong>Contact</strong>
          <a href="<?= dalia_e(dalia_phone_href($contact['phone'])) ?>"><?= dalia_e($contact['phone']) ?></a>
          <a href="mailto:<?= dalia_e($contact['email']) ?>"><?= dalia_e($contact['email']) ?></a>
        </div>
        <div class="site-footer__column">
          <strong>Overzicht</strong>
          <a href="./index.php">Home</a>
          <a href="./projecten.php">Projecten</a>
          <a href="./over.php">Over ons</a>
          <a href="./contact.php">Contact</a>
          <a href="./voorwaarden.php">Voorwaarden</a>
        </div>
        <?php if ($socials): ?>
          <div class="site-footer__column">
            <strong>Social</strong>
            <div class="site-footer__socials">
              <?php foreach ($socials as $social): ?>
                <a class="footer-social" href="<?= dalia_e($social['url']) ?>" target="_blank" rel="noreferrer"><?= dalia_social_icon($social['label']) ?><span><?= dalia_e($social['label']) ?></span></a>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
        <div class="site-footer__column">
          <strong>Website</strong>
          <a href="./cookies.php">Cookiebeleid</a>
          <a href="./admin/">Admin</a>
          <a href="https://www.digisteps.be" target="_blank" rel="noopener">© Digisteps</a>
        </div>
      </div>
      <div class="site-footer__bottom container">
        <span>© <?= date('Y') ?> Daliasprojects. Alle rechten zijn voorbehouden.</span>
        <span class="site-footer__credits">
          <a href="./admin/" aria-label="Adminpaneel">Admin</a>
          <a href="https://www.digisteps.be" target="_blank" rel="noopener">© Digisteps</a>
        </span>
      </div>
    </footer>
    <div class="cookie-banner" id="cookie-banner" hidden>
      <div class="cookie-banner__copy">
        <strong>Cookiebeleid</strong>
        <p>Cookies worden gebruikt om de site goed te laten werken.</p>
      </div>
      <div class="cookie-banner__actions">
        <button class="btn btn--secondary btn--small" type="button" data-cookie="decline">Weiger</button>
        <button class="btn btn--secondary btn--small" type="button" data-cookie="manage">Voorkeuren</button>
        <button class="btn btn--primary btn--small" type="button" data-cookie="accept">Accepteer alles</button>
      </div>
    </div>
    <div class="mobile-quick-contact" aria-label="Snel contact">
      <a class="mobile-quick-contact__link" href="<?= dalia_e(dalia_phone_href($contact['phone'])) ?>">Bel ons</a>
      <a class="mobile-quick-contact__link mobile-quick-contact__link--primary" href="./contact.php">Contact</a>
    </div>
    <?php if (!empty($publicAdmin) && is_array($publicAdmin)): ?>
      <a class="admin-session-pill" href="./admin/" data-inline-ignore="true" aria-label="Terug naar adminpaneel">
        <span>Aangemeld</span>
        <strong><?= dalia_e($publicAdmin['full_name'] ?: $publicAdmin['username'] ?: 'Admin') ?></strong>
      </a>
    <?php endif; ?>
    <script src="./script.js?v=<?= DALIA_ASSET_VERSION ?>"></script>
  </body>
</html>
