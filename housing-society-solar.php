<?php
require __DIR__ . '/inc/config.php';
require __DIR__ . '/inc/ui.php';
$page = [
    'title' => 'Solar for Housing Societies & RWAs: Rs 18,000/kW Subsidy | Greenedge Infratech',
    'description' => 'Rooftop solar for group housing societies and resident welfare associations across India. Rs 18,000 per kW central subsidy for common facilities and EV charging, up to 500 kW. Lower maintenance charges for residents.',
    'path' => '/housing-society-solar', 'nav' => 'services',
    'crumbs' => [['Solutions', '/services'], ['Housing societies & RWAs', '/housing-society-solar']],
    'schema' => [['@context' => 'https://schema.org', '@type' => 'Service', 'name' => 'Rooftop solar for housing societies and RWAs', 'provider' => ['@id' => SITE_URL . '/#business'], 'areaServed' => ['@type' => 'Country', 'name' => 'India'], 'url' => SITE_URL . '/housing-society-solar']],
];
include __DIR__ . '/inc/header.php';
ui_hero([
    'eyebrow' => 'Group housing societies &amp; RWAs',
    'title' => 'Power your society&rsquo;s common areas with solar',
    'sub' => 'Lifts, water pumps, corridor and street lighting, clubhouse and EV chargers run up large common-area bills. Under PM Surya Ghar, societies and RWAs get <strong class="text-white">&#8377;18,000 per kW</strong> central subsidy for common facilities, up to 500 kW.',
    'badges' => ['Up to &#8377;90 lakh subsidy', 'Lower maintenance charges', 'EV charging covered', 'CAPEX or zero-investment'],
    'ctas' => [['/calculator?cat=society', 'Calculate society savings', 'btn-accent', 'cta_calculator'], ['#enquire', 'Request a society proposal', 'btn-outline-light', 'cta_proposal']],
    'aside' => '<div class="card p-6 text-slate-800"><p class="font-bold text-lg">How the society subsidy is worked out</p><p class="text-sm mt-2 text-slate-600">Subsidy = &#8377;18,000 &times; the <strong>lowest</strong> of:</p><ul class="text-sm mt-2 space-y-1 list-disc pl-5"><li>the solar capacity installed (kW)</li><li>3 kW &times; number of houses</li><li>500 kW</li></ul><p class="text-sm mt-3 text-slate-600">Example from the MNRE guidelines: a 100 kW plant in a society of 50 houses is eligible for &#8377;18,000 &times; 100 = <strong>&#8377;18,00,000</strong>.</p><p class="text-xs mt-3 text-slate-500">The 500 kW limit includes rooftop systems installed by individual residents in the society.</p></div>',
]);
?>
<section class="container mx-auto px-4 py-16">
  <?php ui_heading('Why societies are switching to solar', 'Common-area electricity is often the biggest single item in a society&rsquo;s maintenance budget.'); ?>
  <?php ui_cards([
      ['Lower maintenance charges', 'Solar cuts the common-area bill, freeing money for security, gardening, water and repairs &ndash; or lowering what every flat pays.'],
      ['Government subsidy', '&#8377;18,000 per kW central financial assistance under PM Surya Ghar for common facilities, including EV charging.'],
      ['Ready for EV charging', 'Plan solar together with shared EV chargers so residents can charge with daytime solar power.'],
      ['Uses idle roof space', 'Tower roofs, clubhouse roofs and parking sheds become a long-term income-saving asset.'],
      ['Zero-investment option', 'If the society prefers not to invest, a RESCO investor can build the plant and sell power at a fixed tariff below the grid rate.'],
      ['Greener community', 'Visible, measurable carbon savings that residents and buyers value.'],
  ]); ?>
</section>

<section class="bg-slate-50">
  <div class="container mx-auto px-4 py-16 grid lg:grid-cols-2 gap-10 items-start">
    <div>
      <h2 class="section-title">How we deliver a society project</h2>
      <ol class="mt-6 space-y-4 text-slate-700 list-decimal pl-5">
        <li><strong>Committee meeting.</strong> We present options, savings and the subsidy calculation to the managing committee.</li>
        <li><strong>Energy audit and roof survey.</strong> 12 months of common-area bills, connected loads, roof structure and shadow study across towers.</li>
        <li><strong>Proposal for the general body.</strong> Clear CAPEX and RESCO options with cash-flow tables the society can share with residents.</li>
        <li><strong>Resolution and application.</strong> Society resolution, National Portal application for common facilities, and DISCOM feasibility.</li>
        <li><strong>Installation with minimum disturbance.</strong> Scheduled work, safety barricading and tidy cable routing on each tower.</li>
        <li><strong>Net metering, subsidy and handover.</strong> DISCOM inspection, commissioning, subsidy documents and monitoring access for the committee.</li>
        <li><strong>Maintenance plan.</strong> Cleaning schedule, preventive checks and generation reports for the AGM.</li>
      </ol>
    </div>
    <div>
      <h2 class="section-title">Documents the society usually needs</h2>
      <ul class="mt-6 space-y-3 tick-list text-slate-700">
        <li>Society / RWA registration certificate</li>
        <li>Resolution authorising the solar project and the signatory</li>
        <li>Recent electricity bill of the common-area connection</li>
        <li>Number of houses / flats in the society</li>
        <li>Society bank account details for the subsidy</li>
        <li>PAN of the society and KYC of the authorised signatory</li>
      </ul>
      <p class="mt-6 text-sm text-slate-600">The subsidy is for common facilities only. Solar under this category must not be used to supply individual flats; residents can apply separately for their own homes under the residential category.</p>
      <?php ui_sources([['PM Surya Ghar National Portal', 'https://pmsuryaghar.gov.in'], ['MNRE', 'https://mnre.gov.in']]); ?>
    </div>
  </div>
</section>

<?php ui_enquiry(['type' => 'quotation', 'category' => 'housing-society', 'business' => true, 'message' => true, 'heading' => 'Request a proposal for your society', 'button' => 'Request Society Proposal'],
    'Get a solar proposal for your society',
    'Share your society&rsquo;s name and location. We handle the PM Surya Ghar society application in Uttar Pradesh, and build society plants across India. We will set up a call with the committee, review common-area bills and prepare CAPEX and zero-investment options.',
    ['Subsidy calculation for your society', 'Presentation for the committee or AGM', 'Single point of contact through approvals']); ?>

<?php ui_faqs([
    ['Who can apply for the society subsidy?', 'Group Housing Societies and Resident Welfare Associations, for rooftop solar that supplies common facilities such as lifts, pumps, common lighting and EV charging.'],
    ['What is the maximum subsidy?', '&#8377;18,000 per kW up to 500 kW, so up to &#8377;90 lakh for a fully eligible 500 kW project. Eligible capacity is also limited to 3 kW per house, and the 500 kW limit includes residents&rsquo; own rooftop systems.'],
    ['Can residents also get the home subsidy?', 'Yes, residents with their own electricity connection and roof rights can apply under the residential category for their own homes. That capacity counts within the society&rsquo;s 500 kW limit.'],
    ['What if the society does not want to invest?', 'A <a href="/resco-solar">RESCO (zero-investment) model</a> may suit you: an investor builds and maintains the plant, and the society pays a fixed tariff per unit for an agreed number of years. We can compare both options for you.'],
]); ?>
<?php ui_related('/housing-society-solar'); ?>
<?php include __DIR__ . '/inc/footer.php'; ?>
