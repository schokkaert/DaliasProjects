const SITE = {
  brand: {
    title: "CHATEAUX REAL ESTATE",
    logo: "./Webimages/chateaux-logo.svg",
  },
  nav: [
    { label: "Home", href: "./index.html", key: "home" },
    { label: "Projecten", href: "./projecten.html", key: "projecten" },
    { label: "Over", href: "./over.html", key: "over" },
    { label: "Grond gezocht", href: "./grond-gezocht.html", key: "grond-gezocht" },
    { label: "Contact", href: "./contact.html", key: "contact" },
  ],
  socials: [
    { label: "Instagram", href: "https://www.instagram.com/grouponclin/" },
    { label: "Facebook", href: "https://www.facebook.com/ChateauxRealEstate.Hasselt" },
    { label: "LinkedIn", href: "https://www.linkedin.com/company/chateaux-real-estate/" },
  ],
  admin: {
    sessionKey: "cre-admin-session",
    projectKey: "cre-admin-projects",
    inquiryKey: "cre-admin-inquiries",
    username: "admin",
    password: "chateaux2026",
  },
  projects: [
    {
      slug: "paal",
      title: "Paal",
      location: "Wordt verwacht",
      type: "Residentieel",
      status: "Binnenkort in verkoop",
      summary: "Een nieuw woonproject in Paal, georienteerd op rust, licht en een heldere ruimtelijke opbouw.",
      hero:
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/df4d7b18-fc75-4677-9445-6acafb3a9bb2/ChatGPT+Image+Dec+23%2C+2025+at+10_34_41+AM.png?content-type=image%2Fpng",
      gallery: [
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/df4d7b18-fc75-4677-9445-6acafb3a9bb2/ChatGPT+Image+Dec+23%2C+2025+at+10_34_41+AM.png?content-type=image%2Fpng",
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/23413f2c-1b56-4540-b1da-c6d19755084a/Chateaux+real+estate+%2844+van+86%29.jpg",
      ],
      quote:
        "Een project start met de juiste locatie en eindigt met een leefomgeving die nog jaren relevant blijft.",
      context:
        "De kaart van Paal past in de bredere strategie van Chateaux Real Estate: kwalitatieve projecten op plekken met structureel potentieel.",
      cta: "./contact.html",
      ctaLabel: "Meer info aanvragen",
    },
    {
      slug: "oud-rekem",
      title: "Oud-Rekem",
      location: "Wordt verwacht",
      type: "Residentieel",
      status: "Binnenkort in verkoop",
      summary: "Een toekomstig woonproject met aandacht voor erfgoed, schaal en een rustige inpassing.",
      hero:
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/132521d1-1d78-416b-969a-eda2a753dc3f/1.jpg?content-type=image%2Fjpeg",
      gallery: [
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/132521d1-1d78-416b-969a-eda2a753dc3f/1.jpg?content-type=image%2Fjpeg",
      ],
      quote:
        "We zoeken telkens een evenwicht tussen karakter, context en het comfort van vandaag.",
      context:
        "Oud-Rekem wordt in de huidige site als aankomend project gepositioneerd en past in de rij van toekomstige ontwikkelingen.",
      cta: "./contact.html",
      ctaLabel: "Interesse melden",
    },
    {
      slug: "bunderhof",
      title: "Bunderhof",
      location: "Kuringen",
      type: "Residentieel",
      status: "Verkoop gestart",
      summary: "Een karaktervol woonproject met een landelijke signatuur aan de rand van Hasselt.",
      hero:
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/efc821b0-a2bd-4266-a577-46bfe3916bc7/Chateaux+Real+Estate+-+kleine+negenbundersstraat+finaal+-+scene+2+HDRI013+AI.jpg?content-type=image%2Fjpeg",
      gallery: [
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/efc821b0-a2bd-4266-a577-46bfe3916bc7/Chateaux+Real+Estate+-+kleine+negenbundersstraat+finaal+-+scene+2+HDRI013+AI.jpg?content-type=image%2Fjpeg",
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/2e6dab8f-6823-4d6d-8c98-39e7352a72af/Chateaux+real+estate+%2885+van+86%29.jpg",
      ],
      quote:
        "Bunderhof combineert rust, privacy en een sterke ruimtelijke samenhang.",
      context:
        "Het project sluit aan op de lokale eigenheid van Kuringen en vertaalt die naar een hedendaagse woonvorm.",
      cta: "./contact.html",
      ctaLabel: "Vraag brochure",
    },
    {
      slug: "rongese-park",
      title: "Rongese Park",
      location: "Hasselt",
      type: "Residentieel & handelspand",
      status: "Bijna uitverkocht",
      summary: "Wonen tussen stad en park, met veel licht, groen en een sterk gevoel van ruimte.",
      hero:
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/9b1834f5-fd48-4949-9336-3958489df9fa/970+2025_07_17+P3.jpg",
      gallery: [
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/9b1834f5-fd48-4949-9336-3958489df9fa/970+2025_07_17+P3.jpg",
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/10f9ca44-a95a-4603-a69e-c54172fd3697/5.jpg?content-type=image%2Fjpeg",
      ],
      quote:
        "Rongese Park zet in op open leefruimtes, groen en privacy aan de rand van de stad.",
      context:
        "Dit project toont de typische Chateaux-mix van stedelijke bereikbaarheid en een zachte woonomgeving.",
      cta: "https://www.rongese-park.be/",
      ctaLabel: "Ontdek het project",
      external: true,
    },
    {
      slug: "paulina-park",
      title: "Paulina Park",
      location: "Dilsen-Stokkem",
      type: "Residentieel",
      status: "35% verkocht",
      summary: "Een woonontwikkeling met vrijstaande woningen, water nabij en een groene inplanting.",
      hero:
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/6b9f455c-aaee-4dc5-b794-ecca991a678b/Woning+Lot+8_4_Living.jpg",
      gallery: [
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/6b9f455c-aaee-4dc5-b794-ecca991a678b/Woning+Lot+8_4_Living.jpg",
      ],
      quote:
        "Paulina Park koppelt ruimte, comfort en een context aan het water.",
      context:
        "De projectsite benadrukt de mix van moderne en landelijke architectuur met een rustige sfeer.",
      cta: "./contact.html",
      ctaLabel: "Meer weten",
    },
    {
      slug: "as-park",
      title: "As Park",
      location: "As",
      type: "Handelspand",
      status: "75% verkocht",
      summary: "Een bedrijvenpark met zichtbaarheid, bereikbaarheid en schaalbare KMO-units.",
      hero:
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/6df441a1-ddc7-47d1-84fd-51950041da06/1+%2815%29.jpg",
      gallery: [
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/6df441a1-ddc7-47d1-84fd-51950041da06/1+%2815%29.jpg",
      ],
      quote:
        "As Park is ontwikkeld als een toegankelijke en zichtbare locatie voor ondernemingen.",
      context:
        "Met units voor bedrijvigheid en een strategische ligging past dit project in de commerciële portfolio.",
      cta: "https://www.aspark.be/",
      ctaLabel: "Ontdek het project",
      external: true,
    },
    {
      slug: "the-mill",
      title: "The Mill",
      location: "Hasselt",
      type: "Residentieel",
      status: "Verkocht",
      summary: "Kleinschalig wonen in het centrum, met architecturale finesse en een sterke stedelijke ligging.",
      hero:
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/b977d6f2-184e-4747-9cd8-c2dcf48395d2/Chateaux+real+estate+%2836+van+86%29.jpg",
      gallery: [
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/b977d6f2-184e-4747-9cd8-c2dcf48395d2/Chateaux+real+estate+%2836+van+86%29.jpg",
      ],
      quote:
        "The Mill vertaalt stadswonen naar een rustige, verfijnde woonervaring.",
      context:
        "Het project is een voorbeeld van hoe Chateaux waarde creëert op een drukke, centrale locatie.",
      cta: "./contact.html",
      ctaLabel: "Meer info",
    },
    {
      slug: "stadshaven",
      title: "Stadshaven",
      location: "Hasselt",
      type: "Residentieel",
      status: "Verkocht",
      summary: "Een sleutelproject aan de Kanaalkom, met een mix van wonen, groen en stedelijke verbinding.",
      hero:
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/636da066-40f8-4a35-ae62-55ac0c0d0e0d/Chateaux+real+estate+%289+van+86%29.jpg",
      gallery: [
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/636da066-40f8-4a35-ae62-55ac0c0d0e0d/Chateaux+real+estate+%289+van+86%29.jpg",
      ],
      quote:
        "Stadshaven bracht klassieke stadsvormen samen met hedendaagse woonkwaliteit.",
      context:
        "Het project versterkt de overgang tussen centrum, water en nieuwe stadsontwikkeling.",
      cta: "./contact.html",
      ctaLabel: "Meer info",
    },
    {
      slug: "quartier-bleu",
      title: "Quartier Bleu",
      location: "Hasselt",
      type: "Residentieel",
      status: "Verkocht",
      summary: "Een gemengd stadsproject aan het water, met wonen, retail, horeca en recreatie.",
      hero:
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/a15a895f-a626-4810-941a-6e8530846f6f/Chateaux+real+estate+%2873+van+86%29.jpg",
      gallery: [
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/a15a895f-a626-4810-941a-6e8530846f6f/Chateaux+real+estate+%2873+van+86%29.jpg",
      ],
      quote:
        "Quartier Bleu is een stadsontwikkeling waarin water, wonen en beleving samenkomen.",
      context:
        "Dit is een van de meest herkenbare projecten in de Chateaux-portefeuille en positioneert het merk sterk in Hasselt.",
      cta: "./contact.html",
      ctaLabel: "Meer info",
    },
    {
      slug: "hassaporta",
      title: "Hassaporta",
      location: "Hasselt",
      type: "Handelspand",
      status: "Verkocht",
      summary: "Een woontoren met handelsruimtes en zicht over de stad.",
      hero:
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/36babbdd-2ed6-4022-97c5-8d549ac7dd06/Chateaux+real+estate+%2882+van+86%29.jpg",
      gallery: [
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/36babbdd-2ed6-4022-97c5-8d549ac7dd06/Chateaux+real+estate+%2882+van+86%29.jpg",
      ],
      quote:
        "Hassaporta koppelt hoge zichtbaarheid aan een duidelijke stedelijke identiteit.",
      context:
        "De site toont dit project als een gevestigde referentie in de Blauwe Boulevard-context.",
      cta: "./contact.html",
      ctaLabel: "Meer info",
    },
    {
      slug: "heerenhof",
      title: "Heerenhof",
      location: "Hasselt",
      type: "Residentieel",
      status: "Verkocht",
      summary: "Authentiek vanbuiten, hedendaags vanbinnen.",
      hero:
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/5b6600a9-5bfb-4c40-9ef2-9285d8e553e4/Chateaux+real+estate+2+%2837+van+64%29.jpg",
      gallery: [
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/5b6600a9-5bfb-4c40-9ef2-9285d8e553e4/Chateaux+real+estate+2+%2837+van+64%29.jpg",
      ],
      quote:
        "Heerenhof legt nadruk op historische context en een rustige woonomgeving.",
      context:
        "Dit project laat zien hoe karaktervolle locaties opnieuw relevant worden gemaakt.",
      cta: "./contact.html",
      ctaLabel: "Meer info",
    },
    {
      slug: "heerenhuys",
      title: "Heerenhuys",
      location: "Lanaken",
      type: "Residentieel",
      status: "Verkocht",
      summary: "Een compacte residentiële ontwikkeling met een rustig en verzorgd beeld.",
      hero:
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/6a560b6f-18c4-4645-90e1-bff775c2bb3d/Chateaux+real+estate+2+%2851+van+64%29.jpg",
      gallery: [
        "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/6a560b6f-18c4-4645-90e1-bff775c2bb3d/Chateaux+real+estate+2+%2851+van+64%29.jpg",
      ],
      quote:
        "Heerenhuys sluit aan op de meer klassieke, rustige identiteit van de site.",
      context:
        "Ook hier is de focus duidelijk: kleinschaligheid, afwerking en een goed gekozen ligging.",
      cta: "./contact.html",
      ctaLabel: "Meer info",
    },
  ],
};

