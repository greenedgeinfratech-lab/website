<?php
require __DIR__ . '/inc/config.php';
$page = [
    'title' => 'Rooftop Solar Installation in Aligarh | PM Surya Ghar Subsidy | Greenedge Infratech',
    'description' => 'Rooftop solar for homes, shops and factories in Aligarh and Western UP. PM Surya Ghar subsidy up to Rs 1,08,000 for eligible homes in UP. Free site survey. Call +91 98370 67681.',
    'path' => '/',
    'preload' => '/assets/hero-solar.jpg',
];
include __DIR__ . '/inc/header.php';
?>
<section class="relative bg-slate-900 text-white overflow-hidden">
  <img src="/assets/hero-solar.jpg" alt="" class="absolute inset-0 w-full h-full object-cover opacity-30" fetchpriority="high" width="1600" height="900">
  <div class="absolute inset-0 bg-gradient-to-r from-green-950/95 via-green-900/80 to-slate-900/60"></div>
  <div class="relative container mx-auto px-4 py-16 lg:py-24 grid lg:grid-cols-[1.2fr_1fr] gap-10 items-center">
    <div>
      <p class="inline-flex flex-wrap gap-2 mb-5"><span class="rounded-full bg-white/15 px-4 py-1 text-sm font-medium">Solar EPC company in Aligarh since <?= BIZ_SINCE ?></span><span class="rounded-full bg-yellow-400 text-green-950 px-4 py-1 text-sm font-semibold">Registered PM Surya Ghar vendor (UP)</span></p>
      <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight">Rooftop Solar Installation in Aligarh &amp; Western UP</h1>
      <p class="mt-5 text-lg text-green-50 max-w-xl">Cut your electricity bill by up to 70&ndash;80% with a rooftop solar system designed for your home, shop or factory. Eligible homes in Uttar Pradesh can get up to <strong>&#8377;1,08,000</strong> in PM Surya Ghar central and state subsidy.</p>
      <div class="mt-8 flex flex-wrap gap-3">
        <a href="/calculator" class="btn-primary text-base" data-track="cta_calculator">Calculate Your Solar Savings</a>
        <a href="/contact?type=site-survey" class="btn-outline-light text-base" data-track="cta_site_survey">Book a Free Site Survey</a>
      </div>
      <ul class="mt-8 grid grid-cols-3 gap-3 max-w-lg text-center">
        <li class="rounded-lg bg-white/10 p-3"><span class="block text-2xl font-bold"><?= BIZ_INSTALLS ?></span><span class="text-xs text-green-100">solar installations</span></li>
        <li class="rounded-lg bg-white/10 p-3"><span class="block text-2xl font-bold">70&ndash;80%</span><span class="text-xs text-green-100">typical bill saving*</span></li>
        <li class="rounded-lg bg-white/10 p-3"><span class="block text-2xl font-bold"><?= BIZ_SINCE ?></span><span class="text-xs text-green-100">working since</span></li>
      </ul>
      <p class="mt-3 text-xs text-green-100/80">*Depends on your usage, roof, system size and tariff. Use the calculator for your own estimate.</p>
    </div>
    <form action="/calculator" method="get" class="card p-6 text-slate-800">
      <h2 class="text-xl font-bold">Quick savings estimate</h2>
      <p class="text-sm text-slate-600 mt-1">Enter your average monthly bill. No contact details needed.</p>
      <label class="block mt-4"><span class="label">I am a</span>
        <select name="cat" class="input"><option value="residential">Home owner</option><option value="commercial">Shop / office / institution</option><option value="industrial">Factory / industry</option></select></label>
      <label class="block mt-3"><span class="label">Monthly electricity bill (&#8377;)</span>
        <input name="bill" type="number" min="300" step="100" inputmode="numeric" required class="input" placeholder="e.g. 3500"></label>
      <button class="btn-primary w-full mt-4" data-track="calculator_start_home">Show My Savings</button>
    </form>
  </div>
</section>

<section class="container mx-auto px-4 py-16">
  <h2 class="section-title text-center">Choose your solar journey</h2>
  <p class="text-center text-slate-600 max-w-2xl mx-auto mt-2">Every system is designed from your electricity bills, roof and load &ndash; not from a fixed package.</p>
  <div class="grid gap-6 mt-10 sm:grid-cols-2 lg:grid-cols-4">
    <?php
    $journeys = [
        ['PM Surya Ghar (homes)', 'Subsidy-backed 1&ndash;10 kW on-grid systems for houses. We guide you through the National Portal, DISCOM net metering and subsidy documents.', '/pmsuryaghar/', 'Check subsidy'],
        ['Residential solar', 'On-grid, hybrid or off-grid systems for homes, villas and farmhouses, with battery backup where power cuts are frequent.', '/services#residential', 'Explore home solar'],
        ['Commercial solar', 'Shops, showrooms, schools, colleges, hospitals and hotels: lower daytime bills and a fast payback on your own roof.', '/services#commercial', 'Explore commercial'],
        ['Industrial solar', 'Factories, cold stores and mills in and around Aligarh: rooftop and ground-mounted plants sized to your load profile.', '/services#industrial', 'Explore industrial'],
    ];
    foreach ($journeys as $j): ?>
    <a href="<?= $j[2] ?>" class="card p-6 hover:shadow-lg transition flex flex-col">
      <h3 class="text-lg font-bold text-green-800"><?= $j[0] ?></h3>
      <p class="text-sm text-slate-600 mt-2 flex-1"><?= $j[1] ?></p>
      <span class="mt-4 font-semibold text-green-700"><?= $j[3] ?> &rarr;</span>
    </a>
    <?php endforeach; ?>
  </div>
</section>

<section class="bg-green-50">
  <div class="container mx-auto px-4 py-16 grid lg:grid-cols-2 gap-10 items-center">
    <div>
      <h2 class="section-title">PM Surya Ghar subsidy in Uttar Pradesh</h2>
      <p class="mt-3 text-slate-700">Eligible residential consumers in UP can combine the central PM Surya Ghar: Muft Bijli Yojana subsidy with the UP state subsidy from UPNEDA.</p>
      <div class="overflow-x-auto mt-6">
        <table class="w-full text-sm bg-white rounded-lg overflow-hidden">
          <thead class="bg-green-700 text-white"><tr><th class="p-3 text-left">System size</th><th class="p-3 text-right">Central</th><th class="p-3 text-right">UP state</th><th class="p-3 text-right">Total</th></tr></thead>
          <tbody class="divide-y">
            <tr><td class="p-3">1 kW</td><td class="p-3 text-right">&#8377;30,000</td><td class="p-3 text-right">&#8377;15,000</td><td class="p-3 text-right font-semibold">&#8377;45,000</td></tr>
            <tr><td class="p-3">2 kW</td><td class="p-3 text-right">&#8377;60,000</td><td class="p-3 text-right">&#8377;30,000</td><td class="p-3 text-right font-semibold">&#8377;90,000</td></tr>
            <tr><td class="p-3">3 kW and above</td><td class="p-3 text-right">&#8377;78,000</td><td class="p-3 text-right">&#8377;30,000</td><td class="p-3 text-right font-semibold">&#8377;1,08,000</td></tr>
          </tbody>
        </table>
      </div>
      <p class="text-xs text-slate-500 mt-3">Subsidy is approved and paid by the government, not by Greenedge. It depends on eligibility, scheme rules and funds available at the time. Figures checked against MNRE and UPNEDA information in November 2026.</p>
      <a href="/pmsuryaghar/" class="btn-primary mt-6 inline-flex">How to apply under PM Surya Ghar</a>
    </div>
    <img src="/assets/installation-team.jpg" alt="Greenedge installation team fixing solar panels on a rooftop" loading="lazy" width="800" height="600" class="rounded-xl shadow-lg w-full object-cover">
  </div>
</section>

<section class="container mx-auto px-4 py-16">
  <h2 class="section-title text-center">How your solar installation works</h2>
  <ol class="grid gap-6 mt-10 sm:grid-cols-2 lg:grid-cols-3 counter-list">
    <?php
    $steps = [
        ['Free consultation', 'Share your bill on call or WhatsApp. We estimate the right size and budget.'],
        ['Site survey', 'Our engineer checks roof space, shadow, structure, wiring and sanctioned load.'],
        ['Written quotation', 'Clear pricing for panels, inverter, structure, cabling, net meter work and warranties.'],
        ['Approvals', 'For PM Surya Ghar homes we help with the National Portal application and DISCOM feasibility.'],
        ['Installation & net metering', 'Installation by our team, then DISCOM inspection and net meter commissioning.'],
        ['Subsidy & after-sales', 'We help you upload documents for subsidy and provide maintenance and service support.'],
    ];
    foreach ($steps as $i => $s): ?>
    <li class="card p-6"><span class="w-9 h-9 rounded-full bg-green-700 text-white font-bold flex items-center justify-center"><?= $i + 1 ?></span>
      <h3 class="font-bold mt-3"><?= e($s[0]) ?></h3><p class="text-sm text-slate-600 mt-1"><?= e($s[1]) ?></p></li>
    <?php endforeach; ?>
  </ol>
</section>

<section class="bg-slate-50">
  <div class="container mx-auto px-4 py-16 grid lg:grid-cols-2 gap-10">
    <div>
      <h2 class="section-title">Why homes and businesses choose Greenedge</h2>
      <ul class="mt-6 space-y-4 text-slate-700">
        <li><strong>Registered PM Surya Ghar vendor.</strong> We are registered under PM Surya Ghar: Muft Bijli Yojana in Uttar Pradesh, so eligible homes can apply for subsidy through us.</li>
        <li><strong>Local team in Aligarh.</strong> Survey, installation and service are handled by our own people, close to you.</li>
        <li><strong>Designed from your bills.</strong> We size the system from 12 months of usage, so you don&rsquo;t over- or under-invest.</li>
        <li><strong>Paperwork handled.</strong> DISCOM net metering, PM Surya Ghar portal steps and subsidy documents for eligible homes.</li>
        <li><strong>Honest estimates.</strong> Our calculator shows its assumptions and gives ranges, not guarantees.</li>
        <li><strong>After-sales support.</strong> Cleaning guidance, maintenance visits and fault diagnosis after commissioning.</li>
      </ul>
      <p class="mt-6 text-slate-600">We serve <?= e(implode(', ', BIZ_SERVICE_AREA)) ?> and nearby areas of Western Uttar Pradesh.</p>
    </div>
    <?php $lf = ['type' => 'site-survey', 'heading' => 'Book a free site survey', 'button' => 'Book My Free Site Survey']; include __DIR__ . '/inc/lead-form.php'; ?>
  </div>
</section>

<section class="container mx-auto px-4 py-16 max-w-3xl">
  <h2 class="section-title text-center">Common questions</h2>
  <div class="mt-8 space-y-3">
    <?php
    $faqs = [
        ['How much does a rooftop solar system cost in Aligarh?', 'For a typical home on-grid system, budget roughly &#8377;55,000&ndash;65,000 per kW before subsidy, depending on panel and inverter brand, structure height and wiring. Eligible homes can then claim PM Surya Ghar subsidy. Our <a class="underline" href="/calculator">calculator</a> shows a range for your size, and the site survey gives an exact quotation.'],
        ['What size system do I need?', 'Each kW of rooftop solar in Western UP produces about 4&ndash;4.5 units a day on average across the year, roughly 120&ndash;135 units a month. A home using 400 units a month usually needs about 3&ndash;3.5 kW.'],
        ['How much roof space is needed?', 'About 100 sq ft of shadow-free roof for every 1 kW.'],
        ['Will solar work during a power cut?', 'A standard on-grid system shuts down during a grid outage for safety. If you need backup, ask about a hybrid system with batteries.'],
        ['How long does installation take?', 'Installation itself takes 1&ndash;3 days for most homes. Net metering and approvals by the DISCOM usually take a few weeks.'],
    ];
    foreach ($faqs as $f): ?>
    <details class="card p-5 group"><summary class="font-semibold cursor-pointer"><?= $f[0] ?></summary><p class="mt-3 text-slate-600"><?= $f[1] ?></p></details>
    <?php endforeach; ?>
  </div>
  <p class="text-center mt-6"><a href="/faq" class="font-semibold text-green-700">More solar FAQs &rarr;</a></p>
</section>
<?php include __DIR__ . '/inc/footer.php'; ?>
