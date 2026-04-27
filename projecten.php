<?php
require __DIR__ . '/includes/site.php';
$pageTitle = 'Portfolio — Daliasprojects';
$pageDescription = 'Portfolio van Daliasprojects met lopende projecten, projecten in voorbereiding, toekomstige projecten en gerealiseerde referenties.';
$activeNav = 'projecten';
$bodyPage = 'projects';
$canonicalPath = './projecten.php';
require __DIR__ . '/includes/header.php';
?>
    <main class="site-main portfolio-page">
      <?php if (dalia_section_enabled('projects.hero')): ?>
      <section class="page-hero page-hero--portfolio">
        <div class="container page-hero__grid">
          <div class="page-hero__copy">
            <p class="eyebrow">Portfolio</p>
            <h1>Projecten met focus op ligging, architectuur en duurzame waarde.</h1>
            <p class="lead">Een helder overzicht van lopende projecten in verkoop, projecten in voorbereiding, toekomstige projecten en gerealiseerde referenties.</p>
          </div>
          <div class="page-hero__panel panel panel--gallery">
            <div class="gallery-rail">
              <?php foreach (array_slice(dalia_projects_by_group('current'), 0, 6) as $project): ?>
                <a class="gallery-card" href="./project.php?slug=<?= rawurlencode((string) $project['slug']) ?>">
                  <img src="<?= dalia_e($project['hero'] ?? '') ?>" alt="<?= dalia_e($project['title'] ?? '') ?>" loading="lazy" />
                  <span class="gallery-card__label"><?= dalia_e($project['title'] ?? '') ?></span>
                </a>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </section>
      <?php endif; ?>

      <?php foreach ([
        'current' => ['1.1', 'Lopende projecten'],
        'preparation' => ['1.2', 'Projecten in voorbereiding'],
        'future' => ['1.3', 'Toekomstige projecten'],
        'realized' => ['1.4', 'Gerealiseerde projecten'],
      ] as $group => [$number, $title]): ?>
        <?php if (!dalia_section_enabled('projects.' . $group)) { continue; } ?>
        <section class="section portfolio-section <?= $group === 'future' ? 'portfolio-section--quiet' : '' ?>" id="<?= dalia_e($group) ?>">
          <div class="container">
            <div class="section__heading">
              <div>
                <p class="eyebrow"><?= dalia_e($number) ?></p>
                <h2><?= dalia_e($title) ?></h2>
              </div>
            </div>
            <div class="portfolio-grid <?= $group === 'current' ? 'portfolio-grid--current' : '' ?>">
              <?php foreach (dalia_projects_by_group($group) as $project): ?>
                <?php dalia_render_project_tile($project); ?>
              <?php endforeach; ?>
            </div>
          </div>
        </section>
      <?php endforeach; ?>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