const PAGE_TITLES = {
  home: "CHATEAUX REAL ESTATE | Ontdek duurzame vastgoedmogelijkheden",
  projects: "Projecten — CHATEAUX REAL ESTATE",
  about: "Over — CHATEAUX REAL ESTATE",
  contact: "Contact — CHATEAUX REAL ESTATE",
  legal: "CHATEAUX REAL ESTATE",
  land-search: "Grond gezocht — CHATEAUX REAL ESTATE",
  project: "Project — CHATEAUX REAL ESTATE",
  admin: "Admin — CHATEAUX REAL ESTATE",
};

const DEFAULT_INQUIRIES = [
  {
    id: "lead-001",
    name: "Verantwoordelijke bouwgrond",
    email: "info@voorbeeld.be",
    project: "Grond gezocht",
    status: "Nieuw",
    message: "Interesse in een discreet gesprek over een site in de regio Hasselt.",
    date: "2026-04-21",
  },
  {
    id: "lead-002",
    name: "Investeerder residentieel",
    email: "hello@voorbeeld.be",
    project: "Quartier Bleu",
    status: "In behandeling",
    message: "Vraag naar beschikbaarheid van gelijkaardige residentiële opportuniteiten.",
    date: "2026-04-19",
  },
  {
    id: "lead-003",
    name: "Projectpartner",
    email: "contact@voorbeeld.be",
    project: "Bunderhof",
    status: "Afgesloten",
    message: "Afspraak ingepland voor verdere afstemming over ontwikkeling en timing.",
    date: "2026-04-16",
  },
];

