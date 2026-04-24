<?php
require __DIR__ . '/includes/site.php';
$project = dalia_project_by_slug((string) ($_GET['slug'] ?? ''));
if (!$project) {
    http_response_code(404);
    $project = ['title' => 'Project niet gevonden', 'summary' => '', 'hero' => './Webimages/Logo.png'];
}
$pageTitle = ($project['title'] ?? 'Project') . ' — Dalia Projects';
$pageDescription = (string) ($project['summary'] ?? 'Projectdetail van Dalia Projects.');
$activeNav = 'projecten';
$bodyPage = 'project';
$canonicalPath = './project.php?slug=' . rawurlencode((string) ($project['slug'] ?? ''));
$salesUrl = (string) ($project['sales_url'] ?? 'https://www.sbcvastgoed.be/');
$salesOffice = (string) ($project['sales_office'] ?? 'SBC Vastgoed');
require __DIR__ . '/includes/header.php';
?>
    <main class="site-main project-detail-page">
      <section class="project-hero project-template">
        <div class="container project-hero__grid">
          <div class="project-hero__copy">
            <p class="eyebrow"><?= dalia_e($project['location'] ?? '') ?></p>
            <h1><?= dalia_e($project['title'] ?? '') ?></h1>
            <p class="lead"><?= dalia_e($project['summary'] ?? '') ?></p>
            <div class="project-meta">
              <div class="project-meta__item"><span>Type</span><strong><?= dalia_e($project['type'] ?? '') ?></strong></div>
              <div class="project-meta__item"><span>Status</span><strong><?= dalia_e($project['status'] ?? '') ?></strong></div>
              <div class="project-meta__item"><span>Locatie</span><strong><?= dalia_e($project['location'] ?? '') ?></strong></div>
            </div>
            <div class="button-row">
              <a class="btn btn--primary" href="<?= dalia_e($salesUrl) ?>" target="_blank" rel="noopener">Contacteer ons</a>
              <a class="btn btn--secondary" href="./projecten.php">Terug naar portfolio</a>
            </div>
          </div>
          <div class="project-hero__panel panel">
            <img src="<?= dalia_e($project['hero'] ?? '') ?>" alt="<?= dalia_e($project['title'] ?? '') ?>" />
          </div>
        </div>
      </section>

      <section class="section project-sales-section">
        <div class="container project-sales-grid">
          <article class="project-highlight-card">
            <p class="eyebrow">Belangrijke info</p>
            <h2><?= dalia_e($project['highlight'] ?? '6% btw mogelijk in plaats van 21% btw') ?></h2>
          </article>
          <article class="project-highlight-card project-highlight-card--dark">
            <p class="eyebrow">Info en verkoop</p>
            <h2>Info en verkoop: <?= dalia_e($salesOffice) ?></h2>
          </article>
        </div>
      </section>

      <section class="section project-overview">
        <div class="container project-detail-grid">
          <article class="detail-card"><p class="eyebrow">Projectomschrijving</p><blockquote><?= dalia_e($project['quote'] ?? '') ?></blockquote></article>
          <article class="detail-card"><p class="eyebrow">Context</p><p><?= dalia_e($project['context'] ?? '') ?></p></article>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <div class="section__heading"><div><p class="eyebrow">Beelden</p><h2>Slideshow en renders.</h2></div></div>
          <div class="gallery-rail gallery-rail--detail">
            <?php foreach (dalia_gallery($project) as $src): ?>
              <div class="gallery-card"><img src="<?= dalia_e($src) ?>" alt="<?= dalia_e($project['title'] ?? '') ?>" loading="lazy" /></div>
            <?php endforeach; ?>
          </div>
        </div>
      </section>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
