<?php
require __DIR__ . '/inc/config.php';
require __DIR__ . '/inc/ui.php';
$page = [
    'title' => 'Home Rooftop Solar in Aligarh & UP: On-grid, Hybrid, Off-grid | Greenedge Infratech',
    'description' => 'Rooftop solar for houses and villas in Aligarh and Western UP. On-grid with net metering, hybrid with battery backup, or off-grid. PM Surya Ghar subsidy up to Rs 1,08,000 for eligible homes. Free site survey.',
    'path' => '/residential-solar', 'nav' => 'services',
    'crumbs' => [['Solutions', '/services'], ['Home rooftop solar', '/residential-solar']],
    'schema' => [['@context' => 'https://schema.org', '@type' => 'Service', 'name' => 'Residential rooftop solar installation', 'provider' => ['@id' => SITE_URL . '/#business'], 'areaServed' => 'Uttar Pradesh', 'url' => SITE_URL . '/residential-solar']],
];
include __DIR__ . '/inc/header.php';
ui_hero([
    'eyebrow' => 'Home rooftop solar',
    'title' => 'Cut your home electricity bill with rooftop solar',
    'sub' => 'A correctly sized rooftop system can bring a home&rsquo;s energy charges close to zero. Eligible homes in Uttar Pradesh get up to <strong class="text-white">&#8377;1,08,000</strong> subsidy under PM Surya Ghar, and Greenedge is a registered vendor.',
    'badges' => ['1&ndash;10 kW systems', 'Net metering handled', 'Battery backup options', 'Collateral-free loans for eligible homes'],
    'ctas' => [['/calculator?cat=residential', 'Calculate my savings', 'btn-accent', 'cta_calculator'], ['#enquire', 'Book a free site survey', 'btn-outline-light', 'cta_site_survey']],
    'image' => '/assets/solar-installation.jpg',
]);
?>
<section class="container mx-auto px-4 py-16">
  <?php ui_heading('Which home solar system is right for you?', 'Most homes in Western UP choose on-grid. Pick hybrid if power cuts are frequent, or off-grid if there is no reliable connection.'); ?>
  <div class="grid gap-6 mt-10 lg:grid-cols-3">
    <?php foreach ([
      ['On-grid (net metering)', 'Recommended for most homes', 'Panels feed your home first; extra units go to the grid and are adjusted in your bill through a net meter.', ['Lowest cost per kW', 'Eligible for PM Surya Ghar subsidy', 'No batteries to replace', 'Switches off during a power cut (safety rule)']],
      ['Hybrid (with battery)', 'For homes with frequent cuts', 'Works like on-grid, and also charges a battery that runs your chosen loads during outages.', ['Backup for lights, fans, fridge, Wi-Fi', 'Lithium (LFP) battery options', 'Higher cost than on-grid', 'Subsidy rules apply only to the eligible grid-connected part']],
      ['Off-grid', 'For farmhouses &amp; remote sites', 'Runs completely on solar and batteries, with no grid connection.', ['Independence from the grid', 'Battery sized to your night-time use', 'Highest cost per unit', 'Not eligible for PM Surya Ghar']],
    ] as $t): ?>
    <div class="card p-6">
      <p class="text-xs font-semibold uppercase tracking-wider text-green-700"><?= $t[1] ?></p>
      <h3 class="text-xl font-bold text-slate-900 mt-1"><?= $t[0] ?></h3>
      <p class="mt-2 text-sm text-slate-600"><?= $t[2] ?></p>
      <ul class="mt-4 space-y-2 text-sm text-slate-700 tick-list"><?php foreach ($t[3] as $li): ?><li><?= $li ?></li><?php endforeach; ?></ul>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="bg-slate-50">
  <div class="container mx-auto px-4 py-16 grid lg:grid-cols-2 gap-10 items-start">
    <div>
      <h2 class="section-title">What size does your home need?</h2>
      <p class="mt-3 text-slate-700">In Western UP each kW of rooftop solar produces about 120&ndash;135 units a month on average. Use this as a starting point; the <a class="text-green-700 underline" href="/calculator?cat=residential">calculator</a> and site survey give the exact size.</p>
      <div class="overflow-x-auto mt-6">
        <table class="w-full text-sm bg-white rounded-lg overflow-hidden border border-slate-200">
          <thead class="bg-green-700 text-white"><tr><th class="p-3 text-left">Monthly units used</th><th class="p-3 text-left">Typical system</th><th class="p-3 text-left">Roof area</th><th class="p-3 text-right">UP subsidy*</th></tr></thead>
          <tbody class="divide-y">
            <tr><td class="p-3">Up to 150</td><td class="p-3">1&ndash;2 kW</td><td class="p-3">100&ndash;200 sq ft</td><td class="p-3 text-right">&#8377;45,000&ndash;90,000</td></tr>
            <tr><td class="p-3">150&ndash;300</td><td class="p-3">2&ndash;3 kW</td><td class="p-3">200&ndash;300 sq ft</td><td class="p-3 text-right">&#8377;90,000&ndash;1,08,000</td></tr>
            <tr><td class="p-3">300&ndash;500</td><td class="p-3">3&ndash;4 kW</td><td class="p-3">300&ndash;400 sq ft</td><td class="p-3 text-right">&#8377;1,08,000</td></tr>
            <tr><td class="p-3">500+</td><td class="p-3">4&ndash;10 kW</td><td class="p-3">400&ndash;1,000 sq ft</td><td class="p-3 text-right">&#8377;1,08,000 (capped)</td></tr>
          </tbody>
        </table>
      </div>
      <p class="text-xs text-slate-500 mt-3">*Central PM Surya Ghar + UPNEDA state subsidy for eligible residential consumers. Approval and payment are by the government.</p>
    </div>
    <div>
      <h2 class="section-title">What&rsquo;s included in a Greenedge home system</h2>
      <ul class="mt-6 space-y-3 tick-list text-slate-700">
        <li>ALMM-listed solar panels (Mono PERC or TOPCon; domestic-content panels where PM Surya Ghar requires them)</li>
        <li>On-grid or hybrid inverter with app monitoring of daily generation</li>
        <li>Hot-dip galvanised mounting structure designed for wind load, at the height you choose</li>
        <li>DC and AC cabling, earthing, lightning arrester and protection devices (SPD, MCB, isolators)</li>
        <li>National Portal application, DISCOM feasibility, net meter and inspection coordination</li>
        <li>Subsidy document upload support until your subsidy is credited</li>
        <li>Handover training, cleaning guidance and after-sales service</li>
      </ul>
      <p class="mt-4 text-sm text-slate-600">Your quotation names every brand and model, and the warranty given by each manufacturer, so you can compare like for like.</p>
    </div>
  </div>