function escapeHtml(value) {
  return String(value)
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;");
}

function safeParse(json, fallback) {
  try {
    return JSON.parse(json);
  } catch (error) {
    return fallback;
  }
}

function safeStorageGet(key, fallback) {
  try {
    const value = localStorage.getItem(key);
    return value ? safeParse(value, fallback) : fallback;
  } catch (error) {
    return fallback;
  }
}

function safeStorageSet(key, value) {
  try {
    localStorage.setItem(key, JSON.stringify(value));
    return true;
  } catch (error) {
    return false;
  }
}

function getProjectCatalog() {
  const stored = safeStorageGet(SITE.admin.projectKey, null);
  if (!Array.isArray(stored)) {
    return SITE.projects.map((project) => ({ ...project }));
  }

  const overrides = new Map(stored.map((project) => [project.slug, project]));
  return SITE.projects.map((project) => ({
    ...project,
    ...(overrides.get(project.slug) || {}),
  }));
}

function getInquiryQueue() {
  const stored = safeStorageGet(SITE.admin.inquiryKey, null);
  if (Array.isArray(stored) && stored.length) {
    return stored;
  }
  return DEFAULT_INQUIRIES.map((item) => ({ ...item }));
}

function saveInquiryQueue(items) {
  safeStorageSet(SITE.admin.inquiryKey, items);
}

