<?php
require __DIR__ . '/inc/config.php';
require __DIR__ . '/inc/ui.php';
$page = [
    'title' => 'Commercial Rooftop Solar in Aligarh & UP: Shops, Offices, Schools, Hospitals | Greenedge',
    'description' => 'Commercial rooftop solar for shops, showrooms, offices, schools, colleges, hospitals and hotels in Uttar Pradesh. Daytime savings, 40% accelerated depreciation, CAPEX or zero-investment RESCO. Free energy assessment.',
    'path' => '/commercial-solar', 'nav' => 'services',
    'crumbs' => [['Solutions', '/services'], ['Commercial solar', '/commercial-solar']],
    'schema' => [['@context' => 'https://schema.org', '@type' => 'Service', 'name' => 'Commercial rooftop solar', 'provider' => ['@id' => SITE_URL . '/#business'], 'areaServed' => 'Uttar Pradesh', 'url' => SITE_URL . '/commercial-solar']],
];
include __DIR__ . '/inc/header.php';
ui_hero([
    'eyebrow' => 'Commercial &amp; institutional solar',
    'title' => 'Turn your roof into your cheapest source of power',
    'sub' => 'Shops, offices, schools, hospitals and hotels use most of their electricity in daylight &ndash; exactly when solar generates. That means lower bills from the first month, a short payback and tax benefits, with or without upfront investment.',
    'badges' => ['10 kW to 1 MW+', '40% accelerated depreciation*', 'CAPEX or RESCO', 'Remote monitoring'],
    'ctas' => [['/calculator?cat=commercial', 'Calculate business savings', 'btn-accent', 'cta_calculator'], ['#enquire', 'Get a free energy assessment', 'btn-outline-light', 'cta_proposal']],
    'image' => '/assets/commercial.jpg',
]);
?>
<section class="container mx-auto px-4 py-16">
  <?php ui_heading('Built for the way your building uses power'); ?>
  <?php ui_cards([
      ['Retail &amp; showrooms', 'Lighting, air-conditioning and display loads through the day. Solar on the roof or a parking shed trims the costliest units.'],
      ['Offices &amp; banks', 'Steady weekday daytime demand that solar matches closely, with app monitoring for the facilities team.'],
      ['Schools, colleges &amp; universities', 'Large roofs and daytime use. Educational institutions in UP can use net metering for rooftop solar.'],
      ['Hospitals &amp; clinics', 'Round-the-clock loads; solar cuts daytime grid draw, and hybrid designs can support critical loads.'],
      ['Hotels, marriage halls &amp; restaurants', 'High cooling loads in summer, when solar output is strongest.'],
      ['Cold stores, petrol pumps &amp; warehouses', 'Long operating hours and big roofs suited to larger plants.'],
  ]); ?>
</section>

<section class="bg-slate-50">
  <div class="container mx-auto px-4 py-16 grid lg:grid-cols-2 gap-10 items-start">
    <div>
      <h2 class="section-title">The business case</h2>
      <ul class="mt-6 space-y-4 text-slate-700 tick-list">
        <li><strong>Lower energy cost.</strong> Every solar unit you use on site replaces a unit bought at your commercial tariff.</li>
        <li><strong>Tax benefit.</strong> Solar power plants are listed for 40% depreciation (written-down value) under the Income Tax rules, which can reduce tax in the early years. *Confirm eligibility and timing with your CA.</li>
        <li><strong>Protection from tariff rises.</strong> Your solar cost is fixed once the plant is built.</li>
        <li><strong>No-investment route.</strong> Under <a class="text-green-700 underline" href="/resco-solar">RESCO</a>, a developer funds and maintains the plant and you pay only for units generated, at a tariff below the grid rate.</li>
        <li><strong>Green credentials.</strong> Report renewable energy use to customers, lenders and parent companies.</li>
      </ul>
    </div>
    <div class="card p-6">
      <h3 class="text-xl font-bold text-slate-900">What our commercial proposal covers</h3>
      <ul class="mt-4 space-y-2 text-sm text-slate-700 tick-list">
        <li>12-month bill and load-profile analysis, including sanctioned load and contract demand</li>
        <li>Shadow analysis and layout drawing for your roof or parking area</li>
        <li>Structural check of RCC roofs and metal sheds</li>
        <li>Generation estimate, savings, payback and IRR for CAPEX, and tariff offer for RESCO</li>
        <li>Metering option that applies to your consumer category under UPERC rooftop regulations</li>
        <li>Bill of materials with brands, models and manufacturer warranties</li>
        <li>Project schedule, safety plan and O&amp;M plan</li>
      </ul>
      <a href="#enquire" class="btn-primary mt-6 inline-flex">Request a proposal</a>
    </div>
  </div>
</section>

<section class="container mx-auto px-4 py-16">
  <?php ui_heading('Project delivery', 'A typical 50&ndash;200 kW rooftop plant is installed within a few weeks of material reaching site; approvals add time depending on the DISCOM.'); ?>
  <?php ui_steps([
      ['Assessment', 'Bills, load data and site survey.'],
      ['Design &amp; proposal', 'Layout, energy yield, finance options.'],
      ['Approvals', 'DISCOM application and metering arrangement.'],
      ['Procurement', 'ALMM-listed panels, quality inverters and structures.'],
      ['Installation &amp; testing', 'Safe installation, testing and DISCOM inspection.'],
      ['Monitoring &amp; O&amp;M', 'Remote monitoring, cleaning and preventive maintenance.'],
  ], 'sm:grid-cols-2 lg:grid-cols-3'); ?>
</section>

<?php ui_enquiry(['type' => 'quotation', 'category' => 'commercial', 'business' => true, 'message' => true, 'heading' => 'Get a free energy assessment', 'button' => 'Request Assessment'],
    'Find out what solar will do for your business',
    'Share your details and, if you can, your last 12 electricity bills. We will come back with a written proposal for both owning the plant and the zero-investment option.',
    ['Savings, payback and IRR in writing', 'CAPEX and RESCO compared side by side', 'Site survey by our engineer']); ?>

<?php ui_faqs([
    ['Do businesses get the PM Surya Ghar subsidy?', 'No. PM Surya Ghar is for residential consumers and housing societies. Commercial consumers benefit from energy savings and, if eligible, 40% accelerated depreciation.'],
    ['Is net metering available for commercial buildings in UP?', 'It depends on your consumer category under the UPERC rooftop solar regulations. Educational institutions and government buildings can use net metering; other commercial categories may be offered net billing or gross metering. We check the current rules for your connection and design to maximise on-site use.'],
    ['What is the payback period?', 'It depends on your tariff, daytime use and the price of the plant. With high daytime use and a commercial tariff, payback is often a few years. The calculator gives a first estimate and our proposal gives the exact figure.'],
    ['What maintenance is needed?', 'Regular cleaning, periodic inspection of connections and inverters, and monitoring of generation. See our <a href="/solar-maintenance">maintenance plans</a>.'],
]); ?>
<?php ui_related('/commercial-solar'); ?>
<?php include __DIR__ . '/inc/footer.php'; ?>
