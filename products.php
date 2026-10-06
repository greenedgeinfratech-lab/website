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

// Get product slug from URL
$slug = $_GET['slug'] ?? '';

// If no slug provided, show all products instead of redirecting
if (empty($slug)) {
    // Fetch all active products
    $sql = "SELECT `id`, `name`, `slug`, `description`, `image_path`, `content`, `is_active`, `created_at`, `updated_at` FROM `products` WHERE `is_active` = 1 ORDER BY `created_at` DESC";
    $result = $conn->query($sql);
    $showAllProducts = true;
} else {
    // Fetch specific product
    $stmt = $conn->prepare("SELECT `id`, `name`, `slug`, `description`, `image_path`, `content`, `is_active`, `created_at`, `updated_at` FROM `products` WHERE `slug` = ? AND `is_active` = 1");
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $showAllProducts = false;
    
    // If product not found, show all products instead of redirecting
    if (!$product) {
        $sql = "SELECT `id`, `name`, `slug`, `description`, `image_path`, `content`, `is_active`, `created_at`, `updated_at` FROM `products` WHERE `is_active` = 1 ORDER BY `created_at` DESC";
        $result = $conn->query($sql);
        $showAllProducts = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php if (!$showAllProducts && isset($product)): ?>
            <?php echo htmlspecialchars($product['name']); ?> - GreenEdge Infratech
        <?php else: ?>
            Our Products - GreenEdge Infratech
        <?php endif; ?>
    </title>
    <meta name="description" content="<?php echo (!$showAllProducts && isset($product)) ? htmlspecialchars(mb_substr(strip_tags($product['description'] ?? $product['name']), 0, 155)) : 'Explore high-quality solar products, inverters, and clean energy components from GreenEdge Infratech.'; ?>">
    <link rel="canonical" href="https://greenedgeinfratech.com/products<?= (!$showAllProducts && isset($product) && !empty($product['slug'])) ? '?slug=' . urlencode($product['slug']) : ''; ?>" />
    <link rel="icon" href="assets/image/favicon.ico" type="image/x-icon">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://greenedgeinfratech.com/products<?= (!$showAllProducts && isset($product) && !empty($product['slug'])) ? '?slug=' . urlencode($product['slug']) : ''; ?>" />
    <meta property="og:title" content="<?php echo (!$showAllProducts && isset($product)) ? htmlspecialchars($product['name']) . ' - GreenEdge Infratech' : 'Our Products - GreenEdge Infratech'; ?>" />
    <meta property="og:description" content="<?php echo (!$showAllProducts && isset($product)) ? htmlspecialchars(mb_substr(strip_tags($product['description'] ?? $product['name']), 0, 155)) : 'Explore high-quality solar products, inverters, and clean energy components from GreenEdge Infratech.'; ?>" />
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

    <?php if (!$showAllProducts && isset($product)): ?>
        <!-- Single Product Details Section -->
        <section class="container mx-auto px-6 py-16">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Product Image -->
                    <div>
                        <?php if (!empty($product['image_path'])): ?>
                            <img src="<?php echo htmlspecialchars($product['image_path']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                 class="w-full rounded-lg shadow-lg">
                        <?php else: ?>
                            <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-image text-gray-400 text-6xl"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Product Info -->
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-4">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </h1>
                        
                        <?php if (!empty($product['description'])): ?>
                            <p class="text-gray-600 text-lg mb-6">
                                <?php echo htmlspecialchars($product['description']); ?>
                            </p>
                        <?php endif; ?>
                        
                        <div class="prose max-w-none mb-6">
                            <?php echo $product['content']; ?>
                        </div>
                        
                        <div class="border-t pt-6">
                            <p class="text-sm text-gray-500">
                                <strong>Last Updated:</strong> 
                                <?php echo date('F j, Y', strtotime($product['updated_at'])); ?>
                            </p>
                        </div>
                        
                        <div class="mt-8">
                            <a href="contact.html" 
                               class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 transition duration-300 font-semibold">
                                Inquire About This Product
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php else: ?>
        <!-- All Products Section -->
        <section class="relative bg-[url('assets/image/products.jpg')] bg-cover bg-center bg-no-repeat text-white py-20">
            <div class="absolute inset-0 bg-gradient-to-r from-green-700/80 to-green-500/80 to-transparent"></div>
            <div class="relative container mx-auto px-6 text-center">
                <h1 class="text-4xl font-bold mb-4">Our Products</h1>
                <p class="max-w-2xl mx-auto text-lg">
                    High-quality, sustainable, and innovative products designed to meet your infrastructure needs.
                </p>
            </div>
        </section>

        <section class="container mx-auto px-6 py-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Explore Our Product Range</h2>
                <p class="text-gray-600 mt-2">
                    Choose from our wide selection of eco-friendly and reliable infrastructure products.
                </p>
            </div>

            <!-- Product Grid -->
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <?php if (isset($result) && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                            <div class="h-48 overflow-hidden">
                                <?php if (!empty($row['image_path'])): ?>
                                    <img src="<?php echo htmlspecialchars($row['image_path']); ?>" 
                                         alt="<?php echo htmlspecialchars($row['name']); ?>" 
                                         class="w-full h-full object-cover hover:scale-105 transition duration-300">
                                <?php else: ?>
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-4xl"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">
                                    <?php echo htmlspecialchars($row['name']); ?>
                                </h3>
                                
                                <p class="text-gray-600 mb-4">
                                    <?php 
                                    $description = !empty($row['description']) ? $row['description'] : 
                                                 (strip_tags($row['content']) ?: 'No description available.');
                                    echo htmlspecialchars(substr($description, 0, 120)) . 
                                        (strlen($description) > 120 ? '...' : '');
                                    ?>
                                </p>
                                
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">
                                        Added: <?php echo date('M j, Y', strtotime($row['created_at'])); ?>
                                    </span>
                                    
                                    <a href="?slug=<?php echo urlencode($row['slug']); ?>" 
                                       class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-300 text-sm font-medium">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-span-3 text-center py-12">
                        <i class="fas fa-box-open text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">No Products Available</h3>
                        <p class="text-gray-500">We're currently updating our product catalog. Please check back later.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- CTA Section -->
    <section class="bg-gradient-to-br from-green-900/90 via-green-700/70 text-white py-12">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-4">Interested in Our Products?</h2>
            <p class="mb-6">Get in touch with us today to learn more about our sustainable product range.</p>
            <a href="contact.html"
                class="bg-white text-green-600 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition">
                Contact Us
            </a>
        </div>
    </section>

    <div id="footer"></div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
    <script src="./assets/js/component.js"></script>

</body>
</html>

<?php
// Close database connection
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?>