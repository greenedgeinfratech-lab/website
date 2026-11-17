<?php
require __DIR__ . '/inc/config.php';
$posts = require __DIR__ . '/inc/blog-data.php';
$posts = array_filter($posts, fn($p) => empty($p['draft']));
uasort($posts, fn($a, $b) => strcmp($b['date'], $a['date']));
$page = [
    'title' => 'Solar Blog: Subsidy, Savings & Rooftop Solar Guides | Greenedge Infratech',
    'description' => 'Practical guides on PM Surya Ghar subsidy, solar system sizing, maintenance and savings for homes and businesses in India.',
    'path' => '/blogs', 'nav' => 'blogs', 'crumbs' => [['Blog', '/blogs']],
];
include __DIR__ . '/inc/header.php';
?>
<section class="container mx-auto px-4 py-12">
  <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Solar guides &amp; news</h1>
  <p class="mt-2 text-slate-600 max-w-2xl">Clear, practical answers about rooftop solar.</p>
  <div class="grid gap-6 mt-8 sm:grid-cols-2 lg:grid-cols-3">
    <?php foreach ($posts as $slug => $p): ?>
    <a href="/blog/<?= e($slug) ?>" class="card overflow-hidden hover:shadow-lg transition flex flex-col"<?= isset($p['lang']) ? ' lang="' . e($p['lang']) . '"' : '' ?>>
      <img src="<?= e(str_replace(' ', '%20', $p['image'])) ?>" alt="" loading="lazy" width="600" height="340" class="w-full aspect-video object-cover">
      <div class="p-5 flex-1 flex flex-col">
        <p class="text-xs text-slate-500"><?= date('j M Y', strtotime($p['date'])) ?></p>
        <h2 class="font-bold text-lg mt-1 text-slate-900"><?= e($p['title']) ?></h2>
        <p class="text-sm text-slate-600 mt-2 flex-1"><?= e($p['description']) ?></p>
        <span class="mt-3 font-semibold text-green-700">Read &rarr;</span>
      </div>
    </a>
    <?php endforeach; ?>
  </div>
</section>
<?php include __DIR__ . '/inc/footer.php';
