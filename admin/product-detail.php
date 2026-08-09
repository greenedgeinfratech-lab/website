<?php
session_start();

include "../db.php";





// Get product parameter from URL
$productSlug = $_GET['product'] ?? '';

// Find the matching product from database
$product = $productManager->getProductBySlug($productSlug);

if ($product) {
    // Fill hero section
    $heroImage = !empty($product['image_path']) ? $product['image_path'] : 'assets/image/default-product.jpg';
    $heroTitle = $product['name'];
    $heroDescription = $product['description'];
    
    // Fill content section
    $productContent = $product['content'];
    
    // Page title
    $pageTitle = $product['name'] . " - GreenEdge Infratech";
} else {
    // Product not found
    $heroImage = 'assets/image/default-bg.jpg';
    $heroTitle = 'Product Not Found';
    $heroDescription = 'The requested product could not be found.';
    $productContent = '<p class="text-center text-gray-600">Product not found.</p>';
    $pageTitle = 'Product Not Found - GreenEdge Infratech';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $pageTitle; ?></title>
  <link rel="icon" href="assets/image/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-b from-green-50 to-white text-gray-800">
  <div id="header"></div>

  <!-- Hero Section -->
  <section class="relative text-center py-20">
    <div class="absolute inset-0">
      <img id="heroImage" src="<?php echo $heroImage; ?>" alt="<?php echo $heroTitle; ?>" class="w-full h-full object-cover">
      <div class="absolute inset-0 bg-gradient-to-br from-green-700/80 to-green-500/80"></div>
    </div>
    <div class="relative z-10">
      <h2 id="heroTitle" class="text-4xl font-bold text-white"><?php echo $heroTitle; ?></h2>
      <p id="heroDescription" class="mt-4 text-lg text-white max-w-2xl mx-auto"><?php echo $heroDescription; ?></p>
    </div>
  </section>

  <!-- Product Content Section -->
  <section class="max-w-6xl mx-auto py-16 px-6" id="productContent">
    <h3 class="text-3xl font-bold mb-6"><?php echo $heroTitle; ?></h3>
    <?php echo $productContent; ?>
  </section>

  <div id="footer"></div>

  <script src="./assets/js/component.js"></script>
</body>
</html>