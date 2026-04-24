const SITE = {
  brand: {
    title: "Dalia Projects",
    logo: "./Webimages/Logo.png",
  },
  nav: [
    { label: "Home", href: "./index.php", key: "home" },
    { label: "Projecten", href: "./projecten.php", key: "projecten" },
    { label: "Over", href: "./over.php", key: "over" },
    { label: "Grond te koop?", href: "./grond-gezocht.php", key: "grond-gezocht" },
    { label: "Contact", href: "./contact.php", key: "contact" },
  ],
  socials: [
    { label: "LinkedIn", href: "https://be.linkedin.com/company/diss-europe-bv" },
  ],
  admin: {
    sessionKey: "cre-admin-session",
    projectKey: "cre-admin-projects",
    inquiryKey: "cre-admin-inquiries",
    settingsKey: "cre-admin-settings",
    settingsEndpoint: "./admin/settings.php",
    projectsEndpoint: "./admin/projects-data.php",
    personnelEndpoint: "./admin/personnel-data.php",
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
        "De kaart van Paal past in de bredere strategie van Dalia Projects: kwalitatieve projecten op plekken met structureel potentieel.",
      cta: "./contact.php",
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
      cta: "./contact.php",
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
      cta: "./contact.php",
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
        "Dit project toont de typische Dalia Projects-mix van stedelijke bereikbaarheid en een zachte woonomgeving.",
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
      cta: "./contact.php",
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
        "Het project is een voorbeeld van hoe Dalia Projects waarde creëert op een drukke, centrale locatie.",
      cta: "./contact.php",
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
      cta: "./contact.php",
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
        "Dit is een van de meest herkenbare projecten in de portfolio van Dalia Projects en positioneert het merk sterk in Hasselt.",
      cta: "./contact.php",
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
      cta: "./contact.php",
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
      cta: "./contact.php",
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
      cta: "./contact.php",
      ctaLabel: "Meer info",
    },
  ],
};

document.documentElement.classList.add("js-ready");

const DEFAULT_HOME_HERO_IMAGE =
  "https://images.squarespace-cdn.com/content/v1/66a1eaeaa923c50bf4382099/23413f2c-1b56-4540-b1da-c6d19755084a/Chateaux+real+estate+%2844+van+86%29.jpg";

const DEFAULT_SITE_SETTINGS = {
  heroVideoUrl: "/Webimages/dalia-hero-building-timelapse.mp4",
  heroPosterUrl: "/Webimages/dalia-hero-building-timelapse-poster.jpg",
  public_email: "info@daliasprojects.be",
  public_phone: "Jens 0499/10.50.11",
  contact_address_line_1: "",
  contact_address_line_2: "",
  maps_embed_url: "",
  maps_link_url: "",
  socials: [
    { label: "LinkedIn", url: "https://be.linkedin.com/company/diss-europe-bv", active: true },
  ],
};

let currentSiteSettings = { ...DEFAULT_SITE_SETTINGS };

