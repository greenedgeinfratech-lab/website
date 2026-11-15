<?php
require __DIR__ . '/inc/config.php';
$page = [
    'title' => 'Solar Calculator Aligarh & UP: Size, Subsidy, Savings & Payback | Greenedge',
    'description' => 'Free rooftop solar calculator for Uttar Pradesh. Find the right system size, PM Surya Ghar subsidy, cost range, monthly savings and payback from your electricity bill.',
    'path' => '/calculator',
    'nav' => 'calculator',
    'crumbs' => [['Solar Calculator', '/calculator']],
    'scripts' => ['/assets/js/solar-config.js', '/assets/js/calculator.js'],
    'schema' => [[
        '@context' => 'https://schema.org', '@type' => 'WebApplication',
        'name' => 'Greenedge Solar Savings Calculator', 'url' => SITE_URL . '/calculator',
        'applicationCategory' => 'UtilitiesApplication', 'operatingSystem' => 'Any',
        'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'INR'],
        'provider' => ['@id' => SITE_URL . '/#business'],
    ]],
];
include __DIR__ . '/inc/header.php';
?>
<section class="bg-green-900 text-white">
  <div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl sm:text-4xl font-extrabold">Solar savings calculator for Uttar Pradesh</h1>
    <p class="mt-3 text-green-100 max-w-2xl">Enter your electricity bill or units to see a recommended system size, PM Surya Ghar subsidy, cost range, savings and payback. Results appear instantly &ndash; no sign-up.</p>
  </div>
</section>