</section>

<section class="container mx-auto px-4 py-16">
  <?php ui_heading('From enquiry to free electricity', 'Most homes are installed within 1&ndash;3 days of material reaching site. DISCOM approvals and net metering usually take a few weeks.'); ?>
  <?php ui_steps([
      ['Free consultation &amp; survey', 'Share your last bills. Our engineer checks roof space, shadow, structure and your sanctioned load.'],
      ['Portal registration', 'We help you register on the PM Surya Ghar National Portal and apply, selecting Greenedge as vendor.'],
      ['DISCOM feasibility', 'Your DISCOM (DVVNL for Aligarh) checks technical feasibility for net metering.'],
      ['Installation', 'Our team installs panels, structure, inverter, earthing and protection, then tests the system.'],
      ['Net meter &amp; commissioning', 'The DISCOM inspects and installs the net meter; the commissioning certificate is generated on the portal.'],
      ['Subsidy credited', 'You submit bank details on the portal. The central subsidy is credited to your account, and the UP state subsidy follows through UPNEDA.'],
  ]); ?>
</section>

<?php ui_enquiry(['type' => 'site-survey', 'category' => 'pm-surya-ghar', 'heading' => 'Book your free home solar survey', 'button' => 'Book My Free Survey', 'message' => true],
    'Get a home solar plan in writing',
    'Tell us where you live. We will call you, check your bills and roof, and give you a written proposal with the subsidy you can apply for.',
    ['No obligation and no charge for the survey', 'Sizing from your actual consumption', 'Clear price with every component listed']); ?>

<?php ui_faqs([
    ['Will I really get 300 units free a month?', 'A 3 kW system in Western UP typically produces around 350&ndash;400 units a month on average, so a home using about 300 units can bring energy charges close to zero. Fixed charges remain, and output is lower in winter and foggy months.'],
    ['Is my roof strong enough?', 'Most RCC roofs carry a rooftop system easily: panels and structure add roughly 15&ndash;20 kg per square metre. Our engineer checks the roof during the survey and recommends the right structure.'],
    ['Can I install solar on a rented house?', 'The PM Surya Ghar application is made by the electricity consumer named on the bill, and the owner&rsquo;s consent for the roof may be needed. Talk to us and we will check your case.'],
    ['How do I clean the panels?', 'Rinse with clean water and a soft mop, early morning or evening, about twice a month in dusty seasons. Avoid detergent, hard brushes and walking on the panels. We also offer <a href="/solar-maintenance">cleaning and maintenance plans</a>.'],
    ['Can I get a loan?', 'Yes. Under PM Surya Ghar, public sector banks such as SBI offer collateral-free loans for homes: up to &#8377;2 lakh for systems up to 3 kW and up to &#8377;6 lakh for 3&ndash;10 kW, subject to bank rules. See <a href="/solar-schemes#loans">solar loans</a>.'],
]); ?>
<?php ui_related('/residential-solar'); ?>
<?php include __DIR__ . '/inc/footer.php'; ?>
