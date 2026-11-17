<?php
/**
 * Shared page header.
 * Set before including:  $page = ['title'=>..., 'description'=>..., 'path'=>'/calculator',
 *   'image'=>'/assets/hero-solar.jpg', 'schema'=>[...extra JSON-LD objects], 'crumbs'=>[['Name','/path'],...], 'noindex'=>false]
 */
require_once __DIR__ . '/config.php';
$page = $page ?? [];
$title = $page['title'] ?? BIZ_SHORT;
$desc  = $page['description'] ?? '';
$path  = $page['path'] ?? '/';
$canonical = SITE_URL . $path;
$image = SITE_URL . ($page['image'] ?? '/assets/hero-solar.jpg');
$active = $page['nav'] ?? '';

$schema = [];
$schema[] = [
    '@context' => 'https://schema.org',
    '@type' => ['LocalBusiness', 'HomeAndConstructionBusiness'],
    '@id' => SITE_URL . '/#business',
    'name' => BIZ_NAME,
    'alternateName' => 'Greenedge Infratech',
    'description' => 'Solar EPC company serving India and international clients: residential, housing society, commercial, industrial and government solar plants, zero-investment RESCO solar, green energy open access, solar pumps and maintenance. Registered vendor under PM Surya Ghar in Uttar Pradesh.',
    'url' => SITE_URL . '/',
    'logo' => SITE_URL . '/assets/logo.png',
    'image' => SITE_URL . '/assets/hero-solar.jpg',
    'telephone' => BIZ_PHONE,
    'email' => BIZ_EMAIL,
    'foundingDate' => (string)BIZ_SINCE,
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => BIZ_STREET,
        'addressLocality' => BIZ_CITY,
        'addressRegion' => BIZ_REGION,
        'postalCode' => BIZ_PIN,
        'addressCountry' => 'IN',
    ],
    'openingHoursSpecification' => [[
        '@type' => 'OpeningHoursSpecification',
        'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        'opens' => '09:00', 'closes' => '18:00',
    ]],
    'areaServed' => [['@type' => 'Country', 'name' => 'India'], ['@type' => 'Place', 'name' => 'International']],
    'sameAs' => [
        'https://www.facebook.com/share/1BzXrvyHHt/',
        'https://www.instagram.com/greenedge.infratech',
        'https://www.linkedin.com/company/greenedgeinfratech/',
        'https://x.com/Greenedgeinfra',
    ],
];
if (!empty($page['crumbs'])) {
    $items = [['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => SITE_URL . '/']];
    foreach ($page['crumbs'] as $i => $c) {
        $items[] = ['@type' => 'ListItem', 'position' => $i + 2, 'name' => $c[0], 'item' => SITE_URL . $c[1]];
    }
    $schema[] = ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $items];
}
foreach (($page['schema'] ?? []) as $s) $schema[] = $s;

$nav = [
    ['/pmsuryaghar/', 'PM Surya Ghar', 'pmsg'],
    ['/solar-schemes', 'Schemes & Policies', 'schemes'],
    ['/solar-guide', 'Solar Guide', 'guide'],
    ['/partner', 'Partner With Us', 'partner'],
    ['/about', 'About', 'about'],
    ['/contact', 'Contact', 'contact'],
];
$solGroups = [];
foreach (GE_SOLUTIONS as $sol) $solGroups[$sol[3]][] = $sol;
?><!DOCTYPE html>
<html lang="en-IN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title) ?></title>
<meta name="description" content="<?= e($desc) ?>">
<link rel="canonical" href="<?= e($canonical) ?>">
<?php if (!empty($page['noindex'])): ?><meta name="robots" content="noindex, follow">
<?php endif; ?>
<link rel="icon" href="/assets/image/favicon.ico" type="image/x-icon">
<meta name="theme-color" content="#15803d">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Greenedge Infratech">
<meta property="og:locale" content="en_IN">
<meta property="og:url" content="<?= e($canonical) ?>">
<meta property="og:title" content="<?= e($title) ?>">
<meta property="og:description" content="<?= e($desc) ?>">
<meta property="og:image" content="<?= e($image) ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($title) ?>">
<meta name="twitter:description" content="<?= e($desc) ?>">
<meta name="twitter:image" content="<?= e($image) ?>">
<link rel="stylesheet" href="/assets/css/site.css?v=<?= is_file(dirname(__DIR__) . '/assets/css/site.css') ? filemtime(dirname(__DIR__) . '/assets/css/site.css') : '1' ?>">
<?php if (!empty($page['preload'])): ?><link rel="preload" as="image" href="<?= e($page['preload']) ?>">
<?php endif; ?>
<script type="application/ld+json"><?= json_encode(count($schema) === 1 ? $schema[0] : $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= e(GOOGLE_TAG_ID) ?>"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?= e(GOOGLE_TAG_ID) ?>');</script>
</head>
<body class="bg-white text-slate-800 antialiased">
<a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:p-3 focus:bg-white">Skip to content</a>

<div class="bg-green-800 text-white text-sm">
  <div class="container mx-auto px-4 py-2 flex flex-wrap items-center justify-between gap-2">
    <span class="hidden sm:inline">Solar EPC across India &amp; abroad &bull; Homes, societies, business, industry &amp; government</span>
    <div class="flex items-center gap-4">
      <a href="tel:<?= BIZ_PHONE ?>" class="font-semibold hover:underline" data-track="phone_click">Call <?= BIZ_PHONE_DISPLAY ?></a>
      <a href="<?= e(wa_link('Hello Greenedge, I would like to know about rooftop solar.')) ?>" class="font-semibold hover:underline" target="_blank" rel="noopener" data-track="whatsapp_click">WhatsApp</a>
    </div>
  </div>
</div>

<header class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-slate-200">
  <div class="container mx-auto px-4 flex items-center justify-between h-16">
    <a href="/" class="flex items-center gap-2" aria-label="Greenedge Infratech home">
      <img src="/assets/logo.png" alt="Greenedge Infratech logo" width="44" height="44" class="w-11 h-11 object-contain">
      <span class="leading-tight"><span class="block font-extrabold tracking-wide text-green-700">GREENEDGE</span><span class="block text-xs font-semibold tracking-widest text-slate-500">INFRATECH</span></span>
    </a>
    <nav class="hidden lg:flex items-center gap-5 text-[15px] font-medium" aria-label="Main">
      <div class="relative group">
        <a href="/services" class="inline-flex items-center gap-1 py-5 hover:text-green-700 <?= $active === 'services' ? 'text-green-700' : '' ?>" aria-haspopup="true">Solutions <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg></a>
        <div class="nav-drop grid grid-cols-3 gap-4">
          <?php foreach ($solGroups as $g => $items): ?>
          <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2"><?= e($g) ?></p>
            <ul class="space-y-2"><?php foreach ($items as $it): ?>
              <li><a href="<?= $it[0] ?>" class="block rounded-md p-2 -m-2 hover:bg-green-50"><span class="block font-semibold text-slate-900 text-sm"><?= e($it[1]) ?></span><span class="block text-xs text-slate-500 font-normal"><?= e($it[2]) ?></span></a></li>
            <?php endforeach; ?></ul>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php foreach ($nav as $n): ?>
        <a href="<?= $n[0] ?>" class="hover:text-green-700 <?= $active === $n[2] ? 'text-green-700' : '' ?>"><?= $n[1] ?></a>
      <?php endforeach; ?>
    </nav>
    <div class="flex items-center gap-2">
      <a href="/calculator" class="hidden sm:inline-flex btn-primary text-sm" data-track="cta_calculator">Solar Calculator</a>
      <button id="menu-toggle" class="lg:hidden p-2 rounded-md border border-slate-300" aria-expanded="false" aria-controls="mobile-menu" aria-label="Open menu">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
      </button>
    </div>
  </div>
  <nav id="mobile-menu" class="hidden lg:hidden border-t border-slate-200 bg-white" aria-label="Mobile">
    <div class="container mx-auto px-4 py-3 grid gap-1">
      <a href="/calculator" class="py-2 font-semibold text-green-700">Solar Savings Calculator</a>
      <details class="py-1"><summary class="py-1 font-medium cursor-pointer">Solutions</summary>
        <div class="grid gap-1 pl-3 pb-2"><?php foreach (GE_SOLUTIONS as $it): ?><a href="<?= $it[0] ?>" class="py-1.5 text-slate-700"><?= e($it[1]) ?></a><?php endforeach; ?></div>
      </details>
      <?php foreach ($nav as $n): ?>
        <a href="<?= $n[0] ?>" class="py-2 font-medium"><?= $n[1] ?></a>
      <?php endforeach; ?>
      <a href="tel:<?= BIZ_PHONE ?>" class="btn-primary mt-2 text-center" data-track="phone_click">Call <?= BIZ_PHONE_DISPLAY ?></a>
    </div>
  </nav>
</header>
<main id="main">
<?php if (!empty($page['crumbs'])): ?>
<nav class="container mx-auto px-4 pt-4 text-sm text-slate-500" aria-label="Breadcrumb">
  <a href="/" class="hover:text-green-700">Home</a>
  <?php foreach ($page['crumbs'] as $c): ?> <span aria-hidden="true">/</span> <a href="<?= e($c[1]) ?>" class="hover:text-green-700"><?= e($c[0]) ?></a><?php endforeach; ?>
</nav>
<?php endif; ?>
