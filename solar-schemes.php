<?php
require __DIR__ . '/inc/config.php';
require __DIR__ . '/inc/ui.php';
$page = [
    'title' => 'Solar Schemes, Subsidies & Policies in India (2026) | Greenedge Infratech',
    'description' => 'All solar schemes and rules in one place: PM Surya Ghar subsidy, housing society subsidy, state subsidies, solar loans, PM-KUSUM, state solar policies, net metering, green energy open access, ALMM and tax depreciation.',
    'path' => '/solar-schemes', 'nav' => 'schemes',
    'crumbs' => [['Schemes & policies', '/solar-schemes']],
];
include __DIR__ . '/inc/header.php';
ui_hero([
    'eyebrow' => 'Government schemes &amp; policies',
    'title' => 'Solar schemes, subsidies and rules in India',
    'sub' => 'A plain-language guide to the central and state programmes that affect solar in India, kept up to date by our team. Use it to understand what applies to you, then let us confirm the details for your case.',
]);
$toc = [['pm-surya-ghar', 'PM Surya Ghar (homes)'], ['rwa', 'Housing societies &amp; RWAs'], ['loans', 'Solar loans'], ['kusum', 'PM-KUSUM (farmers)'], ['state-policies', 'State solar policies'], ['net-metering', 'Net metering'], ['open-access', 'Green energy open access'], ['depreciation', 'Tax benefits for business'], ['almm', 'ALMM &amp; domestic content']];
?>
<div class="container mx-auto px-4 py-12 grid lg:grid-cols-[240px_1fr] gap-10 items-start">
  <nav class="lg:sticky lg:top-24 card p-4 text-sm" aria-label="On this page">
    <p class="font-semibold text-slate-900 mb-2">On this page</p>
    <ul class="space-y-1"><?php foreach ($toc as $t): ?><li><a class="text-green-700 hover:underline" href="#<?= $t[0] ?>"><?= $t[1] ?></a></li><?php endforeach; ?></ul>
  </nav>
  <article class="prose-lite max-w-none">
    <section id="pm-surya-ghar" class="scroll-mt-24">
      <h2 class="!mt-0">PM Surya Ghar: Muft Bijli Yojana (homes)</h2>
      <p>The Government of India&rsquo;s rooftop solar scheme for households, launched in 2024 and run by MNRE through the National Portal. It gives a direct subsidy to residential consumers who install a grid-connected rooftop system through a registered vendor. Several states add their own subsidy on top of the central amount.</p>
      <table>
        <thead><tr><th>System size</th><th>Central subsidy</th></tr></thead>
        <tbody>
          <tr><td>1 kW</td><td>&#8377;30,000</td></tr>
          <tr><td>2 kW</td><td>&#8377;60,000</td></tr>
          <tr><td>3 kW and above</td><td>&#8377;78,000 (cap)</td></tr>
        </tbody>
      </table>
      <p>Central subsidy is &#8377;30,000 per kW for the first 2 kW and &#8377;18,000 for the third kW; there is no extra central subsidy beyond 3 kW. Greenedge is a registered PM Surya Ghar vendor in Uttar Pradesh, where homes also get a state subsidy of &#8377;15,000 per kW up to &#8377;30,000. <a href="/pmsuryaghar/">Full guide: eligibility, documents and steps &rarr;</a></p>
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
      <p>PM-KUSUM supports solar in agriculture in three parts: small solar plants on farmers&rsquo; land (Component A), standalone solar pumps (Component B) and solarisation of grid-connected pumps and agricultural feeders (Component C). Each state runs its own application rounds and adds its share of the subsidy. <a href="/solar-pumps-kusum">Solar pumps &amp; PM-KUSUM &rarr;</a></p>
    </section>

    <section id="state-policies" class="scroll-mt-24">
      <h2>State solar policies</h2>
      <p>Most states have their own solar or renewable energy policy, run by a state nodal agency. These policies set state targets, any extra subsidy for homes, rules for solar on government buildings and educational institutions, land and approval support for larger plants, and incentives for industry. Many now promote solar on government buildings through both CAPEX and RESCO models. Tell us your state and we will explain what applies to your project.</p>
    </section>

    <section id="net-metering" class="scroll-mt-24">
      <h2>Net metering and rooftop rules</h2>
      <p>Grid-connected rooftop solar is governed by the rooftop or net-metering regulations of your State Electricity Regulatory Commission, within national rules. Under net metering, a bidirectional meter records units you import and export, and exported units are adjusted against imports in your bill, with any surplus settled at a rate set by the regulator. Depending on your state and consumer category, you may be offered net metering, net billing or gross metering, and there are limits on capacity relative to your sanctioned load. Applications go through your electricity distribution company (DISCOM).</p>
    </section>

    <section id="open-access" class="scroll-mt-24">
      <h2>Green energy open access</h2>
      <p>The Electricity (Promoting Renewable Energy Through Green Energy Open Access) Rules, 2022 let consumers with 100 kW or more contracted demand buy renewable power from plants elsewhere. Each state regulator implements the rules with its own charges and procedures. <a href="/open-access-solar">Open access solar &rarr;</a></p>
    </section>

    <section id="depreciation" class="scroll-mt-24">
      <h2>Tax benefits for businesses</h2>
      <p>Solar power generating systems are listed for 40% depreciation on the written-down value under the Income Tax depreciation schedule, so a business that owns a plant can claim a large deduction in the early years. Conditions apply, including when the plant is put to use; confirm with your chartered accountant. Under the RESCO model the developer, not the consumer, claims depreciation.</p>
    </section>

    <section id="almm" class="scroll-mt-24">
      <h2>ALMM and domestic content</h2>
      <p>MNRE&rsquo;s Approved List of Models and Manufacturers (ALMM) lists solar modules (and, in phases, cells) approved for government-supported and many other projects. Subsidised schemes such as PM Surya Ghar also require domestic-content (DCR) modules made from Indian cells. We specify ALMM-listed equipment and DCR modules wherever a scheme requires them, and name every model in your quotation.</p>
    </section>

    <?php ui_sources([['PM Surya Ghar National Portal', 'https://pmsuryaghar.gov.in'], ['MNRE', 'https://mnre.gov.in'], ['SBI Surya Ghar loan', 'https://sbi.co.in/web/personal-banking/loans/pm-surya-ghar-loan-for-solar-roof-top']]); ?>
  </article>
</div>

<?php ui_enquiry(['type' => 'callback', 'message' => true, 'heading' => 'Ask which scheme applies to you', 'button' => 'Ask a Solar Expert'],
    'Not sure what you are eligible for?',
    'Tell us who you are and what you want to power. We will tell you which schemes, subsidies or tax benefits apply, and what to do next.'); ?>
<?php include __DIR__ . '/inc/footer.php'; ?>
