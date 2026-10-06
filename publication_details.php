<?php
include 'db.php';

// Validate ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("SELECT * FROM publications WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$publication = $result->fetch_assoc();

if (!$publication) {
    header("Location: publications.php");
    exit;
}

// Fetch related publications (exclude current one)
$relatedStmt = $conn->prepare("SELECT id, title FROM publications WHERE id != ? ORDER BY created_at DESC LIMIT 3");
$relatedStmt->bind_param("i", $id);
$relatedStmt->execute();
$relatedResult = $relatedStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($publication['title']); ?> | GreenEdge Infratech</title>
<meta name="description" content="<?= htmlspecialchars(mb_substr(trim(preg_replace('/\s+/', ' ', strip_tags($publication['content'] ?? ''))), 0, 155)); ?>">
<link rel="canonical" href="https://greenedgeinfratech.com/publication_details<?= ($id > 0) ? '?id=' . $id : ''; ?>" />
<link rel="icon" href="assets/image/favicon.ico">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="article" />
<meta property="og:url" content="https://greenedgeinfratech.com/publication_details<?= ($id > 0) ? '?id=' . $id : ''; ?>" />
<meta property="og:title" content="<?= htmlspecialchars($publication['title']); ?> | GreenEdge Infratech" />
<meta property="og:description" content="<?= htmlspecialchars(mb_substr(trim(preg_replace('/\s+/', ' ', strip_tags($publication['content'] ?? ''))), 0, 155)); ?>" />
<meta property="og:image" content="<?= !empty($publication['image']) ? 'https://greenedgeinfratech.com/uploads/' . htmlspecialchars($publication['image']) : 'https://greenedgeinfratech.com/assets/logo.png'; ?>" />
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
        <h1 class="text-3xl md:text-4xl font-bold">
            <?= htmlspecialchars($publication['title']); ?>
        </h1>
        <p class="mt-4 text-lg">
            <i class="fas fa-calendar-alt mr-1"></i>
            <?= date("d M Y", strtotime($publication['created_at'])); ?>
        </p>
    </div>
</section>

<!-- Main Content -->
<section class="py-16 bg-white">
<div class="container mx-auto px-6 max-w-8xl">

    <div class="prose max-w-none">
        <?= $publication['content']; ?>
    </div>

    <!-- Back Button -->
    <div class="mt-10">
        <a href="publications.php"
           class="inline-block bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
           <i class="fas fa-arrow-left mr-1"></i> Back to Publications
        </a>
    </div>

</div>
</section>

<!-- Related Publications -->
<?php if ($relatedResult->num_rows > 0): ?>
<section class="py-16 bg-gray-50">
<div class="container mx-auto px-6 max-w-6xl">

    <h2 class="text-2xl font-bold mb-8 text-center">Related Publications</h2>

    <div class="grid md:grid-cols-3 gap-6">
        <?php while($related = $relatedResult->fetch_assoc()): ?>
            <div class="bg-white p-6 rounded shadow hover:shadow-lg transition">
                <h3 class="font-semibold mb-3">
                    <?= htmlspecialchars($related['title']); ?>
                </h3>

                <a href="publication_details.php?id=<?= $related['id']; ?>"
                   class="text-green-600 font-semibold hover:underline">
                   Read More →
                </a>
            </div>
        <?php endwhile; ?>
    </div>

</div>
</section>
<?php endif; ?>

<div id="footer"></div>
<script src="./assets/js/component.js"></script>

</body>
</html>
