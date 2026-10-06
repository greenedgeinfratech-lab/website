<?php
// Database connection
$servername = "localhost";
$username = "u414903541_greenedge";
$password = "Gyanendra123!";
$dbname = "u414903541_greenedge";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get service ID from URL
$service_id = $_GET['id'] ?? '';

if (empty($service_id)) {
    header("Location: services.php");
    exit();
}

// Fetch specific service
$stmt = $conn->prepare("SELECT `id`, `title`, `description`, `image_path`, `is_active`, `created_at`, `updated_at` FROM `services` WHERE `id` = ? AND `is_active` = 1");
$stmt->bind_param("i", $service_id);
$stmt->execute();
$result = $stmt->get_result();
$service = $result->fetch_assoc();

if (!$service) {
    header("Location: services.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($service['title']); ?> - GreenEdge Infratech</title>
    <meta name="description" content="<?php echo htmlspecialchars(mb_substr(strip_tags($service['description'] ?? $service['title']), 0, 155)); ?>">
    <link rel="canonical" href="https://greenedgeinfratech.com/service-details<?= (!empty($service_id)) ? '?id=' . htmlspecialchars((string)$service_id) : ''; ?>" />
    <link rel="icon" href="assets/image/favicon.ico" type="image/x-icon">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://greenedgeinfratech.com/service-details<?= (!empty($service_id)) ? '?id=' . htmlspecialchars((string)$service_id) : ''; ?>" />
    <meta property="og:title" content="<?php echo htmlspecialchars($service['title']); ?> - GreenEdge Infratech" />
    <meta property="og:description" content="<?php echo htmlspecialchars(mb_substr(strip_tags($service['description'] ?? $service['title']), 0, 155)); ?>" />
    <meta property="og:image" content="<?php echo !empty($service['image_path']) ? 'https://greenedgeinfratech.com/' . htmlspecialchars($service['image_path']) : 'https://greenedgeinfratech.com/assets/logo.png'; ?>" />
    <meta property="og:site_name" content="GreenEdge Infratech" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-11515555005"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-11515555005');
</script>
</head>
<body class="font-sans text-gray-800">

    <div id="header"></div>

    <!-- Service Details Section -->
    <section class="container mx-auto px-6 py-16">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Service Image -->
                <div>
                    <?php if (!empty($service['image_path'])): ?>
                        <img src="<?php echo htmlspecialchars($service['image_path']); ?>" 
                             alt="<?php echo htmlspecialchars($service['title']); ?>" 
                             class="w-full rounded-lg shadow-lg">
                    <?php else: ?>
                        <div class="w-full h-64 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-solar-panel text-green-600 text-6xl"></i>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Service Info -->
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">
                        <?php echo htmlspecialchars($service['title']); ?>
                    </h1>
                    
                    <div class="prose max-w-none mb-6 text-gray-700 leading-relaxed">
                        <?php echo nl2br(htmlspecialchars($service['description'])); ?>
                    </div>
                    
                    <div class="border-t pt-6">
                        <p class="text-sm text-gray-500">
                            <strong>Last Updated:</strong> 
                            <?php echo date('F j, Y', strtotime($service['updated_at'])); ?>
                        </p>
                    </div>
                    
                    <div class="mt-8 flex gap-4">
                        <a href="contact.html" 
                           class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 transition duration-300 font-semibold">
                            Get Quote
                        </a>
                        <a href="services.php" 
                           class="border border-green-600 text-green-600 px-8 py-3 rounded-lg hover:bg-green-50 transition duration-300 font-semibold">
                            Back to Services
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="bg-gradient-to-br from-green-900/90 via-green-700/70 text-white py-16 text-center">
        <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
        <p class="mb-6">Contact us today to learn more about our <?php echo htmlspecialchars($service['title']); ?> service.</p>
        <a href="contact.html"
            class="bg-white text-green-900 px-6 py-3 rounded-full font-semibold shadow hover:bg-gray-200 transition">Contact
            Us</a>
    </section>

    <div id="footer"></div>

    <script src="./assets/js/component.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>