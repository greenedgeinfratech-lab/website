<?php
/**
 * Greenedge Infratech - website lead endpoint
 * Receives calculator, quotation, site-survey and contact enquiries.
 *  1. Validates and cleans the input, blocks spam (honeypot, timing, rate limit, origin check).
 *  2. Saves every lead to a private file OUTSIDE public_html (never web-readable).
 *  3. Emails the lead to the sales inbox.
 * Responds with JSON: { ok: bool, message: string }
 */
declare(strict_types=1);
require __DIR__ . '/../inc/config.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
header('X-Robots-Tag: noindex');

function respond(bool $ok, string $message, int $code = 200): void {
    http_response_code($code);
    echo json_encode(['ok' => $ok, 'message' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    respond(false, 'Method not allowed.', 405);
}

// Same-site check: browsers send Origin on POST; reject other sites posting here.
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if ($origin !== '' && !in_array(parse_url($origin, PHP_URL_HOST), SITE_HOSTS, true)) {
    respond(false, 'Request not allowed.', 403);
}

$raw = file_get_contents('php://input', false, null, 0, 20000) ?: '';
$in = stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false
    ? (json_decode($raw, true) ?: [])
    : $_POST;

function field(array $in, string $key, int $max = 200): string {
    $v = isset($in[$key]) && is_scalar($in[$key]) ? (string)$in[$key] : '';
    $v = trim(preg_replace('/[\x00-\x1F\x7F]+/u', ' ', $v) ?? '');
    return mb_substr($v, 0, $max);
}

// --- spam traps -----------------------------------------------------------
if (field($in, 'website') !== '') {           // hidden honeypot: humans leave it empty
    respond(true, 'Thank you! Our solar expert will call you shortly.');
}
$startedAt = (int)field($in, 'ts', 20);
if ($startedAt > 0 && (time() * 1000 - $startedAt) < 3000) { // filled in under 3 seconds
    respond(false, 'Please take a moment to check your details and try again.', 400);
}

$privateDir = dirname(__DIR__, 2) . '/private_leads';
if (!is_dir($privateDir)) {
    @mkdir($privateDir, 0700, true);
    @file_put_contents($privateDir . '/.htaccess', "Require all denied\n");
}

// Rate limit: max 5 enquiries per IP per hour
$ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$ip = trim(explode(',', $ip)[0]);
$rateFile = $privateDir . '/rate-' . hash('sha256', $ip . date('YmdH')) . '.cnt';
$hits = is_file($rateFile) ? (int)file_get_contents($rateFile) : 0;
if ($hits >= 5) {
    respond(false, 'Too many requests. Please call us on ' . BIZ_PHONE_DISPLAY . '.', 429);
}
@file_put_contents($rateFile, (string)($hits + 1), LOCK_EX);

// --- validation -------------------------------------------------------------
$name  = field($in, 'name', 80);
$phone = preg_replace('/\D+/', '', field($in, 'phone', 20)) ?? '';
if (strlen($phone) === 12 && str_starts_with($phone, '91')) $phone = substr($phone, 2);
if (strlen($phone) === 11 && str_starts_with($phone, '0'))  $phone = substr($phone, 1);
$city     = field($in, 'city', 80);
$email    = field($in, 'email', 120);
$category = field($in, 'category', 20);
$type     = field($in, 'enquiry_type', 30);
$message  = field($in, 'message', 1500);
$company  = field($in, 'company', 120);
$partnerType = field($in, 'partner_type', 80);
$consent  = in_array(field($in, 'consent', 5), ['1', 'on', 'true', 'yes'], true);

$errors = [];
if (mb_strlen($name) < 2)                      $errors[] = 'your name';
if (!preg_match('/^[6-9]\d{9}$/', $phone))      $errors[] = 'a valid 10-digit mobile number';
if (mb_strlen($city) < 2)                      $errors[] = 'your city and state';
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'a valid email (or leave it blank)';
if (!$consent)                                 $errors[] = 'your consent to be contacted';
if ($errors) {
    respond(false, 'Please add ' . implode(', ', $errors) . '.', 422);
}
if (!in_array($category, ['residential', 'commercial', 'industrial', 'pm-surya-ghar', 'housing-society', 'government', 'agriculture', 'other'], true)) $category = 'other';
if (!in_array($type, ['calculator', 'quotation', 'site-survey', 'callback', 'contact', 'partner'], true)) $type = 'contact';

// Calculator results (kept as numbers only)
$calc = [];
$calcRaw = json_decode(field($in, 'calc_summary', 2000), true);
if (is_array($calcRaw)) {
    foreach (['system_kw', 'monthly_units', 'monthly_bill', 'tariff', 'annual_savings', 'subsidy', 'net_cost', 'payback_years', 'houses'] as $k) {
        if (isset($calcRaw[$k]) && is_numeric($calcRaw[$k])) $calc[$k] = $calcRaw[$k] + 0;
    }
    if (isset($calcRaw['cost_range']) && is_array($calcRaw['cost_range'])) {
        $calc['cost_range'] = array_map('intval', array_slice($calcRaw['cost_range'], 0, 2));
    }
}

$lead = [
    'id'           => date('Ymd-His') . '-' . substr(bin2hex(random_bytes(3)), 0, 6),
    'received_at'  => date('c'),
    'enquiry_type' => $type,
    'category'     => $category,
    'name'         => $name,
    'phone'        => $phone,
    'city'         => $city,
    'email'        => $email,
    'company'      => $company,
    'partner_type' => $partnerType,
    'message'      => $message,
    'calculator'   => $calc ?: null,
    'source_page'  => field($in, 'source_page', 300),
    'referrer'     => field($in, 'referrer', 300),
    'utm'          => array_filter([
        'source'   => field($in, 'utm_source', 100),
        'medium'   => field($in, 'utm_medium', 100),
        'campaign' => field($in, 'utm_campaign', 100),
        'term'     => field($in, 'utm_term', 100),
        'content'  => field($in, 'utm_content', 100),
        'gclid'    => field($in, 'gclid', 200),
    ]),
    'consent'      => true,
    'ip_hash'      => hash('sha256', $ip),
];

// --- spam score: sales pitches (SEO, marketing, web design...) are kept aside, not emailed
function ge_spam_score(string $text, string $email, int $startedAt): array {
    $t = mb_strtolower($text);
    $why = []; $score = 0;
    $strong = ['seo', 'search engine', 'search result', 'first page', 'page 1 of google', 'top of google', 'rank higher', 'ranking',
        'backlink', 'guest post', 'traffic', 'digital marketing', 'marketing services', 'web design', 'website design', 'redesign',
        'web development', 'app development', 'lead generation', 'more leads', 'more customers', 'virtual assistant', 'outsourc',
        'crypto', 'bitcoin', 'casino', 'betting', 'forex', 'loan offer', 'unsubscribe', 'opt out', 'local market', 'keyword',
        'google maps ranking', 'social media management', 'video explainer', 'whatsapp marketing', 'bulk sms', 'ai chatbot'];
    $weak = ['your website', 'your business', 'your niche', 'let me know', 'i noticed', 'i came across', 'free trial', 'dominate',
        'within 24 hours', 'measurable', 'no obligation', 'quick call', 'interested?', 'schedule a call', 'estimates'];
    foreach ($strong as $k) if (preg_match('/\b' . preg_quote($k, '/') . '/u', $t)) { $score += 3; $why[] = $k; }
    foreach ($weak as $k) if (str_contains($t, $k)) { $score += 1; $why[] = $k; }
    if (preg_match('~https?://|www\.|\.(com|net|io|co|xyz|ru)\b/?~i', $text)) { $score += 2; $why[] = 'link'; }
    $domain = strtolower(substr(strrchr($email, '@') ?: '', 1));
    $badDomains = ['jmailservice.com', 'mailinator.com', 'guerrillamail.com', 'yopmail.com', 'tempmail.com', '10minutemail.com',
        'sharklasers.com', 'trashmail.com', 'getnada.com', 'temp-mail.org', 'dispostable.com'];
    if ($domain !== '' && in_array($domain, $badDomains, true)) { $score += 4; $why[] = 'throwaway email'; }
    if ($startedAt <= 0) { $score += 2; $why[] = 'form not used'; }
    if (preg_match('/[\x{0900}-\x{097F}]/u', $text)) { $score -= 3; }   // Hindi text: a real local visitor
    return [$score, $why];
}
[$spamScore, $spamWhy] = ge_spam_score($message . ' ' . $company . ' ' . $name, $email, $startedAt);
if ($spamScore >= 4) {
    $lead['spam'] = ['score' => $spamScore, 'reasons' => $spamWhy];
    @file_put_contents($privateDir . '/spam-' . date('Y-m') . '.jsonl',
        json_encode($lead, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n", FILE_APPEND | LOCK_EX);
    // Same reply as a real lead, so the sender cannot tell it was filtered. No emails are sent.
    respond(true, 'Thank you, ' . $name . '! Our solar expert will call you on ' . $phone . ' within one working day.');
}

// --- 1. save (always, before email, so no lead is lost) ---------------------
$saved = @file_put_contents(
    $privateDir . '/leads-' . date('Y-m') . '.jsonl',
    json_encode($lead, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n",
    FILE_APPEND | LOCK_EX
) !== false;

// --- 2. email ------------------------------------------------------------------
$labels = [
    'calculator' => 'Solar calculator', 'quotation' => 'Quotation request', 'site-survey' => 'Free site survey',
    'callback' => 'Call-back request', 'contact' => 'Contact form', 'partner' => 'Partner application',
];
$subject = 'New ' . ($labels[$type] ?? 'website') . ' lead: ' . $name . ' (' . $city . ')'
    . (isset($calc['system_kw']) ? ' - ' . $calc['system_kw'] . ' kW' : '');

$lines = [
    'New enquiry from greenedgeinfratech.com',
    str_repeat('-', 44),
    'Type:      ' . ($labels[$type] ?? $type),
    'Category:  ' . ucfirst(str_replace('-', ' ', $category)),
    'Name:      ' . $name,
    'Company:   ' . ($company ?: '-'),
    'Mobile:    +91 ' . $phone,
    'City:      ' . $city,
    'Email:     ' . ($email ?: '-'),
    'Message:   ' . ($message ?: '-'),
];
if ($partnerType !== '') array_splice($lines, 3, 0, ['Partner as: ' . $partnerType]);
if ($calc) {
    $lines[] = '';
    $lines[] = 'Calculator result';
    $lines[] = str_repeat('-', 44);
    $map = [
        'system_kw' => ['Recommended system', ' kW'], 'monthly_units' => ['Monthly units', ''],
        'monthly_bill' => ['Monthly bill', '', 'Rs '], 'tariff' => ['Tariff', ' /unit', 'Rs '],
        'annual_savings' => ['Est. savings (yr 1)', '', 'Rs '], 'subsidy' => ['Subsidy (if eligible)', '', 'Rs '],
        'net_cost' => ['Net cost', '', 'Rs '], 'payback_years' => ['Payback', ' years'], 'houses' => ['Houses in society', ''],
    ];
    foreach ($map as $k => $m) {
        if (isset($calc[$k])) $lines[] = str_pad($m[0] . ':', 24) . ($m[2] ?? '') . number_format((float)$calc[$k], is_float($calc[$k]) ? 1 : 0) . $m[1];
    }
    if (isset($calc['cost_range'])) $lines[] = str_pad('Est. cost range:', 24) . 'Rs ' . number_format($calc['cost_range'][0]) . ' - ' . number_format($calc['cost_range'][1]);
}
$lines[] = '';
$lines[] = 'Page:      ' . ($lead['source_page'] ?: '-');
if ($lead['utm']) $lines[] = 'Campaign:  ' . http_build_query($lead['utm'], '', ', ');
$lines[] = 'Lead ID:   ' . $lead['id'];
$lines[] = '';
$lines[] = 'Call: tel:+91' . $phone . '   WhatsApp: https://wa.me/91' . $phone;

require __DIR__ . '/../inc/mailer.php';
[$mailed, $diag] = ge_send_mail(LEAD_EMAIL_TO, $subject, implode("\n", $lines), $email);

// Acknowledgement to the customer, if they gave an email
$ackDiag = '-';
if ($email !== '') {
    $ack = [
        'Dear ' . $name . ',',
        '',
        $type === 'partner'
        ? 'Thank you for your interest in partnering with Greenedge Infratech. Our partnerships team will call you on +91 ' . $phone . ' within two working days.'
        : 'Thank you for contacting Greenedge Infratech. We have received your solar enquiry and a solar expert will call you on +91 ' . $phone . ' within one working day.',
    ];
    if (isset($calc['system_kw'])) {
        $ack[] = '';
        $ack[] = 'Your calculator estimate (indicative, to be confirmed after a site survey):';
        $ack[] = '- Recommended system: ' . $calc['system_kw'] . ' kW';
        if (isset($calc['annual_savings'])) $ack[] = '- Estimated savings in year 1: Rs ' . number_format((float)$calc['annual_savings']);
        if (!empty($calc['subsidy'])) $ack[] = '- PM Surya Ghar subsidy (incl. state subsidy where applicable), if eligible: up to Rs ' . number_format((float)$calc['subsidy']);
        if (isset($calc['payback_years'])) $ack[] = '- Simple payback: about ' . $calc['payback_years'] . ' years';
    }
    $ack[] = '';
    $ack[] = 'If you would like to talk sooner, call or WhatsApp us on ' . BIZ_PHONE_DISPLAY . '.';
    $ack[] = '';
    $ack[] = 'Regards,';
    $ack[] = BIZ_NAME;
    $ack[] = BIZ_STREET . ', ' . BIZ_CITY . ', ' . BIZ_REGION . ' ' . BIZ_PIN;
    $ack[] = SITE_URL;
    [$ackOk, $ackDiag] = ge_send_mail($email, 'We received your solar enquiry - Greenedge Infratech', implode("\n", $ack), LEAD_EMAIL_TO);
}
@file_put_contents($privateDir . '/mail-log.txt', date('c') . ' ' . $lead['id'] . ' company:' . $diag . ' customer:' . $ackDiag . "\n", FILE_APPEND | LOCK_EX);

if (!$saved && !$mailed) {
    error_log('Lead capture failed for ' . $lead['id']);
    respond(false, 'Sorry, something went wrong. Please call or WhatsApp us on ' . BIZ_PHONE_DISPLAY . '.', 500);
}
if (!$mailed) {
    error_log('Lead saved but email failed: ' . $lead['id']);
}

respond(true, $type === 'partner'
    ? 'Thank you, ' . $name . '! Our partnerships team will call you on ' . $phone . ' within two working days.'
    : 'Thank you, ' . $name . '! Our solar expert will call you on ' . $phone . ' within one working day.');
