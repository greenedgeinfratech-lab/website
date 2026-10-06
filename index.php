<?php
// START SESSION FOR SECURITY (CSRF & Rate Limiting)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/* ==========================================================================
   1. BACKEND LOGIC: DATABASE + EMAIL
   ========================================================================== */

// Database Connection
include "db.php"; 

// Check POST Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' 
    && isset($_POST['form_type']) 
    && $_POST['form_type'] === 'solar_form') {
    
    // Clear buffer to avoid unwanted output
    ob_clean();

    // Handle standard POST or JSON input
    if (empty($_POST)) {
        $input = file_get_contents("php://input");
        $_POST = json_decode($input, true) ?: [];
        if (empty($_POST)) {
            parse_str($input, $_POST);
        }
    }

    /* =========================
       🛡️ ANTI-SPAM SECURITY LAYERS
    ========================== */

    // 1. HONEYPOT TRAP
    if (!empty($_POST['website_url'])) {
        // Bot detected! Return fake success to fool the bot, but do nothing.
        echo "success";
        exit;
    }

    // 2. CSRF TOKEN CHECK
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo "csrf_error";
        exit;
    }

    // 3. RATE LIMITING (30 Seconds Cooldown)
    if (isset($_SESSION['last_solar_index_submit']) && (time() - $_SESSION['last_solar_index_submit']) < 30) {
        echo "rate_limit";
        exit;
    }

    // --- 1. COLLECT & SANITIZE DATA ---
    $name            = htmlspecialchars(trim($_POST['name'] ?? ''));
    $city            = htmlspecialchars(trim($_POST['city'] ?? ''));
    $phone           = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $email           = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    
    $system_size     = floatval($_POST['system_size'] ?? 0);
    $estimated_cost  = floatval($_POST['estimated_cost'] ?? 0);
    $monthly_generation = floatval($_POST['monthly_generation'] ?? 0);
    $payback_period  = floatval($_POST['payback_period'] ?? 0);
    $annual_savings  = floatval($_POST['annual_savings'] ?? 0);
    
    // EXISTING FIELDS
    $category        = htmlspecialchars(trim($_POST['category'] ?? ''));
    $area_required   = floatval($_POST['area_required'] ?? 0);

    // --- NEW FIELDS FOR EMAIL ---
    $state           = htmlspecialchars(trim($_POST['state'] ?? ''));
    $unit_cost       = floatval($_POST['unit_cost'] ?? 0);
    $calc_type       = htmlspecialchars(trim($_POST['calc_type'] ?? '')); 
    $calc_value      = htmlspecialchars(trim($_POST['calc_value'] ?? '')); 

    // Validation
    if (empty($name) || empty($phone)) {
        echo "Error: Name and Phone are required.";
        exit;
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "invalid_email";
        exit;
    }

    // Update rate limit timer
    $_SESSION['last_solar_index_submit'] = time();

    // --- 2. INSERT INTO DATABASE ---
    $stmt = $conn->prepare("INSERT INTO solar_requests 
        (name, city, phone, email, system_size, estimated_cost, monthly_generation, payback_period, annual_savings, category, area_required) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $db_inserted = false;

    if ($stmt) {
        $stmt->bind_param("ssssdddddss", 
            $name, $city, $phone, $email, 
            $system_size, $estimated_cost, $monthly_generation, $payback_period, $annual_savings,
            $category, $area_required
        );

        if ($stmt->execute()) {
            $db_inserted = true;
        } else {
            echo "Database Error: " . $stmt->error;
            exit;
        }
        $stmt->close();
    }

    // --- 3. SEND EMAIL ---
    if ($db_inserted) {
        
        require_once __DIR__ . '/mail_config.php';

        try {
            $mail = createMailer();
            $mail->setFrom(SMTP_FROM_EMAIL, 'Green Edge Solar');
            $mail->addAddress(SMTP_FROM_EMAIL); 
            
            $mail->isHTML(false); 
            $mail->Subject = "New Solar Enquiry: " . $name;

            // --- PREPARE EMAIL TEXT (Full Names & Units) ---
            $type_label = "";
            $val_suffix = "";

            if($calc_type == 'bill') { 
                $type_label = "Monthly Electricity Bill"; 
                $val_suffix = " Rs"; 
            } elseif($calc_type == 'units') { 
                $type_label = "Monthly Electricity Consumption Units"; 
                $val_suffix = " kWh"; 
            } elseif($calc_type == 'area') { 
                $type_label = "Total Area of the Rooftop"; 
                $val_suffix = " sq ft"; 
            } else {
                $type_label = ucfirst($calc_type);
            }

            // Construct Body
            $body = "New Solar Quote Request Received\n\n";
            $body .= "Dear Admin,\n\n";
            $body .= "A new user has calculated their solar requirements.\n\n";
            
            $body .= "--- User Inputs (Calculator) ---\n";
            $body .= "Selected Option: " . $type_label . "\n";
            $body .= "Input Value: " . $calc_value . $val_suffix . "\n";
            $body .= "State: " . $state . "\n";
            $body .= "Category: " . $category . "\n";
            $body .= "Unit Cost: Rs. " . $unit_cost . " /kWh\n\n";

            $body .= "--- Customer Details ---\n";
            $body .= "Name: " . $name . "\n";
            $body .= "Phone: " . $phone . "\n";
            $body .= "City: " . $city . "\n";
            $body .= "Email: " . $email . "\n\n";

            $body .= "--- Solar Estimate ---\n";
            $body .= "System Size: " . $system_size . " kW\n";
            $body .= "Area Required: " . $area_required . " sq ft\n";
            $body .= "Estimated Cost: Rs. " . $estimated_cost . "\n";
            $body .= "Monthly Generation: " . $monthly_generation . " units\n";
            $body .= "Annual Savings: Rs. " . $annual_savings . "\n\n";
            
            $body .= "Regards,\nGreen Edge Infratech System";

            $mail->Body = $body;
            $mail->send();
            
            /* ===============================
               SEND SEPARATE EMAIL TO USER
               =============================== */
            if (!empty($email)) {
            
                try {
                    $userMail = createMailer();
                    $userMail->setFrom(SMTP_FROM_EMAIL, 'Greenedge Infratech');
                    $userMail->addAddress($email, $name);
            
                    $userMail->CharSet = 'UTF-8';
                    $userMail->isHTML(true);
                    $userMail->Subject = "Your Solar Requirement Estimate – Greenedge Infratech";
            
                    $userMail->Body = "
                    <p>Dear <strong>{$name}</strong>,</p>
            
                    <p>Thank you for using the <strong>Greenedge Infratech Solar Calculator</strong>. We have received your request and are pleased to share the details of your solar requirement estimate.</p>
            
                    <h3>Your Solar Estimate</h3>
            
                    <p><strong>Proposed System Size:</strong> {$system_size} kW<br>
                    <strong>Approx Area Required:</strong> {$area_required} sq ft<br>
                    <strong>Estimated Installation Cost:</strong> Rs. {$estimated_cost}<br>
                    <strong>Expected Monthly Generation:</strong> {$monthly_generation} units<br>
                    <strong>City:</strong> {$city}<br>
                    <strong>State:</strong> {$state}<br>
                    <strong>Category:</strong> {$category}<br>
                    <strong>Registered Mobile:</strong> {$phone}</p>
            
                    <p>Our team will contact you shortly to guide you further on system design, subsidy eligibility under <strong>PM Surya Ghar Yojana</strong>, and the next steps toward installation.</p>
                    
                       <p>If you have any questions or would like to expedite the process, please feel free to reply to this email or contact us directly.</p>
                       
             <p>Thank you for considering Greenedge Infratech for your solar needs. We look forward to assisting you in adopting clean and cost-effective solar energy.</p>
                       
                    <p>Warm regards,<br>
                    <strong>Team Greenedge Infratech</strong></p>
                    ";
            
                    $userMail->send();
            
                } catch (Exception $e) {
                    error_log("User Email Error: " . $userMail->ErrorInfo);
                }
            }


        } catch (Exception $e) {
            error_log("Mailer Error: " . $mail->ErrorInfo);
        }

        // Return success to JS
        echo "success";
    }
    
    exit; 
}

