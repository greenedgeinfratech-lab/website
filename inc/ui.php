<?php
/**
 * Small page-building helpers shared by every page, so the whole site looks and
 * behaves the same. Each function echoes HTML.
 */
require_once __DIR__ . '/config.php';

/** Page hero. $h = ['title','sub','eyebrow'?,'badges'?=>[], 'ctas'?=>[[href,label,class,track]], 'aside'?=>html, 'image'?=>src] */
function ui_hero(array $h): void { ?>
<section class="relative overflow-hidden bg-green-950 text-white">
  <?php if (!empty($h['image'])): ?>
  <img src="<?= e($h['image']) ?>" alt="" class="absolute inset-0 h-full w-full object-cover opacity-25" width="1600" height="900" fetchpriority="high">
  <?php endif; ?>
  <div class="absolute inset-0 bg-gradient-to-r from-green-950 via-green-900/90 to-green-900/60"></div>
  <div class="relative container mx-auto px-4 py-12 lg:py-16 grid gap-8 <?= !empty($h['aside']) ? 'lg:grid-cols-[1.3fr_1fr] items-center' : '' ?>">
    <div>
      <?php if (!empty($h['eyebrow'])): ?><p class="text-sm font-semibold uppercase tracking-wider text-yellow-300"><?= e($h['eyebrow']) ?></p><?php endif; ?>
      <h1 class="mt-2 text-3xl sm:text-4xl lg:text-5xl font-extrabold leading-tight"><?= $h['title'] ?></h1>
      <?php if (!empty($h['sub'])): ?><p class="mt-4 text-lg text-green-50 max-w-2xl"><?= $h['sub'] ?></p><?php endif; ?>
      <?php if (!empty($h['badges'])): ?>
      <ul class="mt-5 flex flex-wrap gap-2 text-sm"><?php foreach ($h['badges'] as $b): ?><li class="rounded-full bg-white/10 px-3 py-1"><?= $b ?></li><?php endforeach; ?></ul>
      <?php endif; ?>
      <?php if (!empty($h['ctas'])): ?>
      <div class="mt-7 flex flex-wrap gap-3">
        <?php foreach ($h['ctas'] as $c): ?><a href="<?= e($c[0]) ?>" class="<?= $c[2] ?? 'btn-light' ?> text-base" data-track="<?= e($c[3] ?? 'hero_cta') ?>"><?= $c[1] ?></a><?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
    <?php if (!empty($h['aside'])): ?><div><?= $h['aside'] ?></div><?php endif; ?>
  </div>
</section>
<?php }

/** Section heading block. */
function ui_heading(string $title, string $sub = '', string $eyebrow = '', bool $center = true): void { ?>
  <div class="<?= $center ? 'text-center mx-auto' : '' ?> max-w-3xl">
    <?php if ($eyebrow): ?><p class="eyebrow"><?= e($eyebrow) ?></p><?php endif; ?>
    <h2 class="section-title mt-1"><?= $title ?></h2>
    <?php if ($sub): ?><p class="mt-3 text-slate-600"><?= $sub ?></p><?php endif; ?>
  </div>
<?php }

/** Grid of cards: $items = [[title, text, href?, linkLabel?], ...] */
function ui_cards(array $items, string $cols = 'sm:grid-cols-2 lg:grid-cols-3'): void { ?>
  <div class="grid gap-6 mt-10 <?= $cols ?>">
    <?php foreach ($items as $it): $tag = !empty($it[2]) ? 'a' : 'div'; ?>
    <<?= $tag ?> <?= $tag === 'a' ? 'href="' . e($it[2]) . '"' : '' ?> class="card p-6 flex flex-col <?= $tag === 'a' ? 'hover:shadow-lg hover:border-green-300 transition' : '' ?>">
      <h3 class="text-lg font-bold text-green-800"><?= $it[0] ?></h3>
      <p class="mt-2 text-sm text-slate-600 flex-1"><?= $it[1] ?></p>
      <?php if (!empty($it[2])): ?><span class="mt-4 font-semibold text-green-700"><?= $it[3] ?? 'Learn more' ?> &rarr;</span><?php endif; ?>
    </<?= $tag ?>>
    <?php endforeach; ?>
  </div>
<?php }