function saveProjectCatalog(items) {
  safeStorageSet(SITE.admin.projectKey, items);
}

function renderHeader() {
  const active = document.body.dataset.activeNav || "home";
  const mount = document.getElementById("site-header");
  if (!mount) return;
  const links = SITE.nav
    .map(
      (item) => `
        <a class="nav__link ${item.key === active ? "is-active" : ""}" href="${item.href}">
          ${item.label}
        </a>`
    )
    .join("");

  const social = SITE.socials
    .map(
      (item) =>
        `<a href="${item.href}" target="_blank" rel="noreferrer" aria-label="${item.label}">${item.label[0]}</a>`
    )
    .join("");

  const header = `
    <div class="site-header__inner container">
      <a class="brand" href="./index.html" aria-label="${SITE.brand.title}">
        <img src="${SITE.brand.logo}" alt="${SITE.brand.title}" />
      </a>
      <nav class="nav" aria-label="Hoofdnavigatie">
        ${links}
      </nav>
      <div class="header-actions">
        <div class="social-icons" aria-label="Social media">
          ${social}
        </div>
        <a class="btn btn--primary" href="./contact.html">Contact</a>
        <button class="menu-toggle" type="button" data-menu-toggle aria-label="Menu openen">
          Menu
        </button>
      </div>
    </div>
    <div class="menu-panel" data-menu-panel>
      <div class="menu-panel__inner container">
        <div class="menu-panel__links">
          ${links}
        </div>
        <div class="button-row">
          <a class="btn btn--primary" href="./contact.html">Contact</a>
          <a class="btn btn--secondary" href="./voorwaarden.html">Voorwaarden</a>
        </div>
      </div>
    </div>
  `;

  mount.innerHTML = header;
}

