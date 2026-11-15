<?php
require __DIR__ . '/inc/config.php';
$posts = require __DIR__ . '/inc/blog-data.php';
$slug = preg_replace('/[^a-z0-9-]/', '', strtolower($_GET['slug'] ?? ''));
if (!isset($posts[$slug])) {
    // Old URLs: /blog_details?id=3
    $id = (int)($_GET['id'] ?? 0);
    foreach ($posts as $s => $p) {
        if ($id && $p['old_id'] === $id) { header('Location: ' . SITE_URL . '/blog/' . $s, true, 301); exit; }
    }
    if ($id || $slug === '') { header('Location: ' . SITE_URL . '/blogs', true, 301); exit; }
    http_response_code(404);
    include __DIR__ . '/404.php';
    exit;
}
$p = $posts[$slug];
$plainTitle = html_entity_decode(strip_tags($p['title']), ENT_QUOTES, 'UTF-8');
$page = [
    'title' => $plainTitle . ' | Greenedge Infratech',
    'description' => $p['description'],
    'path' => '/blog/' . $slug, 'nav' => 'blogs',
    'image' => str_replace(' ', '%20', $p['image']),
    'crumbs' => [['Blog', '/blogs'], [$plainTitle, '/blog/' . $slug]],
    'schema' => [[
        '@context' => 'https://schema.org', '@type' => 'BlogPosting',
        'headline' => $plainTitle, 'description' => $p['description'],
        'datePublished' => $p['date'], 'dateModified' => $p['updated'],
        'image' => SITE_URL . str_replace(' ', '%20', $p['image']),
        'inLanguage' => $p['lang'] ?? 'en-IN',
        'author' => ['@type' => 'Organization', 'name' => BIZ_SHORT, 'url' => SITE_URL . '/'],
        'publisher' => ['@id' => SITE_URL . '/#business'],
        'mainEntityOfPage' => SITE_URL . '/blog/' . $slug,
    ]],
];
include __DIR__ . '/inc/header.php';
?>
<article class="container mx-auto px-4 py-10 max-w-3xl"<?= isset($p['lang']) ? ' lang="' . e($p['lang']) . '"' : '' ?>>
  <p class="text-sm text-slate-500">Published <?= date('j M Y', strtotime($p['date'])) ?> &middot; Updated <?= date('j M Y', strtotime($p['updated'])) ?></p>
  <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2"><?= $p['title'] ?></h1>
  <img src="<?= e(str_replace(' ', '%20', $p['image'])) ?>" alt="" width="1200" height="630" class="rounded-xl mt-6 w-full aspect-video object-cover">
  <div class="prose-lite mt-8"><?= $p['body'] ?></div>
  <div class="card p-6 mt-10 bg-green-50">
    <p class="font-bold text-lg">Want to know what solar can save you?</p>
    <div class="flex flex-wrap gap-3 mt-3">
      <a href="/calculator" class="btn-primary" data-track="cta_calculator">Calculate Your Solar Savings</a>
      <a href="/contact?type=site-survey" class="btn-secondary" data-track="cta_site_survey">Book a Free Site Survey</a>
    </div>
  </div>
  <h2 class="font-bold text-xl mt-10">More articles</h2>
  <ul class="mt-3 space-y-2">
    <?php foreach (array_slice(array_diff_key($posts, [$slug => 1]), 0, 3, true) as $s => $o): ?>
    <li><a class="text-green-700 underline" href="/blog/<?= e($s) ?>"><?= $o['title'] ?></a></li>
    <?php endforeach; ?>
  </ul>
</article>
<?php include __DIR__ . '/inc/footer.php';
