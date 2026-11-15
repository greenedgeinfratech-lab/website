<?php
require __DIR__ . '/inc/config.php';
$page = [
    'title' => 'Rooftop Solar FAQs: Cost, Subsidy, Net Metering, Maintenance | Greenedge Aligarh',
    'description' => 'Answers to common questions about rooftop solar in Uttar Pradesh: cost per kW, PM Surya Ghar subsidy, net metering, roof space, power cuts, maintenance and warranties.',
    'path' => '/faq', 'crumbs' => [['FAQs', '/faq']],
];
$groups = [
 'Cost & savings' => [
  ['How much does rooftop solar cost in Aligarh?', 'For on-grid home systems, a typical budget is about &#8377;55,000&ndash;65,000 per kW including GST before subsidy. Larger commercial and industrial plants cost less per kW. Hybrid systems with batteries cost more. Your site survey gives an exact quotation.'],
  ['How much will I save?', 'Many homes reduce their bill by 70&ndash;80% or more with a correctly sized system. Fixed charges stay on the bill. Try the <a class="underline" href="/calculator">calculator</a> with your own bill.'],
  ['What is the payback period?', 'For eligible homes with PM Surya Ghar subsidy it is often 3&ndash;5 years; for businesses with daytime use it is commonly 3&ndash;5 years as well. It depends on your tariff and usage.'],
 ],
 'Subsidy & approvals' => [
  ['How much subsidy can I get in UP?', 'Eligible homes: &#8377;45,000 for 1 kW, &#8377;90,000 for 2 kW and &#8377;1,08,000 for 3 kW or more (central PM Surya Ghar + UPNEDA state subsidy). See our <a class="underline" href="/pmsuryaghar/">PM Surya Ghar guide</a>.'],
  ['Can shops or factories get the subsidy?', 'No. PM Surya Ghar subsidy is only for residential consumers (and housing societies for common areas). Businesses may get tax benefits such as depreciation &ndash; ask your CA.'],
  ['What is net metering?', 'A two-way meter records units you import from and export to the grid. Exported units are adjusted against imported units in your bill. Any annual surplus is settled at a lower rate set by the regulator.'],
 ],
 'Technical' => [
  ['How much roof space do I need?', 'About 100 sq ft of shadow-free roof per kW.'],
  ['How many units does 1 kW produce?', 'In Western UP, about 4&ndash;4.5 units a day on average across the year, roughly 120&ndash;135 units a month. Summer months produce more, winter and foggy months less.'],
  ['Will solar run during a power cut?', 'A standard on-grid system switches off during outages for safety. If you need backup, choose a hybrid system with batteries.'],
  ['Mono PERC or TOPCon panels?', 'Both are reliable. TOPCon panels are a newer technology with slightly higher efficiency and better performance in heat, useful when roof space is limited. Mono PERC is often more economical.'],
 ],
 'Maintenance & warranty' => [
  ['How do I clean the panels?', 'Rinse with clean water and a soft mop, early morning or evening, about twice a month in dusty seasons. Avoid detergent, hard brushes and walking on the panels.'],
  ['What warranties come with the system?', 'Panel and inverter warranties are given by their manufacturers (panels usually 25&ndash;30 years on power output). Installation workmanship terms are written in your Greenedge quotation.'],
 ],
];
include __DIR__ . '/inc/header.php';
?>
<section class="container mx-auto px-4 py-12 max-w-3xl">
  <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Rooftop solar FAQs</h1>
  <?php foreach ($groups as $g => $items): ?>
  <h2 class="text-xl font-bold mt-10 text-green-800"><?= e($g) ?></h2>
  <div class="mt-4 space-y-3">
    <?php foreach ($items as $f): ?>
    <details class="card p-5"><summary class="font-semibold cursor-pointer"><?= $f[0] ?></summary><p class="mt-3 text-slate-600"><?= $f[1] ?></p></details>
    <?php endforeach; ?>
  </div>
  <?php endforeach; ?>
  <div class="card p-6 mt-10 bg-green-50">
    <p class="font-bold">Still have a question?</p>
    <p class="text-slate-600 text-sm mt-1">Call <a class="underline" href="tel:<?= BIZ_PHONE ?>" data-track="phone_click"><?= BIZ_PHONE_DISPLAY ?></a> or <a class="underline" href="/contact">send us a message</a>.</p>
  </div>
</section>
<?php include __DIR__ . '/inc/footer.php';
