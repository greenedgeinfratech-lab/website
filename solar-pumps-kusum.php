<?php
require __DIR__ . '/inc/config.php';
require __DIR__ . '/inc/ui.php';
$page = [
    'title' => 'Solar Water Pumps & PM-KUSUM in Uttar Pradesh | Greenedge Infratech',
    'description' => 'Solar irrigation pumps, grid-connected pump solarisation and farm solar plants in Uttar Pradesh. PM-KUSUM components A, B and C explained, with help for farmers to apply.',
    'path' => '/solar-pumps-kusum', 'nav' => 'services',
    'crumbs' => [['Solutions', '/services'], ['Solar pumps & PM-KUSUM', '/solar-pumps-kusum']],
    'schema' => [['@context' => 'https://schema.org', '@type' => 'Service', 'name' => 'Solar water pumps and PM-KUSUM installations', 'provider' => ['@id' => SITE_URL . '/#business'], 'areaServed' => 'Uttar Pradesh', 'url' => SITE_URL . '/solar-pumps-kusum']],
];
include __DIR__ . '/inc/header.php';
ui_hero([
    'eyebrow' => 'Agriculture &amp; rural solar',
    'title' => 'Irrigate with the sun, not diesel',
    'sub' => 'Solar pumps give farmers free daytime water pumping for 20+ years, with no fuel bills. Under PM-KUSUM, central and state governments share the cost of solar pumps and farm solar plants for eligible farmers.',
    'badges' => ['Submersible &amp; surface pumps', '1&ndash;10 HP and above', 'PM-KUSUM guidance', 'Service in your village'],
    'ctas' => [['#enquire', 'Ask about a solar pump', 'btn-accent', 'cta_pump'], ['#kusum', 'PM-KUSUM explained', 'btn-outline-light', 'cta_kusum']],
    'image' => '/assets/image/solar-micro-pump.webp',
]);
?>
<section id="kusum" class="container mx-auto px-4 py-16 scroll-mt-24">
  <?php ui_heading('PM-KUSUM in three parts', 'PM-KUSUM (Pradhan Mantri Kisan Urja Suraksha evam Utthaan Mahabhiyan) is the Government of India&rsquo;s programme for solar in agriculture, run by MNRE and implemented in UP by state agencies.'); ?>
  <div class="grid gap-6 mt-10 lg:grid-cols-3">
    <div class="card p-6"><p class="text-xs font-semibold uppercase tracking-wider text-green-700">Component A</p><h3 class="text-xl font-bold mt-1">Solar plants on farm land</h3><p class="mt-2 text-sm text-slate-600">Small, decentralised grid-connected solar plants on barren, fallow or cultivable land of farmers, with the power sold to the DISCOM.</p></div>
    <div class="card p-6"><p class="text-xs font-semibold uppercase tracking-wider text-green-700">Component B</p><h3 class="text-xl font-bold mt-1">Standalone solar pumps</h3><p class="mt-2 text-sm text-slate-600">Off-grid solar pumps for farmers without a reliable grid connection, often replacing diesel pumps.</p></div>
    <div class="card p-6"><p class="text-xs font-semibold uppercase tracking-wider text-green-700">Component C</p><h3 class="text-xl font-bold mt-1">Solarising grid-connected pumps</h3><p class="mt-2 text-sm text-slate-600">Adding solar to existing grid pumps (individual pump solarisation), or solarising whole agricultural feeders (feeder-level solarisation). UP has been approving power purchase agreements for feeder-level projects.</p></div>
  </div>
  <p class="mt-8 text-sm text-slate-600 max-w-3xl mx-auto text-center">The government share of the pump cost is at least 30% from the centre for Component B and individual pump solarisation, with the state adding its share. Applications in UP open in rounds announced by the state; amounts, eligibility and booking rules are set for each round.</p>
  <?php ui_sources([['MNRE PM-KUSUM', 'https://pmkusum.mnre.gov.in'], ['UPNEDA', 'https://upneda.org.in']]); ?>
</section>

<section class="bg-slate-50">
  <div class="container mx-auto px-4 py-16 grid lg:grid-cols-2 gap-10 items-start">
    <div>
      <h2 class="section-title">Solar pumps we supply and install</h2>
      <ul class="mt-6 space-y-3 tick-list text-slate-700">
        <li>DC and AC submersible pumps for borewells and tube wells</li>
        <li>Surface pumps for open wells, ponds and canals</li>
        <li>Controllers with dry-run, overload and reverse-flow protection</li>
        <li>Universal solar pump controllers that can also run chaff cutters, flour mills or lights</li>
        <li>Ground structures with manual seasonal tilt for more output</li>
        <li>Pump sizing from your water depth, flow requirement and crop pattern</li>
      </ul>
    </div>
    <div>
      <h2 class="section-title">Other rural solar</h2>
      <?php ui_cards([
          ['Dairy &amp; milk chilling', 'Solar for bulk milk coolers and dairy units with long daytime loads.'],
          ['Cold storage &amp; agri-processing', 'Rooftop plants for cold stores, mills and food processing units.', '/industrial-solar'],
          ['Village &amp; community buildings', 'Panchayat bhawans, schools and health centres.', '/government-solar'],
      ], 'sm:grid-cols-1'); ?>
    </div>
  </div>
</section>

<?php ui_enquiry(['type' => 'callback', 'category' => 'agriculture', 'message' => true, 'heading' => 'Ask about a solar pump', 'button' => 'Request a Call'],
    'Talk to us about solar for your farm',
    'Tell us your village, borewell depth and the pump you use today. We will suggest the right solar pump and tell you about any open scheme round.',
    ['Pump sizing from water depth and flow', 'Help with scheme paperwork when a round opens', 'Installation and service by our team']); ?>

<?php ui_faqs([
    ['Can a solar pump run on cloudy days?', 'It runs at reduced output in cloudy weather and stops at night. Pump size and panel capacity are chosen to meet your daily water need over the season.'],
    ['How long does a solar pump last?', 'Solar panels last 25 years or more; pumps and controllers need periodic servicing like any pump.'],
    ['How do I apply for PM-KUSUM in UP?', 'The state announces application rounds with eligibility, subsidy share and booking rules. Contact us and we will help you check eligibility and prepare documents when the next round opens.'],
]); ?>
<?php ui_related('/solar-pumps-kusum'); ?>
<?php include __DIR__ . '/inc/footer.php'; ?>
