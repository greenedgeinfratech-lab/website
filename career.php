<?php
require __DIR__ . '/inc/config.php';
$page = [
    'title' => 'Careers & Internships at Greenedge Infratech, Aligarh | Solar Jobs',
    'description' => 'Solar site engineer jobs and electrical / renewable energy internships with Greenedge Infratech in Aligarh and Western Uttar Pradesh.',
    'path' => '/career', 'crumbs' => [['Careers', '/career']],
];
$roles = [
  ['Solar Site Engineer / Supervisor', 'Full time', 'Aligarh &amp; Western UP', 'Supervise rooftop solar sites: mounting structure erection, DC/AC cabling, earthing, inverter commissioning and quality checks. Coordinate with customers and DISCOM inspections.', ['Diploma / B.Tech in Electrical or related field', 'Site experience in solar or electrical work preferred', 'Two-wheeler and willingness to travel in Western UP']],
  ['Solar Technical Intern (Electrical / Renewable)', 'Internship', 'Aligarh', 'Hands-on internship for diploma and degree students: site feasibility surveys, system design basics and subsidy documentation.', ['Electrical / renewable energy students', 'Certificate of completion', 'Stipend based on performance and fieldwork']],
];
include __DIR__ . '/inc/header.php';
?>
<section class="container mx-auto px-4 py-12 max-w-4xl">
  <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Work with Greenedge</h1>
  <p class="mt-2 text-slate-600">Help homes and businesses in Western UP switch to solar.</p>
  <div class="mt-8 space-y-6">
  <?php foreach ($roles as $i => $r): ?>
    <section id="<?= $i ? 'internship' : 'jobs' ?>" class="card p-6 scroll-mt-24">
      <h2 class="text-xl font-bold"><?= $r[0] ?></h2>
      <p class="text-sm text-slate-500 mt-1"><?= $r[1] ?> &middot; <?= $r[2] ?></p>
      <p class="mt-3 text-slate-700"><?= $r[3] ?></p>
      <ul class="mt-3 list-disc pl-5 text-slate-700"><?php foreach ($r[4] as $li): ?><li><?= e($li) ?></li><?php endforeach; ?></ul>
      <a class="btn-primary mt-4 inline-flex" href="mailto:<?= BIZ_EMAIL ?>?subject=<?= rawurlencode('Application: ' . html_entity_decode($r[0])) ?>">Apply by email</a>
    </section>
  <?php endforeach; ?>
  </div>
  <p class="text-sm text-slate-500 mt-6">Send your CV and a short note about your experience to <?= BIZ_EMAIL ?>.</p>
</section>
<?php include __DIR__ . '/inc/footer.php';
