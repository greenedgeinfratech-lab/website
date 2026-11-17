<?php
require __DIR__ . '/inc/config.php';
$page = [
    'title' => 'Contact Greenedge Infratech | Free Solar Site Survey | +91 98370 67681',
    'description' => 'Call, WhatsApp or write to Greenedge Infratech for a free rooftop solar site survey, quotation or PM Surya Ghar help. Open Monday to Saturday, 9 AM to 6 PM.',
    'path' => '/contact',
    'nav' => 'contact',
    'crumbs' => [['Contact', '/contact']],
];
include __DIR__ . '/inc/header.php';
?>
<section class="container mx-auto px-4 py-12 grid lg:grid-cols-[1fr_1.2fr] gap-10 items-start">
  <div>
    <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Talk to a solar expert</h1>
    <p class="mt-3 text-slate-600">Ask about a free site survey, a quotation, PM Surya Ghar subsidy or service for an existing system. We usually call back within one working day.</p>
    <div class="mt-8 space-y-4">
      <a href="tel:<?= BIZ_PHONE ?>" class="card p-5 flex items-center justify-between hover:shadow-lg" data-track="phone_click">
        <span><span class="block text-sm text-slate-500">Call</span><span class="text-xl font-bold"><?= BIZ_PHONE_DISPLAY ?></span></span><span class="text-green-700 font-semibold">Call now &rarr;</span></a>
      <a href="<?= e(wa_link('Hello Greenedge, I would like to know about rooftop solar.')) ?>" target="_blank" rel="noopener" class="card p-5 flex items-center justify-between hover:shadow-lg" data-track="whatsapp_click">
        <span><span class="block text-sm text-slate-500">WhatsApp</span><span class="text-xl font-bold"><?= BIZ_PHONE_DISPLAY ?></span></span><span class="text-green-700 font-semibold">Chat &rarr;</span></a>
      <a href="mailto:<?= BIZ_EMAIL ?>" class="card p-5 flex items-center justify-between hover:shadow-lg">
        <span><span class="block text-sm text-slate-500">Email</span><span class="text-lg font-bold break-all"><?= BIZ_EMAIL ?></span></span></a>
      <div class="card p-5">
        <p class="text-sm text-slate-500">Office</p>
        <address class="not-italic font-semibold mt-1"><?= e(BIZ_NAME) ?><br><?= e(BIZ_STREET) ?>,<br><?= e(BIZ_CITY) ?>, <?= e(BIZ_REGION) ?> <?= e(BIZ_PIN) ?></address>
        <p class="text-sm text-slate-600 mt-2"><?= e(BIZ_HOURS) ?></p>
        <a class="text-green-700 font-semibold text-sm mt-2 inline-block" target="_blank" rel="noopener" href="https://www.google.com/maps/search/?api=1&amp;query=<?= rawurlencode('Greenedge Infratech ' . BIZ_STREET . ' ' . BIZ_CITY) ?>">Open in Google Maps &rarr;</a>
      </div>
      <p class="text-sm text-slate-600">We take up projects across India and abroad through our own team and partner network. Tell us your city and we will confirm how we can serve you.</p>
    </div>
  </div>
  <?php $lf = ['type' => 'callback', 'message' => true, 'heading' => 'Send us your enquiry', 'button' => 'Send Enquiry']; include __DIR__ . '/inc/lead-form.php'; ?>
</section>
<?php include __DIR__ . '/inc/footer.php'; ?>
