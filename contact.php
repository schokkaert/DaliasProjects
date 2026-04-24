<?php
require __DIR__ . '/includes/site.php';
$pageTitle = 'Contact — Dalia Projects';
$pageDescription = 'Contacteer Dalia Projects voor projectinformatie, grond te koop of algemene vastgoedvragen.';
$activeNav = 'contact';
$bodyPage = 'contact';
$canonicalPath = './contact.php';
$contact = dalia_contact();
require __DIR__ . '/includes/header.php';
?>
    <main class="site-main contact-page">
      <section class="page-hero page-hero--contact">
        <div class="container page-hero__grid">
          <div class="page-hero__copy">
            <p class="eyebrow">Contact</p>
            <h1>Stel uw vraag rechtstreeks aan Dalia Projects.</h1>
            <p class="lead">Voor informatie over een lopend project, een mogelijke grondverkoop of een algemene vraag kan u onderstaand formulier gebruiken.</p>
          </div>
          <div class="page-hero__panel panel">
            <img src="https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/636da066-40f8-4a35-ae62-55ac0c0d0e0d/Chateaux+real+estate+%289+van+86%29.jpg" alt="Dalia Projects contact" />
          </div>
        </div>
      </section>
      <section class="section">
        <div class="container contact-form-grid">
          <form class="site-form site-form--large" action="./contact-submit.php" method="post">
            <label>Waarover gaat uw vraag?
              <select name="subject_type" required>
                <option value="">Maak een keuze</option>
                <option value="project omschrijving">Project omschrijving</option>
                <option value="grond te koop">Grond te koop</option>
                <option value="algemene informatie">Algemene informatie</option>
              </select>
            </label>
            <label>Lopend project
              <select name="project">
                <option value="">Kies een lopend project</option>
                <?php foreach (dalia_projects_by_group('current') as $project): ?>
                  <option value="<?= dalia_e($project['title'] ?? '') ?>"><?= dalia_e($project['title'] ?? '') ?></option>
                <?php endforeach; ?>
              </select>
            </label>
            <label>Naam<input type="text" name="name" autocomplete="name" required /></label>
            <label>E-mail<input type="email" name="email" autocomplete="email" required /></label>
            <label>Telefoon<input type="tel" name="phone" autocomplete="tel" /></label>
            <label>Bericht<textarea name="message" rows="7" required></textarea></label>
            <button class="btn btn--primary" type="submit">Verstuur bericht</button>
          </form>
          <aside class="contact-side">
            <p class="eyebrow">Rechtstreeks</p>
            <h2>Jens</h2>
            <p><a href="<?= dalia_e(dalia_phone_href($contact['phone'])) ?>"><?= dalia_e($contact['phone']) ?></a></p>
            <p><a href="mailto:<?= dalia_e($contact['email']) ?>"><?= dalia_e($contact['email']) ?></a></p>
          </aside>
        </div>
      </section>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
