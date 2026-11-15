<?php
/**
 * Admin sign-in for /manage/: no passwords. An allowed email address receives a
 * 6-digit code valid for 10 minutes. Codes are stored hashed outside public_html.
 */
declare(strict_types=1);
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../mailer.php';

define('ADMIN_STATE_DIR', PRIVATE_ROOT . '/private_config/admin');
const ADMIN_IDLE_SECONDS = 7200;   // sign out after 2 hours of inactivity
const OTP_TTL = 600;               // code valid for 10 minutes
const OTP_MAX_TRIES = 5;
const OTP_MAX_SENDS = 4;           // per 15 minutes

function admin_state(string $name, ?array $data = null): array {
    if (!is_dir(ADMIN_STATE_DIR)) { @mkdir(ADMIN_STATE_DIR, 0700, true); @file_put_contents(ADMIN_STATE_DIR . '/.htaccess', "Require all denied\n"); }
    $f = ADMIN_STATE_DIR . '/' . $name . '.json';
    if ($data !== null) { file_put_contents($f, json_encode($data), LOCK_EX); return $data; }
    $d = is_file($f) ? json_decode((string)file_get_contents($f), true) : [];
    return is_array($d) ? $d : [];
}

function admin_log(string $event): void {
    if (!is_dir(ADMIN_STATE_DIR)) admin_state('init', []);
    $who = $_SESSION['admin_email'] ?? '-';
    $ip = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '')[0]);
    @file_put_contents(ADMIN_STATE_DIR . '/activity.log', date('c') . " $who $ip $event\n", FILE_APPEND | LOCK_EX);
}

function admin_session_start(): void {
    if (session_status() === PHP_SESSION_ACTIVE) return;
    session_name('ge_admin');
    session_set_cookie_params(['lifetime' => 0, 'path' => '/manage', 'secure' => (($_SERVER['HTTPS'] ?? '') === 'on' || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https' || (string)($_SERVER['SERVER_PORT'] ?? '') === '443'), 'httponly' => true, 'samesite' => 'Strict']);
    session_start();
    if (!empty($_SESSION['admin_email']) && (time() - ($_SESSION['last_seen'] ?? 0)) > ADMIN_IDLE_SECONDS) {
        $_SESSION = []; session_regenerate_id(true);
    }
    $_SESSION['last_seen'] = time();
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

function admin_is_logged_in(): bool { return !empty($_SESSION['admin_email']); }
function csrf_field(): string { return '<input type="hidden" name="csrf" value="' . e($_SESSION['csrf']) . '">'; }
function csrf_check(): void {
    if (!hash_equals($_SESSION['csrf'] ?? '', (string)($_POST['csrf'] ?? ''))) { http_response_code(400); exit('Your session expired. Please go back and try again.'); }
}

/** @return string message for the user */
function admin_send_code(string $email): string {
    $email = strtolower(trim($email));
    $generic = 'If this email is allowed, a 6-digit code has been sent to it. Check your inbox (and the Promotions/Spam tabs).';
    $allowed = array_map('strtolower', ADMIN_EMAILS);
    $rl = admin_state('ratelimit');
    $rl = array_values(array_filter($rl, fn($t) => $t > time() - 900));
    if (count($rl) >= OTP_MAX_SENDS) return 'Too many codes requested. Please wait 15 minutes and try again.';
    $rl[] = time(); admin_state('ratelimit', $rl);
    if (!in_array($email, $allowed, true)) { admin_log("login-code-refused $email"); return $generic; }
    $code = (string)random_int(100000, 999999);
    admin_state('otp', ['email' => $email, 'hash' => password_hash($code, PASSWORD_DEFAULT), 'expires' => time() + OTP_TTL, 'tries' => 0]);
    [$ok, $diag] = ge_send_mail($email, 'Your Greenedge admin sign-in code: ' . $code,
        "Your sign-in code for the Greenedge website admin panel is:\n\n    $code\n\nIt is valid for 10 minutes. If you did not try to sign in, you can ignore this email.\n\n" . SITE_URL . "/manage/");
    admin_log('login-code-sent ' . ($ok ? 'ok' : 'FAILED ' . $diag));
    $_SESSION['pending_email'] = $email;
    return $ok ? $generic : 'The code email could not be sent. Please try again later.';
}

function admin_verify_code(string $code): bool {
    $otp = admin_state('otp');
    if (!$otp || empty($_SESSION['pending_email']) || $otp['email'] !== $_SESSION['pending_email']) return false;
    if (time() > (int)$otp['expires'] || (int)$otp['tries'] >= OTP_MAX_TRIES) { admin_state('otp', []); return false; }
    $otp['tries'] = (int)$otp['tries'] + 1; admin_state('otp', $otp);
    if (!password_verify(preg_replace('/\D/', '', $code), $otp['hash'])) { admin_log('login-code-wrong'); return false; }
    admin_state('otp', []);
    session_regenerate_id(true);
    $_SESSION['admin_email'] = $otp['email'];
    unset($_SESSION['pending_email']);
    admin_log('login-ok');
    return true;
}

function admin_logout(): void { admin_log('logout'); $_SESSION = []; session_regenerate_id(true); }
