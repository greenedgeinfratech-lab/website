<?php
include 'db.php';

// Pagination
$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$offset = ($page - 1) * $limit;

// Count total publications
$totalQuery = $conn->query("SELECT COUNT(*) as total FROM publications");
$totalPublications = $totalQuery->fetch_assoc()['total'];
$totalPages = ceil($totalPublications / $limit);

// Fetch publications
$stmt = $conn->prepare("SELECT * FROM publications ORDER BY created_at DESC LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Publications | GreenEdge Infratech</title>
<meta name="description" content="Explore research publications, whitepapers, and technical reports on solar energy and sustainable infrastructure by GreenEdge Infratech.">
<link rel="canonical" href="https://greenedgeinfratech.com/publications<?= ($page > 1) ? '?page=' . $page : ''; ?>" />
<link rel="icon" href="assets/image/favicon.ico">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website" />
<meta property="og:url" content="https://greenedgeinfratech.com/publications<?= ($page > 1) ? '?page=' . $page : ''; ?>" />
<meta property="og:title" content="Publications | GreenEdge Infratech" />
<meta property="og:description" content="Explore research publications, whitepapers, and technical reports on solar energy by GreenEdge Infratech." />
<meta property="og:image" content="https://greenedgeinfratech.com/assets/logo.png" />
<meta property="og:site_name" content="GreenEdge Infratech" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans text-gray-800 bg-gray-100">

<div id="header"></div>

<!-- Hero -->
<section class="relative bg-[url('assets/image/about-bg.png')] bg-cover bg-center text-white py-20">
    <div class="absolute inset-0 bg-gradient-to-r from-green-900/90 via-green-700/70 to-transparent"></div>
    <div class="container mx-auto text-center px-6 relative z-10">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Publications</h1>
        <p class="text-lg max-w-2xl mx-auto">
            Explore our research articles, whitepapers, and thought leadership insights.
        </p>
    </div>
</section>

<!-- Publications Grid -->
<section class="py-20 bg-white">
<div class="container mx-auto px-6">

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">

<?php if ($result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>
        
        <div class="bg-white border border-gray-200 rounded-xl 
            shadow-md hover:shadow-2xl 
            hover:-translate-y-2 
            transition-all duration-300 
            p-6 flex flex-col justify-between">

        <div>
            <p class="text-sm text-green-600 font-medium mb-2">
                <i class="fas fa-calendar-alt mr-1"></i>
                <?= date("d M Y", strtotime($row['created_at'])); ?>
            </p>
    
            <h3 class="text-xl font-bold mb-3 text-gray-800">
                <?= htmlspecialchars($row['title']); ?>
            </h3>
    
            <p class="text-gray-600 mb-6">
                <?= substr(strip_tags($row['content']), 0, 120); ?>...
            </p>
        </div>
    
        <a href="publication_details.php?id=<?= $row['id']; ?>"
           class="inline-flex items-center justify-center 
                  bg-green-600 text-white 
                  px-4 py-2 rounded-lg 
                  hover:bg-green-700 
                  transition font-semibold">
            Read More
            <i class="fas fa-arrow-right ml-2"></i>
        </a>
    
    </div>

    <?php endwhile; ?>
<?php else: ?>
    <div class="col-span-3 text-center text-gray-500">
        No publications available.
    </div>
<?php endif; ?>

</div>

<!-- Pagination -->
<div class="flex justify-center space-x-2">

<?php if ($page > 1): ?>
    <a href="?page=<?= $page-1; ?>" 
       class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
       <i class="fas fa-arrow-left"></i> Prev
    </a>
<?php endif; ?>

<?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="?page=<?= $i; ?>"
       class="px-4 py-2 <?= $i == $page ? 'bg-green-600 text-white' : 'bg-gray-200'; ?> rounded hover:bg-green-500 hover:text-white">
       <?= $i; ?>
    </a>
<?php endfor; ?>

<?php if ($page < $totalPages): ?>
    <a href="?page=<?= $page+1; ?>" 
       class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
       Next <i class="fas fa-arrow-right"></i>
    </a>
<?php endif; ?>

</div>

</div>
</section>

<div id="footer"></div>
<script src="./assets/js/component.js"></script>

</body>
</html>
