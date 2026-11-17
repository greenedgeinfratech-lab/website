<?php
require __DIR__ . '/inc/config.php';
require __DIR__ . '/inc/ui.php';
$page = [
    'title' => 'Solar Buyer\'s Guide for India & UP: Everything to Know Before You Install | Greenedge',
    'description' => 'A complete, honest guide to buying solar in Uttar Pradesh: system types, panels and inverters, sizing, cost, savings, subsidy, net metering, financing, how to choose an installer, warranties and maintenance.',
    'path' => '/solar-guide', 'nav' => 'guide',
    'crumbs' => [['Solar buyer\'s guide', '/solar-guide']],
    'schema' => [['@context' => 'https://schema.org', '@type' => 'Article', 'headline' => 'Solar buyer\'s guide for Uttar Pradesh', 'author' => ['@id' => SITE_URL . '/#business'], 'publisher' => ['@id' => SITE_URL . '/#business'], 'dateModified' => '2026-11-17', 'mainEntityOfPage' => SITE_URL . '/solar-guide']],
];
include __DIR__ . '/inc/header.php';
ui_hero([
    'eyebrow' => 'Solar buyer&rsquo;s guide',
    'title' => 'Everything you need to know before installing solar',
    'sub' => 'Written by our engineers for homes, societies, businesses and institutions in Uttar Pradesh. No jargon, no hard sell &ndash; just what to check so you make a good decision, with us or anyone else.',
    'ctas' => [['/calculator', 'Try the calculator', 'btn-accent', 'cta_calculator'], ['#checklist', 'Installer checklist', 'btn-outline-light', 'cta_checklist']],
]);
$toc = [['right-for-me', 'Is solar right for me?'], ['how', 'How solar works'], ['types', 'On-grid, hybrid or off-grid'], ['components', 'Panels, inverters &amp; parts'], ['sizing', 'Sizing your system'], ['cost', 'Cost, savings &amp; payback'], ['models', 'Ways to pay'], ['subsidy', 'Subsidy &amp; net metering'], ['checklist', 'Choosing an installer'], ['warranty', 'Warranties'], ['maintenance', 'Maintenance'], ['timeline', 'Timeline'], ['glossary', 'Glossary']];
?>
<div class="container mx-auto px-4 py-12 grid lg:grid-cols-[240px_1fr] gap-10 items-start">
  <nav class="lg:sticky lg:top-24 card p-4 text-sm" aria-label="On this page">
    <p class="font-semibold text-slate-900 mb-2">On this page</p>
    <ul class="space-y-1"><?php foreach ($toc as $t): ?><li><a class="text-green-700 hover:underline" href="#<?= $t[0] ?>"><?= $t[1] ?></a></li><?php endforeach; ?></ul>
  </nav>
  <article class="prose-lite max-w-none">
    <section id="right-for-me" class="scroll-mt-24">
      <h2 class="!mt-0">1. Is solar right for me?</h2>
      <p>Solar usually makes sense if most of these are true:</p>
      <ul>
        <li>You have a roof or land with shadow-free space for most of the day (about 100 sq ft per kW).</li>
        <li>Your electricity bill is meaningful &ndash; for homes, roughly &#8377;1,500 a month or more; for businesses, any significant daytime use.</li>
        <li>You plan to stay in the building for a few years (or the plant can move with you).</li>
        <li>The roof is in good condition, or you can repair it before installation.</li>
      </ul>
      <p>Western Uttar Pradesh gets good sunshine for most of the year. Output dips in foggy winter weeks and peaks in spring and summer.</p>
    </section>

    <section id="how" class="scroll-mt-24">
      <h2>2. How a solar system works</h2>
      <p>Solar panels turn sunlight into direct current (DC). The inverter converts it into alternating current (AC) that your appliances use. In an on-grid system, your building uses solar power first; any extra goes to the grid through a bidirectional (net) meter, and when solar is not enough &ndash; at night, for example &ndash; you draw from the grid as usual.</p>
    </section>

    <section id="types" class="scroll-mt-24">
      <h2>3. On-grid, hybrid or off-grid?</h2>
      <table>
        <thead><tr><th></th><th>On-grid</th><th>Hybrid</th><th>Off-grid</th></tr></thead>
        <tbody>
          <tr><td>Battery</td><td>No</td><td>Yes</td><td>Yes</td></tr>
          <tr><td>Works in a power cut</td><td>No (safety shutdown)</td><td>Yes, for chosen loads</td><td>Yes</td></tr>
          <tr><td>Cost per kW</td><td>Lowest</td><td>Higher</td><td>Highest</td></tr>
          <tr><td>PM Surya Ghar subsidy</td><td>Yes (homes)</td><td>Grid-connected part, as per scheme rules</td><td>No</td></tr>
          <tr><td>Best for</td><td>Most homes and businesses</td><td>Areas with frequent cuts</td><td>No grid connection</td></tr>
        </tbody>
      </table>
    </section>

    <section id="components" class="scroll-mt-24">
      <h2>4. Panels, inverters and other parts</h2>
      <h3>Solar panels</h3>
      <ul>
        <li><strong>Mono PERC:</strong> proven, widely used and cost-effective.</li>
        <li><strong>N-type TOPCon:</strong> newer, slightly higher efficiency and better hot-weather performance; useful when roof space is tight.</li>
        <li><strong>Bifacial:</strong> generate from both sides; best on elevated structures with reflective surfaces below.</li>
        <li><strong>ALMM and DCR:</strong> check that modules are on MNRE&rsquo;s Approved List of Models and Manufacturers. Subsidised home systems under PM Surya Ghar need domestic-content (DCR) modules.</li>
      </ul>
      <h3>Inverter</h3>
      <p>Choose a reputed brand with local service, the right capacity for your panels, and Wi-Fi monitoring. String inverters suit most rooftops; hybrid inverters add battery charging.</p>
      <h3>Mounting structure</h3>
      <p>Ask for hot-dip galvanised steel or suitable aluminium, designed for local wind speeds, with proper anchoring. Elevated structures let you use the roof below; make sure the design is checked for the extra height.</p>
      <h3>Balance of system</h3>
      <p>Good DC and AC cables of the right size, earthing pits, a lightning arrester, surge protection devices, isolators and a proper distribution box. These are where low-cost quotations often cut corners.</p>
      <h3>Batteries (hybrid and off-grid)</h3>
      <p>Lithium iron phosphate (LFP) batteries last longer and need no topping up; tubular lead-acid batteries cost less upfront but need more care and replacement sooner.</p>
    </section>

    <section id="sizing" class="scroll-mt-24">
      <h2>5. Sizing your system</h2>
      <p>Start from your units, not your bill. Add up 12 months of units (kWh) and divide by 12. In Western UP, each kW of panels produces about 4&ndash;4.5 units a day on average, or roughly 120&ndash;135 units a month. So a home using 400 units a month needs about 3&ndash;3.5 kW, if the roof allows.</p>
      <p>Also check your <strong>sanctioned load</strong>: DISCOM rules tie the solar capacity you can connect to your connection&rsquo;s load, so you may need a load increase first. Our <a href="/calculator">calculator</a> does this maths for you.</p>
    </section>

    <section id="cost" class="scroll-mt-24">
      <h2>6. Cost, savings and payback</h2>
      <p>A typical home on-grid system costs roughly &#8377;55,000&ndash;65,000 per kW before subsidy; larger commercial and industrial plants cost less per kW. Savings come from the units solar replaces at your tariff. Fixed charges stay on your bill. For eligible homes with subsidy, payback is often a few years, after which the power is close to free for the rest of the plant&rsquo;s 25-year life.</p>
      <p>Compare quotations on <strong>cost per kW for the same specification</strong>, not just the total, and ask for the expected annual generation in writing.</p>
    </section>

    <section id="models" class="scroll-mt-24">
      <h2>7. Ways to pay</h2>
      <ul>
        <li><strong>Buy outright (CAPEX):</strong> highest lifetime savings; homes get subsidy, businesses may get tax depreciation.</li>
        <li><strong>Loan or EMI:</strong> collateral-free bank loans for eligible homes under PM Surya Ghar; term loans for businesses.</li>
        <li><strong>Zero investment (RESCO):</strong> a developer owns the plant and you pay per unit. Best for larger commercial, industrial, institutional and government sites. <a href="/resco-solar">Compare the options</a>.</li>
        <li><strong>Open access:</strong> buy solar power from an off-site plant if you have 100 kW+ contracted demand. <a href="/open-access-solar">Learn more</a>.</li>
      </ul>
    </section>

    <section id="subsidy" class="scroll-mt-24">
      <h2>8. Subsidy and net metering</h2>
      <p>Eligible UP homes get up to &#8377;1,08,000 (central + state); housing societies get &#8377;18,000 per kW for common facilities. Businesses do not get PM Surya Ghar subsidy. Net metering lets exported units offset imported units in your bill, with any annual surplus settled at a rate set by the regulator. See <a href="/solar-schemes">schemes &amp; policies</a> for details.</p>
    </section>

    <section id="checklist" class="scroll-mt-24">
      <h2>9. How to choose a solar installer</h2>
      <p>Ask every installer &ndash; including us &ndash; these questions:</p>
      <ol>
        <li>Are you a registered vendor on the PM Surya Ghar National Portal for my state (for home subsidy)?</li>
        <li>Will you visit and survey my site before quoting?</li>
        <li>Which exact panel, inverter and structure models will you use? Are the panels ALMM-listed (and DCR where needed)?</li>
        <li>What annual generation do you expect, and how did you calculate it?</li>
        <li>What cable sizes, earthing, lightning and surge protection are included?</li>
        <li>Who handles the portal, DISCOM, net meter and subsidy paperwork?</li>
        <li>What is your workmanship warranty, and who do I call for service?</li>
        <li>Can I speak to two customers you installed for in the last year?</li>
      </ol>
      <h3>Red flags</h3>
      <ul>
        <li>A price far below everyone else with no brand names in the quotation</li>
        <li>&ldquo;Guaranteed&rdquo; subsidy promised by the installer (only the government approves subsidy)</li>
        <li>Pressure to pay in full before installation, or cash without a proper invoice</li>
        <li>No site visit before the quotation</li>
      </ul>
    </section>

    <section id="warranty" class="scroll-mt-24">
      <h2>10. Warranties</h2>
      <ul>
        <li><strong>Panels:</strong> manufacturer product warranty (often 10&ndash;12 years) plus a 25&ndash;30 year linear power-output warranty.</li>
        <li><strong>Inverter:</strong> typically 5&ndash;10 years from the manufacturer, sometimes extendable.</li>
        <li><strong>Structure and workmanship:</strong> given by the installer &ndash; get it in writing.</li>
        <li><strong>Batteries:</strong> by the battery manufacturer, often linked to cycles and years.</li>
      </ul>
    </section>

    <section id="maintenance" class="scroll-mt-24">
      <h2>11. Maintenance</h2>
      <p>Solar needs little maintenance: regular cleaning with water, a yearly check of connections and earthing, and watching your monitoring app for drops in generation. Larger plants benefit from a preventive maintenance contract. <a href="/solar-maintenance">Maintenance plans</a>.</p>
    </section>

    <section id="timeline" class="scroll-mt-24">
      <h2>12. Typical timeline for a home</h2>
      <ol>
        <li>Survey and quotation: a few days</li>
        <li>Portal application and DISCOM feasibility: depends on the DISCOM, often one to three weeks</li>
        <li>Installation: 1&ndash;3 days once material is on site</li>
        <li>Inspection, net meter and commissioning: a few weeks, depending on the DISCOM</li>
        <li>Subsidy credit: after commissioning and bank details are submitted on the portal</li>
      </ol>
    </section>

    <section id="glossary" class="scroll-mt-24">
      <h2>13. Glossary</h2>
      <ul>
        <li><strong>kW / kWp:</strong> the rated size of a solar system. <strong>kWh (unit):</strong> energy produced or used.</li>
        <li><strong>DISCOM:</strong> your electricity distribution company (DVVNL for Aligarh).</li>
        <li><strong>Net metering:</strong> billing where exported units offset imported units.</li>
        <li><strong>ALMM:</strong> MNRE&rsquo;s Approved List of Models and Manufacturers. <strong>DCR:</strong> domestic content requirement.</li>
        <li><strong>CAPEX / OPEX:</strong> owning the plant vs paying for power under a contract. <strong>RESCO:</strong> renewable energy service company. <strong>PPA:</strong> power purchase agreement.</li>
        <li><strong>CFA:</strong> central financial assistance &ndash; the central subsidy. <strong>UPNEDA:</strong> UP New and Renewable Energy Development Agency.</li>
      </ul>
    </section>
  </article>
</div>

<?php ui_enquiry(['type' => 'callback', 'message' => true, 'heading' => 'Ask our engineers anything', 'button' => 'Ask a Question'],
    'Still have questions?',
    'Send us your question with your city and monthly bill. An engineer, not a salesperson, will call you back.'); ?>
<?php include __DIR__ . '/inc/footer.php'; ?>
