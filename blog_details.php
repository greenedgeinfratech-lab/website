<?php
include 'db.php'; // database connection

// Get blog ID from query string
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    die("Invalid blog ID.");
}

// Fetch blog details
$stmt = $conn->prepare("SELECT * FROM blogs WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Blog not found.");
}

$blog = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($blog['title']); ?> | Blog Details</title>
    <link rel="icon" href="assets/image/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
<body class="bg-gray-100">
    
    <div id="header"></div>
    
    <!-- Blog Detail Section -->
    <section class="py-10 bg-white">
        <div class="container mx-auto px-4 w-[90%] max-w-7xl">

            <!-- Blog Image -->
            <?php if (!empty($blog['image'])): ?>
                <img src="uploads/<?= htmlspecialchars($blog['image']); ?>" 
                     alt="<?= htmlspecialchars($blog['title']); ?>" 
                     class="w-full h-80 object-cover rounded-lg shadow-lg mb-8">
            <?php endif; ?>

            <!-- Blog Title -->
            <h1 class="text-4xl font-bold mb-4"><?= htmlspecialchars($blog['title']); ?></h1>

            <!-- Blog Meta -->
            <p class="text-gray-500 mb-6">
                <i class="fas fa-calendar-alt mr-2"></i>
                <?= date("F j, Y", strtotime($blog['created_at'])); ?>
            </p>

            <!-- Blog Content -->
            <div class="prose max-w-none text-lg text-gray-700 leading-relaxed">
                <?= $blog['content']; ?>
            </div>

        </div>
    </section>
    
    <div id="footer"></div>

<script src="./assets/js/component.js"></script>
</body>
</html>
