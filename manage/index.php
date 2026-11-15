<?php
/**
 * Greenedge website admin panel: /manage/
 * Sign in with an emailed one-time code. Edits are saved to private_content/ (outside public_html).
 */
declare(strict_types=1);
require __DIR__ . '/../inc/admin/auth.php';
header('X-Robots-Tag: noindex, nofollow');
header('Cache-Control: no-store');
header("Content-Security-Policy: default-src 'self'; img-src 'self' data:; style-src 'self' 'unsafe-inline'; script-src 'self' 'unsafe-inline'; frame-ancestors 'none'; form-action 'self'");
admin_session_start();

$p = preg_replace('/[^a-z-]/', '', $_GET['p'] ?? 'dashboard');
$flash = $_SESSION['flash'] ?? ''; unset($_SESSION['flash']);
function go(string $page, string $msg = ''): void { if ($msg) $_SESSION['flash'] = $msg; header('Location: /manage/?p=' . $page); exit; }

// ------------------------------------------------------------------ sign in
if (!admin_is_logged_in()) {
    $msg = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        csrf_check();
        if (isset($_POST['email'])) $msg = admin_send_code((string)$_POST['email']);
        elseif (isset($_POST['code'])) { if (admin_verify_code((string)$_POST['code'])) go('dashboard', 'Signed in.'); $msg = 'That code is wrong or has expired. Request a new one if needed.'; }
    }
    $step = !empty($_SESSION['pending_email']) ? 'code' : 'email';
    if (isset($_GET['restart'])) { unset($_SESSION['pending_email']); $step = 'email'; }
    page_head('Sign in');
    ?>
    <div class="max-w-sm mx-auto mt-16 card p-6">
      <h1 class="text-xl font-bold">Greenedge admin</h1>
      <?php if ($msg): ?><p class="mt-3 text-sm rounded-md p-3 bg-slate-50 border"><?= e($msg) ?></p><?php endif; ?>
      <?php if ($step === 'email'): ?>
        <form method="post" class="mt-4 space-y-3"><?= csrf_field() ?>
          <label class="block"><span class="label">Admin email</span><input name="email" type="email" required class="input" autocomplete="email"></label>
          <button class="btn-primary w-full">Email me a sign-in code</button>
        </form>
      <?php else: ?>
        <form method="post" class="mt-4 space-y-3"><?= csrf_field() ?>
          <label class="block"><span class="label">6-digit code sent to <?= e($_SESSION['pending_email']) ?></span><input name="code" inputmode="numeric" maxlength="6" required class="input text-center text-2xl tracking-widest" autocomplete="one-time-code"></label>
          <button class="btn-primary w-full">Sign in</button>
        </form>
        <p class="text-sm mt-3"><a class="underline" href="/manage/?restart=1">Use a different email / send a new code</a></p>
      <?php endif; ?>
    </div>
    <?php page_foot(); exit;
}

if ($p === 'logout') { admin_logout(); header('Location: /manage/'); exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST') csrf_check();

// ------------------------------------------------------------------ data helpers
function leads_all(): array {
    $out = [];
    foreach (glob(PRIVATE_ROOT . '/private_leads/leads-*.jsonl') ?: [] as $f) {
        foreach (file($f, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $l) { $j = json_decode($l, true); if ($j) $out[] = $j; }
    }
    usort($out, fn($a, $b) => strcmp($b['received_at'] ?? '', $a['received_at'] ?? ''));
    return $out;
}
function num_or($v, $d) { return is_numeric($v) ? $v + 0 : $d; }
function slugify(string $s): string { $s = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $s), '-')); return $s !== '' ? substr($s, 0, 80) : 'post-' . date('YmdHis'); }

