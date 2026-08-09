<?php
include "db.php";

// ===== FOR FETCH REQUESTS — CAPTURE POST SAFELY =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // If normal POST didn't populate:
    if(empty($_POST)){
        parse_str(file_get_contents("php://input"), $_POST);
    }

    // Debug log
    file_put_contents("debug_post.txt", print_r($_POST, true));
}

use PHPMailer\PHPMailer;
use PHPMailer\Exception;

// DEBUG: log what PHP receives
file_put_contents("debug_post.txt", print_r($_POST, true));

// Collect POST data
$name               = $_POST['name']              ?? '';
$city               = $_POST['city']              ?? '';
$phone              = $_POST['phone']             ?? '';
$email              = $_POST['email']             ?? '';
$system_size        = $_POST['system_size']       ?? '';
$estimated_cost     = $_POST['estimated_cost']    ?? '';
$monthly_generation = $_POST['monthly_generation']?? '';
$payback_period     = $_POST['payback_period']    ?? '';
$annual_savings     = $_POST['annual_savings']    ?? '';

// Basic validation – don't insert fully empty rows
if ($name === '' && $city === '' && $phone === '' && $email === '') {
    echo "No form data received";
    exit;
}

// Insert into DB
$stmt = $conn->prepare("INSERT INTO solar_requests 
    (name, city, phone, email, system_size, estimated_cost, monthly_generation, payback_period, annual_savings)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param(
    "sssssssss",
    $name, $city, $phone, $email,
    $system_size, $estimated_cost, $monthly_generation, $payback_period, $annual_savings
);

if (!$stmt->execute()) {
    echo "DB Error: " . $stmt->error;
    exit;
}

require_once __DIR__ . '/mail_config.php';

try {
    $mail = createMailer();
    $mail->setFrom(SMTP_FROM_EMAIL, "Solar Quote Lead");
    $mail->addAddress(SMTP_FROM_EMAIL);

    $mail->isHTML(true);
    $mail->Subject = "New Solar Quote Request";

    $mail->Body = <<<HTML
<h2>New Solar Quote Request</h2>
<b>Name:</b> {$name}<br>
<b>City:</b> {$city}<br>
<b>Phone:</b> {$phone}<br>
<b>Email:</b> {$email}<br><br>
<b>System Size:</b> {$system_size} kW<br>
<b>Estimated Cost:</b> ₹{$estimated_cost}<br>
<b>Monthly Generation:</b> {$monthly_generation} kWh<br>
<b>Payback Period:</b> {$payback_period} Years<br>
<b>Annual Savings:</b> ₹{$annual_savings}<br>
HTML;

    $mail->send();
    echo "success";
} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}

$stmt->close();
$conn->close();
