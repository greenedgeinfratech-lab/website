<?php
require __DIR__ . '/inc/config.php';
require __DIR__ . '/inc/ui.php';
$page = [
    'title' => 'About Greenedge Infratech | Solar & Sustainability Company since 2016',
    'description' => 'Greenedge Infratech Private Limited: a solar EPC and sustainability company founded in 2016. Registered PM Surya Ghar vendor in Uttar Pradesh, serving homes, societies, businesses, industry and government in India and abroad.',
    'path' => '/about', 'nav' => 'about',
    'crumbs' => [['About', '/about']],
];
include __DIR__ . '/inc/header.php';
ui_hero([
    'eyebrow' => 'About Greenedge Infratech',
    'title' => 'Building a clean energy future, one roof at a time',
    'sub' => 'Greenedge Infratech Private Limited is a solar EPC and sustainability company headquartered in Aligarh. Since ' . BIZ_SINCE . ' we have helped homes, institutions, businesses and public bodies plan, build and maintain clean-energy solutions.',
    'badges' => ['Founded ' . BIZ_SINCE, BIZ_INSTALLS . ' solar installations', 'PM Surya Ghar registered vendor (Uttar Pradesh)', 'Head office: Aligarh'],
]);
?>
<section class="container mx-auto px-4 py-16 grid lg:grid-cols-2 gap-10 items-center">
  <div class="prose-lite">
    <h2 class="!mt-0">Who we are</h2>
    <p>Greenedge Infratech was founded in 2016 by Dr. Gyanendra Mishra, philanthropist and President of UDAAN Society, with a simple belief: sustainable development is the need of the hour, and it takes a collective, determined effort to bring the change we all want to see.</p>
    <p>We started as a sustainability consultancy, helping architects, planners, builders and organisations design greener spaces. Today our main focus is solar energy &ndash; designing, installing and maintaining solar power plants for residential, housing society, commercial, industrial, institutional and government customers across India and abroad.</p>
    <p>As a registered vendor under PM Surya Ghar: Muft Bijli Yojana in Uttar Pradesh, we support the Government of India&rsquo;s mission of free, clean electricity for households, and guide every customer through application, inspection and subsidy.</p>
    <p>Our clients have included educational institutions, hospitals, companies and government agencies, alongside hundreds of homes.</p>
  </div>
  <img src="/assets/installation-team.jpg" alt="Greenedge Infratech solar installation team at work" loading="lazy" width="800" height="600" class="rounded-xl shadow-lg w-full object-cover">
</section>

<section class="bg-slate-50">
  <div class="container mx-auto px-4 py-16 grid gap-6 lg:grid-cols-3">
    <div class="card p-6"><p class="eyebrow">Vision</p><p class="mt-2 text-slate-700">To promote sustainable, affordable, carbon-free renewable energy for our customers, communities, nation and planet, for a safe and healthy environment.</p></div>
    <div class="card p-6"><p class="eyebrow">Mission</p><p class="mt-2 text-slate-700">To make solar energy affordable, accessible and hassle-free for every home, business and institution in India &ndash; through technical excellence, transparent dealing and dependable after-sales service &ndash; while treading lightly on the planet in our own operations.</p></div>
    <div class="card p-6"><p class="eyebrow">Core values</p><ul class="mt-2 space-y-2 text-slate-700 tick-list"><li><strong>Integrity is our identity:</strong> we deliver what we commit.</li><li><strong>Nature friendly:</strong> protect nature and be protected.</li><li><strong>Results oriented:</strong> on time, every time.</li></ul></div>
  </div>
</section>

<section class="container mx-auto px-4 py-16">
  <?php ui_heading('What we do', 'End-to-end capability across every solar segment and business model.'); ?>
  <?php ui_cards(array_map(fn($s) => [e($s[1]), e($s[2]), $s[0], 'Explore'], GE_SOLUTIONS), 'sm:grid-cols-2 lg:grid-cols-5'); ?>
</section>

<section class="bg-green-900 text-white">
  <div class="container mx-auto px-4 py-16 grid lg:grid-cols-2 gap-10">
    <div>
      <h2 class="text-3xl font-extrabold">How we work</h2>
      <ul class="mt-6 space-y-4 text-green-50">
        <li><strong class="text-white">Engineering before selling.</strong> Every proposal starts from real bills, load data and a site survey.</li>
        <li><strong class="text-white">Transparency.</strong> Itemised quotations with brands and models, and estimates that show their assumptions.</li>
        <li><strong class="text-white">Safety and quality.</strong> Trained installers, proper earthing and protection, and documented checks at commissioning.</li>
        <li><strong class="text-white">Compliance.</strong> ALMM-listed equipment, scheme specifications and DISCOM requirements followed on every project.</li>
        <li><strong class="text-white">Long-term care.</strong> We stay with our customers through monitoring and maintenance for the life of the plant.</li>
      </ul>
    </div>
    <div>
      <h2 class="text-3xl font-extrabold">Where we work</h2>
      <p class="mt-6 text-green-50">From our head office in Aligarh we take up projects across India and abroad with our own engineering team and a growing network of installation and service partners. Commercial, industrial, open access and government projects are taken up across the state.</p>
      <address class="not-italic mt-6 card p-5 text-slate-800 bg-white">
        <strong><?= e(BIZ_NAME) ?></strong><br><?= e(BIZ_STREET) ?>, <?= e(BIZ_CITY) ?>, <?= e(BIZ_REGION) ?> <?= e(BIZ_PIN) ?><br>
        <a class="text-green-700 font-semibold" href="tel:<?= BIZ_PHONE ?>"><?= BIZ_PHONE_DISPLAY ?></a> &middot; <a class="text-green-700 font-semibold break-all" href="mailto:<?= BIZ_EMAIL ?>"><?= BIZ_EMAIL ?></a>
      </address>
    </div>
  </div>
</section>

<section class="container mx-auto px-4 py-16 text-center">
  <h2 class="section-title">Work with us</h2>
  <p class="mt-3 text-slate-600 max-w-2xl mx-auto">Whether you want solar for your home, society, business or department &ndash; or want to grow with us as a partner &ndash; we would like to hear from you.</p>
  <div class="mt-6 flex flex-wrap gap-3 justify-center"><a href="/contact" class="btn-primary">Contact us</a><a href="/partner" class="btn-secondary">Partner with us</a><a href="/career" class="btn-secondary">Careers</a></div>
</section>
<?php include __DIR__ . '/inc/footer.php'; ?>