// ------------------------------------------------------------------ actions
if ($p === 'leads-csv') {
    $rows = leads_all();
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="greenedge-leads-' . date('Y-m-d') . '.csv"');
    $o = fopen('php://output', 'w'); fwrite($o, "\xEF\xBB\xBF");
    fputcsv($o, ['Received', 'Type', 'Category', 'Name', 'Mobile', 'City', 'Email', 'Message', 'System kW', 'Monthly bill', 'Yearly savings', 'Subsidy', 'Net cost', 'Payback yrs', 'Page', 'UTM source', 'UTM campaign', 'Lead ID']);
    foreach ($rows as $r) { $c = $r['calculator'] ?? []; $u = $r['utm'] ?? [];
        fputcsv($o, [$r['received_at'] ?? '', $r['enquiry_type'] ?? '', $r['category'] ?? '', $r['name'] ?? '', $r['phone'] ?? '', $r['city'] ?? '', $r['email'] ?? '', $r['message'] ?? '',
            $c['system_kw'] ?? '', $c['monthly_bill'] ?? '', $c['annual_savings'] ?? '', $c['subsidy'] ?? '', $c['net_cost'] ?? '', $c['payback_years'] ?? '', $r['source_page'] ?? '', $u['source'] ?? '', $u['campaign'] ?? '', $r['id'] ?? '']); }
    admin_log('leads-csv-download'); exit;
}

if ($p === 'business' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    global $GE_SITE;
    $site = ge_load_json('site');
    foreach (['biz_name', 'biz_short', 'phone', 'phone_display', 'whatsapp', 'email', 'street', 'city', 'region', 'pin', 'hours', 'installs', 'pmsg_vendor', 'lead_email_to'] as $k) {
        $site[$k] = mb_substr(trim((string)($_POST[$k] ?? '')), 0, 300);
    }
    $site['since'] = (int)($_POST['since'] ?? 2016);
    $site['service_area'] = array_values(array_filter(array_map('trim', explode(',', (string)($_POST['service_area'] ?? '')))));
    foreach (['email', 'lead_email_to'] as $k) if (!filter_var($site[$k], FILTER_VALIDATE_EMAIL)) go('business', 'Please enter a valid email address.');
    ge_save_json('site', $site); admin_log('saved business details'); go('business', 'Business details saved. They now show across the website.');
}
if ($p === 'home' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $site = ge_load_json('site');
    foreach (['home_hero_title' => 120, 'home_hero_text' => 400, 'home_savings_stat' => 20] as $k => $max) $site[$k] = mb_substr(trim((string)($_POST[$k] ?? '')), 0, $max);
    ge_save_json('site', $site); admin_log('saved homepage'); go('home', 'Homepage text saved.');
}
if ($p === 'calculator' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $c = [
        'generationPerKwPerDay' => num_or($_POST['gen'] ?? '', 4.2),
        'surplusExportRate' => num_or($_POST['export'] ?? '', 2.5),
        'tariffEscalation' => num_or($_POST['escalation'] ?? '', 3) / 100,
        'costPerKw' => array_map(fn($i) => (int)num_or($_POST['cost'][$i] ?? '', 0), range(0, 5)),
        'categories' => [],
        'subsidy' => [
            'centralFirst2' => (int)num_or($_POST['s_c2'] ?? '', 30000), 'centralThird' => (int)num_or($_POST['s_c3'] ?? '', 18000),
            'centralCap' => (int)num_or($_POST['s_ccap'] ?? '', 78000), 'statePerKw' => (int)num_or($_POST['s_st'] ?? '', 15000), 'stateCap' => (int)num_or($_POST['s_stcap'] ?? '', 30000),
        ],
    ];
    foreach (['residential', 'commercial', 'industrial'] as $k) $c['categories'][$k] = ['defaultTariff' => num_or($_POST['tariff'][$k] ?? '', 7), 'fixedCharges' => num_or($_POST['fixed'][$k] ?? '', 0)];
    if ($c['generationPerKwPerDay'] < 2 || $c['generationPerKwPerDay'] > 7) go('calculator', 'Generation per kW must be between 2 and 7 units a day.');
    ge_save_json('calculator', $c); admin_log('saved calculator settings'); go('calculator', 'Calculator settings saved.');
}
if ($p === 'faqs' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $groups = [];
    foreach ((array)($_POST['q'] ?? []) as $i => $q) {
        $q = trim((string)$q); $a = trim((string)($_POST['a'][$i] ?? '')); $g = trim((string)($_POST['g'][$i] ?? '')) ?: 'General';
        if ($q === '' || $a === '' || !empty($_POST['del'][$i])) continue;
        $groups[mb_substr($g, 0, 60)][] = [mb_substr($q, 0, 300), mb_substr($a, 0, 3000)];
    }
    ge_save_json('faqs', $groups); admin_log('saved FAQs'); go('faqs', 'FAQs saved.');
}
if ($p === 'blog-save' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $posts = require __DIR__ . '/../inc/blog-data.php';
    $old = (string)($_POST['old_slug'] ?? '');
    $title = trim((string)($_POST['title'] ?? ''));
    if ($title === '') go('blog', 'The title cannot be empty.');
    $slug = slugify((string)($_POST['slug'] ?? '') ?: $title);
    if ($slug !== $old && isset($posts[$slug])) $slug .= '-' . date('His');
    $post = $posts[$old] ?? ['old_id' => 0, 'date' => date('Y-m-d')];
    $post['title'] = mb_substr($title, 0, 160);
    $post['description'] = mb_substr(trim((string)($_POST['description'] ?? '')), 0, 300);
    $post['date'] = preg_match('/^\d{4}-\d{2}-\d{2}$/', (string)($_POST['date'] ?? '')) ? $_POST['date'] : ($post['date'] ?? date('Y-m-d'));
    $post['updated'] = date('Y-m-d');
    $post['body'] = mb_substr((string)($_POST['body'] ?? ''), 0, 60000);
    $post['format'] = 'text';
    $post['draft'] = !empty($_POST['draft']);
    $post['lang'] = ($_POST['lang'] ?? '') === 'hi' ? 'hi' : null;
    if (!empty($_FILES['image']['tmp_name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
        $info = @getimagesize($_FILES['image']['tmp_name']);
        $ext = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp'][$info[2] ?? 0] ?? null;
        if (!$ext || $_FILES['image']['size'] > 3 * 1024 * 1024) go('blog-edit&slug=' . rawurlencode($old), 'Image must be a JPG, PNG or WebP file under 3 MB.');
        $dir = __DIR__ . '/../uploads/blog'; if (!is_dir($dir)) mkdir($dir, 0755, true);
        $name = date('Ymd') . '-' . bin2hex(random_bytes(4)) . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], "$dir/$name");
        $post['image'] = '/uploads/blog/' . $name;
    }
    $post['image'] = $post['image'] ?? '/assets/hero-solar.jpg';
    if ($old !== '' && $old !== $slug) unset($posts[$old]);
    $posts[$slug] = $post;
    ge_save_json('blogs', $posts); admin_log("saved blog $slug"); go('blog', 'Post saved' . ($post['draft'] ? ' as a draft (not visible on the website).' : '. It is live at /blog/' . $slug));
}
if ($p === 'blog-delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $posts = require __DIR__ . '/../inc/blog-data.php';
    $s = (string)($_POST['slug'] ?? '');
    if (isset($posts[$s])) { unset($posts[$s]); ge_save_json('blogs', $posts); admin_log("deleted blog $s"); }
    go('blog', 'Post deleted.');
}

