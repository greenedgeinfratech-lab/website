<?php
require __DIR__ . '/../inc/config.php';
$page = [
    'title' => 'PM Surya Ghar Yojana in Aligarh & UP: Subsidy up to Rs 1,08,000 | Greenedge',
    'description' => 'PM Surya Ghar Muft Bijli Yojana in Uttar Pradesh: Rs 78,000 central + Rs 30,000 UP state subsidy for eligible homes, eligibility, documents and step-by-step process. Free help in Aligarh.',
    'path' => '/pmsuryaghar/',
    'nav' => 'pmsg',
    'crumbs' => [['PM Surya Ghar Yojana', '/pmsuryaghar/']],
    'schema' => [[
        '@context' => 'https://schema.org', '@type' => 'Service',
        'name' => 'PM Surya Ghar rooftop solar installation',
        'serviceType' => 'Residential rooftop solar installation under PM Surya Ghar: Muft Bijli Yojana',
        'provider' => ['@id' => SITE_URL . '/#business'],
        'areaServed' => array_map(fn($c) => ['@type' => 'City', 'name' => $c], BIZ_SERVICE_AREA),
        'url' => SITE_URL . '/pmsuryaghar/',
    ]],
];
include __DIR__ . '/../inc/header.php';
?>
<section class="bg-green-900 text-white">
  <div class="container mx-auto px-4 py-12 grid lg:grid-cols-[1.3fr_1fr] gap-8 items-center">
    <div>
      <h1 class="text-3xl sm:text-4xl font-extrabold">PM Surya Ghar Muft Bijli Yojana in Aligarh &amp; Uttar Pradesh</h1>
      <p class="mt-4 text-green-100 text-lg">Eligible homes in UP can get up to <strong class="text-white">&#8377;1,08,000</strong> towards a rooftop solar system: &#8377;78,000 from the central government plus &#8377;30,000 from the UP government. Greenedge is a <strong class="text-white">registered vendor under PM Surya Ghar in Uttar Pradesh</strong> and helps you with the system, the paperwork and net metering.</p>
      <div class="mt-6 flex flex-wrap gap-3">
        <a href="#apply" class="btn-light" data-track="cta_pmsg_apply">Check my eligibility</a>
        <a href="/calculator?cat=residential" class="btn-outline-light" data-track="cta_calculator">Calculate my savings</a>
      </div>
    </div>
    <div class="card p-6 text-slate-800">
      <p class="font-bold text-lg">Subsidy for UP homes</p>
      <table class="w-full text-sm mt-3">
        <thead><tr class="text-left text-slate-500"><th class="py-2">Size</th><th class="py-2 text-right">Central</th><th class="py-2 text-right">UP state</th><th class="py-2 text-right">Total</th></tr></thead>
        <tbody class="divide-y">
          <tr><td class="py-2">1 kW</td><td class="py-2 text-right">&#8377;30,000</td><td class="py-2 text-right">&#8377;15,000</td><td class="py-2 text-right font-bold">&#8377;45,000</td></tr>
          <tr><td class="py-2">2 kW</td><td class="py-2 text-right">&#8377;60,000</td><td class="py-2 text-right">&#8377;30,000</td><td class="py-2 text-right font-bold">&#8377;90,000</td></tr>
          <tr><td class="py-2">3 kW+</td><td class="py-2 text-right">&#8377;78,000</td><td class="py-2 text-right">&#8377;30,000</td><td class="py-2 text-right font-bold">&#8377;1,08,000</td></tr>
        </tbody>
      </table>
      <p class="text-xs text-slate-500 mt-3">Central: &#8377;30,000/kW for the first 2 kW, &#8377;18,000 for the 3rd kW, capped at &#8377;78,000. UP (UPNEDA): &#8377;15,000/kW, maximum &#8377;30,000 per consumer.</p>
    </div>
  </div>
</section>

