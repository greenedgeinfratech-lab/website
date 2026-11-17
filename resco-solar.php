<?php
require __DIR__ . '/inc/config.php';
require __DIR__ . '/inc/ui.php';
$page = [
    'title' => 'Zero-Investment Solar (RESCO / OPEX PPA) in India | Greenedge Infratech',
    'description' => 'Go solar with no upfront cost under the RESCO (OPEX) model. The developer builds, owns and maintains the plant; you pay a fixed tariff per unit below your grid rate. For industries, institutions, societies and government buildings.',
    'path' => '/resco-solar', 'nav' => 'services',
    'crumbs' => [['Solutions', '/services'], ['Zero-investment solar (RESCO)', '/resco-solar']],
    'schema' => [['@context' => 'https://schema.org', '@type' => 'Service', 'name' => 'RESCO / OPEX rooftop solar', 'provider' => ['@id' => SITE_URL . '/#business'], 'areaServed' => ['@type' => 'Country', 'name' => 'India'], 'url' => SITE_URL . '/resco-solar']],
];
include __DIR__ . '/inc/header.php';
ui_hero([
    'eyebrow' => 'RESCO &bull; OPEX &bull; Power Purchase Agreement',
    'title' => 'Solar with zero investment: pay only for the power',
    'sub' => 'Under the RESCO model, the solar plant on your roof is financed, built, owned and maintained by a renewable energy service company. You sign a long-term Power Purchase Agreement (PPA) and pay a fixed tariff for each unit &ndash; set below what you pay the grid.',
    'badges' => ['No capital outlay', 'Savings from day one', 'Maintenance included', 'Fixed tariff for the contract term'],
    'ctas' => [['#enquire', 'Check if my site qualifies', 'btn-accent', 'cta_resco'], ['#compare', 'Compare CAPEX vs RESCO', 'btn-outline-light', 'cta_compare']],
]);
?>
<section class="container mx-auto px-4 py-16">
  <?php ui_heading('How RESCO works', 'Greenedge develops RESCO projects with financing partners and delivers the engineering, construction and long-term maintenance.'); ?>
  <?php ui_steps([
      ['Site and bill assessment', 'We confirm roof or land area, structure, daytime load, tariff and payment track record.'],
      ['Tariff offer', 'You receive a per-unit tariff, contract term and any annual escalation, with projected savings against your grid tariff.'],
      ['PPA signing', 'A long-term agreement covers tariff, term, roof access, insurance, performance and what happens at the end of the term.'],
      ['Build at no cost to you', 'The developer funds equipment and installation; we handle design, approvals and construction.'],
      ['Pay per unit', 'Each month you pay only for the solar units supplied, read from a dedicated meter.'],
      ['Maintenance for the term', 'Cleaning, repairs, monitoring and insurance are the developer&rsquo;s responsibility for the contract period.'],
  ]); ?>
</section>