function renderFooter() {
  const mount = document.getElementById("site-footer");
  if (!mount) return;
  const footer = `
    <div class="site-footer__inner container">
      <div class="site-footer__column">
        <strong>Chateaux Real Estate</strong>
        <p>Bannerlaan 50</p>
        <p>2280 Grobbendonk</p>
        <a href="tel:+3214302100">+32 (0)1 430 21 00</a>
        <a href="mailto:sales@disseurope.be">sales@disseurope.be</a>
      </div>
      <div class="site-footer__column">
        <strong>Overzicht</strong>
        <a href="./projecten.html">Projecten</a>
        <a href="./over.html">Over ons</a>
        <a href="./contact.html">Contact</a>
        <a href="./voorwaarden.html">Voorwaarden</a>
      </div>
      <div class="site-footer__column">
        <strong>Social</strong>
        <a href="https://www.instagram.com/grouponclin/" target="_blank" rel="noreferrer">Instagram</a>
        <a href="https://www.facebook.com/ChateauxRealEstate.Hasselt" target="_blank" rel="noreferrer">Facebook</a>
        <a href="https://www.linkedin.com/company/chateaux-real-estate/" target="_blank" rel="noreferrer">LinkedIn</a>
      </div>
      <div class="site-footer__column">
        <strong>Website</strong>
        <p>Gemaakt door COCO media</p>
        <a href="./cookies.html">Cookiebeleid</a>
        <a href="./admin.html">Admin</a>
      </div>
    </div>
    <div class="site-footer__bottom container">
      <span>© <span data-year></span> CHATEAUX REAL ESTATE. Alle rechten zijn voorbehouden.</span>
    </div>
  `;
  mount.innerHTML = footer;
}

function renderProjectCards(target, projects, featuredOnly = false) {
  const catalog = projects && projects.length ? projects : getProjectCatalog();
  const selected = featuredOnly ? catalog.slice(0, 6) : catalog;
  target.innerHTML = selected
    .map(
      (project) => `
        <a class="project-card" href="./project.html?slug=${encodeURIComponent(project.slug)}">
          <div class="project-card__media">
            <img src="${project.hero}" alt="${escapeHtml(project.title)}" loading="lazy" />
            <span class="project-card__badge">${escapeHtml(project.status)}</span>
          </div>
          <div class="project-card__body">
            <p class="eyebrow">${escapeHtml(project.location)}</p>
            <h3>${escapeHtml(project.title)}</h3>
            <p>${escapeHtml(project.summary)}</p>
          </div>
        </a>
      `
    )
    .join("");
}

function renderGalleryRail(target) {
  const railProjects = getProjectCatalog().slice(1, 7);
  target.innerHTML = railProjects
    .map(
      (project) => `
        <a class="gallery-card" href="./project.html?slug=${encodeURIComponent(project.slug)}">
          <img src="${project.hero}" alt="${escapeHtml(project.title)}" loading="lazy" />
          <span class="gallery-card__label">${escapeHtml(project.title)}</span>
        </a>
      `
    )
    .join("");
}

function getSlug() {
  return new URLSearchParams(window.location.search).get("slug") || "quartier-bleu";
}