const PAGE_TITLES = {
  home: "Dalia Projects | Ontdek duurzame vastgoedmogelijkheden",
  projects: "Projecten — Dalia Projects",
  about: "Over — Dalia Projects",
  contact: "Contact — Dalia Projects",
  legal: "Dalia Projects",
  land-search: "Grond gezocht — Dalia Projects",
  project: "Project — Dalia Projects",
  admin: "Admin — Dalia Projects",
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

function normalizeSocials(socials) {
  if (!Array.isArray(socials)) return [];
  return socials
    .map((item) => ({
      label: String(item.label || "").trim(),
      href: String(item.href || item.url || "").trim(),
      active: item.active !== false,
    }))
    .filter((item) => item.label && item.href && item.active);
}

function applyPublicSettings(settings) {
  if (!settings || typeof settings !== "object") return DEFAULT_SITE_SETTINGS;
  const merged = {
    ...DEFAULT_SITE_SETTINGS,
    ...settings,
  };
  currentSiteSettings = merged;
  const socials = normalizeSocials(merged.socials);
  if (socials.length) {
    SITE.socials = socials;
  }
  return merged;
}

function getContactInfo() {
  const settings = currentSiteSettings || DEFAULT_SITE_SETTINGS;
  return {
    email: String(settings.public_email || DEFAULT_SITE_SETTINGS.public_email).trim(),
    phone: String(settings.public_phone || DEFAULT_SITE_SETTINGS.public_phone).trim(),
    addressLine1: String(settings.contact_address_line_1 || DEFAULT_SITE_SETTINGS.contact_address_line_1).trim(),
    addressLine2: String(settings.contact_address_line_2 || DEFAULT_SITE_SETTINGS.contact_address_line_2).trim(),
    mapsEmbedUrl: String(settings.maps_embed_url || DEFAULT_SITE_SETTINGS.maps_embed_url).trim(),
    mapsLinkUrl: String(settings.maps_link_url || DEFAULT_SITE_SETTINGS.maps_link_url).trim(),
  };
}

function getPhoneHref(phone) {
  const normalized = String(phone || "").replace(/\(0\)/g, "").replace(/[^\d+]/g, "");
  return normalized ? `tel:${normalized}` : "#";
}

function fetchPublicSettings() {
  const endpoint = SITE.admin.settingsEndpoint || "./admin/settings.php";
  return fetch(endpoint, { cache: "no-store" })
    .then((response) => (response.ok ? response.json() : null))
    .then((settings) => applyPublicSettings(settings))
    .catch(() => DEFAULT_SITE_SETTINGS);
}

function getSiteSettings() {
  return {
    ...DEFAULT_SITE_SETTINGS,
    ...safeStorageGet(SITE.admin.settingsKey, {}),
  };
}

function saveSiteSettings(settings) {
  return safeStorageSet(SITE.admin.settingsKey, {
    ...DEFAULT_SITE_SETTINGS,
    ...settings,
  });
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

function normalizeProject(project) {
  const slug = String(project.slug || project.title || "")
    .trim()
    .toLowerCase()
    .replace(/[^a-z0-9]+/g, "-")
    .replace(/^-+|-+$/g, "");
  const gallery = Array.isArray(project.gallery)
    ? project.gallery
    : String(project.gallery || "")
        .split(/\r?\n|,/)
        .map((item) => item.trim())
        .filter(Boolean);

  return {
    ...project,
    slug,
    title: String(project.title || "Project").trim(),
    location: String(project.location || "").trim(),
    type: String(project.type || "Residentieel").trim(),
    status: String(project.status || "").trim(),
    group: String(project.group || "").trim(),
    summary: String(project.summary || "").trim(),
    hero: String(project.hero || DEFAULT_HOME_HERO_IMAGE).trim(),
    gallery,
    quote: String(project.quote || "").trim(),
    context: String(project.context || "").trim(),
    highlight: String(project.highlight || "").trim(),
    salesOffice: String(project.salesOffice || project.sales_office || "").trim(),
    salesUrl: String(project.salesUrl || project.sales_url || project.cta || "").trim(),
    salesStart: String(project.salesStart || project.sales_start || "").trim(),
    ctaLabel: String(project.ctaLabel || project.cta_label || "Contacteer ons").trim(),
    external: Boolean(project.external || /^https?:\/\//i.test(String(project.salesUrl || project.sales_url || project.cta || ""))),
    active: project.active !== false,
  };
}

function applyPublicProjects(payload) {
  const items = Array.isArray(payload) ? payload : Array.isArray(payload?.projects) ? payload.projects : [];
  const projects = items.map(normalizeProject).filter((project) => project.slug && project.active !== false);
  if (projects.length) {
    SITE.projects = projects;
  }
  return getProjectCatalog();
}

function fetchPublicProjects() {
  const endpoint = SITE.admin.projectsEndpoint || "./admin/projects-data.php";
  return fetch(endpoint, { cache: "no-store" })
    .then((response) => (response.ok ? response.json() : null))
    .then((payload) => applyPublicProjects(payload))
    .catch(() => getProjectCatalog());
}

function normalizePersonnel(person) {
  const roles = Array.isArray(person.roles)
    ? person.roles
    : String(person.roles || "")
        .split(/\r?\n|,/)
        .map((item) => item.trim())
        .filter(Boolean);

  return {
    id: String(person.id || person.name || "").trim(),
    name: String(person.name || "").trim(),
    roles,
    biv: String(person.biv || "").trim(),
    phone: String(person.phone || "").trim(),
    email: String(person.email || "").trim(),
    photo: String(person.photo || "").trim(),
    active: person.active !== false,
  };
}

function applyPublicPersonnel(payload) {
  const items = Array.isArray(payload) ? payload : Array.isArray(payload?.personnel) ? payload.personnel : [];
  return items.map(normalizePersonnel).filter((person) => person.name && person.active !== false);
}

function fetchPublicPersonnel() {
  const endpoint = SITE.admin.personnelEndpoint || "./admin/personnel-data.php";
  return fetch(endpoint, { cache: "no-store" })
    .then((response) => (response.ok ? response.json() : null))
    .then((payload) => applyPublicPersonnel(payload))
    .catch(() => []);
}

function getPortfolioGroup(project) {
  const explicit = String(project.group || "").toLowerCase();
  if (["current", "future", "realized"].includes(explicit)) return explicit;
  const status = String(project.status || "").toLowerCase();
  if (status.includes("verkocht")) return "realized";
  if (status.includes("verwacht") || status.includes("binnenkort")) return "future";
  return "current";
}

function getProjectHighlight(project) {
  return project.highlight || (getPortfolioGroup(project) === "current" ? "6% btw mogelijk in plaats van 21% btw" : "");
}

function getProjectSalesOffice(project) {
  return project.salesOffice || "SBC Vastgoed";
}

function getProjectSalesUrl(project) {
  return project.salesUrl || project.cta || "https://www.sbcvastgoed.be/";
}

function getProjectSalesStart(project) {
  return project.salesStart || "Timing volgt";
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

function getSocialIcon(label) {
  const normalized = String(label || "").toLowerCase();
  const iconAttrs = 'viewBox="0 0 24 24" aria-hidden="true" focusable="false"';
  if (normalized.includes("instagram")) {
    return `<svg ${iconAttrs}><rect x="3" y="3" width="18" height="18" rx="5"></rect><circle cx="12" cy="12" r="4"></circle><circle cx="17.5" cy="6.5" r="1"></circle></svg>`;
  }
  if (normalized.includes("facebook")) {
    return `<svg ${iconAttrs}><path d="M14 8.2h2.4V4.3c-.4-.1-1.8-.3-3.4-.3-3.3 0-5.5 2-5.5 5.7V13H4v4.4h3.5V24H12v-6.6h3.5L16 13h-4V10.1c0-1.3.4-1.9 2-1.9Z"></path></svg>`;
  }
  if (normalized.includes("linkedin")) {
    return `<svg ${iconAttrs}><path d="M5.1 8.8H1.4V21h3.7V8.8ZM3.3 3C2.1 3 1.2 3.9 1.2 5s.9 2 2.1 2 2.1-.9 2.1-2-.9-2-2.1-2ZM21.8 14.2c0-3.7-2-5.7-4.8-5.7-2.2 0-3.2 1.2-3.8 2.1V8.8H9.6V21h3.7v-6.1c0-1.6.3-3.2 2.3-3.2s2 1.9 2 3.3v6h3.7v-6.8Z"></path></svg>`;
  }
  return `<span>${escapeHtml(String(label || "?").slice(0, 2))}</span>`;
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
        `<a href="${item.href}" target="_blank" rel="noreferrer" aria-label="${item.label}">${getSocialIcon(item.label)}</a>`
    )
    .join("");

  const header = `
    <div class="site-header__inner container">
      <a class="brand" href="./index.php" aria-label="${SITE.brand.title}">
        <img src="${SITE.brand.logo}" alt="${SITE.brand.title}" />
      </a>
      <nav class="nav" aria-label="Hoofdnavigatie">
        ${links}
      </nav>
      <div class="header-actions">
        ${social ? `<div class="social-icons" aria-label="Social media">${social}</div>` : ""}
        <a class="btn btn--primary" href="./contact.php">Contact</a>
        <button class="menu-toggle" type="button" data-menu-toggle aria-label="Menu openen" aria-expanded="false">
          <span data-menu-toggle-label>Menu openen</span>
        </button>
      </div>
    </div>
    <div class="menu-panel" data-menu-panel>
      <div class="menu-panel__inner container">
        <div class="menu-panel__links">
          ${links}
        </div>
        <div class="button-row">
          <a class="btn btn--primary" href="./contact.php">Contact</a>
          <a class="btn btn--secondary" href="./grond-gezocht.php">Grond gezocht</a>
        </div>
      </div>
    </div>
  `;

  mount.innerHTML = header;
}

function renderAnnouncement() {
  const mount = document.querySelector(".announcement__inner");
  if (!mount) return;
  const contact = getContactInfo();
  mount.innerHTML = `
    <a href="mailto:${escapeHtml(contact.email)}">${escapeHtml(contact.email)}</a>
    <a href="${escapeHtml(getPhoneHref(contact.phone))}">${escapeHtml(contact.phone)}</a>
  `;
}

function renderFooter() {
  const mount = document.getElementById("site-footer");
  if (!mount) return;
  const contact = getContactInfo();
  const socialFooter = SITE.socials
    .map((item) => `<a class="footer-social" href="${item.href}" target="_blank" rel="noreferrer" aria-label="${item.label}">${getSocialIcon(item.label)}<span>${item.label}</span></a>`)
    .join("");
  const footer = `
    <div class="site-footer__inner container">
      <div class="site-footer__column site-footer__brand">
        <strong>Dalia Projects</strong>
        <p>Belgische vastgoedontwikkeling met focus op vertrouwen, kwaliteit en langetermijnwaarde.</p>
      </div>
      <div class="site-footer__column">
        <strong>Contact</strong>
        <a href="${escapeHtml(getPhoneHref(contact.phone))}">${escapeHtml(contact.phone)}</a>
        <a href="mailto:${escapeHtml(contact.email)}">${escapeHtml(contact.email)}</a>
      </div>
      <div class="site-footer__column">
        <strong>Overzicht</strong>
        <a href="./projecten.php">Projecten</a>
        <a href="./over.php">Over ons</a>
        <a href="./contact.php">Contact</a>
        <a href="./voorwaarden.php">Voorwaarden</a>
      </div>
      ${socialFooter ? `
      <div class="site-footer__column">
        <strong>Social</strong>
        <div class="site-footer__socials">${socialFooter}</div>
      </div>
      ` : ""}
      <div class="site-footer__column">
        <strong>Website</strong>
        <a href="./cookies.php">Cookiebeleid</a>
        <a href="./admin/">Admin</a>
        <a href="https://www.digisteps.be" target="_blank" rel="noopener">© Digisteps</a>
      </div>
    </div>
    <div class="site-footer__bottom container">
      <span>© <span data-year></span> Dalia Projects. Alle rechten zijn voorbehouden.</span>
      <span class="site-footer__credits">
        <a href="./admin/" aria-label="Adminpaneel">Admin</a>
        <a href="https://www.digisteps.be" target="_blank" rel="noopener">© Digisteps</a>
      </span>
    </div>
  `;
  mount.innerHTML = footer;
}

function renderContactSocials() {
  const mount = document.querySelector("[data-contact-socials]");
  if (!mount) return;

  const socials = normalizeSocials(SITE.socials);
  if (!socials.length) {
    mount.innerHTML = `
      <p>
        De sociale kanalen worden later toegevoegd. Voor nu verloopt alle communicatie
        rechtstreeks via e-mail of telefoon.
      </p>
    `;
    return;
  }

  mount.innerHTML = `
    <div class="social-list">
      ${socials
        .map(
          (item) => `
            <a href="${escapeHtml(item.href)}" target="_blank" rel="noreferrer">
              ${getSocialIcon(item.label)}
              ${escapeHtml(item.label)}
            </a>
          `
        )
        .join("")}
    </div>
  `;
}

function renderContactDetails() {
  const mount = document.querySelector("[data-contact-details]");
  if (!mount) return;
  const contact = getContactInfo();
  mount.innerHTML = `
    <p class="eyebrow">Contact</p>
    <h2>Wij nemen discreet contact op.</h2>
    <p>Voor projectvragen, grond te koop of algemene informatie kan u ons rechtstreeks bereiken.</p>
    <p><a href="${escapeHtml(getPhoneHref(contact.phone))}">${escapeHtml(contact.phone)}</a></p>
    <p><a href="mailto:${escapeHtml(contact.email)}">${escapeHtml(contact.email)}</a></p>
  `;

  document.querySelectorAll("[data-contact-phone]").forEach((link) => {
    link.setAttribute("href", getPhoneHref(contact.phone));
    link.textContent = `Bel ${contact.phone}`;
  });
  document.querySelectorAll("[data-contact-email]").forEach((link) => {
    link.setAttribute("href", `mailto:${contact.email}`);
  });
}

function renderContactMap() {
  const mount = document.querySelector("[data-contact-map]");
  if (!mount) return;
  const contact = getContactInfo();
  if (!contact.mapsEmbedUrl) {
    mount.remove();
    return;
  }
  const mapLink = contact.mapsLinkUrl || contact.mapsEmbedUrl;
  mount.innerHTML = `
    <div class="map-card__frame">
      <iframe
        title="Google Maps locatie Dalia Projects"
        src="${escapeHtml(contact.mapsEmbedUrl)}"
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        allowfullscreen>
      </iframe>
    </div>
    <div class="map-card__body">
      <p class="eyebrow">Google Maps</p>
      <h2>${escapeHtml(contact.addressLine1)}</h2>
      <p>${escapeHtml(contact.addressLine2)}</p>
      <a class="text-link" href="${escapeHtml(mapLink)}" target="_blank" rel="noopener">Open in Google Maps</a>
    </div>
  `;
}

function renderProjectSelects() {
  const currentProjects = getProjectCatalog().filter((project) => getPortfolioGroup(project) === "current");
  document.querySelectorAll("[data-project-select]").forEach((select) => {
    const selected = select.value;
    const options = currentProjects
      .map((project) => `<option value="${escapeHtml(project.title)}">${escapeHtml(project.title)}</option>`)
      .join("");
    select.innerHTML = `<option value="">Kies een lopend project</option>${options}`;
    if (selected) select.value = selected;
  });
}

function renderPersonnel(personnel = []) {
  const mount = document.querySelector("[data-personnel-grid]");
  if (!mount) return;
  if (!personnel.length) {
    mount.innerHTML = '<p class="portfolio-empty">Er zijn momenteel geen medewerkers gepubliceerd.</p>';
    return;
  }

  mount.innerHTML = personnel
    .map((person) => {
      const roleLine = [...person.roles, person.biv ? `BIV ${person.biv}` : ""].filter(Boolean).join(" - ");
      return `
        <article class="person-card" data-reveal>
          <div class="person-card__photo">
            <img src="${escapeHtml(person.photo || "./Webimages/Logo.png")}" alt="${escapeHtml(person.name)}" loading="lazy" />
          </div>
          <div class="person-card__body">
            <h3>${escapeHtml(person.name)}</h3>
            <p class="person-card__roles">${escapeHtml(roleLine)}</p>
            ${person.phone ? `<a class="person-card__contact person-card__contact--phone" href="${escapeHtml(getPhoneHref(person.phone))}">${escapeHtml(person.phone)}</a>` : ""}
            ${person.email ? `<a class="person-card__contact person-card__contact--mail" href="mailto:${escapeHtml(person.email)}">${escapeHtml(person.email)}</a>` : ""}
          </div>
        </article>
      `;
    })
    .join("");
}

function getVideoMimeType(url) {
  const normalized = String(url || "").toLowerCase();
  if (normalized.endsWith(".webm") || normalized.includes(".webm?")) {
    return "video/webm";
  }
  if (normalized.endsWith(".mov") || normalized.includes(".mov?")) {
    return "video/quicktime";
  }
  return "video/mp4";
}

function renderHomeHero() {
  const mount = document.querySelector("[data-home-hero-media]");
  if (!mount) return;

  const render = (settings = {}) => {
    const videoUrl = String(settings.heroVideoUrl || "").trim();
    const posterUrl = String(settings.heroPosterUrl || "").trim() || DEFAULT_HOME_HERO_IMAGE;
    const reducedMotion = window.matchMedia?.("(prefers-reduced-motion: reduce)")?.matches;

    const frame = videoUrl && !reducedMotion
      ? `
          <video class="hero-media__video" autoplay muted loop playsinline preload="auto" poster="${escapeHtml(posterUrl)}">
            <source src="${escapeHtml(videoUrl)}" type="${escapeHtml(getVideoMimeType(videoUrl))}" />
          </video>
        `
      : `
          <img class="hero-media__image" src="${escapeHtml(posterUrl)}" alt="Dalia Projects hero" loading="eager" />
        `;

    mount.innerHTML = `
      <div class="hero-media__frame">
        ${frame}
      </div>
      <div class="hero-media__scrim"></div>
    `;

    const video = mount.querySelector("video");
    if (video) {
      const playAttempt = video.play?.();
      if (playAttempt && typeof playAttempt.catch === "function") {
        playAttempt.catch(() => {});
      }
      video.addEventListener("error", () => {
        mount.innerHTML = `
          <div class="hero-media__frame">
            <img class="hero-media__image" src="${escapeHtml(posterUrl)}" alt="Dalia Projects hero" loading="eager" />
          </div>
          <div class="hero-media__scrim"></div>
        `;
      }, { once: true });
    }
  };

  render(DEFAULT_SITE_SETTINGS);

  const endpoint = SITE.admin.settingsEndpoint || "./admin/settings.php";
  fetch(endpoint, { cache: "no-store" })
    .then((response) => (response.ok ? response.json() : null))
    .then((settings) => {
      if (settings && typeof settings === "object") {
        render(settings);
      }
    })
    .catch(() => {
      render();
    });
}

function renderProjectCards(target, projects, featuredOnly = false) {
  const catalog = projects && projects.length ? projects : getProjectCatalog();
  const selected = featuredOnly ? catalog.slice(0, 6) : catalog;
  target.innerHTML = selected
    .map(
      (project) => {
        const isCurrent = getPortfolioGroup(project) === "current";
        const tag = isCurrent ? "a" : "article";
        const attrs = isCurrent ? `href="./project.php?slug=${encodeURIComponent(project.slug)}"` : 'aria-label="Projecttegel"';
        return `
        <${tag} class="project-card" ${attrs} data-reveal>
          <div class="project-card__media">
            <img src="${escapeHtml(project.hero)}" alt="${escapeHtml(project.title)}" loading="lazy" />
            <span class="project-card__badge">${escapeHtml(project.status)}</span>
          </div>
          <div class="project-card__body">
            <div class="project-card__meta">
              <span>${escapeHtml(project.type)}</span>
              <span>${escapeHtml(project.location)}</span>
            </div>
            <h3>${escapeHtml(project.title)}</h3>
            <p>${escapeHtml(project.summary)}</p>
            ${isCurrent ? '<span class="project-card__link">Bekijk project</span>' : ""}
          </div>
        </${tag}>
      `;
      }
    )
    .join("");
}

function renderProjectTile(project) {
  const group = getPortfolioGroup(project);
  const isCurrent = group === "current";
  const href = isCurrent ? `./project.php?slug=${encodeURIComponent(project.slug)}` : "";
  const tag = isCurrent ? "a" : "article";
  const attrs = isCurrent ? `href="${href}"` : 'aria-label="Projecttegel"';
  const secondary =
    group === "future"
      ? `Start verkoop: ${getProjectSalesStart(project)}`
      : group === "realized"
        ? "Verkocht"
        : project.type;

  return `
    <${tag} class="portfolio-tile portfolio-tile--${group}" ${attrs} data-reveal>
      <div class="portfolio-tile__media">
        <img src="${escapeHtml(project.hero)}" alt="${escapeHtml(project.title)}" loading="lazy" />
        <span class="portfolio-tile__badge">${escapeHtml(group === "realized" ? "Verkocht" : project.status)}</span>
      </div>
      <div class="portfolio-tile__body">
        <span>${escapeHtml(secondary)}</span>
        <h3>${escapeHtml(project.title)}</h3>
        <p>${escapeHtml(project.location)}</p>
        ${isCurrent ? '<strong>Bekijk project</strong>' : ""}
      </div>
    </${tag}>
  `;
}

function renderPortfolioSections() {
  const sections = {
    current: document.querySelector('[data-project-section="current"]'),
    future: document.querySelector('[data-project-section="future"]'),
    realized: document.querySelector('[data-project-section="realized"]'),
  };
  const catalog = getProjectCatalog();
  Object.entries(sections).forEach(([group, mount]) => {
    if (!mount) return;
    const items = catalog.filter((project) => getPortfolioGroup(project) === group);
    mount.innerHTML = items.length
      ? items.map(renderProjectTile).join("")
      : `<p class="portfolio-empty">Er zijn momenteel geen projecten in deze categorie.</p>`;
  });
}

function renderGalleryRail(target) {
  const railProjects = getProjectCatalog().filter((project) => getPortfolioGroup(project) === "current").slice(0, 6);
  target.innerHTML = railProjects
    .map(
      (project) => `
        <a class="gallery-card" href="./project.php?slug=${encodeURIComponent(project.slug)}">
          <img src="${escapeHtml(project.hero)}" alt="${escapeHtml(project.title)}" loading="lazy" />
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
  document.title = `${project.title} — Dalia Projects`;

  const location = document.querySelector("[data-project-location]");
  const title = document.querySelector("[data-project-title]");
  const bannerTitle = document.querySelector("[data-project-banner-title]");
  const intro = document.querySelector("[data-project-intro]");
  const meta = document.querySelector("[data-project-meta]");
  const hero = document.querySelector("[data-project-hero]");
  const quote = document.querySelector("[data-project-quote]");
  const context = document.querySelector("[data-project-context]");
  const cta = document.querySelector("[data-project-cta]");
  const gallery = document.querySelector("[data-project-gallery]");
  const highlight = document.querySelector("[data-project-highlight]");
  const salesOffice = document.querySelector("[data-project-sales-office]");
  const salesUrl = getProjectSalesUrl(project);

  if (location) location.textContent = project.location;
  if (title) title.textContent = project.title;
  if (bannerTitle) bannerTitle.textContent = project.title;
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
  if (highlight) highlight.textContent = getProjectHighlight(project);
  if (salesOffice) salesOffice.textContent = `Info en verkoop: ${getProjectSalesOffice(project)}`;
  if (cta) {
    cta.href = salesUrl;
    cta.textContent = project.ctaLabel || "Contacteer ons";
    if (/^https?:\/\//i.test(salesUrl)) {
      cta.setAttribute("target", "_blank");
      cta.setAttribute("rel", "noopener");
    }
  }
  if (gallery) {
    const list = project.gallery && project.gallery.length ? project.gallery : [project.hero];
    gallery.innerHTML = list
      .map(
        (src) => `
          <div class="gallery-card">
            <img src="${escapeHtml(src)}" alt="${escapeHtml(project.title)}" loading="lazy" />
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
  if (stored) {
    banner.hidden = true;
    banner.style.display = "none";
    return;
  }

  banner.hidden = false;
  banner.style.display = "";

  banner.querySelectorAll("[data-cookie]").forEach((button) => {
    button.addEventListener("click", () => {
      localStorage.setItem(key, button.dataset.cookie);
      banner.hidden = true;
      banner.style.display = "none";
    });
  });
}

function initMenu() {
  const toggle = document.querySelector("[data-menu-toggle]");
  const panel = document.querySelector("[data-menu-panel]");
  if (!toggle || !panel) return;
  const label = toggle.querySelector("[data-menu-toggle-label]");

  toggle.addEventListener("click", () => {
    const isOpen = panel.classList.toggle("is-open");
    document.body.classList.toggle("is-menu-open", isOpen);
    toggle.setAttribute("aria-expanded", String(isOpen));
    toggle.setAttribute("aria-label", isOpen ? "Menu sluiten" : "Menu openen");
    if (label) label.textContent = isOpen ? "Menu sluiten" : "Menu openen";
  });

  panel.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", () => {
      panel.classList.remove("is-open");
      document.body.classList.remove("is-menu-open");
      toggle.setAttribute("aria-expanded", "false");
      toggle.setAttribute("aria-label", "Menu openen");
      if (label) label.textContent = "Menu openen";
    });
  });
}