<section id="compare" class="bg-slate-50 scroll-mt-24">
  <div class="container mx-auto px-4 py-16">
    <?php ui_heading('CAPEX, loan or RESCO: which suits you?', 'There is no single best answer. Here is how the options compare in general; our proposal shows the numbers for your site.'); ?>
    <div class="overflow-x-auto mt-10">
      <table class="w-full text-sm bg-white rounded-xl overflow-hidden border border-slate-200 min-w-[720px]">
        <thead class="bg-green-700 text-white"><tr><th class="p-3 text-left w-1/4"></th><th class="p-3 text-left">Own it (CAPEX)</th><th class="p-3 text-left">Own it with a loan</th><th class="p-3 text-left">Zero investment (RESCO)</th></tr></thead>
        <tbody class="divide-y">
          <tr><td class="p-3 font-semibold">Upfront cost</td><td class="p-3">Full plant cost</td><td class="p-3">Margin money only</td><td class="p-3">None</td></tr>
          <tr><td class="p-3 font-semibold">Who owns the plant</td><td class="p-3">You</td><td class="p-3">You (bank has a charge)</td><td class="p-3">Developer, for the contract term</td></tr>
          <tr><td class="p-3 font-semibold">What you pay</td><td class="p-3">Nothing after purchase, except O&amp;M</td><td class="p-3">EMI for the loan tenure</td><td class="p-3">Fixed tariff per unit used</td></tr>
          <tr><td class="p-3 font-semibold">Lifetime savings</td><td class="p-3">Highest</td><td class="p-3">High</td><td class="p-3">Moderate, but immediate</td></tr>
          <tr><td class="p-3 font-semibold">Tax depreciation</td><td class="p-3">Yes, to the owner (if eligible)</td><td class="p-3">Yes, to the owner (if eligible)</td><td class="p-3">Goes to the developer</td></tr>
          <tr><td class="p-3 font-semibold">Maintenance</td><td class="p-3">Your responsibility (AMC available)</td><td class="p-3">Your responsibility (AMC available)</td><td class="p-3">Developer&rsquo;s responsibility</td></tr>
          <tr><td class="p-3 font-semibold">Commitment</td><td class="p-3">None</td><td class="p-3">Loan tenure</td><td class="p-3">Long-term PPA, often 15&ndash;25 years</td></tr>
          <tr><td class="p-3 font-semibold">Best for</td><td class="p-3">Homes and businesses with funds</td><td class="p-3">Homes, MSMEs</td><td class="p-3">Industries, institutions, societies, government buildings</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<section class="container mx-auto px-4 py-16 grid lg:grid-cols-2 gap-10 items-start">
  <div>
    <h2 class="section-title">Who RESCO is for</h2>
    <ul class="mt-6 space-y-3 tick-list text-slate-700">
      <li>Factories and warehouses with large, strong roofs and steady daytime load</li>
      <li>Schools, colleges, hospitals and hotels that prefer to keep capital for their core work</li>
      <li>Housing societies wanting lower common-area costs without a special levy on residents</li>
      <li>Government buildings and PSUs, where state policies increasingly promote solar through CAPEX and RESCO models</li>
    </ul>
    <p class="mt-6 text-sm text-slate-600">Developers usually look for a sufficient plant size (often tens of kW or more), a roof with long remaining life, clear ownership, and a good bill-payment record.</p>
  </div>
  <div class="card p-6">
    <h3 class="text-xl font-bold text-slate-900">What to check in a PPA</h3>
    <ul class="mt-4 space-y-2 text-sm text-slate-700 tick-list">
      <li>Tariff, escalation (if any) and the grid tariff it is compared with</li>
      <li>Contract term and early-exit or buy-out options</li>
      <li>Minimum offtake or deemed-generation clauses</li>
      <li>Roof access, insurance and responsibility for roof repairs</li>
      <li>Performance guarantees and monitoring access for you</li>
      <li>Ownership transfer at the end of the term</li>
    </ul>
    <p class="mt-4 text-xs text-slate-500">We explain every clause in plain language before you sign. Take independent legal advice for large contracts.</p>
  </div>
</section>

<?php ui_enquiry(['type' => 'quotation', 'category' => 'industrial', 'business' => true, 'message' => true, 'heading' => 'Check if your site qualifies for RESCO', 'button' => 'Check My Site'],
    'Is zero-investment solar right for you?',
    'Share your details, roof or land area and monthly bill. We will tell you whether a RESCO plant is viable, the likely tariff range, and how it compares with owning the plant.',
    ['No-cost assessment', 'RESCO and CAPEX compared honestly', 'Single contact through construction and O&amp;M']); ?>

<?php ui_faqs([
    ['What does RESCO stand for?', 'Renewable Energy Service Company &ndash; a company that invests in, owns and operates a renewable energy plant and sells the power to the consumer under a PPA.'],
    ['Is RESCO available for homes?', 'It is mainly used for commercial, industrial, institutional and government sites. Homes usually get better value from the PM Surya Ghar subsidy and collateral-free bank loans.'],
    ['What happens if we move or close the site?', 'The PPA sets out exit and buy-out terms. Check these carefully before signing; we walk you through them.'],
    ['Who pays for repairs and cleaning?', 'Under RESCO, maintenance, repairs and insurance of the plant are the developer&rsquo;s responsibility for the contract term.'],
]); ?>
<?php ui_related('/resco-solar'); ?>
<?php include __DIR__ . '/inc/footer.php'; ?>