function renderProjectPage() {
  const slug = getSlug();
  const catalog = getProjectCatalog();
  const project = catalog.find((item) => item.slug === slug) || catalog[0];
  document.title = `${project.title} — CHATEAUX REAL ESTATE`;

  const location = document.querySelector("[data-project-location]");
  const title = document.querySelector("[data-project-title]");
  const intro = document.querySelector("[data-project-intro]");
  const meta = document.querySelector("[data-project-meta]");
  const hero = document.querySelector("[data-project-hero]");
  const quote = document.querySelector("[data-project-quote]");
  const context = document.querySelector("[data-project-context]");
  const cta = document.querySelector("[data-project-cta]");
  const gallery = document.querySelector("[data-project-gallery]");

  if (location) location.textContent = project.location;
  if (title) title.textContent = project.title;
  if (intro) intro.textContent = project.summary;
  if (meta) {
    meta.innerHTML = `
      <div class="project-meta__item"><span>Type</span><strong>${escapeHtml(project.type)}</strong></div>
      <div class="project-meta__item"><span>Status</span><strong>${escapeHtml(project.status)}</strong></div>
      <div class="project-meta__item"><span>Locatie</span><strong>${escapeHtml(project.location)}</strong></div>
    `;
  }
  if (hero) {
    hero.src = project.hero;
    hero.alt = project.title;
  }
  if (quote) quote.textContent = project.quote;
  if (context) context.textContent = project.context;
  if (cta) {
    cta.href = project.cta;
    cta.textContent = project.ctaLabel;
  }
  if (gallery) {
    const list = project.gallery && project.gallery.length ? project.gallery : [project.hero];
    gallery.innerHTML = list
      .map(
        (src) => `
          <div class="gallery-card">
            <img src="${src}" alt="${escapeHtml(project.title)}" loading="lazy" />
          </div>
        `
      )
      .join("");
  }
}

function initCookieBanner() {
  const banner = document.getElementById("cookie-banner");
  if (!banner) return;

  const key = "cre-cookie-choice";
  const stored = localStorage.getItem(key);
  if (!stored) {
    banner.hidden = false;
  }

  banner.querySelectorAll("[data-cookie]").forEach((button) => {
    button.addEventListener("click", () => {
      localStorage.setItem(key, button.dataset.cookie);
      banner.hidden = true;
    });
  });
}

function initMenu() {
  const toggle = document.querySelector("[data-menu-toggle]");
  const panel = document.querySelector("[data-menu-panel]");
  if (!toggle || !panel) return;

  toggle.addEventListener("click", () => {
    panel.classList.toggle("is-open");
  });

  panel.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", () => panel.classList.remove("is-open"));
  });
}

function setYear() {
  document.querySelectorAll("[data-year]").forEach((node) => {
    node.textContent = String(new Date().getFullYear());
  });
}

function initPageContent() {
  const page = document.body.dataset.page;

  if (page === "home") {
    const grid = document.querySelector('[data-project-grid="featured"]');
    if (grid) renderProjectCards(grid, getProjectCatalog(), true);
  }

  if (page === "projects") {
    const grid = document.querySelector('[data-project-grid="all"]');
    const rail = document.querySelector("[data-gallery-rail]");
    if (grid) renderProjectCards(grid, getProjectCatalog(), false);
    if (rail) renderGalleryRail(rail);
  }

  if (page === "project") {
    renderProjectPage();
  }
}

function initLinks() {
  document.querySelectorAll("[data-scroll]").forEach((button) => {
    button.addEventListener("click", () => {
      const selector = button.getAttribute("data-scroll");
      const target = selector && document.querySelector(selector);
      if (target) target.scrollIntoView({ behavior: "smooth", block: "start" });
    });
  });
}

function isAdminSignedIn() {
  return safeStorageGet(SITE.admin.sessionKey, false) === true;
}

function setAdminSignedIn(value) {
  safeStorageSet(SITE.admin.sessionKey, value === true);
}

function renderAdminKpis(container, projects, inquiries) {
  const active = projects.filter((project) => !/verkocht/i.test(project.status)).length;
  const sold = projects.filter((project) => /verkocht/i.test(project.status)).length;
  const external = projects.filter((project) => project.external).length;
  const newLeads = inquiries.filter((item) => item.status === "Nieuw").length;

  container.innerHTML = `
    <article class="admin-kpi">
      <span>Projecten</span>
      <strong>${projects.length}</strong>
      <small>Opgenomen in de catalogus</small>
    </article>
    <article class="admin-kpi">
      <span>Actief</span>
      <strong>${active}</strong>
      <small>Niet als verkocht gemarkeerd</small>
    </article>
    <article class="admin-kpi">
      <span>Verkocht</span>
      <strong>${sold}</strong>
      <small>Projecten in afronding</small>
    </article>
    <article class="admin-kpi">
      <span>Extern</span>
      <strong>${external}</strong>
      <small>Doorverwijzingen naar microsites</small>
    </article>
    <article class="admin-kpi">
      <span>Nieuwe leads</span>
      <strong>${newLeads}</strong>
      <small>Onbehandelde aanvragen</small>
    </article>
  `;
}