// ------------------------------------------------------------------ layout
function page_head(string $title): void { ?>
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow"><title><?= e($title) ?> | Greenedge admin</title>
<link rel="stylesheet" href="/assets/css/site.css?v=admin1"></head><body class="bg-slate-50 text-slate-800">
<?php if (admin_is_logged_in()): ?>
<header class="bg-green-800 text-white"><div class="container mx-auto px-4 py-3 flex flex-wrap items-center gap-4 text-sm">
  <strong class="mr-2">Greenedge admin</strong>
  <?php foreach (['dashboard' => 'Dashboard', 'leads' => 'Leads', 'business' => 'Business details', 'home' => 'Homepage', 'blog' => 'Blog', 'faqs' => 'FAQs', 'calculator' => 'Calculator', 'activity' => 'Activity'] as $k => $v): ?>
    <a href="/manage/?p=<?= $k ?>" class="hover:underline"><?= $v ?></a>
  <?php endforeach; ?>
  <span class="ml-auto"><a href="/" target="_blank" class="hover:underline">View website</a> &middot; <a href="/manage/?p=logout" class="hover:underline">Sign out</a></span>
</div></header>
<?php endif; ?>
<main class="container mx-auto px-4 py-6">
<?php }
function page_foot(): void { echo '</main></body></html>'; }
function field(string $name, string $label, $value, string $type = 'text', string $hint = ''): string {
    return '<label class="block"><span class="label">' . e($label) . '</span><input class="input" type="' . $type . '" name="' . e($name) . '" value="' . e((string)$value) . '">' . ($hint ? '<span class="hint">' . e($hint) . '</span>' : '') . '</label>';
}

