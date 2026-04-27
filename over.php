<?php
require __DIR__ . '/includes/site.php';
$pageTitle = 'Over ons — Daliasprojects';
$pageDescription = 'Lees meer over Daliasprojects als familiaal vastgoedbedrijf, onze waarden en vacatures.';
$activeNav = 'over';
$bodyPage = 'about';
$canonicalPath = './over.php';
require __DIR__ . '/includes/header.php';
?>
    <main class="site-main about-page">
      <?php if (dalia_section_enabled('about.hero')): ?>
      <section class="page-hero">
        <div class="container page-hero__grid">
          <div class="page-hero__copy">
            <p class="eyebrow">Over ons</p>
            <h1>Een familiebedrijf met vastgoed als lange termijnopdracht.</h1>
            <p class="lead">Daliasprojects ontwikkelt vanuit vertrouwen, duidelijke afspraken en een sterke aandacht voor locatie, architectuur en leefkwaliteit.</p>
          </div>
          <div class="page-hero__panel panel">
            <img src="https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/5b6600a9-5bfb-4c40-9ef2-9285d8e553e4/Chateaux+real+estate+2+%2837+van+64%29.jpg" alt="Daliasprojects over ons" />
          </div>
        </div>
      </section>
      <?php endif; ?>
      <?php if (dalia_section_enabled('about.chapters')): ?>
      <section class="section about-chapters">
        <div class="container chapter-list">
          <article class="chapter-card"><p class="eyebrow">3.1 Wie zijn wij</p><h2>Familiaal, betrokken en financieel doordacht.</h2><p>Als familiebedrijf werkt Daliasprojects met een directe lijn tussen beslissing, uitvoering en opvolging. Die korte keten zorgt voor heldere communicatie en een persoonlijke aanpak voor eigenaars, kopers en partners.</p></article>
          <article class="chapter-card"><p class="eyebrow">3.2 Waarden en normen</p><h2>Correctheid, discretie en kwaliteit.</h2><p>We zoeken projecten die steden, buurten en bewoners duurzaam versterken. Elke ontwikkeling moet kloppen in schaal, rendement, architectuur en gebruiksgemak.</p></article>
          <article class="chapter-card"><p class="eyebrow">3.3 Vacatures</p><h2>Geen openstaande vacatures.</h2><p>Momenteel zijn er geen openstaande vacatures. Spontane kennismaking kan altijd via het contactformulier.</p></article>
        </div>
      </section>
      <?php endif; ?>
      <?php if (dalia_section_enabled('about.personnel')): ?>
      <section class="section personnel-section" id="personeel">
        <div class="container">
          <div class="section__heading"><div><p class="eyebrow">Personeel</p><h2>Ons team</h2></div></div>
          <div class="personnel-grid">
            <?php foreach (dalia_personnel() as $person): ?>
              <?php dalia_render_person_card($person); ?>
            <?php endforeach; ?>
          </div>
        </div>
      </section>
      <?php endif; ?>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
