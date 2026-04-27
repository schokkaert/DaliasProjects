<?php
require __DIR__ . '/includes/site.php';
$pageTitle = 'Cookiebeleid — Daliasprojects';
$pageDescription = 'Cookiebeleid van Daliasprojects.';
$activeNav = 'legal';
$bodyPage = 'legal';
$canonicalPath = './cookies.php';
require __DIR__ . '/includes/header.php';
?>
    <main class="site-main">
      <?php if (dalia_section_enabled('cookies.hero')): ?>
      <section class="page-hero page-hero--narrow">
        <div class="container">
          <p class="eyebrow">Cookiebeleid</p>
          <h1>Cookies</h1>
          <p class="lead">Deze website gebruikt enkel functionele cookies om de site goed te laten werken.</p>
        </div>
      </section>
      <?php endif; ?>
      <?php if (dalia_section_enabled('cookies.content')): ?>
      <section class="section">
        <div class="container text-grid">
          <article class="text-card"><h2>Functionele cookies</h2><p>Functionele cookies bewaren bijvoorbeeld uw cookievoorkeur. Ze zijn nodig voor een correcte werking van de website.</p></article>
          <article class="text-card"><h2>Voorkeur wijzigen</h2><p>U kan cookies wissen via de instellingen van uw browser.</p></article>
        </div>
      </section>
      <?php endif; ?>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
