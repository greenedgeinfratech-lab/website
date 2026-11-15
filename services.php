<?php
require __DIR__ . '/inc/config.php';
$page = [
    'title' => 'Solar Installation Services in Aligarh: Residential, Commercial, Industrial | Greenedge',
    'description' => 'Rooftop solar EPC in Aligarh and Western UP: home solar, PM Surya Ghar, commercial and industrial plants, hybrid and off-grid systems, solar pumps, maintenance and energy audits.',
    'path' => '/services',
    'nav' => 'services',
    'crumbs' => [['Services', '/services']],
    'schema' => [[
        '@context' => 'https://schema.org', '@type' => 'ItemList',
        'itemListElement' => array_map(fn($i, $n) => ['@type' => 'ListItem', 'position' => $i + 1, 'item' => ['@type' => 'Service', 'name' => $n, 'provider' => ['@id' => SITE_URL . '/#business'], 'areaServed' => 'Western Uttar Pradesh']],
            array_keys($s = ['Residential rooftop solar', 'Commercial rooftop solar', 'Industrial solar plants', 'Hybrid and off-grid solar with battery', 'Solar water pumps', 'Solar maintenance and AMC', 'Solar feasibility and energy audit']), $s),
    ]],
];
include __DIR__ . '/inc/header.php';
?>
<section class="bg-green-900 text-white">
  <div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl sm:text-4xl font-extrabold">Solar installation services in Aligarh &amp; Western UP</h1>
    <p class="mt-3 text-green-100 max-w-3xl">From a 1 kW system on a house roof to large plants for factories, Greenedge designs, supplies, installs and maintains complete solar power systems &ndash; and handles the DISCOM net-metering work.</p>
  </div>
</section>

<?php
$blocks = [
  ['residential', 'Residential rooftop solar', '/assets/solar-installation.jpg',
   'For houses, villas, farmhouses and apartments. Most homes choose an on-grid system with net metering, which can bring energy charges close to zero and qualifies for PM Surya Ghar subsidy.',
   ['1 kW to 10 kW on-grid systems sized from your bills', 'PM Surya Ghar portal, DISCOM and subsidy paperwork support', 'Hybrid systems with battery for homes with frequent power cuts', 'Elevated structures for parking or terrace use'],
   ['/calculator?cat=residential', 'Calculate home savings'], 'residential'],
  ['commercial', 'Commercial rooftop solar', '/assets/commercial.jpg',
   'Shops, showrooms, offices, schools, colleges, hospitals, hotels and banks use most of their power in the daytime &ndash; exactly when solar generates. That usually means fast payback without batteries.',
   ['Design around your daytime load and sanctioned load', 'Net metering application with the DISCOM', 'Remote monitoring of generation', 'Advice on tax benefits (consult your CA)'],
   ['/calculator?cat=commercial', 'Calculate business savings'], 'commercial'],
  ['industrial', 'Industrial solar plants', '/assets/image/solar-pv.jpg',
   'For factories, cold stores, flour and rice mills, workshops and warehouses around Aligarh, Hathras and nearby industrial areas. We study your load profile and tariff to size the plant for the best return.',
   ['Rooftop and ground-mounted plants', 'Load-profile and bill analysis before design', 'Structural check of sheds and RCC roofs', 'Operation and maintenance contracts'],
   ['/contact?type=site-survey', 'Request an industrial site survey'], 'industrial'],
];
foreach ($blocks as $i => $b): ?>
<section id="<?= $b[0] ?>" class="scroll-mt-24 <?= $i % 2 ? 'bg-slate-50' : '' ?>">
  <div class="container mx-auto px-4 py-14 grid lg:grid-cols-2 gap-10 items-center">
    <img src="<?= $b[2] ?>" alt="<?= e($b[1]) ?> by Greenedge Infratech" loading="lazy" width="800" height="560" class="rounded-xl shadow w-full object-cover aspect-[4/3] <?= $i % 2 ? 'lg:order-2' : '' ?>">
    <div>
      <h2 class="section-title"><?= e($b[1]) ?></h2>
      <p class="mt-3 text-slate-700"><?= $b[3] ?></p>
      <ul class="mt-4 space-y-2 list-disc pl-5 text-slate-700"><?php foreach ($b[4] as $li): ?><li><?= e($li) ?></li><?php endforeach; ?></ul>
      <div class="mt-6 flex flex-wrap gap-3">
        <a href="<?= $b[5][0] ?>" class="btn-primary"><?= e($b[5][1]) ?></a>
        <a href="/contact?type=quotation" class="btn-secondary">Get a quotation</a>
      </div>
    </div>
  </div>
</section>
<?php endforeach; ?>

<section class="container mx-auto px-4 py-14">
  <h2 class="section-title text-center">More solar services</h2>
  <div class="grid gap-6 mt-8 sm:grid-cols-2 lg:grid-cols-4">
    <?php foreach ([
      ['Hybrid &amp; off-grid systems', 'Solar with battery storage for backup during outages, or fully off-grid for sites without a reliable connection.'],
      ['Solar water pumps', 'Submersible and surface pumps for irrigation and water supply. Farmers can ask about the PM-KUSUM scheme.'],
      ['Maintenance &amp; AMC', 'Scheduled cleaning, electrical checks, inverter health checks and quick fault repair, including for systems installed by others.'],
      ['Feasibility &amp; energy audit', 'Roof, shadow and load assessment, bill analysis and a written recommendation before you invest.'],
    ] as $c): ?>
    <div class="card p-6"><h3 class="font-bold text-green-800"><?= $c[0] ?></h3><p class="text-sm text-slate-600 mt-2"><?= $c[1] ?></p></div>
    <?php endforeach; ?>
  </div>
</section>

<section class="bg-green-50">
  <div class="container mx-auto px-4 py-12 max-w-3xl">
    <?php $lf = ['type' => 'quotation', 'heading' => 'Get your solar quotation', 'message' => true, 'button' => 'Get My Solar Quotation']; include __DIR__ . '/inc/lead-form.php'; ?>
  </div>
</section>
<?php include __DIR__ . '/inc/footer.php'; ?>