<section class="container mx-auto px-4 py-10 grid lg:grid-cols-[minmax(0,420px)_1fr] gap-8 items-start">
  <form id="calc-form" class="card p-6 space-y-5 lg:sticky lg:top-24" novalidate>
    <label class="block"><span class="label">Customer type</span>
      <select name="category" class="input">
        <option value="residential">Residential (home)</option>
        <option value="commercial">Commercial (shop, office, school, hospital)</option>
        <option value="industrial">Industrial (factory, cold store, mill)</option>
      </select></label>
    <fieldset>
      <legend class="label">I know my</legend>
      <div class="flex gap-2 mt-1">
        <label class="chip"><input type="radio" name="mode" value="bill" checked> Monthly bill</label>
        <label class="chip"><input type="radio" name="mode" value="units"> Monthly units</label>
      </div>
    </fieldset>
    <label class="block"><span class="label" id="value-label">Average monthly electricity bill (&#8377;)</span>
      <input name="value" type="number" min="1" step="any" inputmode="decimal" required class="input" placeholder="e.g. 3500"></label>
    <label class="block"><span class="label">Electricity rate per unit (&#8377;/kWh)</span>
      <input name="tariff" type="number" min="2" max="25" step="0.1" inputmode="decimal" class="input">
      <span class="hint">Check &ldquo;energy charge&rdquo; on your UPPCL / DVVNL / PVVNL bill. Default is a typical rate.</span></label>
    <label class="block"><span class="label">Shadow-free roof area (sq ft) &ndash; optional</span>
      <input name="roofArea" type="number" min="0" step="10" inputmode="numeric" class="input" placeholder="e.g. 400"></label>
    <input type="hidden" name="sizeOverride" value="">
    <button type="submit" class="btn-primary w-full text-base py-3" id="calc-btn">Calculate My Savings</button>
    <p id="calc-error" class="hidden text-sm rounded-md p-3 bg-red-50 text-red-800 border border-red-200" role="alert"></p>
  </form>

  <div>
    <div id="results" class="hidden scroll-mt-24 space-y-6" aria-live="polite">
      <div class="card p-6">
        <div class="flex flex-wrap items-end justify-between gap-4">
          <div>
            <p class="text-sm text-slate-500">Recommended system</p>
            <p id="r-kw" class="text-4xl font-extrabold text-green-700">&ndash;</p>
            <p id="r-roof" class="text-sm text-slate-600"></p>
          </div>
          <div class="flex items-end gap-2">
            <label class="block"><span class="label">Try another size (kW)</span>
              <input form="calc-form" id="size-input" type="number" min="1" step="0.5" class="input w-28"></label>
            <button form="calc-form" type="submit" id="resize-btn" class="btn-secondary">Update</button>
          </div>
        </div>
        <p id="r-notes" class="hidden mt-4 text-sm rounded-md p-3 bg-amber-50 text-amber-900 border border-amber-200"></p>
      </div>

      <div class="grid sm:grid-cols-2 gap-4">
        <div class="card p-5"><p class="text-sm text-slate-500">Expected generation</p><p id="r-gen" class="text-2xl font-bold">&ndash;</p><p id="r-gen-sub" class="text-sm text-slate-600"></p></div>
        <div class="card p-5"><p class="text-sm text-slate-500">Estimated bill savings</p><p id="r-save" class="text-2xl font-bold text-green-700">&ndash;</p><p id="r-save-sub" class="text-sm text-slate-600"></p></div>
        <div class="card p-5"><p class="text-sm text-slate-500">Estimated system cost</p><p id="r-cost" class="text-2xl font-bold">&ndash;</p><p class="text-sm text-slate-600">before subsidy, on-grid, incl. GST (indicative)</p></div>
        <div class="card p-5"><p class="text-sm text-slate-500">Government subsidy</p><p id="r-sub" class="text-2xl font-bold text-green-700">&ndash;</p><p id="r-sub-sub" class="text-sm text-slate-600"></p></div>
        <div class="card p-5"><p class="text-sm text-slate-500">Your net investment (mid estimate)</p><p id="r-net" class="text-2xl font-bold">&ndash;</p><p class="text-sm text-slate-600">cost minus subsidy, if eligible</p></div>
        <div class="card p-5"><p class="text-sm text-slate-500">Simple payback</p><p id="r-payback" class="text-2xl font-bold">&ndash;</p><p class="text-sm text-slate-600">net investment &divide; year-1 savings</p></div>
        <div class="card p-5"><p class="text-sm text-slate-500">25-year savings (estimate)</p><p id="r-life" class="text-2xl font-bold">&ndash;</p><p class="text-sm text-slate-600">with 0.5%/yr panel ageing and 3%/yr tariff rise</p></div>
        <div class="card p-5"><p class="text-sm text-slate-500">Environmental benefit</p><p id="r-co2" class="text-2xl font-bold">&ndash;</p><p class="text-sm text-slate-600">CO&#8322; avoided (CEA grid factor)</p></div>
      </div>
      <p id="r-selfuse" class="text-sm text-slate-600"></p>

      <div class="rounded-lg bg-slate-50 border border-slate-200 p-4 text-sm text-slate-600">
        <strong class="text-slate-800">These are estimates, not guarantees.</strong> Actual generation depends on orientation, shading, dust and weather. Savings depend on your tariff, usage pattern and DISCOM net-metering rules. Subsidy eligibility is decided by the PM Surya Ghar National Portal, your DISCOM and UPNEDA; approval and payment are made by the government. Prices are indicative until a site survey.
        <a href="#assumptions" class="underline">See all assumptions</a>.
      </div>

      <div class="card p-5 flex flex-wrap items-center justify-between gap-3 bg-green-50">
        <p class="font-semibold text-slate-800">Next step: a free site survey confirms the exact size and price.</p>
        <div class="flex flex-wrap gap-2">
          <a href="/contact?type=site-survey" class="btn-primary" data-track="cta_site_survey">Book a Free Site Survey</a>
          <a href="tel:<?= BIZ_PHONE ?>" class="btn-secondary" data-track="phone_click">Speak to a Solar Expert</a>
          <a href="<?= e(wa_link('Hello Greenedge, I used your solar calculator and would like a quotation.')) ?>" target="_blank" rel="noopener" class="btn-whatsapp" data-track="whatsapp_click">WhatsApp Us</a>
        </div>
      </div>
    </div>

    <div id="calc-gate" class="hidden scroll-mt-24">
      <p class="rounded-lg bg-green-50 border border-green-200 p-4 text-green-900 mb-4"><strong>Your solar estimate is ready.</strong> Enter your details to see it. We will also send a copy to your email, and our solar expert will call you to answer questions.</p>
      <?php $lf = ['type' => 'calculator', 'heading' => 'See your solar savings', 'sub' => 'Your recommended system size, savings, subsidy and payback will appear as soon as you submit.', 'button' => 'Show My Solar Savings', 'email_label' => 'Email (to receive your report)', 'hide_type' => true]; include __DIR__ . '/inc/lead-form.php'; ?>
    </div>

    <div id="results-empty" class="card p-8 text-slate-600">
      <h2 class="text-xl font-bold text-slate-900">What you will see</h2>
      <ul class="mt-3 space-y-2 list-disc pl-5">
        <li>Recommended system size and roof area needed</li>
        <li>Monthly and yearly generation, and your new estimated bill</li>
        <li>PM Surya Ghar central + UP state subsidy for eligible homes</li>
        <li>Cost range, net investment, payback and 25-year savings</li>
      </ul>
    </div>
  </div>
</section>

<section id="assumptions" class="container mx-auto px-4 pb-16 max-w-4xl scroll-mt-24">
  <h2 class="section-title">How this calculator works</h2>
  <div class="prose-lite mt-4">
    <p><strong>System size.</strong> From your bill we first remove typical fixed charges, then divide by your rate per unit to get monthly units. The size is your monthly units divided by expected generation per kW (about 4.2 units per kW per day, roughly 128 a month in Western UP), rounded to 0.5 kW for homes. If you give your roof area, the size is limited to about 100 sq ft per kW.</p>
    <p><strong>Savings.</strong> Units that replace what you would buy from the grid are valued at your tariff. Under net metering, any annual surplus beyond your own use is valued at a lower export rate (assumed &#8377;2.5/unit). Solar generation is therefore <em>not</em> assumed to equal bill savings one-for-one. Fixed charges stay on your bill.</p>
    <p><strong>Subsidy (residential only).</strong> Central PM Surya Ghar: &#8377;30,000 per kW for the first 2 kW and &#8377;18,000 for the third kW, capped at &#8377;78,000. UP state (UPNEDA): &#8377;15,000 per kW up to &#8377;30,000. Fractional sizes are calculated proportionally (e.g. 2.5 kW = &#8377;69,000 + &#8377;30,000). Commercial and industrial customers are not eligible for PM Surya Ghar.</p>
    <p><strong>Cost.</strong> Indicative on-grid prices per kW that fall as systems get larger, shown as a &plusmn;8% range. Battery (hybrid/off-grid) systems cost more.</p>
    <p><strong>Payback and 25-year savings.</strong> Payback = net investment &divide; year-1 savings. Lifetime savings assume panel output falls 0.5% a year and electricity prices rise 3% a year.</p>
    <p><strong>CO&#8322;.</strong> 0.727 kg CO&#8322; per unit, the weighted-average grid emission factor in the Central Electricity Authority CO&#8322; Baseline Database (v20, 2023-24).</p>
  </div>
</section>
<?php include __DIR__ . '/inc/footer.php'; ?>
