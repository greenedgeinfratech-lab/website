<?php
/**
 * Site-wide settings.
 * Defaults live here; anything changed in the admin panel (/manage/) is saved to
 * private_content/site.json OUTSIDE public_html and overrides these defaults.
 */
if (defined('SITE_URL')) return;

define('PRIVATE_ROOT', dirname(__DIR__, 2));            // /home/<user>/domains/greenedgeinfratech.com
define('CONTENT_DIR', PRIVATE_ROOT . '/private_content');

function ge_content_file(string $name): string { return CONTENT_DIR . '/' . $name . '.json'; }
function ge_load_json(string $name, $default = []) {
    $f = ge_content_file($name);
    if (!is_file($f)) return $default;
    $d = json_decode((string)file_get_contents($f), true);
    return is_array($d) ? $d : $default;
}
function ge_save_json(string $name, array $data): bool {
    if (!is_dir(CONTENT_DIR)) { @mkdir(CONTENT_DIR, 0700, true); @file_put_contents(CONTENT_DIR . '/.htaccess', "Require all denied\n"); }
    $f = ge_content_file($name);
    if (is_file($f)) @copy($f, CONTENT_DIR . '/backup-' . $name . '-' . date('Ymd-His') . '.json');
    return file_put_contents($f . '.tmp', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), LOCK_EX) !== false
        && rename($f . '.tmp', $f);
}

$GE_SITE_DEFAULTS = [
    'biz_name'          => 'Greenedge Infratech Private Limited',
    'biz_short'         => 'Greenedge Infratech',
    'phone'             => '+919837067681',
    'phone_display'     => '+91 98370 67681',
    'whatsapp'          => '919837067681',
    'email'             => 'greenedgeinfratech@gmail.com',
    'street'            => 'Opp. BJP Office, Kayampur, Quarsi Bypass',
    'city'              => 'Aligarh',
    'region'            => 'Uttar Pradesh',
    'pin'               => '202001',
    'hours'             => 'Monday to Saturday, 9:00 AM to 6:00 PM',
    'since'             => 2016,
    'installs'          => '200+',
    'pmsg_vendor'       => 'Registered vendor under PM Surya Ghar: Muft Bijli Yojana, Uttar Pradesh',
    'service_area'      => ['Aligarh', 'Hathras', 'Kasganj', 'Etah', 'Bulandshahr', 'Mathura'],
    'lead_email_to'     => 'greenedgeinfratech@gmail.com',
    'home_hero_title'   => 'Rooftop Solar Installation in Aligarh & Western UP',
    'home_hero_text'    => 'Cut your electricity bill by up to 70–80% with a rooftop solar system designed for your home, shop or factory. Eligible homes in Uttar Pradesh can get up to ₹1,08,000 in PM Surya Ghar central and state subsidy.',
    'home_savings_stat' => '70–80%',
];
$GE_SITE = array_merge($GE_SITE_DEFAULTS, ge_load_json('site'));
if (is_string($GE_SITE['service_area'])) $GE_SITE['service_area'] = array_values(array_filter(array_map('trim', explode(',', $GE_SITE['service_area']))));

define('SITE_URL', 'https://greenedgeinfratech.com');
define('SITE_HOSTS', ['greenedgeinfratech.com', 'www.greenedgeinfratech.com']);
define('BIZ_NAME', $GE_SITE['biz_name']);
define('BIZ_SHORT', $GE_SITE['biz_short']);
define('BIZ_PHONE', $GE_SITE['phone']);
define('BIZ_PHONE_DISPLAY', $GE_SITE['phone_display']);
define('BIZ_WHATSAPP', preg_replace('/\D/', '', (string)$GE_SITE['whatsapp']));
define('BIZ_EMAIL', $GE_SITE['email']);
define('BIZ_STREET', $GE_SITE['street']);
define('BIZ_CITY', $GE_SITE['city']);
define('BIZ_REGION', $GE_SITE['region']);
define('BIZ_PIN', $GE_SITE['pin']);
define('BIZ_HOURS', $GE_SITE['hours']);
define('BIZ_SINCE', (int)$GE_SITE['since']);
define('BIZ_INSTALLS', $GE_SITE['installs']);
define('BIZ_PMSG_VENDOR', $GE_SITE['pmsg_vendor']);
define('BIZ_SERVICE_AREA', $GE_SITE['service_area']);

