<?php
require __DIR__ . '/inc/config.php';
require __DIR__ . '/inc/ui.php';
$groups = [];
foreach (GE_SOLUTIONS as $s) $groups[$s[3]][] = $s;
$page = [
    'title' => 'Solar Solutions & Services in India and Abroad | Greenedge Infratech',
    'description' => 'All Greenedge solar solutions: home rooftop solar, PM Surya Ghar, housing societies, commercial, industrial, zero-investment RESCO, open access, government buildings, solar pumps and maintenance.',
    'path' => '/services', 'nav' => 'services',
    'crumbs' => [['Solutions', '/services']],
    'schema' => [[
        '@context' => 'https://schema.org', '@type' => 'ItemList',
        'itemListElement' => array_map(fn($i, $s) => ['@type' => 'ListItem', 'position' => $i + 1, 'url' => SITE_URL . $s[0], 'name' => $s[1]], array_keys(GE_SOLUTIONS), GE_SOLUTIONS),
    ]],
];
include __DIR__ . '/inc/header.php';
ui_hero([
    'eyebrow' => 'Solutions',
    'title' => 'Complete solar solutions, from a 1 kW home system to MW-scale plants',
    'sub' => 'Design, supply, installation, approvals, financing models and maintenance &ndash; delivered by one accountable team.',
    'ctas' => [['/calculator', 'Calculate savings', 'btn-accent', 'cta_calculator'], ['/contact?type=site-survey', 'Book a free survey', 'btn-outline-light', 'cta_site_survey']],
]);
?>
<?php foreach ($groups as $g => $items): ?>
<section class="container mx-auto px-4 py-12">
  <h2 class="section-title"><?= e($g) ?></h2>
  <?php ui_cards(array_map(fn($s) => [e($s[1]), e($s[2]), $s[0], 'Explore'], $items), 'sm:grid-cols-2 lg:grid-cols-4'); ?>
</section>
<?php endforeach; ?>

<section class="bg-slate-50">
  <div class="container mx-auto px-4 py-16">
    <?php ui_heading('What every project includes', 'Whatever the size, you get the same end-to-end service.'); ?>
    <?php ui_cards([
        ['Energy assessment', 'Bills, load profile, sanctioned load and tariff analysis to size the plant correctly.'],
        ['Design &amp; engineering', 'Shadow analysis, layout, structural check, electrical single-line diagram and yield estimate.'],
        ['Quality equipment', 'ALMM-listed modules (DCR where required), reputed inverters, galvanised structures and proper protection.'],
        ['Approvals', 'PM Surya Ghar portal, DISCOM feasibility, net metering, state nodal agency and other approvals.'],
        ['Installation &amp; commissioning', 'Trained teams, safety practices, testing and DISCOM inspection.'],
        ['Finance options', 'CAPEX, bank loans, zero-investment RESCO and open access structures.'],
        ['Monitoring', 'App or web monitoring of generation and faults.'],
        ['Operation &amp; maintenance', 'Cleaning, preventive checks, repairs and performance reports.'],
    ], 'sm:grid-cols-2 lg:grid-cols-4'); ?>
    <p class="text-center mt-10"><a href="/products" class="font-semibold text-green-700">Panels, inverters, batteries &amp; pumps we supply &rarr;</a></p>
  </div>
</section>

<?php ui_enquiry(['type' => 'site-survey', 'message' => true, 'heading' => 'Tell us about your requirement', 'button' => 'Send Requirement'],
    'Not sure which solution fits?',
    'Describe your building or site and your monthly bill. We will recommend the right system and business model.'); ?>
<?php include __DIR__ . '/inc/footer.php'; ?>
