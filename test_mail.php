<?php
// Test Script for SMTP Diagnostics
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/mail_config.php';

echo "=== SMTP Connection & Authentication Test ===\n";

try {
    $mail = createMailer();
    $mail->SMTPDebug = 2; // Output SMTP connection details
    $mail->Debugoutput = 'echo';

    $mail->addAddress(SMTP_FROM_EMAIL); // Send test mail to self
    $mail->Subject = "SMTP Diagnostic Test - " . date("Y-m-d H:i:s");
    $mail->Body    = "If you receive this email, your SMTP configuration is working correctly!";

    echo "Attempting to send test email to " . SMTP_FROM_EMAIL . "...\n\n";
    
    if ($mail->send()) {
        echo "\nSUCCESS: Test email sent successfully! SMTP authentication is working properly.\n";
    }
} catch (Exception $e) {
    echo "\nFAILED: Mailer Error\n";
    echo "Error Message: " . $e->getMessage() . "\n";
    echo "PHPMailer Info: " . $mail->ErrorInfo . "\n";
}
