<?php
require __DIR__ . '/inc/config.php';
$page = [
    'title' => 'Rooftop Solar FAQs: Cost, Subsidy, Net Metering, Maintenance | Greenedge Infratech',
    'description' => 'Answers to common questions about rooftop solar in India: cost per kW, PM Surya Ghar subsidy, net metering, roof space, power cuts, maintenance and warranties.',
    'path' => '/faq', 'crumbs' => [['FAQs', '/faq']],
];
$groups = require __DIR__ . '/inc/faq-data.php';
include __DIR__ . '/inc/header.php';
?>
<section class="container mx-auto px-4 py-12 max-w-3xl">
  <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Rooftop solar FAQs</h1>
  <?php foreach ($groups as $g => $items): ?>
  <h2 class="text-xl font-bold mt-10 text-green-800"><?= e($g) ?></h2>
  <div class="mt-4 space-y-3">
    <?php foreach ($items as $f): ?>
    <details class="card p-5"><summary class="font-semibold cursor-pointer"><?= e($f[0]) ?></summary><div class="mt-3 text-slate-600 prose-lite"><?= ge_format($f[1]) ?></div></details>
    <?php endforeach; ?>
  </div>
  <?php endforeach; ?>
  <div class="card p-6 mt-10 bg-green-50">
    <p class="font-bold">Still have a question?</p>
    <p class="text-slate-600 text-sm mt-1">Call <a class="underline" href="tel:<?= BIZ_PHONE ?>" data-track="phone_click"><?= BIZ_PHONE_DISPLAY ?></a> or <a class="underline" href="/contact">send us a message</a>.</p>
  </div>
</section>
<?php include __DIR__ . '/inc/footer.php';
