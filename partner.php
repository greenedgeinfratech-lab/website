<?php
require __DIR__ . '/inc/config.php';
require __DIR__ . '/inc/ui.php';
$page = [
    'title' => 'Partner With Greenedge Infratech: Solar Dealers, Installers, Referral & Investment Partners',
    'description' => 'Join the Greenedge partner network across India as a solar channel partner, installer, referral partner, investor or supplier. Design support, PM Surya Ghar process support, training, marketing and timely payouts.',
    'path' => '/partner', 'nav' => 'partner',
    'crumbs' => [['Partner with us', '/partner']],
];
include __DIR__ . '/inc/header.php';
ui_hero([
    'eyebrow' => 'Greenedge partner programme',
    'title' => 'Grow your business with solar &ndash; with Greenedge behind you',
    'sub' => 'Solar is one of the fastest-growing markets in India and worldwide, from rooftop homes to factories and government buildings. Partner with us to win and deliver more projects, while we provide the engineering, approvals, supply and after-sales strength.',
    'badges' => ['Channel partners', 'Installers &amp; EPC teams', 'Referral partners', 'Investors &amp; suppliers'],
    'ctas' => [['#apply', 'Apply to partner', 'btn-accent', 'cta_partner_apply'], ['#types', 'Partnership types', 'btn-outline-light', 'cta_partner_types']],
    'image' => '/assets/image/Partner-with-Us.jpg',
]);
?>
<section id="types" class="container mx-auto px-4 py-16 scroll-mt-24">
  <?php ui_heading('Ways to partner with us', 'Pick the model that fits your business. Many partners start with referrals and grow into full channel partners.'); ?>
  <div class="grid gap-6 mt-10 md:grid-cols-2 lg:grid-cols-3">
    <?php foreach ([
      ['Channel partner / dealer', 'For electrical, electronics, inverter and battery dealers, and entrepreneurs who want a solar business in their town.', ['Sell Greenedge solar systems in your area', 'Partner pricing on complete systems', 'We support design, approvals and installation', 'Earn on every project you close']],
      ['Installer / EPC sub-contractor', 'For trained installation teams and small EPC firms anywhere in India.', ['Regular installation work orders', 'Standard drawings, methods and safety checklists', 'Training on our quality standards', 'Clear rates and on-time payment for completed work']],
      ['Referral partner', 'For architects, builders, electricians, CAs, consultants, society office-bearers and anyone with a network.', ['Introduce homes, societies or businesses', 'We do the selling, survey and delivery', 'Referral reward on every converted project', 'Track your referrals with our team']],
      ['Investor / RESCO finance partner', 'For investors, NBFCs and developers looking for solar assets with long-term returns.', ['Pipeline of RESCO-ready commercial, industrial and institutional sites', 'Engineering, construction and O&amp;M by Greenedge', 'Generation monitoring and reporting', 'Structured PPAs with creditworthy offtakers']],
      ['Supplier / manufacturer', 'For module, inverter, structure, cable and battery brands.', ['Projects across homes, C&amp;I and government', 'Product feedback from the field', 'Joint marketing with our partner network']],
      ['Institutional partner', 'For banks, NGOs, CSR teams, colleges and industry associations.', ['Solar awareness and loan camps', 'CSR solar projects for schools and health centres', 'Training and internships for students']],
    ] as $p): ?>
    <div class="card p-6 flex flex-col">
      <h3 class="text-xl font-bold text-slate-900"><?= $p[0] ?></h3>
      <p class="mt-2 text-sm text-slate-600"><?= $p[1] ?></p>
      <ul class="mt-4 space-y-2 text-sm text-slate-700 tick-list flex-1"><?php foreach ($p[2] as $li): ?><li><?= $li ?></li><?php endforeach; ?></ul>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="bg-slate-50">
  <div class="container mx-auto px-4 py-16">
    <?php ui_heading('What partners get from Greenedge'); ?>
    <?php ui_cards([
        ['Engineering support', 'System design, shadow analysis, structural guidance and bill-of-materials for your customers&rsquo; projects.'],
        ['Scheme and approval know-how', 'DISCOM net metering, state agency documentation and, in Uttar Pradesh, our PM Surya Ghar vendor processes, so your customers&rsquo; paperwork is done right.'],
        ['Quality supply', 'ALMM-listed panels, reputed inverters and galvanised structures through our supply chain.'],
        ['Training', 'Product, sales and installation training, including safety practices, for you and your team.'],
        ['Marketing material', 'Brochures, social media creatives, the Greenedge calculator and local lead support.'],
        ['After-sales backing', 'Service and maintenance support so your customers stay happy and refer others.'],
        ['Transparent earnings', 'Clear partner pricing, referral rewards or job rates agreed in writing, and timely payouts.'],
        ['Bigger projects', 'Access to commercial, industrial, RWA and government opportunities you could not take on alone.'],
        ['Long-term relationship', 'A dedicated partner manager and regular reviews as your solar business grows.'],
    ]); ?>
  </div>
