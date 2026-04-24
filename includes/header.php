<?php
declare(strict_types=1);

require_once __DIR__ . '/site.php';

$pageTitle = $pageTitle ?? 'Dalia Projects';
$pageDescription = $pageDescription ?? 'Dalia Projects';
$activeNav = $activeNav ?? 'home';
$bodyPage = $bodyPage ?? $activeNav;
$canonicalPath = $canonicalPath ?? './index.php';
$pageBannerTitle = $pageBannerTitle ?? dalia_page_banner_title($activeNav, $pageTitle, $bodyPage);
$pageTitleBarSettings = dalia_page_title_bar_settings();
$contact = dalia_contact();
$socials = dalia_socials();
$nav = [
    ['label' => 'Home', 'href' => './index.php', 'key' => 'home'],
    ['label' => 'Projecten', 'href' => './projecten.php', 'key' => 'projecten'],
    ['label' => 'Over', 'href' => './over.php', 'key' => 'over'],
    ['label' => 'Grond te koop?', 'href' => './grond-gezocht.php', 'key' => 'grond-gezocht'],
    ['label' => 'Contact', 'href' => './contact.php', 'key' => 'contact'],
];
?>
<!doctype html>
<html lang="nl-BE">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= dalia_e($pageTitle) ?></title>
    <meta name="description" content="<?= dalia_e($pageDescription) ?>" />
    <link rel="canonical" href="<?= dalia_e($canonicalPath) ?>" />
    <link rel="icon" type="image/png" href="./Webimages/Logo.png" />
    <link rel="stylesheet" href="./styles.css?v=<?= DALIA_ASSET_VERSION ?>" />
  </head>
  <body data-page="<?= dalia_e($bodyPage) ?>" data-active-nav="<?= dalia_e($activeNav) ?>">
    <div class="announcement">
      <div class="container announcement__inner">
        <a href="mailto:<?= dalia_e($contact['email']) ?>"><?= dalia_e($contact['email']) ?></a>
        <a href="<?= dalia_e(dalia_phone_href($contact['phone'])) ?>"><?= dalia_e($contact['phone']) ?></a>
      </div>
    </div>
    <header class="site-header" id="site-header">
      <div class="site-header__inner container">
        <a class="brand" href="./index.php" aria-label="Dalia Projects">
          <img src="./Webimages/Logo.png" alt="Dalia Projects" />
        </a>
        <nav class="nav" aria-label="Hoofdnavigatie">
          <?php foreach ($nav as $item): ?>
            <a class="nav__link <?= $item['key'] === $activeNav ? 'is-active' : '' ?>" href="<?= dalia_e($item['href']) ?>"><?= dalia_e($item['label']) ?></a>
          <?php endforeach; ?>
        </nav>
        <div class="header-actions">
          <?php if ($socials): ?>
            <div class="social-icons" aria-label="Social media">
              <?php foreach ($socials as $social): ?>
                <a href="<?= dalia_e($social['url']) ?>" target="_blank" rel="noreferrer" aria-label="<?= dalia_e($social['label']) ?>"><?= dalia_social_icon($social['label']) ?></a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
          <a class="btn btn--primary" href="./contact.php">Contact</a>
          <button class="menu-toggle" type="button" data-menu-toggle aria-label="Menu openen" aria-expanded="false">
            <span data-menu-toggle-label>Menu openen</span>
          </button>
        </div>
      </div>
      <div class="menu-panel" data-menu-panel>
        <div class="menu-panel__inner container">
          <div class="menu-panel__links">
            <?php foreach ($nav as $item): ?>
              <a class="nav__link <?= $item['key'] === $activeNav ? 'is-active' : '' ?>" href="<?= dalia_e($item['href']) ?>"><?= dalia_e($item['label']) ?></a>
            <?php endforeach; ?>
          </div>
          <div class="button-row">
            <a class="btn btn--primary" href="./contact.php">Contact</a>
            <a class="btn btn--secondary" href="./grond-gezocht.php">Grond te koop?</a>
          </div>
        </div>
      </div>
    </header>
    <div class="page-title-strip" aria-label="Paginatitel" style="<?= dalia_e(dalia_page_title_bar_style($pageTitleBarSettings)) ?>">
      <div class="container page-title-strip__inner">
        <div class="page-title-pill">
          <p class="page-title-pill__text"><?= dalia_e($pageBannerTitle) ?></p>
        </div>
      </div>
    </div>
