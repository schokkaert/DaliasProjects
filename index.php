<?php
require __DIR__ . '/includes/site.php';
$pageTitle = 'Daliasprojects | Ontdek duurzame vastgoedmogelijkheden';
$pageDescription = 'Daliasprojects ontwikkelt duurzame vastgoedprojecten met focus op vertrouwen, kwaliteit en meerwaarde.';
$activeNav = 'home';
$bodyPage = 'home';
$canonicalPath = './index.php';
$settings = dalia_settings();
$featuredProjects = array_slice(dalia_projects(), 0, 6);
require __DIR__ . '/includes/header.php';
?>
    <main class="site-main">
      <?php if (dalia_section_enabled('home.hero')): ?>
      <section class="hero hero--cinematic home-manifesto">
        <div class="hero__background" data-home-hero-media aria-hidden="true">
          <div class="hero-media__frame">
            <?php if (!empty($settings['heroVideoUrl'])): ?>
              <video class="hero-media__video" autoplay muted loop playsinline preload="auto" poster="<?= dalia_e($settings['heroPosterUrl'] ?? '') ?>">
                <source src="<?= dalia_e($settings['heroVideoUrl']) ?>" type="video/mp4" />
              </video>
            <?php else: ?>
              <img class="hero-media__image" src="<?= dalia_e($settings['heroPosterUrl'] ?? './Webimages/dalia-hero-building-timelapse-poster.jpg') ?>" alt="Daliasprojects" />
            <?php endif; ?>
          </div>
          <div class="hero-media__scrim"></div>
        </div>
        <div class="container hero__grid">
          <div class="hero__copy" data-reveal>
            <p class="eyebrow">Creating added value</p>
            <h1>Daliasprojects</h1>
            <p class="hero__slogan">Building on trust</p>
            <p class="lead">Bouwen begint met vertrouwen. Door aandachtig te luisteren, helder te communiceren en duurzame oplossingen te ontwikkelen, creëren we vastgoed met blijvende meerwaarde voor bewoners, eigenaars, buurten en steden.</p>
            <p class="hero__intro">Onze projecten verbinden kwaliteit met functionaliteit: residentiële ontwikkelingen, kantoren, retail en gedeelde ruimtes die stedelijke transformatie versterken, groen integreren en waarde doorgeven aan toekomstige generaties.</p>
            <div class="button-row">
              <a class="btn btn--primary" href="./projecten.php">Ontdek de projecten</a>
              <a class="btn btn--secondary" href="./grond-gezocht.php">Heeft u bouwgrond?</a>
            </div>
          </div>
          <aside class="hero__facts" data-reveal>
            <div><span>Focus</span><strong>Ontwikkeling met langetermijnwaarde</strong></div>
            <div><span>Expertise</span><strong>Residentieel, handel, kantoren en gemengde sites</strong></div>
            <div><span>Belofte</span><strong>Correct, discreet en financieel doordacht</strong></div>
          </aside>
        </div>
      </section>
      <?php endif; ?>

      <?php if (dalia_section_enabled('home.brand_visual')): ?>
      <section class="brand-visual section--quiet" aria-label="Architecturale visie">
        <div class="container">
          <figure class="brand-visual__frame" data-reveal>
            <img src="https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/636da066-40f8-4a35-ae62-55ac0c0d0e0d/Chateaux+real+estate+%289+van+86%29.jpg" alt="Architecturale vastgoedontwikkeling" loading="lazy" />
            <figcaption><span>Architecturale kwaliteit</span><strong>Een rustige, duurzame benadering van ontwikkeling.</strong></figcaption>
          </figure>
        </div>
      </section>
      <?php endif; ?>

      <?php if (dalia_section_enabled('home.intro')): ?>
      <section class="section intro-editorial">
        <div class="container intro-editorial__grid">
          <div class="intro-editorial__heading" data-reveal>
            <p class="eyebrow">Visie</p>
            <h2>Ontwikkelen met rust, visie en zekerheid.</h2>
          </div>
          <div class="intro-editorial__copy" data-reveal>
            <div class="intro-editorial__card">
              <p>Elk project vertrekt vanuit de kwaliteiten van de plek: mobiliteit, schaal, licht, groen, gebruiksgemak en economische haalbaarheid. Zo ontstaan gebouwen die vandaag helder functioneren en morgen nog relevant blijven.</p>
              <p>Voor grondeigenaars betekent dat een betrouwbare gesprekspartner: discreet, correct, financieel onderlegd en in staat om snel tot een onderbouwde beslissing te komen.</p>
            </div>
            <div class="intro-editorial__values">
              <span>Heldere analyse</span>
              <span>Correcte waardering</span>
              <span>Duurzame ontwikkeling</span>
            </div>
          </div>
        </div>
      </section>
      <?php endif; ?>

      <?php if (dalia_section_enabled('home.projects')): ?>
      <section class="section projects-showcase">
        <div class="container">
          <div class="section__heading">
            <div>
              <p class="eyebrow">Onze projecten</p>
              <h2>ONZE PROJECTEN</h2>
              <p>Een selectie van actuele, toekomstige en gerealiseerde ontwikkelingen.</p>
            </div>
            <a class="text-link" href="./projecten.php">Bekijk alle projecten</a>
          </div>
          <div class="portfolio-grid">
            <?php foreach ($featuredProjects as $project): ?>
              <?php dalia_render_project_tile($project); ?>
            <?php endforeach; ?>
          </div>
        </div>
      </section>
      <?php endif; ?>

      <?php if (dalia_section_enabled('home.land_lead')): ?>
      <section class="section land-lead">
        <div class="container land-lead__grid">
          <div class="land-lead__copy" data-reveal>
            <p class="eyebrow">Grond gezocht</p>
            <h2>Heeft u bouwgrond te koop?</h2>
            <p>Daliasprojects is actief op zoek naar nieuwe projectlocaties. We beoordelen bouwgrond snel, correct en discreet, met oog voor een faire marktprijs, financiële haalbaarheid en volledige ontzorging.</p>
            <div class="button-row">
              <a class="btn btn--primary" href="./contact.php">Neem contact op</a>
              <a class="btn btn--secondary" href="./grond-gezocht.php">Meer over grond verkopen</a>
            </div>
          </div>
          <div class="land-lead__points" data-reveal>
            <article><span>01</span><strong>Snelle beslissing</strong><p>Financiële kennis en realistische projectanalyse vanaf het eerste gesprek.</p></article>
            <article><span>02</span><strong>Discreet traject</strong><p>Een correcte aanpak met respect voor eigenaar, omgeving en timing.</p></article>
            <article><span>03</span><strong>Zekerheid</strong><p>Ondersteuning van eerste inschatting tot overeenkomst en verdere opvolging.</p></article>
          </div>
        </div>
      </section>
      <?php endif; ?>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
