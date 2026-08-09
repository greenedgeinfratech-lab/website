<?php
// Session start karna zaruri hai Rate Limiting aur CSRF ke liye
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'db.php';
require_once __DIR__ . '/../mail_config.php';

// Generate CSRF token if not exists
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && 
    isset($_POST['form_type']) && 
    $_POST['form_type'] === 'contact_form') {

    /* =========================
       🛡️ ANTI-SPAM SHIELD START
    ========================== */

    // 1. HONEYPOT TRAP (Silent drop)
    if (!empty($_POST['website'])) {
        // Bot pakda gaya. Chupchap process kill kar do, error mat dikhao.
        die(); 
    }

    // 2. CSRF TOKEN VERIFICATION
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("<div style='color:red; font-weight:bold; margin-bottom:15px;'>Security token mismatch. Please refresh the page and try again.</div>");
    }

    // 3. RATE LIMITING (30 seconds cooldown)
    if (isset($_SESSION['last_submit']) && (time() - $_SESSION['last_submit']) < 30) {
        die("<div style='color:red; font-weight:bold; margin-bottom:15px;'>Please wait a moment before sending another message.</div>");
    }

    // 4. GOOGLE reCAPTCHA VERIFICATION
    $recaptchaSecret = "6LeaHnUsAAAAAOl-3DpOGIBp3NxHH-2_JPjHLeyd";
    $recaptchaResponse = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';
    
    if(empty($recaptchaResponse)) {
        die("<div style='color:red; font-weight:bold; margin-bottom:15px;'>Please complete the reCAPTCHA to verify you are human.</div>");
    }

    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecret}&response={$recaptchaResponse}");
    $responseData = json_decode($verify);
    
    if (!$responseData->success) {
        die("<div style='color:red; font-weight:bold; margin-bottom:15px;'>Captcha verification failed.</div>");
    }

    /* =========================
       🧹 SANITIZATION
    ========================== */

    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name  = htmlspecialchars(trim($_POST['last_name']));
    $email      = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone      = htmlspecialchars(trim($_POST['phone']));
    $property   = htmlspecialchars(trim($_POST['property_type']));
    $message    = htmlspecialchars(trim($_POST['message']));

    // Strict Email Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("<div style='color:red; font-weight:bold; margin-bottom:15px;'>Please enter a valid email format.</div>");
    }

    // Rate Limiting ke liye time save karo
    $_SESSION['last_submit'] = time();

    /* =========================
       1️⃣ SAVE TO DATABASE
    ========================== */

    $stmt = $conn->prepare("INSERT INTO contact_inquiries 
        (first_name, last_name, email, phone, property_type, message) 
        VALUES (?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssss", 
        $first_name, $last_name, $email, $phone, $property, $message
    );

    if ($stmt->execute()) {
        $saved = true;
    } else {
        $error = "Database Error: " . $stmt->error;
    }

    $stmt->close();

    /* =========================
       2️⃣ SEND EMAIL
    ========================== */

    if(isset($saved)) {
        try {
            $mail = createMailer();
            $mail->setFrom(SMTP_FROM_EMAIL, 'GreenEdge Website');
            $mail->addAddress(SMTP_FROM_EMAIL);
            $mail->addReplyTo($email, "$first_name $last_name");

            $mail->isHTML(true);
            $mail->Subject = "New Contact Inquiry from $first_name $last_name";

            $mail->Body = "
            <h2>New Contact Form Submission</h2>
            <p><strong>First Name:</strong> $first_name</p>
            <p><strong>Last Name:</strong> $last_name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Property Type:</strong> $property</p>
            <p><strong>Message:</strong><br>$message</p>
            ";

            $mail->send();
            $success = true;

        } catch (Exception $e) {
            $error = $mail->ErrorInfo;
        }
    }
}
?>

<form action="" method="POST" class="space-y-6">
    <input type="hidden" name="form_type" value="contact_form">
    
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="first-name" class="font-medium">First Name</label>
            <input id="first-name" name="first_name" type="text" placeholder="Enter your first name"
                class="mt-1 w-full border rounded-md px-3 py-2" required />
        </div>
        <div>
            <label for="last-name" class="font-medium">Last Name</label>
            <input id="last-name" name="last_name" type="text" placeholder="Enter your last name"
                class="mt-1 w-full border rounded-md px-3 py-2" required />
        </div>
    </div>

    <div>
        <label for="email" class="font-medium">Email Address</label>
        <input id="email" name="email" type="email" placeholder="your@email.com"
            class="mt-1 w-full border rounded-md px-3 py-2" required />
    </div>

    <div>
        <label for="phone" class="font-medium">Phone Number</label>
        <input id="phone" name="phone" type="tel" placeholder="+91 98370 67681"
            class="mt-1 w-full border rounded-md px-3 py-2" required />
    </div>

    <div>
        <label for="property-type" class="font-medium">Property Type</label>
        <select id="property-type" name="property_type"
            class="w-full mt-1 px-3 py-2 border rounded-md" required>
            <option>Residential House</option>
            <option>Commercial Building</option>
            <option>Industrial Facility</option>
            <option>Agricultural Land</option>
        </select>
    </div>

    <div style="position: absolute; left: -5000px;" aria-hidden="true">
        <label for="website">Leave this field blank if you are human</label>
        <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
    </div>

    <div>
        <label for="message" class="font-medium">Message</label>
        <textarea id="message" name="message" placeholder="Tell us about your solar energy requirements..."
            class="mt-1 w-full border rounded-md px-3 py-2 min-h-[100px]" required></textarea>
    </div>

    <div class="g-recaptcha" data-sitekey="6LeaHnUsAAAAAA7ZPcZ0EXO6tQAJsE9Y97NzHCgS"></div>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <button type="submit"
        class="w-full flex items-center justify-center bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700">
        <i data-lucide="send" class="w-5 h-5 mr-2"></i>
        Send Message
    </button>
</form>