<article class="container mx-auto px-4 py-12 max-w-4xl prose-lite">
  <h2>What is PM Surya Ghar: Muft Bijli Yojana?</h2>
  <p>PM Surya Ghar: Muft Bijli Yojana is the Government of India&rsquo;s rooftop solar scheme for households, launched in February 2024 and run by the Ministry of New and Renewable Energy (MNRE). It gives a direct subsidy (central financial assistance) to residential electricity consumers who install a grid-connected rooftop solar system through the National Portal, with the aim of helping homes generate up to 300 units of free electricity a month.</p>
  <p>In Uttar Pradesh, UPNEDA adds a state subsidy on top of the central amount, which makes UP one of the best states in India for home rooftop solar.</p>

  <h2>Who is eligible?</h2>
  <ul>
    <li>You are a <strong>residential</strong> electricity consumer with a valid connection from your DISCOM (for Aligarh, Dakshinanchal Vidyut Vitran Nigam &ndash; DVVNL).</li>
    <li>You have a suitable roof with shadow-free space (about 100 sq ft per kW).</li>
    <li>The house has not already received a solar subsidy for the same connection.</li>
    <li>The system is grid-connected (on-grid) and installed by a vendor registered on the National Portal, using approved (ALMM-listed, domestic-content) panels.</li>
  </ul>
  <p>Shops, offices, schools, factories and other non-residential connections are <strong>not</strong> eligible for PM Surya Ghar subsidy. See our <a href="/commercial-solar">commercial</a> and <a href="/industrial-solar">industrial</a> solutions instead. Housing societies and RWAs get &#8377;18,000 per kW for common-area systems &ndash; see <a href="/housing-society-solar">solar for housing societies</a>.</p>

  <h2>How much subsidy will I get?</h2>
  <p>The central subsidy is &#8377;30,000 per kW for the first 2 kW and &#8377;18,000 for the third kW. Above 3 kW there is no extra central subsidy, so a 5 kW system receives the same &#8377;78,000 as a 3 kW system. UP adds &#8377;15,000 per kW up to &#8377;30,000. For in-between sizes the amount is proportional; for example 2.5 kW = &#8377;69,000 central + &#8377;30,000 state = &#8377;99,000.</p>
  <p><strong>Important:</strong> eligibility, approval and payment are decided by the government through the National Portal, your DISCOM and UPNEDA. The UP state subsidy is released within the funds and allocation available at the time. Greenedge cannot promise or pay any subsidy &ndash; we help you apply correctly.</p>

  <h2 id="process">Step-by-step process</h2>
  <ol>
    <li><strong>Register</strong> on the National Portal (pmsuryaghar.gov.in) with your state, DISCOM, consumer number and mobile number.</li>
    <li><strong>Apply for rooftop solar</strong> on the portal and wait for technical feasibility approval from your DISCOM.</li>
    <li><strong>Choose a registered vendor</strong> and agree the system size and price. Get a written quotation.</li>
    <li><strong>Installation</strong> of panels, structure, inverter, earthing and protection.</li>
    <li><strong>Net metering</strong>: submit installation details on the portal; the DISCOM inspects and installs the net meter.</li>
    <li><strong>Commissioning certificate</strong> is generated on the portal after inspection.</li>
    <li><strong>Submit bank details</strong> and a cancelled cheque on the portal. The central subsidy is credited to your bank account; the UP state subsidy follows through UPNEDA.</li>
  </ol>

  <h2>Documents usually needed</h2>
  <ul>
    <li>Latest electricity bill (consumer number) in the applicant&rsquo;s name</li>
    <li>Aadhaar card and mobile number linked to it</li>
    <li>Bank passbook or cancelled cheque of the same account holder</li>
    <li>Proof of ownership or right to use the roof, if asked</li>
    <li>Recent photograph and roof photographs</li>
  </ul>

  <h2>Can I get a loan?</h2>
  <p>Yes. Public sector banks offer concessional, collateral-free loans for rooftop solar under the scheme. For example, SBI&rsquo;s Surya Ghar loan offers up to &#8377;2 lakh for systems up to 3 kW and up to &#8377;6 lakh for 3&ndash;10 kW. Interest rates and conditions change, so check the current terms with your bank. Our <a href="/calculator?cat=residential">calculator</a> shows an indicative EMI.</p>

  <h2>How Greenedge helps</h2>
  <p>Greenedge Infratech is a registered vendor under PM Surya Ghar: Muft Bijli Yojana in Uttar Pradesh, so you can select us on the National Portal when you apply.</p>
  <ul>
    <li>Free site survey and correct sizing from your last 12 months of bills</li>
    <li>Help with portal registration, application and document upload</li>
    <li>Installation by our Aligarh team, DISCOM inspection and net meter coordination</li>
    <li>Guidance until your subsidy is credited, plus after-sales service</li>
  </ul>

  <h2>Frequently asked questions</h2>
  <h3>Will I really get 300 units free?</h3>
  <p>A 3 kW system in Western UP typically produces around 350&ndash;400 units a month on average, so a home using about 300 units can bring its energy charges close to zero. Fixed charges remain, and output is lower in winter and cloudy months.</p>
  <h3>Should I install more than 3 kW?</h3>
  <p>If your usage is higher, yes &ndash; savings grow with size. Just note the subsidy does not increase beyond 3 kW, so the extra capacity is at full price.</p>
  <h3>How long does it take to get the subsidy?</h3>
  <p>The central subsidy is usually credited a few weeks after the commissioning certificate and bank details are submitted. Timelines depend on the portal, DISCOM and bank.</p>

  <p class="text-sm text-slate-500">Official information: <a href="https://pmsuryaghar.gov.in" target="_blank" rel="noopener">PM Surya Ghar National Portal</a> &middot; <a href="https://upneda.org.in" target="_blank" rel="noopener">UPNEDA</a>. Checked November 2026.</p>
</article>

<section id="apply" class="bg-green-50 scroll-mt-24">
  <div class="container mx-auto px-4 py-12 max-w-3xl">
    <?php $lf = ['type' => 'site-survey', 'category' => 'pm-surya-ghar', 'heading' => 'Check your PM Surya Ghar eligibility', 'sub' => 'Tell us where you are and we will call you to check eligibility, size and the subsidy you can apply for.', 'button' => 'Check My Eligibility', 'message' => true]; include __DIR__ . '/../inc/lead-form.php'; ?>
  </div>
</section>
<?php include __DIR__ . '/../inc/footer.php'; ?>
