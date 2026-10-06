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

// Fetch services from database
$sql = "SELECT `id`, `title`, `description`, `image_path`, `is_active`, `created_at`, `updated_at` FROM `services` WHERE `is_active` = 1 ORDER BY `created_at` DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services - GreenEdge Infratech</title>
    <meta name="description" content="Discover professional solar services by GreenEdge Infratech: solar installation, energy storage solutions, maintenance and repairs, and energy efficiency consulting.">
    <link rel="canonical" href="https://greenedgeinfratech.com/services" />
    <link rel="icon" href="assets/image/favicon.ico" type="image/x-icon">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://greenedgeinfratech.com/services" />
    <meta property="og:title" content="Our Services - GreenEdge Infratech" />
    <meta property="og:description" content="Discover professional solar services by GreenEdge Infratech: solar installation, energy storage, maintenance, and consulting." />
    <meta property="og:image" content="https://greenedgeinfratech.com/assets/logo.png" />
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

    <!-- Hero Section -->
    <section class="relative bg-[url('assets/image/service-bg.jpg')] bg-cover bg-center text-white py-20">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-green-900/90 via-green-700/70 to-transparent"></div>

        <!-- Content -->
        <div class="relative container mx-auto text-center px-6">
            <h1 class="text-4xl md:text-5xl font-bold text-white">Our Services</h1>
        </div>
    </section>


    <!-- Services Intro -->
    <!--<section class="py-16 bg-gray-50 text-center">-->
    <!--    <div class="container mx-auto px-6 md:px-12">-->
    <!--        <h2 class="text-3xl font-bold text-green-900 mb-4">What We Offer</h2>-->
    <!--        <p class="text-gray-600 max-w-2xl mx-auto">-->
    <!--            At GreenEdge Infratech, we provide innovative and sustainable solar energy solutions — from consultation-->
    <!--            to maintenance — that meet the highest standards of quality and efficiency.-->
    <!--        </p>-->
    <!--    </div>-->
    <!--</section>-->

    <section id="services" class="py-20 bg-gray-100">
        <div class="container mx-auto px-4">

            <!-- Header -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center space-x-2 bg-green-100 rounded-full px-4 py-2 mb-4">
                    <i class="fas fa-bolt text-green-600 w-4 h-4"></i>
                    <span class="text-green-600 text-sm font-medium">Our Services</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    Complete Solar Solutions
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    From initial consultation to ongoing maintenance, we provide end-to-end solar energy services
                    tailored to your specific needs and budget.
                </p>
            </div>

            <!-- Services Grid (Dynamic PHP content) -->
            <div id="services-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8 mb-12">
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                            <!-- Service Image -->
                            <div class="h-48 overflow-hidden">
                                <?php if (!empty($row['image_path'])): ?>
                                    <img src="<?php echo htmlspecialchars($row['image_path']); ?>" 
                                         alt="<?php echo htmlspecialchars($row['title']); ?>" 
                                         class="w-full h-full object-cover hover:scale-105 transition duration-300">
                                <?php else: ?>
                                    <div class="w-full h-full bg-green-100 flex items-center justify-center">
                                        <i class="fas fa-solar-panel text-green-600 text-5xl"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Service Content -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-3">
                                    <?php echo htmlspecialchars($row['title']); ?>
                                </h3>
                                
                                <p class="text-gray-600 mb-4 leading-relaxed">
                                    <?php 
                                    $description = !empty($row['description']) ? $row['description'] : 'No description available.';
                                    // Strip HTML tags and limit to 150 characters
                                    $short_description = strip_tags($description);
                                    $short_description = substr($short_description, 0, 150);
                                    if (strlen(strip_tags($description)) > 150) {
                                        $short_description .= '...';
                                    }
                                    echo htmlspecialchars($short_description);
                                    ?>
                                </p>
                                
                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-gray-500">
                                        <span>
                                            <i class="fas fa-calendar-alt mr-1"></i>
                                            <?php echo date('M j, Y', strtotime($row['created_at'])); ?>
                                        </span>
                                        <?php if ($row['updated_at'] != $row['created_at']): ?>
                                            <span class="text-green-600 ml-3">
                                                <i class="fas fa-sync-alt mr-1"></i>
                                                Updated
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <a href="service-details.php?id=<?php echo $row['id']; ?>" 
                                       class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-300 text-sm font-medium">
                                        Learn More
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-span-2 text-center py-12">
                        <div class="bg-white rounded-xl shadow-lg p-8">
                            <i class="fas fa-concierge-bell text-gray-400 text-6xl mb-4"></i>
                            <h3 class="text-2xl font-semibold text-gray-600 mb-2">No Services Available</h3>
                            <p class="text-gray-500">We are currently updating our service offerings. Please check back later.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- CTA -->
            <div class="text-center">
              <a href="contact.html"
                 class="inline-block bg-gradient-to-br from-blue-600 to-green-500 text-white px-6 py-3 rounded-lg text-lg font-semibold hover:opacity-90 transition">
                Get Custom Quote
                <i class="fas fa-arrow-right ml-2"></i>
              </a>
            </div>

        </div>
    </section>

    <!-- Call to Action -->
    <section class="bg-gradient-to-br from-green-900/90 via-green-700/70 text-white py-16 text-center">
        <h2 class="text-3xl font-bold mb-4">Ready to Go Solar?</h2>
        <p class="mb-6">Let's create a sustainable and affordable energy future for your home or business.</p>
        <a href="contact.html"
            class="bg-white text-green-900 px-6 py-3 rounded-full font-semibold shadow hover:bg-gray-200 transition">Contact
            Us</a>
    </section>

    <div id="footer"></div>

    <script src="./assets/js/component.js"></script>
    <script src="./assets/js/script.js"></script>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>