function initHeaderScroll() {
  const header = document.getElementById("site-header");
  if (!header) return;

  const sync = () => {
    header.classList.toggle("is-scrolled", window.scrollY > 24);
  };

  sync();
  window.addEventListener("scroll", sync, { passive: true });
}

function initRevealAnimations() {
  const nodes = Array.from(document.querySelectorAll("[data-reveal]"));
  if (!nodes.length) return;

  if (!("IntersectionObserver" in window)) {
    nodes.forEach((node) => node.classList.add("is-visible"));
    return;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add("is-visible");
        observer.unobserve(entry.target);
      });
    },
    { threshold: 0.12 }
  );

  nodes.forEach((node) => observer.observe(node));
}

function setYear() {
  document.querySelectorAll("[data-year]").forEach((node) => {
    node.textContent = String(new Date().getFullYear());
  });
}

function initPageContent() {
  const page = document.body.dataset.page;

  if (page === "home") {
    renderHomeHero();
    const grid = document.querySelector('[data-project-grid="featured"]');
    if (grid) renderProjectCards(grid, getProjectCatalog(), false);
  }

  if (page === "projects") {
    const rail = document.querySelector("[data-gallery-rail]");
    renderPortfolioSections();
    if (rail) renderGalleryRail(rail);
  }

  if (page === "project") {
    renderProjectPage();
  }

  if (page === "contact") {
    renderContactDetails();
    renderContactSocials();
    renderContactMap();
    renderProjectSelects();
  }

  if (page === "land-search") {
    renderProjectSelects();
  }

  if (page === "about") {
    renderPersonnel();
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

const inlineEditor = {
  authenticated: false,
  csrf: "",
  dirty: false,
  editing: false,
  initialized: false,
  page: "",
  toolbar: null,
  presence: null,
  button: null,
  status: null,
  elements: [],
  content: {},
};

function getInlinePageKey() {
  const page = window.location.pathname.split("/").pop();
  return page || "index.php";
}

function getInlineEditableElements() {
  const root = document.querySelector("main");
  if (!root) return [];

  const selector = [
    "h1",
    "h2",
    "h3",
    "h4",
    "h5",
    "h6",
    "p",
    "blockquote",
    "li",
    "a.btn",
    "a.text-link",
    ".project-card__meta span",
    ".project-card__body h3",
    ".project-card__body p",
    ".project-card__link",
    ".gallery-card__label",
    ".brand-visual__frame figcaption span",
    ".brand-visual__frame figcaption strong",
    ".land-lead__points span",
    ".land-lead__points strong",
  ].join(",");

  return Array.from(root.querySelectorAll(selector)).filter((element) => {
    if (element.closest("[data-inline-ignore], .cookie-banner, .admin-inline-toolbar, .admin-session-pill")) return false;
    if (element.querySelector("img, video, iframe, input, textarea, select")) return false;
    return element.textContent.trim() !== "";
  });
}

function assignInlineKeys(elements) {
  elements.forEach((element, index) => {
    element.dataset.inlineKey = `text_${String(index + 1).padStart(3, "0")}`;
  });
}

function applyInlineContent(content = {}) {
  const elements = getInlineEditableElements();
  assignInlineKeys(elements);
  elements.forEach((element) => {
    const key = element.dataset.inlineKey;
    if (key && Object.prototype.hasOwnProperty.call(content, key)) {
      element.textContent = String(content[key]);
    }
  });
  inlineEditor.elements = elements;
}

function setInlineDirty(value) {
  inlineEditor.dirty = value;
  if (inlineEditor.status) {
    inlineEditor.status.textContent = value ? "Niet opgeslagen" : "Opgeslagen";
  }
}

function setInlineEditing(value) {
  inlineEditor.editing = value;
  document.body.classList.toggle("is-inline-editing", value);
  inlineEditor.elements = getInlineEditableElements();
  assignInlineKeys(inlineEditor.elements);

  inlineEditor.elements.forEach((element) => {
    element.classList.toggle("is-inline-editable", value);
    if (value) {
      element.setAttribute("contenteditable", "true");
      element.setAttribute("spellcheck", "true");
    } else {
      element.removeAttribute("contenteditable");
      element.removeAttribute("spellcheck");
    }
  });

  if (inlineEditor.button) {
    inlineEditor.button.textContent = value ? "Status opslaan" : "Bewerken";
  }
}

function collectInlineUpdates() {
  const updates = {};
  inlineEditor.elements = getInlineEditableElements();
  assignInlineKeys(inlineEditor.elements);
  inlineEditor.elements.forEach((element) => {
    const key = element.dataset.inlineKey;
    if (key) updates[key] = element.textContent.replace(/\s+/g, " ").trim();
  });
  return updates;
}

function saveInlineContent() {
  if (!inlineEditor.authenticated || !inlineEditor.csrf) return Promise.resolve(false);

  const form = new FormData();
  form.set("page", inlineEditor.page);
  form.set("csrf", inlineEditor.csrf);
  form.set("updates", JSON.stringify(collectInlineUpdates()));

  if (inlineEditor.button) inlineEditor.button.textContent = "Opslaan...";
  if (inlineEditor.status) inlineEditor.status.textContent = "Opslaan...";

  return fetch("./admin/content.php", {
    method: "POST",
    body: form,
    cache: "no-store",
  })
    .then((response) => (response.ok ? response.json() : Promise.reject(new Error("save-failed"))))
    .then((payload) => {
      if (!payload.ok) throw new Error(payload.message || "save-failed");
      inlineEditor.content = payload.content || {};
      setInlineDirty(false);
      setInlineEditing(false);
      return true;
    })
    .catch(() => {
      if (inlineEditor.button) inlineEditor.button.textContent = "Status opslaan";
      if (inlineEditor.status) inlineEditor.status.textContent = "Opslaan mislukt";
      return false;
    });
}

function createInlineToolbar() {
  if (inlineEditor.toolbar || !inlineEditor.authenticated) return;

  const toolbar = document.createElement("div");
  toolbar.className = "admin-inline-toolbar";
  toolbar.setAttribute("data-inline-ignore", "true");
  toolbar.innerHTML = `
    <span class="admin-inline-toolbar__status">Pagina bewerken</span>
    <button class="btn btn--primary btn--small" type="button">Bewerken</button>
  `;

  document.body.appendChild(toolbar);
  inlineEditor.toolbar = toolbar;
  inlineEditor.status = toolbar.querySelector(".admin-inline-toolbar__status");
  inlineEditor.button = toolbar.querySelector("button");

  inlineEditor.button.addEventListener("click", () => {
    if (!inlineEditor.editing) {
      setInlineEditing(true);
      if (inlineEditor.status) inlineEditor.status.textContent = "Klik tekst om te wijzigen";
      return;
    }

    saveInlineContent();
  });
}

function createAdminPresenceButton() {
  if (inlineEditor.presence || !inlineEditor.authenticated) return;

  const link = document.createElement("a");
  link.className = "admin-session-pill";
  link.href = "./admin/";
  link.setAttribute("data-inline-ignore", "true");
  link.setAttribute("aria-label", "Terug naar adminpaneel");
  link.innerHTML = `
    <span>Aangemeld</span>
    <strong>Admin</strong>
  `;

  document.body.appendChild(link);
  inlineEditor.presence = link;
}

function initInlineEditor() {
  if (activePage === "admin") return;
  inlineEditor.page = getInlinePageKey();

  fetch(`./admin/content.php?page=${encodeURIComponent(inlineEditor.page)}`, { cache: "no-store" })
    .then((response) => (response.ok ? response.json() : null))
    .then((payload) => {
      if (!payload || typeof payload !== "object") return;
      inlineEditor.authenticated = payload.authenticated === true;
      inlineEditor.csrf = payload.csrf || "";
      inlineEditor.content = payload.content || {};
      applyInlineContent(inlineEditor.content);
      createAdminPresenceButton();
      createInlineToolbar();
      inlineEditor.initialized = true;
    })
    .catch(() => {});
}

document.addEventListener("input", (event) => {
  if (!inlineEditor.editing) return;
  if (!event.target.closest?.(".is-inline-editable")) return;
  setInlineDirty(true);
});

document.addEventListener("paste", (event) => {
  if (!inlineEditor.editing || !event.target.closest?.(".is-inline-editable")) return;
  event.preventDefault();
  const text = event.clipboardData?.getData("text/plain") || "";
  document.execCommand("insertText", false, text);
});

document.addEventListener("click", (event) => {
  if (!inlineEditor.editing) return;
  const link = event.target.closest?.("main a");
  if (link) event.preventDefault();
}, true);

window.addEventListener("beforeunload", (event) => {
  if (!inlineEditor.dirty) return;
  event.preventDefault();
  event.returnValue = "";
});

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

function fillAdminSettingsForm(form, settings) {
  if (!form || !settings) return;
  form.querySelector('[name="heroVideoUrl"]').value = settings.heroVideoUrl || "";
  form.querySelector('[name="heroPosterUrl"]').value = settings.heroPosterUrl || "";
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

function readAdminSettingsForm(form) {
  return {
    heroVideoUrl: form.querySelector('[name="heroVideoUrl"]').value.trim(),
    heroPosterUrl: form.querySelector('[name="heroPosterUrl"]').value.trim(),
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
  const settingsForm = document.querySelector("[data-admin-settings-form]");
  const settingsSaveButton = document.querySelector("[data-admin-settings-save]");
  const settingsResetButton = document.querySelector("[data-admin-settings-reset]");
  const settingsStatus = document.querySelector("[data-admin-settings-status]");

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
    fillAdminSettingsForm(settingsForm, getSiteSettings());

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

  settingsForm?.addEventListener("submit", (event) => {
    event.preventDefault();
    saveSiteSettings(readAdminSettingsForm(settingsForm));
    if (settingsStatus) {
      settingsStatus.textContent = "Homepage film opgeslagen.";
    }
    if (settingsSaveButton) {
      const original = settingsSaveButton.textContent;
      settingsSaveButton.textContent = "Opgeslagen";
      window.setTimeout(() => {
        settingsSaveButton.textContent = original;
      }, 1200);
    }
    syncDashboard();
  });

  settingsResetButton?.addEventListener("click", () => {
    saveSiteSettings({ ...DEFAULT_SITE_SETTINGS });
    if (settingsStatus) {
      settingsStatus.textContent = "Homepage film gereset naar de standaardafbeelding.";
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
    localStorage.removeItem(SITE.admin.settingsKey);
    syncDashboard();
  });
}

const activePage = document.body.dataset.page;

if (activePage === "admin") {
  initAdminPage();
} else {
  renderHeader();
  renderAnnouncement();
  renderFooter();
  setYear();
  initHeaderScroll();
  initMenu();
  initCookieBanner();
  initPageContent();
  initLinks();
  initRevealAnimations();
  Promise.all([fetchPublicSettings(), fetchPublicProjects(), fetchPublicPersonnel()]).then(([, , personnel]) => {
    renderHeader();
    renderAnnouncement();
    renderFooter();
    setYear();
    initHeaderScroll();
    initMenu();
    initPageContent();
    renderContactDetails();
    renderContactSocials();
    renderContactMap();
    renderProjectSelects();
    renderPersonnel(personnel);
    initRevealAnimations();
    initInlineEditor();
  });
}