function renderAdminProjectTable(container, projects) {
  container.innerHTML = projects
    .map(
      (project) => `
        <tr>
          <td>
            <strong>${escapeHtml(project.title)}</strong>
            <div class="admin-muted">${escapeHtml(project.location)}</div>
          </td>
          <td>${escapeHtml(project.type)}</td>
          <td><span class="status-pill">${escapeHtml(project.status)}</span></td>
          <td>${project.external ? "Extern" : "Intern"}</td>
          <td>
            <button class="text-link" type="button" data-admin-select="${escapeHtml(project.slug)}">Bewerken</button>
          </td>
        </tr>
      `
    )
    .join("");
}

function renderAdminInquiries(container, inquiries) {
  container.innerHTML = inquiries
    .map(
      (item) => `
        <article class="admin-inquiry">
          <div class="admin-inquiry__head">
            <div>
              <strong>${escapeHtml(item.name)}</strong>
              <p>${escapeHtml(item.email)}</p>
            </div>
            <span class="status-pill">${escapeHtml(item.status)}</span>
          </div>
          <p class="admin-inquiry__project">${escapeHtml(item.project)}</p>
          <p>${escapeHtml(item.message)}</p>
          <div class="admin-inquiry__foot">
            <time>${escapeHtml(item.date)}</time>
            <button class="text-link" type="button" data-admin-inquiry="${escapeHtml(item.id)}">
              Status wisselen
            </button>
          </div>
        </article>
      `
    )
    .join("");
}

function fillAdminProjectForm(form, project) {
  if (!form || !project) return;
  form.dataset.selected = project.slug;
  form.querySelector('[name="title"]').value = project.title || "";
  form.querySelector('[name="location"]').value = project.location || "";
  form.querySelector('[name="type"]').value = project.type || "";
  form.querySelector('[name="status"]').value = project.status || "";
  form.querySelector('[name="summary"]').value = project.summary || "";
  form.querySelector('[name="quote"]').value = project.quote || "";
  form.querySelector('[name="context"]').value = project.context || "";
  form.querySelector('[name="ctaLabel"]').value = project.ctaLabel || "";
  form.querySelector('[name="cta"]').value = project.cta || "";
  const hero = form.querySelector('[name="hero"]');
  if (hero) hero.value = project.hero || "";
}

function readAdminProjectForm(form, currentProject) {
  return {
    ...currentProject,
    title: form.querySelector('[name="title"]').value.trim(),
    location: form.querySelector('[name="location"]').value.trim(),
    type: form.querySelector('[name="type"]').value.trim(),
    status: form.querySelector('[name="status"]').value.trim(),
    summary: form.querySelector('[name="summary"]').value.trim(),
    quote: form.querySelector('[name="quote"]').value.trim(),
    context: form.querySelector('[name="context"]').value.trim(),
    ctaLabel: form.querySelector('[name="ctaLabel"]').value.trim(),
    cta: form.querySelector('[name="cta"]').value.trim(),
    hero: form.querySelector('[name="hero"]').value.trim(),
  };
}

