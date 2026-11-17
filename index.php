<?php
require __DIR__ . '/inc/config.php';
require __DIR__ . '/inc/ui.php';
$page = [
    'title' => 'Greenedge Infratech | Solar EPC Company in India: Homes, Societies, Business, Industry, Government',
    'description' => 'Rooftop and ground-mounted solar for homes, housing societies, commercial, industrial and government buildings across India and abroad. Zero-investment RESCO solar, open access, solar pumps. Free site survey.',
    'path' => '/',
    'preload' => '/assets/hero-solar.jpg',
];
include __DIR__ . '/inc/header.php';
?>
<section class="relative bg-slate-900 text-white overflow-hidden">
  <img src="/assets/hero-solar.jpg" alt="" class="absolute inset-0 w-full h-full object-cover opacity-30" fetchpriority="high" width="1600" height="900">
  <div class="absolute inset-0 bg-gradient-to-r from-green-950/95 via-green-900/85 to-slate-900/60"></div>
  <div class="relative container mx-auto px-4 py-14 lg:py-20 grid lg:grid-cols-[1.25fr_1fr] gap-10 items-center">
    <div>
      <p class="inline-flex flex-wrap gap-2 mb-5"><span class="rounded-full bg-white/15 px-4 py-1 text-sm font-medium">Solar EPC company since <?= BIZ_SINCE ?></span><span class="rounded-full bg-yellow-400 text-green-950 px-4 py-1 text-sm font-semibold">Projects across India &amp; abroad</span></p>
      <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight">Solar power for every roof, factory and field</h1>
      <p class="mt-5 text-lg text-green-50 max-w-xl">Greenedge designs, builds and maintains solar plants for homes, housing societies, shops, factories, government buildings and farms. Buy it outright with subsidy, or go solar with <strong class="text-white">zero investment</strong> and pay only for the power.</p>
      <div class="mt-8 flex flex-wrap gap-3">
        <a href="/calculator" class="btn-accent text-base" data-track="cta_calculator">Calculate My Solar Savings</a>
        <a href="/contact?type=site-survey" class="btn-outline-light text-base" data-track="cta_site_survey">Book a Free Site Survey</a>
      </div>
      <ul class="mt-8 grid grid-cols-3 gap-3 max-w-lg text-center">
        <li class="rounded-lg bg-white/10 p-3"><span class="block text-2xl font-bold"><?= BIZ_INSTALLS ?></span><span class="text-xs text-green-100">solar installations</span></li>
        <li class="rounded-lg bg-white/10 p-3"><span class="block text-2xl font-bold"><?= e(site('home_savings_stat')) ?></span><span class="text-xs text-green-100">typical bill saving*</span></li>
        <li class="rounded-lg bg-white/10 p-3"><span class="block text-2xl font-bold">India+</span><span class="text-xs text-green-100">and international projects</span></li>
      </ul>
      <p class="mt-3 text-xs text-green-100/80">*Depends on usage, roof, system size and tariff. Use the calculator for your own estimate.</p>
    </div>
    <form action="/calculator" method="get" class="card p-6 text-slate-800">
      <h2 class="text-xl font-bold">Quick solar savings estimate</h2>
      <p class="text-sm text-slate-600 mt-1">Enter your monthly bill to see system size, subsidy, cost and payback.</p>
      <label class="block mt-4"><span class="label">I am a</span>
        <select name="cat" class="input">
          <option value="residential">Home owner</option>
          <option value="society">Housing society / RWA</option>
          <option value="commercial">Shop / office / school / hospital</option>
          <option value="industrial">Factory / industry</option>
        </select></label>
      <label class="block mt-3"><span class="label">Monthly electricity bill (&#8377;)</span>
        <input name="bill" type="number" min="300" step="100" inputmode="numeric" required class="input" placeholder="e.g. 3500"></label>
      <button class="btn-primary w-full mt-4" data-track="calculator_start_home">Calculate My Savings</button>
      <p class="text-xs text-slate-500 mt-3">Free. Takes under a minute.</p>
    </form>
  </div>
</section>

<section class="container mx-auto px-4 py-16">
  <?php ui_heading('One solar partner for every kind of customer', 'Every plant is designed from your electricity bills, roof or land, and load &ndash; not from a fixed package.', 'Who we work with'); ?>
  <?php ui_cards([
      ['Homes &amp; PM Surya Ghar', 'On-grid, hybrid and off-grid systems for houses. Eligible homes get up to &#8377;78,000 central subsidy. In Uttar Pradesh we are a registered PM Surya Ghar vendor and handle the portal, DISCOM and paperwork.', '/residential-solar', 'Home solar'],
      ['Housing societies &amp; RWAs', 'Solar for lifts, pumps, common lighting and EV charging, with &#8377;18,000 per kW central subsidy for common facilities.', '/housing-society-solar', 'Society solar'],
      ['Commercial buildings', 'Shops, showrooms, offices, schools, hospitals and hotels: daytime use means fast payback and tax benefits.', '/commercial-solar', 'Commercial solar'],
      ['Industries &amp; MSMEs', 'Rooftop, carport and ground-mounted plants for factories, cold stores, mills and warehouses, sized to your load profile.', '/industrial-solar', 'Industrial solar'],
      ['Government &amp; institutions', 'Government offices, PSUs, schools, universities and hospitals, under CAPEX or RESCO models, including tender-based projects.', '/government-solar', 'Government solar'],
      ['Farms &amp; agriculture', 'Solar irrigation pumps and farm solar plants, including guidance on the PM-KUSUM scheme.', '/solar-pumps-kusum', 'Solar for farms'],
  ]); ?>
</section>

<section class="bg-slate-50">
  <div class="container mx-auto px-4 py-16">
    <?php ui_heading('Four ways to go solar', 'Choose the model that suits your money and your site. We explain the numbers for each before you decide.', 'Business models'); ?>
    <div class="grid gap-6 mt-10 sm:grid-cols-2 lg:grid-cols-4">
      <?php foreach ([
        ['Own it (CAPEX)', 'You invest once and own the plant. Highest lifetime savings, plus subsidy for homes or tax depreciation for businesses.', '/solar-guide#models', 'Best for: homes, businesses with funds'],
        ['Own it with a loan', 'Bank finance or EMI. For eligible homes, public sector banks offer collateral-free solar loans under PM Surya Ghar.', '/solar-schemes#loans', 'Best for: homes, MSMEs'],
        ['Zero investment (RESCO)', 'An investor builds and runs the plant on your roof. You pay a fixed tariff per unit, below your grid rate, for an agreed period.', '/resco-solar', 'Best for: factories, institutions, government'],
        ['Open access', 'Buy solar power from a plant elsewhere through the grid, for consumers with 100 kW or more contracted demand.', '/open-access-solar', 'Best for: large industries'],
      ] as $m): ?>
      <a href="<?= $m[2] ?>" class="card p-6 flex flex-col hover:shadow-lg hover:border-green-300 transition">
        <h3 class="text-lg font-bold text-slate-900"><?= $m[0] ?></h3>
        <p class="mt-2 text-sm text-slate-600 flex-1"><?= $m[1] ?></p>
        <p class="mt-4 text-xs font-semibold text-green-800 bg-green-50 rounded-md px-2 py-1"><?= $m[3] ?></p>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="container mx-auto px-4 py-16 grid lg:grid-cols-2 gap-10 items-center">
  <div>
    <p class="eyebrow">Government subsidy</p>
    <h2 class="section-title mt-1">PM Surya Ghar: up to &#8377;78,000 for homes</h2>
    <p class="mt-3 text-slate-700">Eligible residential consumers in India get central subsidy under PM Surya Ghar: Muft Bijli Yojana, and some states add their own. Greenedge is a registered PM Surya Ghar vendor in Uttar Pradesh, where homes get an extra state subsidy of up to &#8377;30,000 (up to &#8377;1,08,000 in total). Housing societies get &#8377;18,000 per kW for common facilities.</p>
    <div class="overflow-x-auto mt-6">
      <table class="w-full text-sm bg-white rounded-lg overflow-hidden border border-slate-200">
        <thead class="bg-green-700 text-white"><tr><th class="p-3 text-left">System size</th><th class="p-3 text-right">Central subsidy</th></tr></thead>
        <tbody class="divide-y">
          <tr><td class="p-3">1 kW</td><td class="p-3 text-right font-semibold">&#8377;30,000</td></tr>
          <tr><td class="p-3">2 kW</td><td class="p-3 text-right font-semibold">&#8377;60,000</td></tr>
          <tr><td class="p-3">3 kW and above</td><td class="p-3 text-right font-semibold">&#8377;78,000</td></tr>
          <tr><td class="p-3">Housing society / RWA (common areas)</td><td class="p-3 text-right font-semibold">&#8377;18,000 per kW, up to &#8377;90 lakh</td></tr>
        </tbody>
      </table>
    </div>
    <p class="text-xs text-slate-500 mt-3">Subsidy is approved and paid by the government, not by Greenedge, and depends on eligibility and scheme rules at the time. State subsidies vary; we tell you what applies in your state. Checked against MNRE information in November 2026.</p>
    <div class="mt-6 flex flex-wrap gap-3"><a href="/pmsuryaghar/" class="btn-primary">How to apply</a><a href="/solar-schemes" class="btn-secondary">All schemes &amp; policies</a></div>
  </div>
  <img src="/assets/installation-team.jpg" alt="Greenedge installation team fixing solar panels on a rooftop" loading="lazy" width="800" height="600" class="rounded-xl shadow-lg w-full object-cover">
</section>

<section class="bg-green-900 text-white">
  <div class="container mx-auto px-4 py-14 grid lg:grid-cols-[1.4fr_1fr] gap-8 items-center">
    <div>
      <h2 class="text-3xl font-extrabold">What will solar save you?</h2>
      <p class="mt-3 text-green-100 max-w-2xl">Our calculator uses typical Indian sunshine data, your state, your tariff and the current subsidy rules to estimate system size, cost, subsidy, monthly savings, EMI and payback &ndash; for homes, housing societies, shops and factories. It shows every assumption.</p>
    </div>
    <div class="flex flex-wrap gap-3 lg:justify-end">
      <a href="/calculator?cat=residential" class="btn-light" data-track="cta_calculator">For my home</a>
      <a href="/calculator?cat=society" class="btn-outline-light" data-track="cta_calculator">For my society</a>
      <a href="/calculator?cat=commercial" class="btn-outline-light" data-track="cta_calculator">For my business</a>
    </div>
  </div>
</section>

<section class="container mx-auto px-4 py-16">
  <?php ui_heading('How a Greenedge project works', 'The same disciplined process for a 3 kW home and a 1 MW factory plant.', 'Our process'); ?>
  <?php ui_steps([
      ['Free consultation', 'Share your bills on call or WhatsApp. We estimate size, budget and the right business model.'],
      ['Site survey &amp; design', 'Our engineer checks roof or land, shadow, structure, wiring and sanctioned load, then designs the layout.'],
      ['Clear proposal', 'Itemised quotation or PPA offer: panels, inverter, structure, cabling, protection, net metering, warranties and service.'],
      ['Approvals', 'PM Surya Ghar portal, DISCOM feasibility and net metering, state nodal agency and other approvals your project needs.'],
      ['Installation &amp; commissioning', 'Installation by our trained team with safety checks, DISCOM inspection and commissioning.'],
      ['Subsidy, monitoring &amp; service', 'Subsidy document support, generation monitoring, cleaning guidance and maintenance for the life of the plant.'],
  ]); ?>
</section>

<section class="bg-slate-50">
  <div class="container mx-auto px-4 py-16 grid lg:grid-cols-2 gap-10">
    <div>
      <h2 class="section-title">Why customers choose Greenedge</h2>
      <ul class="mt-6 space-y-4 text-slate-700 tick-list">
        <li><strong>Registered PM Surya Ghar vendor in Uttar Pradesh.</strong> Eligible UP homes and societies can select us on the National Portal.</li>
        <li><strong>Every segment, one team.</strong> Homes, RWAs, commercial, industrial, government and agriculture &ndash; CAPEX, RESCO and open access.</li>
        <li><strong>Reach across India and abroad.</strong> Our own engineering team plus a growing network of trained installation and service partners.</li>
        <li><strong>Engineering first.</strong> Sizing from 12 months of bills and load data, shadow analysis, and structures designed for wind load.</li>
        <li><strong>Paperwork handled.</strong> National Portal, DISCOM net metering, state agency and subsidy documentation.</li>
        <li><strong>Honest numbers.</strong> Our calculator and proposals show assumptions and ranges, never guarantees we cannot keep.</li>
        <li><strong>Long-term care.</strong> Monitoring, cleaning and preventive maintenance plans for the life of the plant.</li>
      </ul>
    </div>
    <?php $lf = ['type' => 'site-survey', 'heading' => 'Book a free site survey', 'button' => 'Book My Free Site Survey']; include __DIR__ . '/inc/lead-form.php'; ?>
  </div>
</section>

<section class="container mx-auto px-4 py-16">
  <div class="card p-8 lg:p-10 grid lg:grid-cols-[1.4fr_1fr] gap-8 items-center bg-gradient-to-br from-yellow-50 to-white">
    <div>
      <p class="eyebrow">Grow with us</p>
      <h2 class="section-title mt-1">Partner with Greenedge</h2>
      <p class="mt-3 text-slate-700">Dealers, installers, electricians, architects, consultants and investors: earn from the fast-growing solar market with our engineering, approvals and after-sales support behind you.</p>
    </div>
    <div class="flex flex-wrap gap-3 lg:justify-end"><a href="/partner" class="btn-primary">See partner benefits</a><a href="/partner#apply" class="btn-secondary">Apply now</a></div>
  </div>
</section>

<?php ui_faqs([
    ['How much does a rooftop solar system cost?', 'For a typical home on-grid system, budget roughly &#8377;55,000&ndash;65,000 per kW before subsidy, depending on panel and inverter brand, structure height and wiring. Larger commercial and industrial plants cost less per kW. Our <a href="/calculator">calculator</a> shows a range for your size, and the site survey gives an exact quotation.'],
    ['Can I go solar without investing money?', 'Businesses, institutions and government bodies with suitable roofs can use the <a href="/resco-solar">RESCO (zero-investment) model</a>: the plant is financed and maintained by an investor, and you pay only for the units at a fixed tariff. Homes can use collateral-free bank loans under PM Surya Ghar.'],
    ['Do commercial and industrial consumers get a subsidy?', 'PM Surya Ghar subsidy is for residential consumers and housing societies only. Businesses usually benefit from 40% accelerated depreciation under the Income Tax rules and from lower energy costs &ndash; confirm the tax treatment with your CA.'],
    ['What size system do I need?', 'Each kW of rooftop solar in most of India produces about 4&ndash;5 units a day on average across the year, roughly 120&ndash;150 units a month. A home using 400 units a month usually needs about 3&ndash;3.5 kW. About 100 sq ft of shadow-free roof is needed per kW.'],
    ['Will solar work during a power cut?', 'A standard on-grid system shuts down during a grid outage for safety. If you need backup, choose a hybrid system with batteries.'],
]); ?>
<?php include __DIR__ . '/inc/footer.php'; ?>