</section>

<section class="container mx-auto px-4 py-16">
  <?php ui_heading('How to become a partner'); ?>
  <?php ui_steps([
      ['Apply online', 'Fill in the short form below with your business details and the type of partnership you want.'],
      ['Introductory call', 'Our partnerships team calls you within two working days to understand your business and area.'],
      ['Meeting &amp; agreement', 'We meet, agree the model, territory and terms in writing.'],
      ['Onboarding &amp; training', 'Product, process and safety training, plus marketing material.'],
      ['First project together', 'We support you closely on your first projects, from survey to commissioning.'],
      ['Grow', 'Regular reviews, more projects and bigger opportunities.'],
  ]); ?>
</section>

<section id="apply" class="bg-green-50 scroll-mt-24">
  <div class="container mx-auto px-4 py-14 grid lg:grid-cols-[1fr_1.2fr] gap-10 items-start">
    <div>
      <h2 class="section-title">Apply to become a Greenedge partner</h2>
      <p class="mt-3 text-slate-700">We are building our partner network across India and abroad. Tell us about yourself and we will be in touch.</p>
      <h3 class="font-bold text-slate-900 mt-8">What we look for</h3>
      <ul class="mt-3 space-y-2 tick-list text-slate-700">
        <li>Honest dealing with customers</li>
        <li>A local presence and network in your area</li>
        <li>For installers: trained electricians and safe working practices</li>
        <li>Willingness to follow our quality and documentation standards</li>
      </ul>
      <p class="mt-6 text-sm text-slate-600">Questions? Call <a class="font-semibold text-green-800 underline" href="tel:<?= BIZ_PHONE ?>"><?= BIZ_PHONE_DISPLAY ?></a> or email <a class="font-semibold text-green-800 underline" href="mailto:<?= BIZ_EMAIL ?>"><?= BIZ_EMAIL ?></a>.</p>
    </div>
    <?php $lf = ['partner' => true, 'type' => 'partner', 'heading' => 'Partner application', 'sub' => 'Takes two minutes. Our partnerships team will call you within two working days.', 'button' => 'Submit Application']; include __DIR__ . '/inc/lead-form.php'; ?>
  </div>
</section>

<?php ui_faqs([
    ['Is there a fee to become a partner?', 'There is no fee to apply. Any commercial terms for a partnership are discussed and agreed in writing before you start.'],
    ['Do I need solar experience?', 'Not for referral partnerships. Channel partners and installers with electrical experience can be trained on solar.'],
    ['Which areas are you looking for partners in?', 'We welcome partners from every state in India and from other countries.'],
    ['How are referral rewards paid?', 'Referral rewards are paid after the referred project is completed and paid for, as per the terms agreed with you.'],
]); ?>
<?php include __DIR__ . '/inc/footer.php'; ?>
