<?php
include 'db.php'; // database connection

// Get blog ID from query string
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$blog = null;

if ($id > 0) {
    // Fetch specific blog details
    $stmt = $conn->prepare("SELECT * FROM blogs WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $blog = $result->fetch_assoc();
        }
    }
}

// If no specific blog ID was provided or not found, fallback to the latest published blog
if (!$blog) {
    $fallbackStmt = $conn->query("SELECT * FROM blogs ORDER BY created_at DESC LIMIT 1");
    if ($fallbackStmt && $fallbackStmt->num_rows > 0) {
        $blog = $fallbackStmt->fetch_assoc();
        $id = (int) $blog['id'];
    }
}

// SEO Data Generation
if ($blog) {
    $canonicalUrl = "https://greenedgeinfratech.com/blog_details?id=" . $id;
    $pageTitle = htmlspecialchars($blog['title']) . " | GreenEdge Infratech";
    $cleanContent = trim(preg_replace('/\s+/', ' ', strip_tags($blog['content'] ?? '')));
    $metaDescription = mb_substr($cleanContent, 0, 155);
    if (mb_strlen($cleanContent) > 155) {
        $metaDescription .= '...';
    }
    $ogImage = !empty($blog['image']) ? "https://greenedgeinfratech.com/uploads/" . htmlspecialchars($blog['image']) : "https://greenedgeinfratech.com/assets/logo.png";

    // Schema.org BlogPosting
    $schemaData = [
        "@context" => "https://schema.org",
        "@type" => "BlogPosting",
        "headline" => $blog['title'],
        "description" => $metaDescription,
        "image" => !empty($blog['image']) ? ["https://greenedgeinfratech.com/uploads/" . $blog['image']] : ["https://greenedgeinfratech.com/assets/logo.png"],
        "datePublished" => !empty($blog['created_at']) ? date('c', strtotime($blog['created_at'])) : null,
        "mainEntityOfPage" => [
            "@type" => "WebPage",
            "@id" => $canonicalUrl
        ],
        "publisher" => [
            "@type" => "Organization",
            "name" => "GreenEdge Infratech",
            "logo" => [
                "@type" => "ImageObject",
                "url" => "https://greenedgeinfratech.com/assets/logo.png"
            ]
        ]
    ];
} else {
    $canonicalUrl = "https://greenedgeinfratech.com/blog_details";
    $pageTitle = "Blog Details | GreenEdge Infratech";
    $metaDescription = "Explore the latest insights, news, and technical guides on solar energy systems from GreenEdge Infratech.";
    $ogImage = "https://greenedgeinfratech.com/assets/logo.png";
    $schemaData = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle; ?></title>
    <meta name="description" content="<?= htmlspecialchars($metaDescription); ?>">
    <link rel="canonical" href="<?= $canonicalUrl; ?>" />
    <link rel="icon" href="assets/image/favicon.ico" type="image/x-icon">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article" />
    <meta property="og:url" content="<?= $canonicalUrl; ?>" />
    <meta property="og:title" content="<?= $pageTitle; ?>" />
    <meta property="og:description" content="<?= htmlspecialchars($metaDescription); ?>" />
    <meta property="og:image" content="<?= $ogImage; ?>" />
    <meta property="og:site_name" content="GreenEdge Infratech" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:url" content="<?= $canonicalUrl; ?>" />
    <meta name="twitter:title" content="<?= $pageTitle; ?>" />
    <meta name="twitter:description" content="<?= htmlspecialchars($metaDescription); ?>" />
    <meta name="twitter:image" content="<?= $ogImage; ?>" />

    <!-- Structured Data (Schema.org JSON-LD) -->
    <?php if (!empty($schemaData)): ?>
    <script type="application/ld+json">
    <?= json_encode(array_filter($schemaData), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?>
    </script>
    <?php endif; ?>
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
            <?php if ($blog): ?>
                <article class="max-w-4xl mx-auto">
                    <!-- Blog Image -->
                    <?php if (!empty($blog['image'])): ?>
                        <img src="uploads/<?= htmlspecialchars($blog['image']); ?>" 
                             alt="<?= htmlspecialchars($blog['title']); ?>" 
                             class="w-full h-80 object-cover rounded-lg shadow-lg mb-8">
                    <?php endif; ?>

                    <!-- Blog Title -->
                    <h1 class="text-4xl font-bold mb-4 text-gray-900"><?= htmlspecialchars($blog['title']); ?></h1>

                    <!-- Blog Meta -->
                    <div class="text-gray-500 mb-6 flex items-center space-x-4 text-sm">
                        <span><i class="fas fa-calendar-alt mr-2"></i><?= date("F j, Y", strtotime($blog['created_at'])); ?></span>
                        <span><i class="fas fa-building mr-2"></i>GreenEdge Infratech</span>
                    </div>

                    <!-- Blog Content -->
                    <div class="blog-content prose max-w-none text-lg text-gray-700 leading-relaxed">
                        <?= $blog['content']; ?>
                    </div>
                </article>
            <?php else: ?>
                <div class="text-center py-16">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">Blog Post Not Found</h1>
                    <p class="text-gray-600 mb-6">The requested blog post is not available. Please explore our other solar articles.</p>
                    <a href="blogs.php" class="inline-block bg-green-600 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-green-700 transition">View All Blogs</a>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
    <div id="footer"></div>

<script src="./assets/js/component.js"></script>
</body>
</html>