page_head(ucfirst($p));
if ($flash) echo '<p class="mb-4 rounded-md p-3 bg-green-50 border border-green-200 text-green-900">' . e($flash) . '</p>';

// ------------------------------------------------------------------ pages
switch ($p) {
case 'leads':
    $rows = leads_all(); ?>
    <div class="flex items-center justify-between"><h1 class="text-2xl font-bold">Leads (<?= count($rows) ?>)</h1><a class="btn-primary" href="/manage/?p=leads-csv">Download CSV (Excel)</a></div>
    <div class="card mt-4 overflow-x-auto"><table class="w-full text-sm"><thead class="bg-slate-100 text-left"><tr>
      <th class="p-2">Received</th><th class="p-2">Name</th><th class="p-2">Mobile</th><th class="p-2">City</th><th class="p-2">Type</th><th class="p-2">kW</th><th class="p-2">Bill</th><th class="p-2">Email</th><th class="p-2">Message</th></tr></thead><tbody class="divide-y">
    <?php foreach ($rows as $r): $c = $r['calculator'] ?? []; ?>
      <tr><td class="p-2 whitespace-nowrap"><?= e(date('j M Y, g:i A', strtotime($r['received_at'] ?? 'now'))) ?></td><td class="p-2"><?= e($r['name'] ?? '') ?></td>
      <td class="p-2 whitespace-nowrap"><a class="underline" href="tel:+91<?= e($r['phone'] ?? '') ?>"><?= e($r['phone'] ?? '') ?></a> &middot; <a class="underline" target="_blank" href="https://wa.me/91<?= e($r['phone'] ?? '') ?>">WA</a></td>
      <td class="p-2"><?= e($r['city'] ?? '') ?></td><td class="p-2"><?= e(($r['enquiry_type'] ?? '') . ' / ' . ($r['category'] ?? '')) ?></td>
      <td class="p-2"><?= e((string)($c['system_kw'] ?? '')) ?></td><td class="p-2"><?= isset($c['monthly_bill']) ? '&#8377;' . number_format((float)$c['monthly_bill']) : '' ?></td>
      <td class="p-2"><?= e($r['email'] ?? '') ?></td><td class="p-2 max-w-xs"><?= e(mb_strimwidth($r['message'] ?? '', 0, 120, '…')) ?></td></tr>
    <?php endforeach; if (!$rows): ?><tr><td class="p-4" colspan="9">No leads yet.</td></tr><?php endif; ?>
    </tbody></table></div>
    <?php break;

case 'business': ?>
    <h1 class="text-2xl font-bold">Business details</h1>
    <p class="text-slate-600 text-sm">Used in the header, footer, contact page, Google business information and lead emails.</p>
    <form method="post" class="card p-6 mt-4 grid sm:grid-cols-2 gap-4"><?= csrf_field() ?>
      <?= field('biz_name', 'Company legal name', BIZ_NAME) ?><?= field('biz_short', 'Short name', BIZ_SHORT) ?>
      <?= field('phone', 'Phone (for call links, with +91)', BIZ_PHONE) ?><?= field('phone_display', 'Phone as shown', BIZ_PHONE_DISPLAY) ?>
      <?= field('whatsapp', 'WhatsApp number (with 91, digits only)', BIZ_WHATSAPP) ?><?= field('email', 'Public email', BIZ_EMAIL, 'email') ?>
      <?= field('street', 'Street address', BIZ_STREET) ?><?= field('city', 'City', BIZ_CITY) ?>
      <?= field('region', 'State', BIZ_REGION) ?><?= field('pin', 'PIN code', BIZ_PIN) ?>
      <?= field('hours', 'Business hours', BIZ_HOURS) ?><?= field('since', 'Working since (year)', BIZ_SINCE, 'number') ?>
      <?= field('installs', 'Installations count (e.g. 200+)', BIZ_INSTALLS) ?><?= field('pmsg_vendor', 'PM Surya Ghar vendor line', BIZ_PMSG_VENDOR) ?>
      <?= field('service_area', 'Service areas (comma separated)', implode(', ', BIZ_SERVICE_AREA)) ?><?= field('lead_email_to', 'Send website leads to (email)', LEAD_EMAIL_TO, 'email') ?>
      <div class="sm:col-span-2"><button class="btn-primary">Save business details</button></div>
    </form>
    <?php break;

case 'home': ?>
    <h1 class="text-2xl font-bold">Homepage</h1>
    <form method="post" class="card p-6 mt-4 space-y-4 max-w-3xl"><?= csrf_field() ?>
      <?= field('home_hero_title', 'Main heading', site('home_hero_title')) ?>
      <label class="block"><span class="label">Introduction text</span><textarea name="home_hero_text" rows="4" class="input h-auto py-2"><?= e(site('home_hero_text')) ?></textarea></label>
      <?= field('home_savings_stat', 'Savings figure in the hero box', site('home_savings_stat'), 'text', 'e.g. 70–80%') ?>
      <button class="btn-primary">Save homepage</button>
    </form>
    <?php break;

case 'blog':
    $posts = require __DIR__ . '/../inc/blog-data.php';
    uasort($posts, fn($a, $b) => strcmp($b['date'], $a['date'])); ?>
    <div class="flex items-center justify-between"><h1 class="text-2xl font-bold">Blog posts</h1><a class="btn-primary" href="/manage/?p=blog-edit">+ New post</a></div>
    <div class="card mt-4 divide-y">
    <?php foreach ($posts as $s => $post): ?>
      <div class="p-4 flex flex-wrap items-center gap-3"><div class="flex-1"><p class="font-semibold"><?= e($post['title']) ?> <?= !empty($post['draft']) ? '<span class="text-xs bg-amber-100 px-2 py-0.5 rounded">Draft</span>' : '' ?></p><p class="text-xs text-slate-500"><?= e($post['date']) ?> &middot; /blog/<?= e($s) ?></p></div>
      <a class="btn-secondary" href="/manage/?p=blog-edit&amp;slug=<?= rawurlencode($s) ?>">Edit</a>
      <a class="btn-secondary" target="_blank" href="/blog/<?= rawurlencode($s) ?>">View</a>
      <form method="post" action="/manage/?p=blog-delete" onsubmit="return confirm('Delete this post permanently?')"><?= csrf_field() ?><input type="hidden" name="slug" value="<?= e($s) ?>"><button class="btn-secondary text-red-700">Delete</button></form></div>
    <?php endforeach; ?>
    </div>
    <?php break;

case 'blog-edit':
    $posts = require __DIR__ . '/../inc/blog-data.php';
    $s = (string)($_GET['slug'] ?? ''); $post = $posts[$s] ?? ['title' => '', 'description' => '', 'date' => date('Y-m-d'), 'body' => '', 'image' => '']; ?>
    <h1 class="text-2xl font-bold"><?= $s ? 'Edit post' : 'New post' ?></h1>
    <form method="post" action="/manage/?p=blog-save" enctype="multipart/form-data" class="card p-6 mt-4 space-y-4 max-w-4xl"><?= csrf_field() ?>
      <input type="hidden" name="old_slug" value="<?= e($s) ?>">
      <?= field('title', 'Title', $post['title']) ?>
      <div class="grid sm:grid-cols-3 gap-4"><?= field('slug', 'Web address (/blog/...)', $s, 'text', 'Leave empty to create from the title') ?><?= field('date', 'Date', $post['date'], 'date') ?>
        <label class="block"><span class="label">Language</span><select name="lang" class="input"><option value="">English</option><option value="hi" <?= ($post['lang'] ?? '') === 'hi' ? 'selected' : '' ?>>Hindi</option></select></label></div>
      <?= field('description', 'Short description (shown on Google and the blog list)', $post['description']) ?>
      <label class="block"><span class="label">Picture (JPG, PNG or WebP, under 3 MB)</span><input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="input pt-2">
        <?php if (!empty($post['image'])): ?><span class="hint">Current: <?= e($post['image']) ?></span><?php endif; ?></label>
      <label class="block"><span class="label">Article text</span><textarea name="body" rows="18" class="input h-auto py-2 font-mono text-sm"><?= e($post['body']) ?></textarea>
        <span class="hint">Formatting: start a line with <b>## </b> for a heading, <b>- </b> for a bullet, <b>1. </b> for numbered steps. <b>**bold**</b>. Links: [text](https://...). Leave an empty line between paragraphs.</span></label>
      <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="draft" value="1" <?= !empty($post['draft']) ? 'checked' : '' ?>> Save as draft (hidden from the website)</label>
      <div class="flex gap-3"><button class="btn-primary">Save post</button><a class="btn-secondary" href="/manage/?p=blog">Cancel</a></div>
    </form>
    <?php break;

case 'faqs':
    $groups = require __DIR__ . '/../inc/faq-data.php'; $i = 0; ?>
    <h1 class="text-2xl font-bold">FAQs</h1>
    <p class="text-sm text-slate-600">Shown on /faq. Same formatting as blog posts. Tick "Remove" to delete a question; fill an empty row to add one.</p>
    <form method="post" class="mt-4 space-y-3"><?= csrf_field() ?>
    <?php $rows = []; foreach ($groups as $g => $items) foreach ($items as $it) $rows[] = [$g, $it[0], $it[1]]; for ($k = 0; $k < 3; $k++) $rows[] = [$rows ? end($rows)[0] : 'General', '', ''];
    foreach ($rows as $r): ?>
      <div class="card p-4 grid gap-2 sm:grid-cols-[180px_1fr]">
        <input class="input" name="g[<?= $i ?>]" value="<?= e($r[0]) ?>" placeholder="Group">
        <div class="space-y-2"><input class="input" name="q[<?= $i ?>]" value="<?= e($r[1]) ?>" placeholder="Question">
          <textarea class="input h-auto py-2" rows="3" name="a[<?= $i ?>]" placeholder="Answer"><?= e($r[2]) ?></textarea>
          <label class="text-sm"><input type="checkbox" name="del[<?= $i ?>]" value="1"> Remove</label></div>
      </div>
    <?php $i++; endforeach; ?>
      <button class="btn-primary">Save FAQs</button>
    </form>
    <?php break;

case 'calculator':
    $c = ge_load_json('calculator'); $d = fn($path, $def) => $path ?? $def;
    $costs = $c['costPerKw'] ?? [60000, 57000, 54000, 48000, 44000, 40000];
    $bands = ['Up to 3 kW', '3–5 kW', '5–10 kW', '10–50 kW', '50–100 kW', 'Above 100 kW'];
    $cat = $c['categories'] ?? []; $sub = $c['subsidy'] ?? []; ?>
    <h1 class="text-2xl font-bold">Calculator settings</h1>
    <p class="text-sm text-slate-600">These numbers drive the solar calculator. Change prices here when your rates change.</p>
    <form method="post" class="mt-4 space-y-4 max-w-4xl"><?= csrf_field() ?>
      <div class="card p-6"><h2 class="font-bold mb-3">Installed price per kW (incl. GST, on-grid)</h2><div class="grid sm:grid-cols-3 gap-4">
        <?php foreach ($bands as $i => $b): ?><?= field("cost[$i]", $b . ' (₹/kW)', $costs[$i] ?? '', 'number') ?><?php endforeach; ?></div></div>
      <div class="card p-6"><h2 class="font-bold mb-3">Electricity rates</h2><div class="grid sm:grid-cols-3 gap-4">
        <?php foreach (['residential' => [7, 220], 'commercial' => [9, 800], 'industrial' => [8, 3000]] as $k => $def): ?>
          <?= field("tariff[$k]", ucfirst($k) . ' tariff (₹/unit)', $cat[$k]['defaultTariff'] ?? $def[0], 'number') ?>
        <?php endforeach; foreach (['residential' => [7, 220], 'commercial' => [9, 800], 'industrial' => [8, 3000]] as $k => $def): ?>
          <?= field("fixed[$k]", ucfirst($k) . ' fixed charges (₹/month)', $cat[$k]['fixedCharges'] ?? $def[1], 'number') ?>
        <?php endforeach; ?></div></div>
      <div class="card p-6"><h2 class="font-bold mb-3">Generation and savings</h2><div class="grid sm:grid-cols-3 gap-4">
        <?= field('gen', 'Units per kW per day', $c['generationPerKwPerDay'] ?? 4.2, 'number', 'Aligarh average about 4.2') ?>
        <?= field('export', 'Surplus export rate (₹/unit)', $c['surplusExportRate'] ?? 2.5, 'number') ?>
        <?= field('escalation', 'Yearly tariff rise (%)', ($c['tariffEscalation'] ?? 0.03) * 100, 'number') ?></div></div>
      <div class="card p-6"><h2 class="font-bold mb-3">PM Surya Ghar subsidy (homes only)</h2><div class="grid sm:grid-cols-3 gap-4">
        <?= field('s_c2', 'Central: per kW for first 2 kW', $sub['centralFirst2'] ?? 30000, 'number') ?>
        <?= field('s_c3', 'Central: for the 3rd kW', $sub['centralThird'] ?? 18000, 'number') ?>
        <?= field('s_ccap', 'Central: maximum', $sub['centralCap'] ?? 78000, 'number') ?>
        <?= field('s_st', 'UP state: per kW', $sub['statePerKw'] ?? 15000, 'number') ?>
        <?= field('s_stcap', 'UP state: maximum', $sub['stateCap'] ?? 30000, 'number') ?></div></div>
      <button class="btn-primary">Save calculator settings</button>
    </form>
    <?php break;

case 'activity':
    $log = is_file(ADMIN_STATE_DIR . '/activity.log') ? array_slice(file(ADMIN_STATE_DIR . '/activity.log', FILE_IGNORE_NEW_LINES), -100) : []; ?>
    <h1 class="text-2xl font-bold">Admin activity (last 100)</h1>
    <pre class="card p-4 mt-4 text-xs overflow-x-auto"><?= e(implode("\n", array_reverse($log))) ?></pre>
    <?php break;

default:
    $rows = leads_all();
    $month = array_filter($rows, fn($r) => str_starts_with($r['received_at'] ?? '', date('Y-m')));
    $calc = array_filter($month, fn($r) => !empty($r['calculator'])); ?>
    <h1 class="text-2xl font-bold">Dashboard</h1>
    <div class="grid sm:grid-cols-3 gap-4 mt-4">
      <div class="card p-5"><p class="text-sm text-slate-500">Leads this month</p><p class="text-3xl font-bold text-green-700"><?= count($month) ?></p></div>
      <div class="card p-5"><p class="text-sm text-slate-500">From the calculator</p><p class="text-3xl font-bold"><?= count($calc) ?></p></div>
      <div class="card p-5"><p class="text-sm text-slate-500">All leads</p><p class="text-3xl font-bold"><?= count($rows) ?></p></div>
    </div>
    <h2 class="font-bold mt-8">Latest enquiries</h2>
    <div class="card mt-2 divide-y">
    <?php foreach (array_slice($rows, 0, 10) as $r): ?>
      <div class="p-3 text-sm flex flex-wrap gap-3"><span class="w-40 text-slate-500"><?= e(date('j M, g:i A', strtotime($r['received_at'] ?? 'now'))) ?></span><strong><?= e($r['name'] ?? '') ?></strong><span><?= e($r['phone'] ?? '') ?></span><span><?= e($r['city'] ?? '') ?></span><span class="text-slate-500"><?= e($r['enquiry_type'] ?? '') ?><?= !empty($r['calculator']['system_kw']) ? ' · ' . e((string)$r['calculator']['system_kw']) . ' kW' : '' ?></span></div>
    <?php endforeach; if (!$rows): ?><p class="p-3 text-sm">No leads yet.</p><?php endif; ?>
    </div>
    <p class="mt-6 text-sm text-slate-500">Signed in as <?= e($_SESSION['admin_email']) ?>.</p>
<?php }
page_foot();
