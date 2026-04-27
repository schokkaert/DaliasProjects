<?php
require __DIR__ . '/includes/site.php';
$pageTitle = 'Voorwaarden — Daliasprojects';
$pageDescription = 'Voorwaarden van Daliasprojects.';
$activeNav = 'legal';
$bodyPage = 'legal';
$canonicalPath = './voorwaarden.php';
require __DIR__ . '/includes/header.php';
?>
    <main class="site-main">
      <?php if (dalia_section_enabled('terms.hero')): ?>
      <section class="page-hero page-hero--narrow">
        <div class="container">
          <p class="eyebrow">Voorwaarden</p>
          <h1>Gebruik van deze website</h1>
          <p class="lead">De informatie op deze website is algemeen en wordt met zorg samengesteld.</p>
        </div>
      </section>
      <?php endif; ?>
      <?php if (dalia_section_enabled('terms.content')): ?>
      <section class="section">
        <div class="container text-grid">
          <article class="text-card"><h2>Informatie</h2><p>Projectinformatie, beschikbaarheden en prijzen kunnen wijzigen. Contacteer ons voor de meest actuele informatie.</p></article>
          <article class="text-card"><h2>Aansprakelijkheid</h2><p>Daliasprojects kan niet aansprakelijk worden gesteld voor onvolledigheden of tijdelijke technische fouten op de website.</p></article>
        </div>
      </section>
      <?php endif; ?>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
