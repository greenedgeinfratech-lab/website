<?php
require_once __DIR__ . '/inc/config.php';
if (!headers_sent()) http_response_code(404);
$page = ['title' => 'Page not found | Greenedge Infratech', 'description' => 'This page could not be found.', 'path' => '/404', 'noindex' => true];
include __DIR__ . '/inc/header.php';
?>
<section class="container mx-auto px-4 py-20 text-center max-w-2xl">
  <p class="text-green-700 font-bold">404</p>
  <h1 class="text-3xl font-extrabold mt-2">Sorry, we couldn&rsquo;t find that page</h1>
  <p class="mt-3 text-slate-600">It may have moved. These links will help:</p>
  <div class="mt-6 flex flex-wrap justify-center gap-3">
    <a href="/calculator" class="btn-primary">Solar Calculator</a>
    <a href="/pmsuryaghar/" class="btn-secondary">PM Surya Ghar</a>
    <a href="/services" class="btn-secondary">Services</a>
    <a href="/contact" class="btn-secondary">Contact</a>
  </div>
</section>
<?php include __DIR__ . '/inc/footer.php';