// Lead delivery (email for now; WhatsApp/CRM can be added later)
define('LEAD_EMAIL_TO', $GE_SITE['lead_email_to']);
define('MAIL_FROM', 'noreply@greenedgeinfratech.com');
define('MAIL_FROM_NAME', 'Greenedge Website');

// Who may sign in to the admin panel (a one-time code is emailed to them)
define('ADMIN_EMAILS', ['greenedgeinfratech@gmail.com']);

// Google Ads tag already used on the site
define('GOOGLE_TAG_ID', 'AW-11515555005');

date_default_timezone_set('Asia/Kolkata');

/**
 * Every solution the company offers, in menu order. Used by the header menu,
 * the footer, the /services hub and "related solutions" links on each page.
 * [path, menu label, one-line description, group]
 */
const GE_SOLUTIONS = [
    ['/residential-solar', 'Home rooftop solar', 'On-grid, hybrid and off-grid systems for houses and villas', 'Homes & communities'],
    ['/pmsuryaghar/', 'PM Surya Ghar subsidy', 'Up to ₹1,08,000 subsidy for eligible UP homes', 'Homes & communities'],
    ['/housing-society-solar', 'Housing societies & RWAs', '₹18,000/kW subsidy for common areas and EV charging', 'Homes & communities'],
    ['/commercial-solar', 'Commercial solar', 'Shops, offices, schools, hospitals, hotels', 'Business & industry'],
    ['/industrial-solar', 'Industrial solar', 'Factories, cold stores, mills, warehouses', 'Business & industry'],
    ['/resco-solar', 'Zero-investment solar (RESCO)', 'Pay only for the power, no upfront cost', 'Business & industry'],
    ['/open-access-solar', 'Green energy open access', 'Solar power from an off-site plant for 100 kW+ users', 'Business & industry'],
    ['/government-solar', 'Government & institutions', 'Government buildings, PSUs, schools, colleges, hospitals', 'Government & farms'],
    ['/solar-pumps-kusum', 'Solar pumps & PM-KUSUM', 'Solar irrigation pumps and farm solar plants', 'Government & farms'],
    ['/solar-maintenance', 'Maintenance & AMC', 'Cleaning, health checks and repairs for any solar plant', 'Government & farms'],
];

function e(?string $s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function wa_link(string $text): string { return 'https://wa.me/' . BIZ_WHATSAPP . '?text=' . rawurlencode($text); }
function site(string $key) { global $GE_SITE; return $GE_SITE[$key] ?? null; }

/** Very small, safe formatter for admin-written text: ## headings, - lists, **bold**, [links](url), paragraphs. */
function ge_format(string $text): string {
    $lines = preg_split('/\r\n|\r|\n/', trim($text));
    $html = ''; $para = []; $list = null;
    $inline = function (string $s): string {
        $s = e($s);
        $s = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $s);
        return preg_replace_callback('/\[([^\]]+)\]\(((?:https?:\/\/|\/)[^\s)]*)\)/', fn($m) => '<a href="' . $m[2] . '">' . $m[1] . '</a>', $s);
    };
    $flush = function () use (&$html, &$para, &$list, $inline) {
        if ($para) { $html .= '<p>' . $inline(implode(' ', $para)) . "</p>\n"; $para = []; }
        if ($list) { $html .= '<' . $list[0] . '>' . implode('', array_map(fn($i) => '<li>' . $inline($i) . '</li>', $list[1])) . '</' . $list[0] . ">\n"; $list = null; }
    };
    foreach ($lines as $l) {
        $t = trim($l);
        if ($t === '') { $flush(); continue; }
        if (preg_match('/^(#{2,3})\s+(.+)$/', $t, $m)) { $flush(); $h = strlen($m[1]); $html .= "<h$h>" . $inline($m[2]) . "</h$h>\n"; continue; }
        if (preg_match('/^[-*]\s+(.+)$/', $t, $m)) { if ($para) $flush(); if (!$list || $list[0] !== 'ul') { $flush(); $list = ['ul', []]; } $list[1][] = $m[1]; continue; }
        if (preg_match('/^\d+[.)]\s+(.+)$/', $t, $m)) { if ($para) $flush(); if (!$list || $list[0] !== 'ol') { $flush(); $list = ['ol', []]; } $list[1][] = $m[1]; continue; }
        if ($list) $flush();
        $para[] = $t;
    }
    $flush();
    return $html;
}
