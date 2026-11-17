<?php require_once __DIR__ . '/config.php'; ?>
</main>

<section class="bg-green-800 text-white">
  <div class="container mx-auto px-4 py-10 grid gap-6 md:grid-cols-[1fr_auto] items-center">
    <div>
      <h2 class="text-2xl font-bold">Thinking about solar? Start with a free site survey.</h2>
      <p class="text-green-100 mt-1">Our engineer checks your roof, load and bill, then gives you a written quotation and subsidy guidance. No obligation.</p>
    </div>
    <div class="flex flex-wrap gap-3">
      <a href="/contact?type=site-survey" class="btn-light" data-track="cta_site_survey">Book a Free Site Survey</a>
      <a href="<?= e(wa_link('Hello Greenedge, I would like a free solar site survey.')) ?>" target="_blank" rel="noopener" class="btn-outline-light" data-track="whatsapp_click">WhatsApp Our Solar Expert</a>
    </div>
  </div>
</section>

<footer class="bg-slate-900 text-slate-300 text-sm">
  <div class="container mx-auto px-4 py-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
    <div>
      <p class="text-white font-bold text-lg">Greenedge Infratech</p>
      <p class="mt-2"><?= e(BIZ_NAME) ?> is a rooftop solar EPC company in Aligarh, working since <?= BIZ_SINCE ?> with homes, businesses and industries across Western Uttar Pradesh.</p>
      <p class="mt-2 text-yellow-300 font-semibold"><?= e(BIZ_PMSG_VENDOR) ?></p>
    </div>
    <div>
      <p class="text-white font-semibold mb-2">Solar solutions</p>
      <ul class="space-y-1">
        <li><a href="/services#residential" class="hover:text-white">Residential rooftop solar</a></li>
        <li><a href="/services#commercial" class="hover:text-white">Commercial solar</a></li>
        <li><a href="/services#industrial" class="hover:text-white">Industrial solar</a></li>
        <li><a href="/pmsuryaghar/" class="hover:text-white">PM Surya Ghar Yojana</a></li>
        <li><a href="/calculator" class="hover:text-white">Solar savings calculator</a></li>
        <li><a href="/products" class="hover:text-white">Panels, inverters &amp; pumps</a></li>
      </ul>
    </div>
    <div>
      <p class="text-white font-semibold mb-2">Company</p>
      <ul class="space-y-1">
        <li><a href="/about" class="hover:text-white">About us</a></li>
        <li><a href="/blogs" class="hover:text-white">Solar blog</a></li>
        <li><a href="/faq" class="hover:text-white">FAQs</a></li>
        <li><a href="/career" class="hover:text-white">Careers &amp; internships</a></li>
        <li><a href="/partner" class="hover:text-white">Partner with us</a></li>
        <li><a href="/privacy_policy" class="hover:text-white">Privacy policy</a></li>
      </ul>
    </div>
    <div>
      <p class="text-white font-semibold mb-2">Contact</p>
      <address class="not-italic space-y-1">
        <p><?= e(BIZ_STREET) ?>,<br><?= e(BIZ_CITY) ?>, <?= e(BIZ_REGION) ?> <?= e(BIZ_PIN) ?></p>
        <p><a href="tel:<?= BIZ_PHONE ?>" class="hover:text-white" data-track="phone_click"><?= BIZ_PHONE_DISPLAY ?></a></p>
        <p><a href="mailto:<?= BIZ_EMAIL ?>" class="hover:text-white"><?= BIZ_EMAIL ?></a></p>
        <p><?= e(BIZ_HOURS) ?></p>
      </address>
      <p class="mt-3 text-slate-400">Serving <?= e(implode(', ', BIZ_SERVICE_AREA)) ?> and nearby areas of Western UP.</p>
    </div>
  </div>
  <div class="border-t border-slate-800">
    <div class="container mx-auto px-4 py-4 flex flex-wrap justify-between gap-2 text-slate-400">
      <p>&copy; <?= date('Y') ?> <?= e(BIZ_NAME) ?>. All rights reserved.</p>
      <p>Savings and subsidy figures on this site are estimates, not guarantees.</p>
    </div>
  </div>
</footer>

<a href="<?= e(wa_link('Hello Greenedge, I would like to know about rooftop solar.')) ?>" target="_blank" rel="noopener" aria-label="Chat on WhatsApp" data-track="whatsapp_click"
   class="fixed bottom-5 right-5 z-50 w-14 h-14 rounded-full bg-[#25D366] text-white shadow-lg flex items-center justify-center hover:scale-105 transition">
  <svg width="30" height="30" viewBox="0 0 32 32" fill="currentColor" aria-hidden="true"><path d="M16 3C9 3 3.3 8.6 3.3 15.6c0 2.5.7 4.8 2 6.8L3 29l6.8-2.2c1.9 1 4 1.6 6.2 1.6 7 0 12.7-5.6 12.7-12.6S23 3 16 3zm0 23.1c-2 0-3.9-.6-5.5-1.6l-.4-.2-4 1.3 1.3-3.9-.3-.4c-1.1-1.7-1.7-3.6-1.7-5.6C5.4 9.9 10.2 5.2 16 5.2s10.6 4.7 10.6 10.4S21.9 26.1 16 26.1zm5.8-7.8c-.3-.2-1.9-.9-2.2-1s-.5-.2-.7.2-.8 1-1 1.2-.4.2-.7.1c-.3-.2-1.3-.5-2.5-1.6-.9-.8-1.6-1.8-1.7-2.1-.2-.3 0-.5.1-.6l.5-.6c.2-.2.2-.4.3-.6.1-.2 0-.4 0-.6l-1-2.4c-.3-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.2 1.1-1.2 2.8s1.2 3.2 1.4 3.5c.2.2 2.4 3.6 5.8 5 .8.4 1.4.6 1.9.7.8.3 1.6.2 2.2.1.7-.1 1.9-.8 2.2-1.5.3-.7.3-1.4.2-1.5-.1-.2-.3-.3-.6-.4z"/></svg>
</a>
<?php
// Cache-busting: the version is the file's last-modified time, so browsers fetch a
// fresh copy whenever a script changes (scripts are cached for 30 days in .htaccess).
$geAssetV = static function (string $src): string {
    $f = dirname(__DIR__) . $src;
    return $src . '?v=' . (is_file($f) ? filemtime($f) : '1');
};
?>
<script src="<?= e($geAssetV('/assets/js/site.js')) ?>" defer></script>
<?php foreach (($page['scripts'] ?? []) as $s): ?><script src="<?= e($geAssetV($s)) ?>" defer></script>
<?php endforeach; ?>
</body>
</html>
