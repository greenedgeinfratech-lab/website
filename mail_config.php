<?php
// Centralized SMTP Configuration for Greenedge Infratech

define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_SECURE', 'tls'); // Options: 'tls' (Port 587) or 'ssl' (Port 465)
define('SMTP_AUTH', true);
define('SMTP_USER', 'greenedgeinfratech@gmail.com');
define('SMTP_PASS', 'lcle rahq ncpw refc'); // Google App Password (16 characters)
define('SMTP_FROM_EMAIL', 'greenedgeinfratech@gmail.com');
define('SMTP_FROM_NAME', 'Greenedge Infratech');

require_once __DIR__ . '/PHPMailer/src/Exception.php';
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Creates and configures a new PHPMailer instance using global SMTP settings.
 * @return PHPMailer
 */
function createMailer() {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = SMTP_HOST;
    $mail->SMTPAuth   = SMTP_AUTH;
    $mail->Username   = SMTP_USER;
    $mail->Password   = SMTP_PASS;
    $mail->SMTPSecure = SMTP_SECURE;
    $mail->Port       = SMTP_PORT;
    $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
    return $mail;
}
