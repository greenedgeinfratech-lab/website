<?php
require __DIR__ . '/inc/config.php';
require __DIR__ . '/inc/ui.php';
$page = [
    'title' => 'Solar Panel Cleaning, Maintenance & AMC in India | Greenedge Infratech',
    'description' => 'Solar maintenance and AMC for homes, societies, businesses and industries: panel cleaning, preventive checks, inverter troubleshooting, performance reports and repairs, including plants installed by others.',
    'path' => '/solar-maintenance', 'nav' => 'services',
    'crumbs' => [['Solutions', '/services'], ['Maintenance & AMC', '/solar-maintenance']],
    'schema' => [['@context' => 'https://schema.org', '@type' => 'Service', 'name' => 'Solar operation, maintenance and AMC', 'provider' => ['@id' => SITE_URL . '/#business'], 'areaServed' => ['@type' => 'Country', 'name' => 'India'], 'url' => SITE_URL . '/solar-maintenance']],
];
include __DIR__ . '/inc/header.php';
ui_hero([
    'eyebrow' => 'Operation, maintenance &amp; AMC',
    'title' => 'Keep your solar plant producing at its best',
    'sub' => 'Dust, bird droppings, loose connections and unnoticed inverter faults quietly cut generation. A simple maintenance plan protects your savings &ndash; whether Greenedge installed your plant or someone else did.',
    'badges' => ['Homes to MW-scale plants', 'Plants by any installer', 'Generation reports', 'Fault diagnosis'],
    'ctas' => [['#enquire', 'Get a maintenance quote', 'btn-accent', 'cta_amc'], ['tel:' . BIZ_PHONE, 'Call for a breakdown', 'btn-outline-light', 'phone_click']],
    'image' => '/assets/maintenance.jpg',
]);
?>
<section class="container mx-auto px-4 py-16">
  <?php ui_heading('Maintenance plans', 'Choose the level of care you need. Final scope and price depend on plant size, location and access.'); ?>
  <div class="grid gap-6 mt-10 lg:grid-cols-3">
    <?php foreach ([
      ['Cleaning plan', 'For homes and small plants', ['Scheduled panel cleaning with soft brushes and clean water', 'Visual check of panels, structure and cables', 'Short report after each visit']],
      ['Preventive maintenance', 'For businesses and societies', ['Everything in the cleaning plan', 'Quarterly electrical checks: connections, earthing, SPDs, isolators', 'Inverter health check and error log review', 'Generation vs expected comparison']],
      ['Comprehensive O&amp;M', 'For industrial and large plants', ['Everything in preventive maintenance', 'Remote monitoring and alerts', 'Breakdown response and repairs (spares as agreed)', 'Thermal imaging and IV-curve testing where needed', 'Monthly performance report']],
    ] as $i => $p): ?>
    <div class="card p-6 <?= $i === 1 ? 'border-green-400 ring-1 ring-green-300' : '' ?>">
      <p class="text-xs font-semibold uppercase tracking-wider text-green-700"><?= $p[1] ?></p>
      <h3 class="text-xl font-bold mt-1"><?= $p[0] ?></h3>
      <ul class="mt-4 space-y-2 text-sm text-slate-700 tick-list"><?php foreach ($p[2] as $li): ?><li><?= $li ?></li><?php endforeach; ?></ul>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="bg-slate-50">
  <div class="container mx-auto px-4 py-16 grid lg:grid-cols-2 gap-10 items-start">
    <div>
      <h2 class="section-title">Signs your plant needs attention</h2>
      <ul class="mt-6 space-y-3 tick-list text-slate-700">
        <li>Monthly generation is clearly lower than the same month last year</li>
        <li>The inverter shows an error code, or the monitoring app has stopped updating</li>
        <li>Your electricity bill has gone up although usage is the same</li>
        <li>Visible dust layers, bird droppings, cracks or brown marks on panels</li>
        <li>Loose, damaged or rodent-bitten cables</li>
        <li>Water pooling or rust on the structure</li>
      </ul>
    </div>
    <div>
      <h2 class="section-title">Safe cleaning at home</h2>
      <ul class="mt-6 space-y-3 tick-list text-slate-700">
        <li>Clean early morning or evening, when panels are cool</li>
        <li>Use clean water and a soft mop or brush; no detergent or hard scrubbers</li>
        <li>Never walk or stand on panels</li>
        <li>Do not open the inverter or DC junction boxes &ndash; call a technician</li>
        <li>In dusty months, clean about twice a month</li>
      </ul>
    </div>
  </div>
</section>

<?php ui_enquiry(['type' => 'callback', 'category' => 'residential', 'message' => true, 'heading' => 'Get a maintenance quote', 'button' => 'Request a Quote'],
    'Tell us about your plant',
    'Share the plant size, location and installer. If there is a problem, describe it or send an inverter photo on WhatsApp.',
    ['Plants by any installer', 'Clear scope and price before we start', 'Visit reports you can keep']); ?>
<?php ui_related('/solar-maintenance'); ?>
<?php include __DIR__ . '/inc/footer.php'; ?>
