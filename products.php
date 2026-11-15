<?php
require __DIR__ . '/inc/config.php';
$page = [
    'title' => 'Solar Panels, Inverters, Batteries & Solar Pumps in Aligarh | Greenedge Infratech',
    'description' => 'Mono PERC and TOPCon solar panels, on-grid and hybrid inverters, batteries, mounting structures and solar pumps supplied and installed by Greenedge Infratech in Aligarh.',
    'path' => '/products',
    'nav' => 'products',
    'crumbs' => [['Products', '/products']],
];
include __DIR__ . '/inc/header.php';
$products = [
  ['panels', 'Solar panels (PV modules)', '/assets/image/solar-pv.jpg',
   'We supply MNRE ALMM-listed panels from established manufacturers, chosen for your roof and budget.',
   ['Mono PERC half-cut modules: proven, cost-effective, widely used for homes', 'N-type TOPCon modules: higher efficiency and better hot-weather performance, useful where roof space is limited', 'Bifacial modules for elevated structures, where the rear side can also collect light', 'Domestic Content (DCR) modules for PM Surya Ghar, as the scheme requires'],
   'Typical warranties: 10&ndash;12 years on the product and 25&ndash;30 years linear power output, as given by the panel manufacturer.'],
  ['inverters', 'Solar inverters', '/assets/image/solar-home-solution.webp',
   'The inverter converts DC from the panels into AC for your home or business and manages export to the grid.',
   ['On-grid (string) inverters for net-metered systems', 'Hybrid inverters that also charge and run from batteries', 'Off-grid inverters with charge controllers', 'Wi-Fi / app monitoring of daily generation'],
   'Inverter warranty is set by the manufacturer, typically 5&ndash;10 years.'],
  ['batteries', 'Batteries &amp; energy storage', '/assets/image/renewable.jpg',
   'For homes and businesses that need power during outages, or sites without a reliable grid connection.',
   ['Lithium-ion (LFP) battery banks for hybrid systems', 'Tubular lead-acid options for smaller off-grid needs', 'Sizing from the loads you want to run during a cut'],
   'Battery systems cost more than on-grid systems and are not required for PM Surya Ghar.'],
  ['structures', 'Mounting structures', '/assets/solar-installation.jpg',
   'Galvanised steel or aluminium structures designed for wind loads and roof type.',
   ['RCC flat-roof and elevated structures', 'Tin-shed (metal sheet) roof mounting for factories and warehouses', 'Ground-mounted structures for open land'],
   ''],
  ['pumps', 'Solar water pumps', '/assets/image/solar-micro-pump.webp',
   'Fuel-free water pumping for irrigation and rural water supply.',
   ['Submersible pumps for borewells and tube wells', 'Surface pumps for open wells, ponds and canals', 'Controllers with dry-run protection'],
   'Farmers can ask us about the PM-KUSUM scheme.'],
];
?>
<section class="bg-green-900 text-white">
  <div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl sm:text-4xl font-extrabold">Solar panels, inverters &amp; equipment</h1>
    <p class="mt-3 text-green-100 max-w-3xl">We supply and install complete systems with quality components and manufacturer warranties. Your quotation lists every brand and model so you can compare.</p>
  </div>
</section>
<div class="container mx-auto px-4 py-12 space-y-8">
  <?php foreach ($products as $p): ?>
  <section id="<?= $p[0] ?>" class="card p-6 grid md:grid-cols-[280px_1fr] gap-6 scroll-mt-24">
    <img src="<?= $p[2] ?>" alt="<?= strip_tags($p[1]) ?>" loading="lazy" width="560" height="400" class="rounded-lg w-full object-cover aspect-[4/3]">
    <div>
      <h2 class="text-2xl font-bold text-slate-900"><?= $p[1] ?></h2>
      <p class="mt-2 text-slate-700"><?= $p[3] ?></p>
      <ul class="mt-3 list-disc pl-5 space-y-1 text-slate-700"><?php foreach ($p[4] as $li): ?><li><?= e($li) ?></li><?php endforeach; ?></ul>
      <?php if ($p[5]): ?><p class="mt-3 text-sm text-slate-500"><?= $p[5] ?></p><?php endif; ?>
      <a href="/contact?type=quotation" class="btn-secondary mt-4 inline-flex">Ask for a quotation</a>
    </div>
  </section>
  <?php endforeach; ?>
</div>
<?php include __DIR__ . '/inc/footer.php'; ?>