function initAdminPage() {
  const authCard = document.querySelector("[data-admin-auth]");
  const dashboard = document.querySelector("[data-admin-dashboard]");
  const loginForm = document.querySelector("[data-admin-login-form]");
  const loginMessage = document.querySelector("[data-admin-login-message]");
  const logoutButton = document.querySelector("[data-admin-logout]");
  const kpis = document.querySelector("[data-admin-kpis]");
  const table = document.querySelector("[data-admin-project-table]");
  const inquiryList = document.querySelector("[data-admin-inquiries]");
  const select = document.querySelector("[data-admin-project-select]");
  const form = document.querySelector("[data-admin-project-form]");
  const saveButton = document.querySelector("[data-admin-project-save]");
  const resetButton = document.querySelector("[data-admin-project-reset]");

  const syncDashboard = () => {
    const currentProjects = getProjectCatalog();
    const currentInquiries = getInquiryQueue();
    const currentSelection = select?.value || form?.dataset.selected || currentProjects[0]?.slug;

    if (select) {
      select.innerHTML = currentProjects
        .map(
          (project) =>
            `<option value="${escapeHtml(project.slug)}">${escapeHtml(project.title)} — ${escapeHtml(project.status)}</option>`
        )
        .join("");
      select.value = currentSelection;
    }

    if (kpis) renderAdminKpis(kpis, currentProjects, currentInquiries);
    if (table) renderAdminProjectTable(table, currentProjects);
    if (inquiryList) renderAdminInquiries(inquiryList, currentInquiries);

    const selectedSlug = select?.value || currentSelection;
    const selected = currentProjects.find((project) => project.slug === selectedSlug) || currentProjects[0];
    fillAdminProjectForm(form, selected);
  };

  const showDashboard = () => {
    if (authCard) authCard.hidden = true;
    if (dashboard) dashboard.hidden = false;
    if (logoutButton) logoutButton.hidden = false;
    syncDashboard();
  };

  const showAuth = () => {
    if (authCard) authCard.hidden = false;
    if (dashboard) dashboard.hidden = true;
    if (logoutButton) logoutButton.hidden = true;
  };

  if (isAdminSignedIn()) {
    showDashboard();
  } else {
    showAuth();
  }

  loginForm?.addEventListener("submit", (event) => {
    event.preventDefault();
    const username = loginForm.querySelector('[name="username"]').value.trim();
    const password = loginForm.querySelector('[name="password"]').value.trim();

    if (username === SITE.admin.username && password === SITE.admin.password) {
      setAdminSignedIn(true);
      if (loginMessage) loginMessage.textContent = "";
      showDashboard();
      return;
    }

    if (loginMessage) {
      loginMessage.textContent = "Onjuiste toegangsgegevens. Gebruik de demo inlog.";
    }
  });

  logoutButton?.addEventListener("click", () => {
    setAdminSignedIn(false);
    showAuth();
  });

  select?.addEventListener("change", () => {
    const currentProjects = getProjectCatalog();
    const selectedSlug = select.value;
    const selected = currentProjects.find((project) => project.slug === selectedSlug) || currentProjects[0];
    fillAdminProjectForm(form, selected);
  });

  form?.addEventListener("submit", (event) => {
    event.preventDefault();
    const currentProjects = getProjectCatalog();
    const selectedSlug = form.dataset.selected || select?.value || currentProjects[0]?.slug;
    const nextProjects = currentProjects.map((project) =>
      project.slug === selectedSlug ? readAdminProjectForm(form, project) : project
    );

    saveProjectCatalog(nextProjects);
    if (saveButton) {
      const original = saveButton.textContent;
      saveButton.textContent = "Opgeslagen";
      window.setTimeout(() => {
        saveButton.textContent = original;
      }, 1200);
    }
    syncDashboard();
  });

  table?.addEventListener("click", (event) => {
    const trigger = event.target.closest("[data-admin-select]");
    if (!trigger) return;
    const slug = trigger.getAttribute("data-admin-select");
    if (select) select.value = slug;
    const currentProjects = getProjectCatalog();
    const selected = currentProjects.find((project) => project.slug === slug) || currentProjects[0];
    fillAdminProjectForm(form, selected);
  });

  inquiryList?.addEventListener("click", (event) => {
    const trigger = event.target.closest("[data-admin-inquiry]");
    if (!trigger) return;
    const id = trigger.getAttribute("data-admin-inquiry");
    const currentQueue = getInquiryQueue().map((item) => {
      if (item.id !== id) return item;
      const cycle = { Nieuw: "In behandeling", "In behandeling": "Afgesloten", Afgesloten: "Nieuw" };
      return { ...item, status: cycle[item.status] || "In behandeling" };
    });
    saveInquiryQueue(currentQueue);
    syncDashboard();
  });

  resetButton?.addEventListener("click", () => {
    localStorage.removeItem(SITE.admin.projectKey);
    localStorage.removeItem(SITE.admin.inquiryKey);
    syncDashboard();
  });
}

const activePage = document.body.dataset.page;

if (activePage === "admin") {
  initAdminPage();
} else {
  renderHeader();
  renderFooter();
  setYear();
  initMenu();
  initCookieBanner();
  initPageContent();
  initLinks();
}
