<?php
require __DIR__ . '/inc/config.php';
require __DIR__ . '/inc/ui.php';
$page = [
    'title' => 'Industrial Solar Plants in UP: Factories, MSMEs, Cold Stores | Greenedge Infratech',
    'description' => 'Rooftop, carport and ground-mounted solar for factories, MSMEs, cold stores, mills and warehouses in Uttar Pradesh. CAPEX, zero-investment RESCO and green energy open access. Load-profile based design.',
    'path' => '/industrial-solar', 'nav' => 'services',
    'crumbs' => [['Solutions', '/services'], ['Industrial solar', '/industrial-solar']],
    'schema' => [['@context' => 'https://schema.org', '@type' => 'Service', 'name' => 'Industrial solar power plants', 'provider' => ['@id' => SITE_URL . '/#business'], 'areaServed' => 'Uttar Pradesh', 'url' => SITE_URL . '/industrial-solar']],
];
include __DIR__ . '/inc/header.php';
ui_hero([
    'eyebrow' => 'Industrial &amp; MSME solar',
    'title' => 'Lower your cost of production with solar',
    'sub' => 'Power is one of the biggest controllable costs for a factory. Greenedge engineers rooftop, carport and ground-mounted plants around your load profile, and offers CAPEX, zero-investment RESCO and open access routes.',
    'badges' => ['Metal-shed &amp; RCC roofs', 'Ground-mounted plants', 'DG-synchronised designs', 'O&amp;M contracts'],
    'ctas' => [['#enquire', 'Request a plant proposal', 'btn-accent', 'cta_proposal'], ['/calculator?cat=industrial', 'Quick estimate', 'btn-outline-light', 'cta_calculator']],
    'image' => '/assets/image/solar-pv.jpg',
]);
?>
<section class="container mx-auto px-4 py-16">
  <?php ui_heading('Three ways to bring solar into your plant'); ?>
  <div class="grid gap-6 mt-10 lg:grid-cols-3">
    <?php foreach ([
      ['On-site captive (CAPEX)', 'You own the plant on your roof or land. Lowest lifetime cost per unit, and solar plants qualify for 40% accelerated depreciation (consult your CA).', '/solar-guide#models'],
      ['Zero investment (RESCO)', 'A developer finances, builds and maintains the plant on your premises. You sign a long-term PPA and pay a fixed tariff below your grid rate.', '/resco-solar'],
      ['Green energy open access', 'If your contracted demand is 100 kW or more, you can source solar power from a plant elsewhere in UP through the grid, without needing your own roof.', '/open-access-solar'],
    ] as $m): ?>
    <a href="<?= $m[2] ?>" class="card p-6 hover:shadow-lg hover:border-green-300 transition flex flex-col">
      <h3 class="text-xl font-bold text-slate-900"><?= $m[0] ?></h3>
      <p class="mt-2 text-sm text-slate-600 flex-1"><?= $m[1] ?></p>
      <span class="mt-4 font-semibold text-green-700">Learn more &rarr;</span>
    </a>
    <?php endforeach; ?>
  </div>
</section>

<section class="bg-slate-50">
  <div class="container mx-auto px-4 py-16 grid lg:grid-cols-2 gap-10 items-start">
    <div>
      <h2 class="section-title">Engineering that suits industry</h2>
      <ul class="mt-6 space-y-4 text-slate-700 tick-list">
        <li><strong>Load-profile design.</strong> We study 15-minute or hourly demand data and shift patterns so solar replaces your costliest units.</li>
        <li><strong>Roof-specific structures.</strong> Mounting for trapezoidal and standing-seam metal sheets, RCC roofs and long-span sheds, with walkways for safe cleaning.</li>
        <li><strong>Ground and carport plants.</strong> For factories with spare land or large parking areas.</li>
        <li><strong>Works with your DG set.</strong> Controllers that prevent reverse feeding into diesel generators and manage zero-export where needed.</li>
        <li><strong>Protection and safety.</strong> String monitoring, surge protection, earthing and lightning protection to IS/IEC practice.</li>
        <li><strong>Monitoring.</strong> Web and app dashboards for generation, faults and performance ratio.</li>
      </ul>
    </div>
    <div>
      <h2 class="section-title">Industries we serve</h2>
      <div class="grid grid-cols-2 gap-3 mt-6 text-sm">
        <?php foreach (['Lock &amp; hardware units', 'Engineering &amp; fabrication', 'Food processing', 'Cold storages', 'Flour, rice &amp; oil mills', 'Dairy &amp; milk chilling', 'Textiles &amp; garments', 'Plastics &amp; packaging', 'Warehouses &amp; logistics', 'Brick kilns &amp; workshops'] as $i): ?>
        <div class="card px-4 py-3 font-medium text-slate-800"><?= $i ?></div>
        <?php endforeach; ?>
      </div>
      <p class="mt-6 text-sm text-slate-600">Aligarh&rsquo;s lock and hardware cluster and the food and cold-storage units across Hathras, Etah and Mathura run long daytime shifts &ndash; ideal for solar.</p>
    </div>
  </div>
</section>

<?php ui_enquiry(['type' => 'quotation', 'category' => 'industrial', 'business' => true, 'message' => true, 'heading' => 'Request an industrial solar proposal', 'button' => 'Request Proposal'],
    'Get a plant-specific proposal',
    'Tell us about your unit. We will review your bills and load data, survey the site, and present CAPEX, RESCO and open access options with clear numbers.',
    ['Load-profile and tariff analysis', 'Structural check of sheds and roofs', 'Savings, payback and IRR in writing']); ?>

<?php ui_faqs([
    ['How much roof do we need?', 'Roughly 80&ndash;100 sq ft of shadow-free roof per kW on metal sheds, and about 100 sq ft per kW on RCC roofs. A 100 kW plant needs around 8,000&ndash;10,000 sq ft.'],
    ['Will solar work with our DG set?', 'Yes. We add controllers that reduce solar output when the DG set is running, so the generator is never back-fed.'],
    ['Is there a subsidy for factories?', 'PM Surya Ghar is only for homes and housing societies. Industries benefit from lower energy costs and, if eligible, 40% accelerated depreciation on the plant. Check the latest UP industrial and MSME policies, which sometimes add incentives.'],
    ['We have no roof space. What can we do?', 'If your contracted demand is 100 kW or more, <a href="/open-access-solar">green energy open access</a> lets you buy solar power from a plant elsewhere. A ground-mounted or carport plant on your own land is another option.'],
]); ?>
<?php ui_related('/industrial-solar'); ?>
<?php include __DIR__ . '/inc/footer.php'; ?>
