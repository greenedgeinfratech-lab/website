<?php
require __DIR__ . '/inc/config.php';
require __DIR__ . '/inc/ui.php';
$page = [
    'title' => 'Solar for Government Buildings, PSUs, Schools & Hospitals | Greenedge Infratech',
    'description' => 'Rooftop solar EPC for government offices, PSUs, schools, colleges, universities, hospitals and public institutions across India, under CAPEX or RESCO models, with net metering and tender documentation support.',
    'path' => '/government-solar', 'nav' => 'services',
    'crumbs' => [['Solutions', '/services'], ['Government & institutions', '/government-solar']],
    'schema' => [['@context' => 'https://schema.org', '@type' => 'Service', 'name' => 'Solar for government buildings and public institutions', 'provider' => ['@id' => SITE_URL . '/#business'], 'areaServed' => ['@type' => 'Country', 'name' => 'India'], 'url' => SITE_URL . '/government-solar']],
];
include __DIR__ . '/inc/header.php';
ui_hero([
    'eyebrow' => 'Government projects &amp; public institutions',
    'title' => 'Solar for government buildings and public institutions',
    'sub' => 'Central and state governments are putting solar on government offices, PSU buildings, schools, colleges, universities and hospitals. Greenedge delivers these projects end to end, under CAPEX or RESCO.',
    'badges' => ['Net metering where state rules allow', 'CAPEX or RESCO', 'Tender &amp; documentation support', 'Multi-site programmes'],
    'ctas' => [['#enquire', 'Discuss a project', 'btn-accent', 'cta_govt'], ['/solar-schemes', 'Schemes &amp; policies', 'btn-outline-light', 'cta_schemes']],
]);
?>
<section class="container mx-auto px-4 py-16">
  <?php ui_heading('Who we work with in the public sector'); ?>
  <?php ui_cards([
      ['Government offices &amp; collectorates', 'Administrative buildings, tehsils, police lines and departmental offices with daytime loads.'],
      ['PSUs &amp; boards', 'Public sector undertakings, development authorities, mandi parishads and utilities.'],
      ['Schools &amp; colleges', 'Government and aided schools, degree colleges, polytechnics and ITIs, where net metering is allowed.'],
      ['Universities &amp; research institutes', 'Large campuses with multiple buildings, hostels and laboratories.'],
      ['Hospitals &amp; health centres', 'District hospitals, CHCs and PHCs, with hybrid options for critical loads.'],
      ['Municipal &amp; panchayat buildings', 'Nagar nigam offices, community centres, panchayat bhawans and water works.'],
  ]); ?>
</section>

<section class="bg-slate-50">
  <div class="container mx-auto px-4 py-16 grid lg:grid-cols-2 gap-10 items-start">
    <div>
      <h2 class="section-title">How public projects are delivered</h2>
      <div class="mt-6 space-y-5">
        <div class="card p-5"><h3 class="font-bold text-slate-900">CAPEX (department-funded)</h3><p class="text-sm text-slate-600 mt-1">The department funds the plant through its budget or a scheme, usually through a tender or empanelment. We supply, install, commission and maintain it for the contract period.</p></div>
        <div class="card p-5"><h3 class="font-bold text-slate-900">RESCO (pay per unit)</h3><p class="text-sm text-slate-600 mt-1">A developer invests in the plant and the department pays a fixed tariff per unit over a long-term agreement. State solar policies increasingly support both CAPEX and RESCO for government buildings. <a class="text-green-700 underline" href="/resco-solar">How RESCO works</a>.</p></div>
        <div class="card p-5"><h3 class="font-bold text-slate-900">Through state nodal agencies</h3><p class="text-sm text-slate-600 mt-1">Many government rooftop programmes are run through each state&rsquo;s renewable energy nodal agency. We work to the technical specifications and processes of the programme concerned.</p></div>
      </div>
    </div>
    <div>
      <h2 class="section-title">What we provide</h2>
      <ul class="mt-6 space-y-3 tick-list text-slate-700">
        <li>Site surveys and feasibility reports for one building or a portfolio of sites</li>
        <li>Detailed project reports, energy yield and savings estimates</li>
        <li>Technical documentation for tenders: drawings, bill of quantities, specifications</li>
        <li>ALMM-listed modules and equipment meeting the tender&rsquo;s technical specifications</li>
        <li>Net metering application and DISCOM inspection</li>
        <li>Safe installation with documented quality checks and commissioning reports</li>
        <li>Comprehensive O&amp;M with generation reporting for the contract period</li>
      </ul>
      <p class="mt-6 text-sm text-slate-600">For participation in a specific tender, contact us with the tender reference and we will confirm eligibility and documents.</p>
      <?php ui_sources([['MNRE', 'https://mnre.gov.in']]); ?>
    </div>
  </div>
</section>

<?php ui_enquiry(['type' => 'quotation', 'category' => 'government', 'business' => true, 'message' => true, 'heading' => 'Discuss a government or institutional project', 'button' => 'Send Project Details'],
    'Plan solar for your department or institution',
    'Tell us about the building or campus, or share a tender reference. Our team will respond with a feasibility view, the model that fits and next steps.',
    ['Feasibility and DPR support', 'Single and multi-site programmes', 'Commissioning and O&amp;M reporting']); ?>

<?php ui_faqs([
    ['Can government buildings use net metering?', 'In many states, yes &ndash; state solar policies and regulations allow net metering for government buildings and educational institutions. We confirm the rules in your state.'],
    ['Can a department go solar without a budget allocation?', 'Under the RESCO model a developer invests and the department pays only for the units, at a tariff agreed in the contract. Procurement rules of the department apply.'],
    ['Do you maintain plants after commissioning?', 'Yes. We offer comprehensive operation and maintenance with periodic cleaning, preventive checks and generation reports. See <a href="/solar-maintenance">maintenance &amp; AMC</a>.'],
]); ?>
<?php ui_related('/government-solar'); ?>
<?php include __DIR__ . '/inc/footer.php'; ?>
