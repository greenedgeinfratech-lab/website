<?php
/**
 * Minimal authenticated SMTP sender (no external libraries).
 * Settings are read from a private file OUTSIDE public_html:
 *   /home/<user>/domains/greenedgeinfratech.com/private_config/mail.php
 * which must return:
 *   ['host'=>'smtp.hostinger.com','port'=>465,'user'=>'website@greenedgeinfratech.com','pass'=>'...','from_name'=>'Greenedge Website']
 * If that file is missing or has no password, PHP mail() is used as a fallback.
 */
declare(strict_types=1);

function ge_mail_config(): array {
    $file = dirname(__DIR__, 2) . '/private_config/mail.php';
    $cfg = is_file($file) ? (include $file) : [];
    return is_array($cfg) ? $cfg : [];
}

/** @return array{0:bool,1:string} [sent, diagnostic] */
function ge_send_mail(string $to, string $subject, string $body, string $replyTo = ''): array {
    $cfg = ge_mail_config();
    $fromName = $cfg['from_name'] ?? MAIL_FROM_NAME;
    $from = $cfg['user'] ?? MAIL_FROM;
    $encSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
    $encName = '=?UTF-8?B?' . base64_encode($fromName) . '?=';
    $headers = [
        'Date: ' . date('r'),
        'From: ' . $encName . ' <' . $from . '>',
        'To: <' . $to . '>',
        'Subject: ' . $encSubject,
        'Message-ID: <' . bin2hex(random_bytes(12)) . '@greenedgeinfratech.com>',
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
        'Content-Transfer-Encoding: base64',
    ];
    if ($replyTo !== '' && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) $headers[] = 'Reply-To: <' . $replyTo . '>';

    if (empty($cfg['pass']) || empty($cfg['user'])) {
        // Fallback: PHP mail(). Hostinger only delivers this if $from is a real mailbox on the domain.
        $h = array_filter($headers, fn($l) => !preg_match('/^(To|Subject|Date|Message-ID):/', $l));
        $ok = @mail($to, $encSubject, chunk_split(base64_encode($body)), implode("\r\n", $h), '-f' . $from);
        return [$ok, $ok ? 'mail() accepted (no SMTP settings found)' : 'mail() failed (no SMTP settings found)'];
    }

    $host = $cfg['host'] ?? 'smtp.hostinger.com';
    $port = (int)($cfg['port'] ?? 465);
    $errno = 0; $errstr = '';
    $fp = @stream_socket_client(($port === 465 ? 'ssl://' : 'tcp://') . $host . ':' . $port, $errno, $errstr, 15);
    if (!$fp) return [false, "connect failed: $errstr ($errno)"];
    stream_set_timeout($fp, 15);
    $read = function () use ($fp): string {
        $data = '';
        while (($line = fgets($fp, 515)) !== false) { $data .= $line; if (strlen($line) < 4 || $line[3] === ' ') break; }
        return $data;
    };
    $cmd = function (string $c, array $expect) use ($fp, $read): array {
        if ($c !== '') fwrite($fp, $c . "\r\n");
        $r = $read();
        return [in_array((int)substr($r, 0, 3), $expect, true), trim($r)];
    };
    $steps = [
        ['', [220]],
        ['EHLO greenedgeinfratech.com', [250]],
    ];
    foreach ($steps as [$c, $e]) { [$ok, $r] = $cmd($c, $e); if (!$ok) { fclose($fp); return [false, "SMTP: $r"]; } }
    if ($port === 587) {
        [$ok, $r] = $cmd('STARTTLS', [220]);
        if (!$ok || !stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) { fclose($fp); return [false, "STARTTLS: $r"]; }
        $cmd('EHLO greenedgeinfratech.com', [250]);
    }
    foreach ([
        ['AUTH LOGIN', [334]],
        [base64_encode($cfg['user']), [334]],
        [base64_encode($cfg['pass']), [235]],
        ['MAIL FROM:<' . $from . '>', [250]],
        ['RCPT TO:<' . $to . '>', [250, 251]],
        ['DATA', [354]],
    ] as $i => [$c, $e]) {
        [$ok, $r] = $cmd($c, $e);
        if (!$ok) { fclose($fp); return [false, 'SMTP step ' . ($i + 1) . ': ' . ($i === 2 ? 'authentication failed' : $r)]; }
    }
    $msg = implode("\r\n", $headers) . "\r\n\r\n" . chunk_split(base64_encode($body)) . "\r\n.";
    [$ok, $r] = $cmd($msg, [250]);
    $cmd('QUIT', [221]);
    fclose($fp);
    return [$ok, $ok ? 'SMTP sent' : "SMTP DATA: $r"];
}