/** Numbered steps: $steps = [[title, text], ...] */
function ui_steps(array $steps, string $cols = 'sm:grid-cols-2 lg:grid-cols-3'): void { ?>
  <ol class="grid gap-6 mt-10 <?= $cols ?>">
    <?php foreach ($steps as $i => $s): ?>
    <li class="card p-6"><span class="w-9 h-9 rounded-full bg-green-700 text-white font-bold flex items-center justify-center"><?= $i + 1 ?></span>
      <h3 class="font-bold mt-3 text-slate-900"><?= $s[0] ?></h3><p class="text-sm text-slate-600 mt-1"><?= $s[1] ?></p></li>
    <?php endforeach; ?>
  </ol>
<?php }

/** FAQ accordion plus FAQPage structured data. $faqs = [[q, a_html], ...] */
function ui_faqs(array $faqs, string $title = 'Frequently asked questions'): void { ?>
<section class="container mx-auto px-4 py-14 max-w-3xl">
  <h2 class="section-title text-center"><?= $title ?></h2>
  <div class="mt-8 space-y-3">
    <?php foreach ($faqs as $f): ?>
    <details class="card p-5"><summary class="font-semibold cursor-pointer text-slate-900"><?= $f[0] ?></summary><div class="mt-3 text-slate-600 prose-lite"><?= $f[1] ?></div></details>
    <?php endforeach; ?>
  </div>
  <script type="application/ld+json"><?= json_encode([
      '@context' => 'https://schema.org', '@type' => 'FAQPage',
      'mainEntity' => array_map(fn($f) => ['@type' => 'Question', 'name' => html_entity_decode(strip_tags($f[0]), ENT_QUOTES, 'UTF-8'),
          'acceptedAnswer' => ['@type' => 'Answer', 'text' => html_entity_decode(strip_tags($f[1]), ENT_QUOTES, 'UTF-8')]], $faqs),
  ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
</section>
<?php }

/** Links to the other solutions, excluding the current page. */
function ui_related(string $currentPath, int $max = 4): void {
    $items = array_values(array_filter(GE_SOLUTIONS, fn($s) => $s[0] !== $currentPath));
    $items = array_slice($items, 0, $max); ?>
<section class="bg-slate-50">
  <div class="container mx-auto px-4 py-14">
    <?php ui_heading('Other ways Greenedge can help'); ?>
    <?php ui_cards(array_map(fn($s) => [e($s[1]), e($s[2]), $s[0], 'Explore'], $items), 'sm:grid-cols-2 lg:grid-cols-4'); ?>
    <p class="text-center mt-8"><a href="/services" class="font-semibold text-green-700">See all solutions &rarr;</a></p>
  </div>
</section>
<?php }

/** Enquiry section: copy on the left, form on the right. */
function ui_enquiry(array $lf, string $title, string $text, array $points = []): void { ?>
<section id="enquire" class="bg-green-50 scroll-mt-24">
  <div class="container mx-auto px-4 py-14 grid lg:grid-cols-[1fr_1.2fr] gap-10 items-start">
    <div>
      <h2 class="section-title"><?= $title ?></h2>
      <p class="mt-3 text-slate-700"><?= $text ?></p>
      <?php if ($points): ?><ul class="mt-6 space-y-3 tick-list text-slate-700"><?php foreach ($points as $p): ?><li><?= $p ?></li><?php endforeach; ?></ul><?php endif; ?>
      <p class="mt-6 text-sm text-slate-600">Prefer to talk? Call <a class="font-semibold text-green-800 underline" href="tel:<?= BIZ_PHONE ?>" data-track="phone_click"><?= BIZ_PHONE_DISPLAY ?></a> or <a class="font-semibold text-green-800 underline" target="_blank" rel="noopener" href="<?= e(wa_link('Hello Greenedge, I have a solar enquiry.')) ?>" data-track="whatsapp_click">WhatsApp us</a>.</p>
    </div>
    <?php include __DIR__ . '/lead-form.php'; ?>
  </div>
</section>
<?php }

/** Small "Sources / checked on" note for pages that quote government rules. */
function ui_sources(array $links, string $checked = 'November 2026'): void { ?>
  <p class="text-xs text-slate-500 mt-6">Official sources: <?= implode(' &middot; ', array_map(fn($l) => '<a class="underline" target="_blank" rel="noopener" href="' . e($l[1]) . '">' . e($l[0]) . '</a>', $links)) ?>. Checked <?= e($checked) ?>. Rules and amounts can change; we confirm the current position for your case before you sign.</p>
<?php }
