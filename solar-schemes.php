<?php
require __DIR__ . '/inc/config.php';
require __DIR__ . '/inc/ui.php';
$page = [
    'title' => 'Solar Schemes, Subsidies & Policies in Uttar Pradesh (2026) | Greenedge Infratech',
    'description' => 'All solar schemes and rules in one place for UP: PM Surya Ghar subsidy, housing society subsidy, UP state subsidy, solar loans, PM-KUSUM, UP Solar Energy Policy 2022, net metering, open access, ALMM and tax depreciation.',
    'path' => '/solar-schemes', 'nav' => 'schemes',
    'crumbs' => [['Schemes & policies', '/solar-schemes']],
];
include __DIR__ . '/inc/header.php';
ui_hero([
    'eyebrow' => 'Government schemes &amp; policies',
    'title' => 'Solar schemes, subsidies and rules in Uttar Pradesh',
    'sub' => 'A plain-language guide to the central and state programmes that affect solar in UP, kept up to date by our team. Use it to understand what applies to you, then let us confirm the details for your case.',
]);
$toc = [['pm-surya-ghar', 'PM Surya Ghar (homes)'], ['rwa', 'Housing societies &amp; RWAs'], ['loans', 'Solar loans'], ['kusum', 'PM-KUSUM (farmers)'], ['up-policy', 'UP Solar Energy Policy 2022'], ['net-metering', 'Net metering in UP'], ['open-access', 'Green energy open access'], ['depreciation', 'Tax benefits for business'], ['almm', 'ALMM &amp; domestic content']];
?>
<div class="container mx-auto px-4 py-12 grid lg:grid-cols-[240px_1fr] gap-10 items-start">
  <nav class="lg:sticky lg:top-24 card p-4 text-sm" aria-label="On this page">
    <p class="font-semibold text-slate-900 mb-2">On this page</p>
    <ul class="space-y-1"><?php foreach ($toc as $t): ?><li><a class="text-green-700 hover:underline" href="#<?= $t[0] ?>"><?= $t[1] ?></a></li><?php endforeach; ?></ul>
  </nav>
  <article class="prose-lite max-w-none">
    <section id="pm-surya-ghar" class="scroll-mt-24">
      <h2 class="!mt-0">PM Surya Ghar: Muft Bijli Yojana (homes)</h2>
      <p>The Government of India&rsquo;s rooftop solar scheme for households, launched in 2024 and run by MNRE through the National Portal. It gives a direct subsidy to residential consumers who install a grid-connected rooftop system through a registered vendor. In Uttar Pradesh, UPNEDA adds a state subsidy of &#8377;15,000 per kW, up to &#8377;30,000 per consumer.</p>
      <table>
        <thead><tr><th>System size</th><th>Central subsidy</th><th>UP state subsidy</th><th>Total in UP</th></tr></thead>
        <tbody>
          <tr><td>1 kW</td><td>&#8377;30,000</td><td>&#8377;15,000</td><td><strong>&#8377;45,000</strong></td></tr>
          <tr><td>2 kW</td><td>&#8377;60,000</td><td>&#8377;30,000</td><td><strong>&#8377;90,000</strong></td></tr>
          <tr><td>3 kW and above</td><td>&#8377;78,000 (cap)</td><td>&#8377;30,000 (cap)</td><td><strong>&#8377;1,08,000</strong></td></tr>
        </tbody>
      </table>
      <p>Central subsidy is &#8377;30,000 per kW for the first 2 kW and &#8377;18,000 for the third kW; there is no extra central subsidy beyond 3 kW. <a href="/pmsuryaghar/">Full guide: eligibility, documents and steps &rarr;</a></p>
    </section>

    <section id="rwa" class="scroll-mt-24">
      <h2>Housing societies and RWAs</h2>
      <p>Group Housing Societies and Resident Welfare Associations get &#8377;18,000 per kW for rooftop solar serving common facilities, including EV charging, up to 500 kW, at up to 3 kW per house. The 500 kW limit includes rooftop systems installed by individual residents. <a href="/housing-society-solar">Society solar &rarr;</a></p>
    </section>

    <section id="loans" class="scroll-mt-24">
      <h2>Solar loans for homes</h2>
      <p>Under PM Surya Ghar, public sector banks offer collateral-free rooftop solar loans at concessional rates. For example, SBI&rsquo;s Surya Ghar loan allows up to &#8377;2 lakh for systems up to 3 kW and up to &#8377;6 lakh for systems above 3 kW and up to 10 kW, with income and margin conditions for the larger slab. Rates and conditions change, so check with your bank. We help you prepare the quotation and documents the bank asks for.</p>
      <p>Businesses can use term loans, equipment finance or the <a href="/resco-solar">zero-investment RESCO model</a>.</p>
    </section>

    <section id="kusum" class="scroll-mt-24">
      <h2>PM-KUSUM (farmers)</h2>
      <p>PM-KUSUM supports solar in agriculture in three parts: small solar plants on farmers&rsquo; land (Component A), standalone solar pumps (Component B) and solarisation of grid-connected pumps and agricultural feeders (Component C). Uttar Pradesh is one of the active states, including feeder-level solarisation projects. <a href="/solar-pumps-kusum">Solar pumps &amp; PM-KUSUM &rarr;</a></p>
    </section>

    <section id="up-policy" class="scroll-mt-24">
      <h2>Uttar Pradesh Solar Energy Policy 2022</h2>
      <p>Approved in November 2022 with UPNEDA as nodal agency, the policy set a target of 22,000 MW of solar in five years:</p>
      <ul>
        <li>14,000 MW from solar parks and utility projects</li>
        <li>4,500 MW from residential rooftop solar</li>
        <li>1,500 MW from non-residential rooftop solar, such as government buildings and educational institutions</li>
        <li>2,000 MW through PM-KUSUM</li>
      </ul>
      <p>It allows rooftop solar with net metering on government buildings and educational institutions, and calls for solar on government and PSU buildings, schools, colleges and universities in phases, through CAPEX and RESCO models. <a href="/government-solar">Government solar &rarr;</a></p>
    </section>

    <section id="net-metering" class="scroll-mt-24">
      <h2>Net metering and rooftop rules in UP</h2>
      <p>Grid-connected rooftop solar in UP is governed by the UPERC (Rooftop Solar PV Grid Interactive System Gross / Net Metering) Regulations, 2019, as amended (the latest amendment came into force in July 2025). Under net metering, a bidirectional meter records units you import and export, and exported units are adjusted against imports in your bill. The arrangement available &ndash; net metering, net billing or gross metering &ndash; depends on your consumer category: residential consumers, government buildings and educational institutions can use net metering. Applications go through your DISCOM: DVVNL for Aligarh, Agra and nearby districts, PVVNL for the Meerut region, plus MVVNL, PuVVNL and KESCo elsewhere in the state.</p>
    </section>

    <section id="open-access" class="scroll-mt-24">
      <h2>Green energy open access</h2>
      <p>The Electricity (Promoting Renewable Energy Through Green Energy Open Access) Rules, 2022 let consumers with 100 kW or more contracted demand buy renewable power from plants elsewhere. UPERC has aligned its open access regulations with these rules and in 2026 issued an order easing metering and fee requirements for green open access consumers. <a href="/open-access-solar">Open access solar &rarr;</a></p>
    </section>

    <section id="depreciation" class="scroll-mt-24">
      <h2>Tax benefits for businesses</h2>
      <p>Solar power generating systems are listed for 40% depreciation on the written-down value under the Income Tax depreciation schedule, so a business that owns a plant can claim a large deduction in the early years. Conditions apply, including when the plant is put to use; confirm with your chartered accountant. Under the RESCO model the developer, not the consumer, claims depreciation.</p>
    </section>

    <section id="almm" class="scroll-mt-24">
      <h2>ALMM and domestic content</h2>
      <p>MNRE&rsquo;s Approved List of Models and Manufacturers (ALMM) lists solar modules (and, in phases, cells) approved for government-supported and many other projects. Subsidised schemes such as PM Surya Ghar also require domestic-content (DCR) modules made from Indian cells. We specify ALMM-listed equipment and DCR modules wherever a scheme requires them, and name every model in your quotation.</p>
    </section>

    <?php ui_sources([['PM Surya Ghar National Portal', 'https://pmsuryaghar.gov.in'], ['MNRE', 'https://mnre.gov.in'], ['UPNEDA', 'https://upneda.org.in'], ['UPERC', 'https://www.uperc.org'], ['SBI Surya Ghar loan', 'https://sbi.co.in/web/personal-banking/loans/pm-surya-ghar-loan-for-solar-roof-top'], ['UP Solar Energy Policy 2022', 'https://invest.up.gov.in/solar-energy-policy-2022/']]); ?>
  </article>
</div>

<?php ui_enquiry(['type' => 'callback', 'message' => true, 'heading' => 'Ask which scheme applies to you', 'button' => 'Ask a Solar Expert'],
    'Not sure what you are eligible for?',
    'Tell us who you are and what you want to power. We will tell you which schemes, subsidies or tax benefits apply, and what to do next.'); ?>
<?php include __DIR__ . '/inc/footer.php'; ?>