// --- PAGE HTML START ---
$query = "SELECT * FROM blogs ORDER BY created_at DESC LIMIT 6";
$result = $conn->query($query);
$servicesQuery = $conn->query("SELECT * FROM services ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Edge Infratech - Solar Energy Solutions</title>
    <meta name="description" content="GreenEdge Infratech provides rooftop solar energy solutions, professional solar panel installation, and customized clean power systems for homes and businesses.">
    <link rel="canonical" href="https://greenedgeinfratech.com/" />
    <link rel="icon" href="assets/image/favicon.ico" type="image/x-icon">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://greenedgeinfratech.com/" />
    <meta property="og:title" content="Green Edge Infratech - Solar Energy Solutions" />
    <meta property="og:description" content="GreenEdge Infratech provides rooftop solar energy solutions, professional solar panel installation, and customized clean power systems for homes and businesses." />
    <meta property="og:image" content="https://greenedgeinfratech.com/assets/logo.png" />
    <meta property="og:site_name" content="GreenEdge Infratech" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:url" content="https://greenedgeinfratech.com/" />
    <meta name="twitter:title" content="Green Edge Infratech - Solar Energy Solutions" />
    <meta name="twitter:description" content="GreenEdge Infratech provides rooftop solar energy solutions, professional solar panel installation, and customized clean power systems for homes and businesses." />
    <meta name="twitter:image" content="https://greenedgeinfratech.com/assets/logo.png" />

    <!-- Structured Data (Schema.org JSON-LD) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "GreenEdge Infratech Pvt. Ltd.",
      "url": "https://greenedgeinfratech.com/",
      "logo": "https://greenedgeinfratech.com/assets/logo.png",
      "image": "https://greenedgeinfratech.com/assets/logo.png",
      "description": "GreenEdge Infratech provides customized rooftop solar solutions, solar installation, and clean energy services.",
      "telephone": "+91 98370 67681",
      "email": "greenedgeinfratech@gmail.com",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "opp. BJP office Kayampur, Asadpur Kayam",
        "addressLocality": "Aligarh",
        "addressRegion": "Uttar Pradesh",
        "postalCode": "202001",
        "addressCountry": "IN"
      },
      "sameAs": [
        "https://www.facebook.com/share/1BzXrvyHHt/",
        "https://www.instagram.com/greenedge.infratech?igsh=Z2t0MTRpMmF5ZGh6",
        "https://www.linkedin.com/company/greenedgeinfratech/",
        "https://x.com/Greenedgeinfra?t=d7USa7IKRU1XjjskGJbmmw&s=09"
      ]
    }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KD4WD7C6');</script>
<!-- End Google Tag Manager -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-11515555005"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'AW-11515555005');
    </script>
    
    <style>
    .active-option {
        background-color: #22c55e !important; /* green-500 */
        color: white !important;
    }
    .calc-option.active-option { @apply bg-green-500 text-white border-green-600 shadow-md; }
    
    /* =========================================
       UPDATED PDF MODE CSS (Fixed Layout & Visibility)
       ========================================= */
    .pdf-mode {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 9999;
        background: white;
        width: 100%;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }

    /* Fixed Width for A4 proportionality */
    .pdf-mode .pdf-area {
        width: 790px !important;  /* Fits nicely in A4 width */
        margin: 0 auto !important;
        padding: 20px !important;
        background-color: white !important;
        border: none !important;
        box-shadow: none !important;
        transform: none !important;
        max-height: none !important;
        overflow: visible !important;
    }

    /* Compact Header */
    .pdf-mode .pdf-header {
        padding: 10px !important;
        margin-bottom: 15px !important;
        border: 1px solid #15803d !important; /* Green border */
    }
    .pdf-mode .pdf-header img { width: 45px !important; height: 45px !important; }
    .pdf-mode h1 { font-size: 22px !important; margin-bottom: 2px !important; }
    .pdf-mode p { font-size: 11px !important; }

    /* Compact Sections */
    .pdf-mode h2 { font-size: 16px !important; margin-bottom: 10px !important; padding-bottom: 5px !important; }
    .pdf-mode h3 { font-size: 14px !important; margin-bottom: 5px !important; }

    /* Force Grid Layouts to be Side-by-Side in PDF */
    .pdf-mode .grid-cols-1 {
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        gap: 20px !important; /* Increased gap for better separation */
    }
    
    /* Force 3 Columns for Environment in PDF */
    .pdf-mode .env-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        gap: 10px !important;
    }
    
    /* Exceptions for specific grids */
    .pdf-mode #services-grid, 
    .pdf-mode .grid-cols-3 {
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
    }

    /* Reduction of Padding/Margins for density */
    .pdf-mode .p-4, .pdf-mode .p-5, .pdf-mode .p-6 { padding: 10px !important; }
    .pdf-mode .mb-6 { margin-bottom: 10px !important; }
    
    /* Smaller Text for Data */
    .pdf-mode .text-xl, .pdf-mode .text-2xl, .pdf-mode .text-3xl {
        font-size: 15px !important;
        line-height: 1.2 !important;
    }
    .pdf-mode .text-lg { font-size: 13px !important; }
    .pdf-mode .text-sm { font-size: 11px !important; }
    
    /* Hide Buttons and Close Icons in PDF */
    .pdf-mode #close-result,
    .pdf-mode #downloadPDF {
        display: none !important;
    }

    /* Visual Adjustments for Charts/Bars */
    .pdf-mode .w-48.h-48 { 
        width: 80px !important; 
        height: 80px !important; 
        margin: 5px auto !important; 
    }
    .pdf-mode .h-[50px] { height: 25px !important; }
    
    /* Ensure borders are visible */
    .pdf-mode .border { border-width: 1px !important; }

    /* Fix Email Wrapping in PDF */
    .pdf-mode .break-all {
        word-break: break-all !important;
        overflow-wrap: break-word !important;
    }
    
    </style>
