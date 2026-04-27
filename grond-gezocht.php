<?php
require __DIR__ . '/includes/site.php';
$pageTitle = 'Grond te koop? — Daliasprojects';
$pageDescription = 'Daliasprojects zoekt gronden en panden voor hoogwaardige vastgoedontwikkeling.';
$activeNav = 'grond-gezocht';
$bodyPage = 'land-search';
$canonicalPath = './grond-gezocht.php';
require __DIR__ . '/includes/header.php';
?>
    <main class="site-main land-page">
      <?php if (dalia_section_enabled('land.hero')): ?>
      <section class="page-hero page-hero--land">
        <div class="container page-hero__grid">
          <div class="page-hero__copy">
            <p class="eyebrow">Grond te koop?</p>
            <h1>Een discreet gesprek over uw grond of pand.</h1>
            <p class="lead">Bent u eigenaar van een stuk grond of pand? Daliasprojects is continu op zoek naar interessante kansen voor hoogwaardige ontwikkeling. Wij zorgen voor een snelle en discrete afhandeling aan marktconforme prijzen.</p>
          </div>
          <div class="page-hero__panel panel">
            <img src="https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/4c541007-4e78-48dc-bded-fe61b215d6b5/Chateaux+real+estate+%2818+van+86%29.jpg" alt="Ontwikkelingsgrond voor Daliasprojects" />
          </div>
        </div>
      </section>
      <?php endif; ?>
      <?php if (dalia_section_enabled('land.form')): ?>
      <section class="section">
        <div class="container lead-form-grid">
          <div>
            <p class="eyebrow">Aanpak</p>
            <h2>Correct, snel en zonder publieke ruis.</h2>
            <p>We beoordelen ligging, schaal, haalbaarheid en marktwaarde. U krijgt een duidelijk antwoord en, wanneer de locatie past, een concreet voorstel met respect voor timing en vertrouwelijkheid.</p>
          </div>
          <form class="site-form" action="./contact-submit.php" method="post">
            <input type="hidden" name="subject_type" value="grond te koop" />
            <label>Naam<input type="text" name="name" autocomplete="name" required /></label>
            <label>E-mail<input type="email" name="email" autocomplete="email" required /></label>
            <label>Telefoon<input type="tel" name="phone" autocomplete="tel" /></label>
            <label>Gemeente of ligging<input type="text" name="project" /></label>
            <label>Bericht<textarea name="message" rows="6" required></textarea></label>
            <button class="btn btn--primary" type="submit">Neem contact op</button>
          </form>
        </div>
      </section>
      <?php endif; ?>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
