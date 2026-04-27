<?php
require __DIR__ . '/includes/site.php';
$project = dalia_project_by_slug((string) ($_GET['slug'] ?? ''));
if (!$project) {
    http_response_code(404);
    $project = ['title' => 'Project niet gevonden', 'summary' => '', 'hero' => './Webimages/logo.png'];
}
$pageTitle = ($project['title'] ?? 'Project') . ' — Daliasprojects';
$pageDescription = (string) ($project['summary'] ?? 'Projectdetail van Daliasprojects.');
$activeNav = 'projecten';
$bodyPage = 'project';
$canonicalPath = './project.php?slug=' . rawurlencode((string) ($project['slug'] ?? ''));
$salesUrl = (string) ($project['sales_url'] ?? 'https://www.sbcvastgoed.be/');
$salesOffice = (string) ($project['sales_office'] ?? 'SBC Vastgoed');
$gallery = dalia_gallery($project);
$galleryPrimary = $gallery[0] ?? (string) ($project['hero'] ?? './Webimages/logo.png');
require __DIR__ . '/includes/header.php';
?>
    <main class="site-main project-detail-page">
      <?php if (dalia_section_enabled('project.hero')): ?>
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
      <?php endif; ?>

      <?php if (dalia_section_enabled('project.sales')): ?>
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
      <?php endif; ?>

      <?php if (dalia_section_enabled('project.overview')): ?>
      <section class="section project-overview">
        <div class="container project-detail-grid">
          <article class="detail-card"><p class="eyebrow">Projectomschrijving</p><blockquote><?= dalia_e($project['quote'] ?? '') ?></blockquote></article>
          <article class="detail-card"><p class="eyebrow">Context</p><p><?= dalia_e($project['context'] ?? '') ?></p></article>
        </div>
      </section>
      <?php endif; ?>

      <?php if (dalia_section_enabled('project.gallery')): ?>
      <section class="section">
        <div class="container">
          <div class="section__heading"><div><p class="eyebrow">Beelden</p><h2>Slideshow en renders.</h2></div></div>
          <div class="project-gallery-viewer" data-project-viewer>
            <div class="project-gallery-stage panel">
              <button class="project-gallery-nav project-gallery-nav--prev" type="button" aria-label="Vorige foto" data-project-nav="prev">‹</button>
              <img
                class="project-gallery-stage__image"
                src="<?= dalia_e($galleryPrimary) ?>"
                alt="<?= dalia_e($project['title'] ?? '') ?>"
                loading="eager"
                data-project-stage-image
              />
              <button class="project-gallery-nav project-gallery-nav--next" type="button" aria-label="Volgende foto" data-project-nav="next">›</button>
            </div>
            <div class="project-gallery-thumbs" aria-label="Projectfoto's">
              <?php foreach ($gallery as $index => $src): ?>
                <button
                  class="project-gallery-thumb<?= $index === 0 ? ' is-active' : '' ?>"
                  type="button"
                  data-project-thumb
                  data-project-index="<?= dalia_e($index) ?>"
                  data-project-src="<?= dalia_e($src) ?>"
                  aria-label="Toon foto <?= dalia_e($index + 1) ?>"
                  aria-pressed="<?= $index === 0 ? 'true' : 'false' ?>"
                >
                  <img src="<?= dalia_e($src) ?>" alt="<?= dalia_e($project['title'] ?? '') ?>" loading="lazy" />
                </button>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </section>
      <?php endif; ?>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