</head>

<body>
    
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KD4WD7C6"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <div id="header"></div>

    <section class="relative min-h-screen flex items-center pt-16 overflow-hidden">
        <div class="absolute inset-0">
            <video autoplay muted loop playsinline class="w-full h-full object-cover">
                <source src="assets/hero-bg.mp4" type="video/mp4">
            </video>
            <div class="absolute inset-0 bg-gradient-to-r from-green-900/90 via-green-700/70 to-transparent"></div>
        </div>
        <div class="relative container mx-auto px-4 z-10">
            <div class="max-w-4xl">
                <div class="inline-flex items-center space-x-2 bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 mb-6">
                    <i class="fas fa-sun text-secondary w-4 h-4"></i>
                    <span class="text-white text-sm font-medium">Clean Energy Solutions</span>
                </div>
                <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 leading-tight">
                    Power Your Future with <span class="block bg-gradient-to-r from-blue-300 to-white bg-clip-text">Solar Energy</span>
                </h1>
                <p class="text-xl md:text-2xl text-white/90 mb-8 max-w-2xl leading-relaxed">
                    Transform your energy costs with premium solar solutions. Professional installation, financing options, and 25-year warranty included.
                </p>
                <div class="grid grid-cols-3 gap-6 mb-8 max-w-md">
                    <div class="text-center"><div class="text-2xl font-bold text-white">500+</div><div class="text-white/80 text-sm">Installations</div></div>
                    <div class="text-center"><div class="text-2xl font-bold text-white">25yr</div><div class="text-white/80 text-sm">Warranty</div></div>
                    <div class="text-center"><div class="text-2xl font-bold text-white">90%</div><div class="text-white/80 text-sm">Savings</div></div>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 mb-8">
                    <a href="#contact"><button class="bg-green-500 text-white px-6 py-3 rounded-lg text-lg font-semibold flex items-center group hover:opacity-90 transition">Get Free Quote <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i></button></a>
                    <a href="tel:9837067681"><button class="border border-white/30 text-white px-6 py-3 rounded-lg text-lg flex items-center hover:bg-white/10 backdrop-blur-sm"><i class="fas fa-phone mr-2"></i> Call Now: 9837067681</button></a>
                </div>
                <div class="flex flex-col sm:flex-row gap-6 text-white/80">
                    <div class="flex items-center space-x-2"><i class="fas fa-envelope w-4 h-4"></i><span class="text-sm">greenedgeinfratech@gmail.com</span></div>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-1"><i class="fas fa-bolt text-secondary w-4 h-4"></i><span class="text-sm">Clean Energy</span></div>
                        <div class="flex items-center space-x-1"><i class="fas fa-leaf text-secondary w-4 h-4"></i><span class="text-sm">Eco Friendly</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute top-1/4 right-10 w-20 h-20 bg-secondary/20 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-32 h-32 bg-green-400/20 rounded-full blur-2xl animate-pulse delay-300"></div>
    </section>

    <section id="services" class="py-20 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <div class="inline-flex items-center space-x-2 bg-green-100 rounded-full px-4 py-2 mb-4">
                    <i class="fas fa-bolt text-green-600 w-4 h-4"></i><span class="text-green-600 text-sm font-medium">Our Services</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold mb-6">Complete Solar Solutions</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">From initial consultation to ongoing maintenance, we provide end-to-end solar energy services tailored to your specific needs and budget.</p>
            </div>
            <div id="services-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8 mb-12">

            <?php if($servicesQuery && $servicesQuery->num_rows > 0): ?>
                <?php while($service = $servicesQuery->fetch_assoc()): ?>
            
                    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-300">
            
                        <?php if(!empty($service['image_path'])): ?>
                            <img src="<?= htmlspecialchars($service['image_path']); ?>"
                                 alt="<?= htmlspecialchars($service['title']); ?>"
                                 class="w-full h-48 object-cover rounded-lg mb-4">
                        <?php endif; ?>
            
                        <h3 class="text-xl font-bold mb-3 text-green-700">
                            <?= htmlspecialchars($service['title']); ?>
                        </h3>
            
                        <p class="text-gray-600 mb-4">
                            <?= substr(strip_tags($service['description']), 0, 150); ?>...
                        </p>
            
                    </div>
            
                <?php endwhile; ?>
            <?php else: ?>
                <p class="col-span-2 text-center text-gray-500">
                    No services available.
                </p>
            <?php endif; ?>
            
            </div>
        </div>
    </section>

    <section id="why-solar" class="py-20">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex items-center space-x-2 bg-green-100 rounded-full px-4 py-2 mb-6"><i class="fas fa-leaf text-green-600 w-4 h-4"></i><span class="text-green-600 text-sm font-medium">Why Choose Solar</span></div>
                    <h2 class="text-4xl md:text-5xl font-bold mb-6">Why We Need <span class="bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent block">Green Energy Solar</span></h2>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">Green energy, such as solar power, is essential for a sustainable future. Solar energy is renewable, abundant, and emits no greenhouse gases, making it a cleaner alternative to fossil fuels.</p>
                    <div class="space-y-4 mb-8">
                        <div class="flex items-center space-x-3"><div class="w-2 h-2 rounded-full bg-green-600"></div><span class="text-gray-800">Renewable and abundant energy source</span></div>
                        <div class="flex items-center space-x-3"><div class="w-2 h-2 rounded-full bg-green-600"></div><span class="text-gray-800">Zero greenhouse gas emissions</span></div>
                        <div class="flex items-center space-x-3"><div class="w-2 h-2 rounded-full bg-green-600"></div><span class="text-gray-800">Increasingly cost-effective solution</span></div>
                        <div class="flex items-center space-x-3"><div class="w-2 h-2 rounded-full bg-green-600"></div><span class="text-gray-800">Perfect for homes and businesses</span></div>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="p-6 text-center bg-white rounded-xl shadow hover:shadow-lg transition-all duration-300 hover:-translate-y-1"><div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-600 to-green-500 flex items-center justify-center mx-auto mb-4"><i class="fas fa-leaf text-white w-6 h-6"></i></div><div class="text-2xl font-bold text-green-600 mb-1">80% Less Carbon</div><h3 class="font-semibold mb-2">Environmental Impact</h3><p class="text-sm text-gray-600">Reduce your carbon footprint by up to 80% with clean, renewable solar energy.</p></div>
                    <div class="p-6 text-center bg-white rounded-xl shadow hover:shadow-lg transition-all duration-300 hover:-translate-y-1"><div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-600 to-green-500 flex items-center justify-center mx-auto mb-4"><i class="fas fa-dollar-sign text-white w-6 h-6"></i></div><div class="text-2xl font-bold text-green-600 mb-1">₹50k+ Annual Savings</div><h3 class="font-semibold mb-2">Cost Savings</h3><p class="text-sm text-gray-600">Save thousands on electricity bills with solar energy that pays for itself.</p></div>
                    <div class="p-6 text-center bg-white rounded-xl shadow hover:shadow-lg transition-all duration-300 hover:-translate-y-1"><div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-600 to-green-500 flex items-center justify-center mx-auto mb-4"><i class="fas fa-bolt text-white w-6 h-6"></i></div><div class="text-2xl font-bold text-green-600 mb-1">90% Self Sufficient</div><h3 class="font-semibold mb-2">Energy Independence</h3><p class="text-sm text-gray-600">Generate your own clean energy and reduce dependence on the grid.</p></div>
                    <div class="p-6 text-center bg-white rounded-xl shadow hover:shadow-lg transition-all duration-300 hover:-translate-y-1"><div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-600 to-green-500 flex items-center justify-center mx-auto mb-4"><i class="fas fa-shield-alt text-white w-6 h-6"></i></div><div class="text-2xl font-bold text-green-600 mb-1">25 Year Warranty</div><h3 class="font-semibold mb-2">Long-term Investment</h3><p class="text-sm text-gray-600">25-year warranty with minimal maintenance and guaranteed performance.</p></div>
                    <div class="p-6 text-center bg-white rounded-xl shadow hover:shadow-lg transition-all duration-300 hover:-translate-y-1"><div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-600 to-green-500 flex items-center justify-center mx-auto mb-4"><i class="fas fa-chart-line text-white w-6 h-6"></i></div><div class="text-2xl font-bold text-green-600 mb-1">15% Value Increase</div><h3 class="font-semibold mb-2">Property Value</h3><p class="text-sm text-gray-600">Increase your property value by up to 15% with solar installations.</p></div>
                    <div class="p-6 text-center bg-white rounded-xl shadow hover:shadow-lg transition-all duration-300 hover:-translate-y-1"><div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-600 to-green-500 flex items-center justify-center mx-auto mb-4"><i class="fas fa-globe text-white w-6 h-6"></i></div><div class="text-2xl font-bold text-green-600 mb-1">Future Ready</div><h3 class="font-semibold mb-2">Future Ready</h3><p class="text-sm text-gray-600">Join the global transition to sustainable energy and future-proof your home.</p></div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="py-3 bg-white">
        <div class="container mx-auto px-4 text-center">
            
            <div class="inline-flex items-center space-x-2 bg-green-100 rounded-full px-4 py-2 mb-6">
                <i class="fas fa-calculator text-green-600 w-4 h-4"></i>
                <span class="text-green-600 text-sm font-medium">Solar Calculator</span>
            </div>
    
            <h2 class="text-4xl md:text-5xl font-bold mb-6">
                Calculate Your Ideal 
                <span class="bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                    Solar System Size
                </span>
                In Minutes
            </h2>
    
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Enter your electricity details and instantly get system size, savings,
                subsidy benefits, payback period and environmental impact —
                powered by Greenedge Infratech.
            </p>
    
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
        <div class="bg-[#e8f5e9] border border-green-300 rounded-xl p-8 shadow-md">
            <h3 class="text-lg font-semibold mb-3">1. Select any one option</h3>
            <div class="grid sm:grid-cols-3 gap-4 mb-8">
              <button class="calc-option active-option transition-all px-4 py-5 rounded-lg text-center font-semibold border border-green-600 bg-green-500 text-white shadow-md" data-type="bill">Monthly Electricity Bill</button>
              <button class="calc-option transition-all px-4 py-5 rounded-lg text-center font-semibold border border-green-400 bg-white hover:bg-green-50" data-type="units">Monthly Electricity Consumption Units</button>
              <button class="calc-option transition-all px-4 py-5 rounded-lg text-center font-semibold border border-green-400 bg-white hover:bg-green-50" data-type="area">Total Area of the Rooftop</button>
            </div>

            <div id="input-section">
              <div id="bill-input" class="toggle-input"><input id="input-bill" type="number" placeholder="Enter Monthly Bill (₹)" class="w-full border border-green-400 rounded-lg h-12 px-3 bg-white mb-3" /></div>
              <div id="units-input" class="toggle-input hidden"><input id="input-units" type="number" placeholder="Enter Monthly Consumption Units (kWh)" class="w-full border border-green-400 rounded-lg h-12 px-3 bg-white mb-3" /></div>
              <div id="area-input" class="toggle-input hidden"><input id="input-area" type="number" placeholder="Enter Rooftop Area (sq ft)" class="w-full border border-green-400 rounded-lg h-12 px-3 bg-white mb-3" /></div>
            </div>

            <h3 class="text-lg font-semibold mb-3">3. Select State and Customer Category</h3>
            <div class="grid sm:grid-cols-2 gap-4 mb-8">
              <select id="state" class="w-full border border-green-400 rounded-lg h-12 px-3 bg-white"><option value="">Select State</option></select>
              <select id="category" class="w-full border border-green-400 rounded-lg h-12 px-3 bg-white">
                <option value="">Select Category</option>
                <option value="residential">Residential</option>
                <option value="commercial">Commercial</option>
                <option value="industrial">Industrial</option>
                <option value="institutional">Institutional</option>
                <option value="government">Government</option>
                <option value="social-sector">Social Sector</option>
              </select>
            </div>

            <h3 class="text-lg font-semibold mb-3">4. Enter Your Electricity Unit Cost</h3>
            <input id="unit-cost" type="number" placeholder="Enter Unit Cost (₹ / kWh)" class="w-full border border-green-600 rounded-lg h-12 px-3 bg-white mb-3" />

            <button id="calculate-btn" class="w-full mt-4 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg shadow-md text-lg">Calculate</button>
          </div>
        </div>
    </section>
    
    <div id="popup-form" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative">
          <button id="close-popup" class="absolute top-2 right-3 text-gray-500 text-2xl">&times;</button>
          <h3 class="text-xl font-bold mb-4 text-green-700">Get Solar Quote</h3>
    
          <form id="solar-form">
              <input type="hidden" name="form_type" value="solar_form">
              
              <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
              <div style="position: absolute; left: -5000px;" aria-hidden="true">
                  <input type="text" name="website_url" id="website_url" tabindex="-1" autocomplete="off">
              </div>

            <label for="name" class="block mb-1 font-medium text-gray-700">Full Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your full name" required class="w-full border rounded-lg h-12 px-3 mb-3">
    
            <label for="city" class="block mb-1 font-medium text-gray-700">City</label>
            <input type="text" id="city" name="city" placeholder="Enter your city" required class="w-full border rounded-lg h-12 px-3 mb-3">
    
            <label for="phone" class="block mb-1 font-medium text-gray-700">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required class="w-full border rounded-lg h-12 px-3 mb-3">
    
            <label for="email" class="block mb-1 font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required class="w-full border rounded-lg h-12 px-3 mb-3">
    
            <input type="hidden" name="system_size" id="form-system-size">
            <input type="hidden" name="estimated_cost" id="form-estimated-cost">
            <input type="hidden" name="monthly_generation" id="form-monthly-generation">
            <input type="hidden" name="payback_period" id="form-payback-period">
            <input type="hidden" name="annual_savings" id="form-annual-savings">
            <input type="hidden" name="category" id="form-category">
            <input type="hidden" name="area_required" id="form-area-required">
            
            <input type="hidden" name="state" id="form-state">
            <input type="hidden" name="unit_cost" id="form-unit-cost">
            <input type="hidden" name="calc_type" id="form-calc-type">
            <input type="hidden" name="calc_value" id="form-calc-value">
    
            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold">Submit Request</button>
          </form>
        </div>
      </div>
    
    <div id="result-popup" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-[#e8f5e9] rounded-lg shadow-lg w-full max-w-4xl mx-4 relative overflow-hidden max-h-[90vh] overflow-y-auto pdf-area border border-gray-300">

        <button id="close-result" class="absolute top-3 right-4 text-gray-700 text-2xl leading-none hover:text-green-700 z-10 bg-white rounded-full w-8 h-8 flex items-center justify-center shadow-md">&times;</button>

        <div class="p-6">

            <div class="pdf-header border-b border-green-700 pb-4 mb-6 flex justify-between items-start bg-gradient-to-r from-green-50 to-emerald-50 p-4 rounded-lg">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-lg bg-white border border-green-700">
                        <img src="assets/logo.png" alt="Logo" class="w-24 h-24 object-contain">
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-green-800">Greenedge Infratech Pvt. Ltd.</h2>
                        <p class="text-green-700 font-medium">Customized Rooftop Solar Solutions</p>
                        <p class="text-gray-600 text-sm flex items-center gap-1 mt-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            We Handle Your Roof with Care
                        </p>
                    </div>
                </div>

                <div class="text-right bg-white p-3 rounded-lg border border-green-700">
                    <p class="text-gray-800 font-semibold text-lg">Rooftop Solar PV System</p>
                    <p id="pdf-category-display" class="text-green-700 font-bold capitalize">Residential Segment</p>
                    <p class="text-gray-600 text-sm mt-1 bg-gray-100 px-2 py-1 rounded">Indicative Proposal</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                
                <div class="p-4 bg-white rounded-lg border border-gray-700 shadow-sm">
                    <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        Customer Details
                    </h2>
                    <div class="space-y-3">
                         <div class="flex items-center gap-2"><p class="text-sm text-gray-600 w-16">Name:</p><p id="cd-name" class="text-gray-800 font-semibold"></p></div>
                         <div class="flex items-center gap-2"><p class="text-sm text-gray-600 w-16">City:</p><p id="cd-city" class="text-gray-800 font-semibold"></p></div>
                         <div class="flex items-center gap-2"><p class="text-sm text-gray-600 w-16">Phone:</p><p id="cd-phone" class="text-gray-800 font-semibold"></p></div>
                         <div class="flex items-start gap-2">
                             <p class="text-sm text-gray-600 w-16 pt-0.5">Email:</p>
                             <p id="cd-email" class="text-gray-800 font-semibold break-all"></p>
                         </div>
                    </div>
                </div>

                <div class="p-4 bg-white rounded-lg border border-green-700 shadow-sm">
                    <h2 class="text-lg font-bold text-green-800 mb-4 border-b pb-2 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M11 17a1 1 0 001.447.894l4-2A1 1 0 0017 15V9.236a1 1 0 00-1.447-.894l-4 2a1 1 0 00-.553.894V17zM15.211 6.276a1 1 0 000-1.788l-4.764-2.382a1 1 0 00-.894 0L4.789 4.488a1 1 0 000 1.788l4.764 2.382a1 1 0 00.894 0l4.764-2.382zM4.447 8.342A1 1 0 003 9.236V15a1 1 0 00.553.894l4 2A1 1 0 009 17v-5.764a1 1 0 00-.553-.894l-4-2z"></path></svg>
                        Proposed System
                    </h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center bg-green-50 p-2 rounded">
                            <span class="text-gray-700">System Size:</span>
                            <span id="popup-system-size" class="text-green-700 font-bold text-xl">0 KW</span>
                        </div>
                        <div class="flex justify-between items-center bg-blue-50 p-2 rounded">
                            <span class="text-gray-700">Roof Area:</span>
                            <span id="popup-area-required" class="text-blue-800 font-bold text-lg">0 sq ft</span>
                        </div>
                         <div class="flex justify-between items-center bg-gray-50 p-2 rounded">
                            <span class="text-gray-700">Type:</span>
                            <span class="text-gray-800 font-semibold">On-Grid (Net Metering)</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 mb-6 shadow-lg border border-gray-200">
                <h3 class="text-2xl font-bold text-green-900 mb-6 text-center border-b pb-3">Solar Estimate Summary</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="border-r pr-4">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 text-center">Estimated Bill Savings</h3>
                        <div class="bg-gray-50 p-4 rounded-xl">
                            <div class="flex justify-center gap-10">
                                <div class="text-center">
                                    <p class="text-gray-600 text-sm">Old Bill</p>
                                    <p id="ui-old-bill" class="text-red-700 font-bold text-lg">0</p>
                                    <div class="w-6 mx-auto mt-2 bg-red-300 rounded"><div id="oldBillBar" class="bg-red-600 w-full" style="height: 50px;"></div></div>
                                </div>
                                <div class="text-center">
                                    <p class="text-gray-600 text-sm">New Bill</p>
                                    <p id="ui-new-bill" class="text-green-700 font-bold text-lg">0</p>
                                    <div class="w-6 mx-auto mt-2 bg-green-300 rounded"><div id="newBillBar" class="bg-green-600 w-full" style="height: 50px;"></div></div>
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                <p class="text-sm text-gray-500">Monthly Savings: <span id="popup-monthly-saving" class="font-bold text-green-700 text-lg">0</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="pl-4">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 text-center">Generation & Returns</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center bg-blue-50 p-3 rounded border border-blue-200">
                                <span class="text-gray-700 text-sm">Monthly Generation</span>
                                <span id="popup-monthly-gen" class="text-blue-700 font-bold">0 kWh</span>
                            </div>
                            <div class="flex justify-between items-center bg-green-50 p-3 rounded border border-green-200">
                                <span class="text-gray-700 text-sm">Annual Generation</span>
                                <span id="popup-annual-gen" class="text-green-700 font-bold">0 kWh</span>
                            </div>
                             <div class="flex justify-between items-center bg-purple-50 p-3 rounded border border-purple-200">
                                <span class="text-gray-700 text-sm">Annual Savings</span>
                                <span id="popup-annual-saving" class="text-purple-700 font-bold">Rs. 0</span>
                            </div>
                             <div class="flex justify-between items-center bg-yellow-50 p-3 rounded border border-yellow-200">
                                <span class="text-gray-700 text-sm">Lifetime Savings (25y)</span>
                                <span id="popup-lifetime-saving" class="text-yellow-700 font-bold">Rs. 0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        Environmental Impact
                    </h3>
                    <div class="space-y-4 env-grid">
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-4 rounded-xl border border-green-700 shadow-sm">
                            <div class="flex items-center justify-center">
                                <div class="bg-green-100 p-3 rounded-full"><span class="text-3xl">🌳</span></div>
                                <div class="ml-4">
                                    <p id="popup-trees-2" class="text-green-800 font-bold text-3xl">0</p>
                                    <p class="text-gray-600 text-sm">Trees Planted</p>
                                </div>
                            </div>
                            <p class="text-gray-700 text-xs text-center mt-2">Your solar system equals planting these many trees</p>
                        </div>
                        
                        <div class="bg-gradient-to-r from-red-50 to-pink-50 p-4 rounded-xl border border-red-700 shadow-sm">
                            <div class="flex items-center justify-center">
                                <div class="bg-red-100 p-3 rounded-full"><span class="text-3xl">🚗</span></div>
                                <div class="ml-4">
                                    <p id="ui-cars-2" class="text-red-800 font-bold text-3xl">0</p>
                                    <p class="text-gray-600 text-sm">Cars Off Road</p>
                                </div>
                            </div>
                            <p class="text-gray-700 text-xs text-center mt-2">Equivalent to removing cars from roads annually</p>
                        </div>

                        <div class="bg-gradient-to-r from-blue-50 to-cyan-50 p-4 rounded-xl border border-blue-700 shadow-sm">
                            <div class="flex items-center justify-center">
                                <div class="bg-blue-100 p-3 rounded-full">
                                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-blue-800 font-bold text-sm">CO₂ Reduced</p>
                                    <p id="popup-co2" class="text-blue-700 font-bold text-2xl">0 Tons</p>
                                </div>
                            </div>
                            <p class="text-gray-700 text-xs text-center mt-2">Total carbon emission reduction over system lifetime</p>
                        </div>
                    </div>
                </div>

                 <div class="bg-gray-50 p-4 rounded-xl border border-gray-400">
                     <h4 class="text-gray-800 font-bold mb-2">Contact Us</h4>
                     <p class="text-sm font-semibold text-green-700">+91 98370 67681</p>
                     <p class="text-sm text-gray-600">greenedgeinfratech@gmail.com</p>
                     <p class="text-xs text-gray-500 mt-2">Prices subject to site visit & taxes.</p>
                 </div>
            </div>

            <div class="mt-6 text-center">
                <button id="downloadPDF" class="bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold px-8 py-3 rounded-full shadow-lg hover:shadow-xl transition-all">
                    Download PDF Report
                </button>
            </div>

        </div>
    </div>
</div>

<section id="blogs" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <div class="inline-flex items-center space-x-2 bg-blue-100 rounded-full px-4 py-2 mb-4"><i class="fas fa-newspaper text-blue-600 w-4 h-4"></i><span class="text-blue-600 text-sm font-medium">Latest Blogs</span></div>
                <h2 class="text-4xl md:text-5xl font-bold mb-6">Stay Updated With Solar Insights</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Explore our latest articles, tips, and updates on solar technology and renewable energy.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <?php if ($result->num_rows > 0) { while ($row = $result->fetch_assoc()) { echo '
        <div class="bg-gray-50 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
            <a href="blog_details.php?id=' . $row["id"] . '">
                <img src="uploads/' . htmlspecialchars($row["image"]) . '" 
                     alt="' . htmlspecialchars($row["title"]) . '" 
                     class="w-full h-48 object-cover hover:opacity-90 transition duration-300">
            </a>
            <div class="p-6">
                <h3 class="text-xl font-bold mb-2">' . htmlspecialchars($row["title"]) . '</h3>
                <p class="text-gray-600 mb-4">' . substr(strip_tags($row["content"]), 0, 100) . '...</p>
                <a href="blog_details.php?id=' . $row["id"] . '" class="mt-auto inline-block bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition">Read More <i class="fas fa-arrow-right ml-2"></i></a>
            </div>
        </div>'; } } else { echo '<p class="col-span-3 text-center text-gray-500">No blogs found.</p>'; } ?>
            </div>
            <div class="text-center"><a href="blogs.php" class="bg-gradient-to-br from-green-600 to-blue-500 text-white px-6 py-3 rounded-lg text-lg font-semibold hover:opacity-90 transition">View All Blogs <i class="fas fa-arrow-right ml-2"></i></a></div>
        </div>
    </section>

    <section id="contact" class="py-20">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <div class="inline-flex items-center space-x-2 bg-primary/10 rounded-full px-4 py-2 mb-4"><i data-lucide="phone" class="w-4 h-4 text-blue-600"></i><span class="text-green-600 text-sm font-medium">Get In Touch</span></div>
                <h2 class="text-4xl md:text-5xl font-bold mb-6">Ready to Go Solar?</h2>
                <p class="text-xl text-gray-500 max-w-2xl mx-auto">Contact our solar experts for a free consultation and personalized quote. We're here to help you make the switch to clean energy.</p>
            </div>
            <div class="grid lg:grid-cols-2 gap-12 max-w-6xl mx-auto">
                <div class="p-8 bg-white/80 backdrop-blur rounded-2xl shadow-md">
                    <h3 class="text-2xl font-bold mb-6">Get Your Free Quote</h3>
                    <?php include("components/contactForm.php") ?>
                </div>
                <div class="space-y-8">
                    <div class="relative rounded-2xl overflow-hidden">
                        <img src="assets/installation-team.jpg" alt="Professional solar installation team" class="w-full h-64 object-cover" />
                        <div class="absolute inset-0 bg-gradient-to-t from-green-600/60 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 text-white"><div class="text-2xl font-bold">Professional Installation</div><div class="text-lg opacity-90">Expert team with 10+ years experience</div></div>
                    </div>
                    <div class="grid gap-6">
                        <div class="p-6 bg-white/80 backdrop-blur rounded-2xl shadow-md"><div class="flex items-center space-x-4"><div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-600 to-green-500 flex items-center justify-center"><i data-lucide="phone" class="w-6 h-6 text-white"></i></div><div><h4 class="font-semibold">Call Us</h4><p class="text-gray-500">+91 98370 67681</p></div></div></div>
                        <div class="p-6 bg-white/80 backdrop-blur rounded-2xl shadow-md"><div class="flex items-center space-x-4"><div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-500 to-yellow-500 flex items-center justify-center"><i data-lucide="mail" class="w-6 h-6 text-white"></i></div><div><h4 class="font-semibold">Email Us</h4><p class="text-gray-500">greenedgeinfratech@gmail.com</p></div></div></div>
                        <div class="p-6 bg-white/80 backdrop-blur rounded-2xl shadow-md"><div class="flex items-center space-x-4"><div class="w-12 h-12 rounded-full bg-gradient-to-br from-yellow-500 to-blue-600 flex items-center justify-center"><i data-lucide="clock" class="w-6 h-6 text-white"></i></div><div><h4 class="font-semibold">Business Hours</h4><p class="text-gray-500">Mon - Sat: 9AM - 6PM</p></div></div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <?php if(isset($success)): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const popup = document.createElement("div");
            popup.innerHTML = `
                <div style="
                    position:fixed;
                    top:0; left:0;
                    width:100%; height:100%;
                    background:rgba(0,0,0,0.6);
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    z-index:9999;">
                    
                    <div style="
                        background:white;
                        padding:30px;
                        border-radius:10px;
                        text-align:center;
                        max-width:400px;">
                        
                        <h2 style="color:green;">✅ Message Sent Successfully!</h2>
                        <p>Thank you for contacting GreenEdge Infratech.<br>We will reach out to you shortly.</p>
                        <button onclick="this.closest('div').parentElement.remove()"
                            style="
                            margin-top:15px;
                            padding:10px 20px;
                            background:green;
                            color:white;
                            border:none;
                            border-radius:5px;
                            cursor:pointer;">
                            Close
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(popup);
        });
    </script>
    <?php endif; ?>

    <div id="footer"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="./assets/js/component.js"></script>

    <script>
      const solarRadiation = { "Uttar Pradesh": 4.5, "Assam": 3.5, "Delhi": 4.2, "Gujarat": 4.8, "Rajasthan": 5.4, "Tamil Nadu": 4.7, "Maharashtra": 4.5, "Odisha": 4.2, "Chhattisgarh": 4.1, "West Bengal": 3.8 };
      
      const indianStates = Object.keys(solarRadiation);
      const stateSelect = document.getElementById("state");
      indianStates.forEach(state => {
          const option = document.createElement("option");
          option.value = state;
          option.textContent = state;
          stateSelect.appendChild(option);
      });
      
      let selectedType = "bill";
      let solarResult = null;
      let selectedCategoryText = ""; 
      
      const LIFE_YEARS = 25;
      const CO2_PER_KWH_TONNES = 0.00082;
      const TONNES_PER_TREE = 0.06;
      
      document.querySelector('.calc-option[data-type="bill"]').classList.add("active-option");
      
      document.querySelectorAll(".calc-option").forEach(btn => {
          btn.addEventListener("click", function () {
              selectedType = this.dataset.type;
              document.querySelectorAll(".calc-option").forEach(b => b.classList.remove("active-option", "bg-green-500", "text-white", "bg-white", "hover:bg-green-50"));
              this.classList.add("active-option", "bg-green-500", "text-white");
              document.querySelectorAll(".toggle-input").forEach(div => div.classList.add("hidden"));
              document.getElementById(selectedType + "-input").classList.remove("hidden");
          });
      });
      
      document.getElementById("calculate-btn").addEventListener("click", function () {
      
          let input = 0;
          if (selectedType === "bill") input = parseFloat(document.getElementById("input-bill").value);
          if (selectedType === "units") input = parseFloat(document.getElementById("input-units").value);
          if (selectedType === "area") input = parseFloat(document.getElementById("input-area").value);
      
          const unitCost = parseFloat(document.getElementById("unit-cost").value);
          const categorySelect = document.getElementById("category");
      
          if (!input || !stateSelect.value || !categorySelect.value || !unitCost) {
              alert("⚠️ Please fill all required fields.");
              return;
          }
          
          selectedCategoryText = categorySelect.options[categorySelect.selectedIndex].text;
      
          let systemSize = 0;
          if (selectedType === "bill") systemSize = ((input / 30) / unitCost) / 4;
          if (selectedType === "units") systemSize = input / 120;
          if (selectedType === "area") systemSize = input / 100;
          
          systemSize = parseFloat(systemSize.toFixed(1));
          const decimal = systemSize - Math.floor(systemSize);
          if (decimal >= 0.5) { systemSize = Math.ceil(systemSize); } else { systemSize = Math.floor(systemSize); }
      
          const estimatedCost = systemSize * 60000;
          const radiation = solarRadiation[stateSelect.value] || 4;
      
          const dailyGeneration = systemSize * radiation;
          const monthlyGeneration = dailyGeneration * 30;
          const annualGeneration = monthlyGeneration * 12;
          const lifetimeGeneration = annualGeneration * LIFE_YEARS;
      
          const monthlySaving = monthlyGeneration * unitCost;
          const yearlySaving = monthlySaving * 12;
          const lifetimeSaving = yearlySaving * LIFE_YEARS;
      
          const annualSavings = yearlySaving;
          const paybackPeriod = estimatedCost / annualSavings;
      
          const co2Tonnes = lifetimeGeneration * CO2_PER_KWH_TONNES;
          const trees = co2Tonnes / TONNES_PER_TREE;
          const areaRequired = systemSize * 100; 
      
          solarResult = { systemSize, estimatedCost, dailyGeneration, monthlyGeneration, annualGeneration, lifetimeGeneration, monthlySaving, yearlySaving, lifetimeSaving, annualSavings, paybackPeriod, unitCost, co2Tonnes, trees, areaRequired };
      
          document.getElementById("form-system-size").value = systemSize.toFixed(1);
          document.getElementById("form-estimated-cost").value = estimatedCost.toFixed(0);
          document.getElementById("form-monthly-generation").value = monthlyGeneration.toFixed(2);
          document.getElementById("form-payback-period").value = paybackPeriod.toFixed(1);
          document.getElementById("form-annual-savings").value = annualSavings.toFixed(0);
          document.getElementById("form-category").value = categorySelect.value;
          document.getElementById("form-area-required").value = areaRequired.toFixed(0);
          document.getElementById("form-state").value = stateSelect.value;
          document.getElementById("form-unit-cost").value = unitCost;
          document.getElementById("form-calc-type").value = selectedType;
          document.getElementById("form-calc-value").value = input;
      
          document.getElementById("popup-form").classList.remove("hidden");
      });
      
      document.getElementById("close-popup").addEventListener("click", () => document.getElementById("popup-form").classList.add("hidden"));
      document.getElementById("close-result").addEventListener("click", () => document.getElementById("result-popup").classList.add("hidden"));
      
      /* =======================================================
         UPDATED PDF GENERATION LOGIC (SINGLE PAGE / SMART FIT)
         ======================================================= */
      document.getElementById("downloadPDF").addEventListener("click", function () {
          const { jsPDF } = window.jspdf;
          const popup = document.querySelector("#result-popup");
          const pdfArea = document.querySelector("#result-popup .pdf-area");
      
          // 1. ADD PDF MODE (Changes CSS to be compact)
          popup.classList.add("pdf-mode");
      
          // 2. Prepare visual state
          const oldMaxHeight = pdfArea.style.maxHeight;
          const oldOverflow = pdfArea.style.overflow;
          pdfArea.style.maxHeight = "none";
          pdfArea.style.height = "auto";
          pdfArea.style.overflow = "visible";
      
          // Wait for DOM to reflow with new CSS
          setTimeout(() => {
              
              // 3. Capture with html2canvas (Use JPEG for smaller size)
              html2canvas(pdfArea, { 
                  scale: 2, // Good balance
                  backgroundColor: "#ffffff",
                  useCORS: true 
              }).then(canvas => {
      
                  // OPTIONAL: Add Contrast to make text sharper
                  const ctx = canvas.getContext('2d');
                  ctx.filter = "contrast(1.1)";
                  
                  // 4. Create PDF (A4)
                  const pdf = new jsPDF('p', 'mm', 'a4');
                  const pdfWidth = 210; // A4 width mm
                  const pdfHeight = 297; // A4 height mm
                  
                  // Calculate proportions
                  const imgWidth = pdfWidth;
                  const imgHeight = (canvas.height * pdfWidth) / canvas.width;
      
                  // 5. SMART FIT LOGIC:
                  // If content is just slightly bigger than 1 page (e.g., 1.2 pages), shrink it to fit 1 page.
                  let finalHeight = imgHeight;
                  let finalWidth = imgWidth;
                  
                  if (imgHeight > pdfHeight && imgHeight < (pdfHeight * 1.3)) {
                      // Scale down to fit 1 page
                      finalHeight = pdfHeight - 10; // 10mm margin
                      finalWidth = (canvas.width * finalHeight) / canvas.height;
                      // Center horizontally
                      const xOffset = (pdfWidth - finalWidth) / 2;
                      
                      const imgData = canvas.toDataURL('image/jpeg', 0.85); // 85% Quality JPEG
                      pdf.addImage(imgData, 'JPEG', xOffset, 5, finalWidth, finalHeight);
                  } 
                  else {
                      // Standard Behavior (Multi-page if really long)
                      const imgData = canvas.toDataURL('image/jpeg', 0.85);
                      let heightLeft = imgHeight;
                      let position = 0;
      
                      pdf.addImage(imgData, 'JPEG', 0, position, imgWidth, imgHeight);
                      heightLeft -= pdfHeight;
      
                      while (heightLeft > 0) {
                          position = heightLeft - imgHeight;
                          pdf.addPage();
                          pdf.addImage(imgData, 'JPEG', 0, position, imgWidth, imgHeight);
                          heightLeft -= pdfHeight;
                      }
                  }
      
                  pdf.save("Solar-Estimate.pdf");
      
                  // 6. Reset UI
                  pdfArea.style.maxHeight = oldMaxHeight;
                  pdfArea.style.overflow = oldOverflow;
                  popup.classList.remove("pdf-mode");
              });
      
          }, 300); // 300ms delay to ensure CSS render
      });

      function openResultPopup() {
          document.getElementById("cd-name").textContent = document.getElementById("name").value;
          document.getElementById("cd-city").textContent = document.getElementById("city").value;
          document.getElementById("cd-phone").textContent = document.getElementById("phone").value;
          document.getElementById("cd-email").textContent = document.getElementById("email").value;
          
          document.getElementById("pdf-category-display").textContent = selectedCategoryText + " Segment";
      
          const oldBill = Math.round(selectedType === "bill" ? document.getElementById("input-bill").value : solarResult.monthlySaving);
          const maxSaving = oldBill * 0.70;
          const actualSaving = Math.min(solarResult.monthlySaving, maxSaving);
          let newBill = oldBill - actualSaving;
          newBill = Math.max(50, newBill);
      
          document.getElementById("ui-old-bill").textContent = oldBill;
          document.getElementById("ui-new-bill").textContent = newBill;
      
          const max = Math.max(oldBill, newBill);
          document.getElementById("oldBillBar").style.height = ((oldBill / max) * 50) + "px"; // Reduced visual height for PDF
          document.getElementById("newBillBar").style.height = ((newBill / max) * 50) + "px";
      
          document.getElementById("popup-system-size").textContent = solarResult.systemSize.toFixed(1) + " kW";
          document.getElementById("popup-monthly-gen").textContent = solarResult.monthlyGeneration.toFixed(2) + " kWh";
          document.getElementById("popup-annual-gen").textContent = solarResult.annualGeneration.toFixed(0) + " kWh";
          document.getElementById("popup-monthly-saving").textContent = "Rs. " + Math.round(solarResult.monthlySaving).toLocaleString();
          document.getElementById("popup-annual-saving").textContent = "Rs. " + Math.round(solarResult.yearlySaving).toLocaleString();
          document.getElementById("popup-lifetime-saving").textContent = "Rs. " + Math.round(solarResult.lifetimeSaving).toLocaleString();
          document.getElementById("popup-co2").textContent = solarResult.co2Tonnes.toFixed(1) + " Tons";
          document.getElementById("popup-area-required").textContent = Math.round(solarResult.areaRequired) + " sq ft";
          document.getElementById("popup-trees-2").textContent = Math.round(solarResult.trees);
          document.getElementById("ui-cars-2").textContent = Math.round(solarResult.co2Tonnes / 4.6);
      
          document.getElementById("result-popup").classList.remove("hidden");
          document.getElementById("result-popup").classList.add("flex");
      }

      // AJAX Form Submit
      document.getElementById("solar-form").onsubmit = function(e) {
          e.preventDefault();
          const submitBtn = document.querySelector("#solar-form button[type='submit']");
          const originalText = submitBtn.innerText;
          submitBtn.innerText = "Processing...";
          submitBtn.disabled = true;
      
          const data = new URLSearchParams();
          data.append("form_type", "solar_form");
          data.append("name", document.getElementById("name").value);
          data.append("city", document.getElementById("city").value);
          data.append("phone", document.getElementById("phone").value);
          data.append("email", document.getElementById("email").value);
          data.append("system_size", document.getElementById("form-system-size").value);
          data.append("estimated_cost", document.getElementById("form-estimated-cost").value);
          data.append("monthly_generation", document.getElementById("form-monthly-generation").value);
          data.append("payback_period", document.getElementById("form-payback-period").value);
          data.append("annual_savings", document.getElementById("form-annual-savings").value);
          data.append("category", document.getElementById("form-category").value);
          data.append("area_required", document.getElementById("form-area-required").value);
          data.append("state", document.getElementById("form-state").value);
          data.append("unit_cost", document.getElementById("form-unit-cost").value);
          data.append("calc_type", document.getElementById("form-calc-type").value);
          data.append("calc_value", document.getElementById("form-calc-value").value);
          
          // Append Security Tokens
          data.append("csrf_token", document.getElementById("csrf_token").value);
          data.append("website_url", document.getElementById("website_url").value);
      
          fetch(window.location.href, {
              method: "POST",
              headers: { "Content-Type": "application/x-www-form-urlencoded" },
              body: data.toString()
          })
          .then(r => r.text())
          .then(res => {
              submitBtn.innerText = originalText;
              submitBtn.disabled = false;
              
              if(res.trim().includes("success")) {
                  // Honeypot will also return success but won't send emails/save DB
                  document.getElementById("popup-form").classList.add("hidden");
                  openResultPopup();
                  document.getElementById("solar-form").reset();
              } else if(res.trim().includes("csrf_error")) {
                  alert("Security token mismatch. Please refresh the page and try again.");
              } else if(res.trim().includes("rate_limit")) {
                  alert("Please wait 30 seconds before submitting another calculation.");
              } else if(res.trim().includes("invalid_email")) {
                  alert("Please enter a valid email address.");
              } else {
                  alert("Something went wrong. Please try again.");
                  console.log(res);
              }
          })
          .catch(err => {
              submitBtn.innerText = originalText;
              submitBtn.disabled = false;
              alert("Error: " + err);
          });
      };
    </script>
</body>
</html>