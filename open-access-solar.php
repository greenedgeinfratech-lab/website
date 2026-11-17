<?php
require __DIR__ . '/inc/config.php';
require __DIR__ . '/inc/ui.php';
$page = [
    'title' => 'Green Energy Open Access Solar in India (100 kW+) | Greenedge Infratech',
    'description' => 'Buy solar power from an off-site plant through green energy open access. For consumers with 100 kW or more contracted demand. Captive, group captive and third-party PPA models explained.',
    'path' => '/open-access-solar', 'nav' => 'services',
    'crumbs' => [['Solutions', '/services'], ['Green energy open access', '/open-access-solar']],
    'schema' => [['@context' => 'https://schema.org', '@type' => 'Service', 'name' => 'Green energy open access solar', 'provider' => ['@id' => SITE_URL . '/#business'], 'areaServed' => ['@type' => 'Country', 'name' => 'India'], 'url' => SITE_URL . '/open-access-solar']],
];
include __DIR__ . '/inc/header.php';
ui_hero([
    'eyebrow' => 'Green energy open access',
    'title' => 'Solar power for your plant &ndash; even without a roof',
    'sub' => 'Open access lets a large consumer buy electricity from a solar plant located elsewhere, delivered through the transmission and distribution network. Under India&rsquo;s Green Energy Open Access Rules, consumers with <strong class="text-white">100 kW or more</strong> contracted demand can buy green power this way, implemented through each state&rsquo;s electricity regulatory commission.',
    'badges' => ['100 kW+ contracted demand', 'Captive, group captive, third-party', 'Larger savings at scale', 'Supports RE / ESG targets'],
    'ctas' => [['#enquire', 'Request a feasibility study', 'btn-accent', 'cta_oa'], ['#models', 'See open access models', 'btn-outline-light', 'cta_oa_models']],
]);
?>
<section class="container mx-auto px-4 py-16">
  <?php ui_heading('Rooftop vs open access', 'Most large consumers use both: rooftop solar for on-site generation, and open access to go further.'); ?>
  <div class="grid gap-6 mt-10 lg:grid-cols-2">
    <div class="card p-6"><h3 class="text-xl font-bold">Rooftop / on-site</h3><ul class="mt-4 space-y-2 text-sm text-slate-700 tick-list"><li>Limited by your roof or land area</li><li>No grid charges on units used on site</li><li>Quick to install</li><li>Works for any size from a few kW</li></ul><a class="text-green-700 font-semibold mt-4 inline-block" href="/industrial-solar">Industrial rooftop solar &rarr;</a></div>
    <div class="card p-6 border-green-300"><h3 class="text-xl font-bold">Open access / off-site</h3><ul class="mt-4 space-y-2 text-sm text-slate-700 tick-list"><li>Plant size not limited by your premises</li><li>Grid charges and surcharges apply, as set by your state regulator</li><li>Needs regulatory approvals and scheduling</li><li>For consumers with 100 kW+ contracted demand</li></ul></div>
  </div>
</section>

<section id="models" class="bg-slate-50 scroll-mt-24">
  <div class="container mx-auto px-4 py-16">
    <?php ui_heading('Open access models'); ?>
    <?php ui_cards([
        ['Captive', 'You (or your group company) own the solar plant and consume its power. Captive status depends on meeting ownership and consumption conditions in the Electricity Rules.'],
        ['Group captive', 'Several consumers jointly hold equity in a plant and share its output, each meeting the captive conditions. Useful for MSME clusters.'],
        ['Third-party PPA', 'A developer owns the plant and sells you power under a long-term agreement at an agreed tariff, with no investment from you.'],
    ]); ?>
  </div>
</section>

<section class="container mx-auto px-4 py-16 grid lg:grid-cols-2 gap-10 items-start">
  <div>
    <h2 class="section-title">What affects open access savings</h2>
    <ul class="mt-6 space-y-3 tick-list text-slate-700">
      <li>Your current tariff and time-of-day pattern of use</li>
      <li>Transmission and wheeling charges and losses</li>
      <li>Cross-subsidy surcharge and additional surcharge (green open access rules give relief in some cases)</li>
      <li>Banking provisions and charges for surplus energy</li>
      <li>Scheduling, metering and SLDC requirements</li>
      <li>The solar tariff from the plant and the contract term</li>
    </ul>
    <p class="mt-6 text-sm text-slate-600">Each state regulator sets its own charges and procedures, and they change often. We model the charges that apply in your state on the day of your study.</p>
    <?php ui_sources([['Ministry of Power', 'https://powermin.gov.in']]); ?>
  </div>
  <div class="card p-6">
    <h3 class="text-xl font-bold text-slate-900">How Greenedge helps</h3>
    <ol class="mt-4 space-y-3 text-sm text-slate-700 list-decimal pl-5">
      <li>Eligibility check and analysis of your bills and load data</li>
      <li>Landed-cost model comparing grid power, rooftop and open access</li>
      <li>Choice of model: captive, group captive or third-party PPA</li>
      <li>Plant development or tie-up with a solar developer</li>
      <li>Support with open access application, approvals and agreements</li>
      <li>Commissioning, monitoring and reporting of green energy consumed</li>
    </ol>
  </div>
</section>

<?php ui_enquiry(['type' => 'quotation', 'category' => 'industrial', 'business' => true, 'message' => true, 'heading' => 'Request an open access feasibility study', 'button' => 'Request Feasibility Study'],
    'Is open access viable for you?',
    'Share your contracted demand and monthly consumption. We will tell you whether open access makes sense, which model fits, and the likely landed cost of solar power.',
    ['Landed-cost comparison in writing', 'Rooftop + open access combined plan', 'Help through approvals']); ?>

<?php ui_faqs([
    ['Who is eligible for green energy open access?', 'Consumers with a contracted demand or sanctioned load of 100 kW or more, under the Electricity (Promoting Renewable Energy Through Green Energy Open Access) Rules, 2022, as implemented by your state electricity regulatory commission. Captive consumers have no minimum limit.'],
    ['Do I need my own land?', 'No. Under a third-party PPA, the developer builds the plant on its land. Under captive models you hold equity in the plant.'],
    ['Will I still get power from the DISCOM?', 'Yes. You stay connected to your DISCOM, which supplies any power not covered by open access.'],
    ['How long does it take?', 'Developing a plant and completing approvals typically takes several months. We give you a realistic timeline after the feasibility study.'],
]); ?>
<?php ui_related('/open-access-solar'); ?>
<?php include __DIR__ . '/inc/footer.php'; ?>
