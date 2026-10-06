<?php
include 'db.php';

// Pagination setup
$limit = 6; // blogs per page
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1) $page = 1;

$offset = ($page - 1) * $limit;

// Count total blogs
$totalQuery = $conn->query("SELECT COUNT(*) as total FROM blogs");
$totalBlogs = $totalQuery->fetch_assoc()['total'];
$totalPages = ceil($totalBlogs / $limit);

// Fetch blogs for current page
$stmt = $conn->prepare("SELECT * FROM blogs ORDER BY created_at DESC LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Blogs | Solar Insights - GreenEdge Infratech</title>
  <meta name="description" content="Explore solar energy insights, news, and guides from GreenEdge Infratech. Stay informed on sustainability, solar panel installation, and clean technology.">
  <link rel="canonical" href="https://greenedgeinfratech.com/blogs<?= ($page > 1) ? '?page=' . $page : ''; ?>" />
  <link rel="icon" href="assets/image/favicon.ico" type="image/x-icon">

  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://greenedgeinfratech.com/blogs<?= ($page > 1) ? '?page=' . $page : ''; ?>" />
  <meta property="og:title" content="All Blogs | Solar Insights - GreenEdge Infratech" />
  <meta property="og:description" content="Explore solar energy insights, news, and guides from GreenEdge Infratech. Stay informed on sustainability, solar panel installation, and clean technology." />
  <meta property="og:image" content="https://greenedgeinfratech.com/assets/logo.png" />
  <meta property="og:site_name" content="GreenEdge Infratech" />

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:url" content="https://greenedgeinfratech.com/blogs<?= ($page > 1) ? '?page=' . $page : ''; ?>" />
  <meta name="twitter:title" content="All Blogs | Solar Insights - GreenEdge Infratech" />
  <meta name="twitter:description" content="Explore solar energy insights, news, and guides from GreenEdge Infratech. Stay informed on sustainability, solar panel installation, and clean technology." />
  <meta name="twitter:image" content="https://greenedgeinfratech.com/assets/logo.png" />

  <!-- Structured Data (Schema.org JSON-LD) -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": "All Blogs | Solar Insights - GreenEdge Infratech",
    "url": "https://greenedgeinfratech.com/blogs",
    "description": "Explore solar energy insights, news, and guides from GreenEdge Infratech.",
    "publisher": {
      "@type": "Organization",
      "name": "GreenEdge Infratech",
      "logo": {
        "@type": "ImageObject",
        "url": "https://greenedgeinfratech.com/assets/logo.png"
      }
    }
  }
  </script>
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
    
  <!-- Blogs Section -->
  <section class="py-20 bg-white">
    <div class="container mx-auto px-4">

      <!-- Header -->
      <div class="text-center mb-16">
        <div class="inline-flex items-center space-x-2 bg-blue-100 rounded-full px-4 py-2 mb-4">
          <i class="fas fa-newspaper text-blue-600 w-4 h-4"></i>
          <span class="text-blue-600 text-sm font-medium">Solar Knowledge Hub</span>
        </div>
        <h1 class="text-4xl md:text-5xl font-bold mb-6">Explore Our Blog Articles</h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
          Discover the latest news, guides, and insights on solar energy and sustainability.
        </p>
      </div>

      <!-- Blogs Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <?php
              $rawExcerpt = trim(preg_replace('/\s+/', ' ', strip_tags($row['content'] ?? '')));
              $excerpt = mb_substr($rawExcerpt, 0, 180);
              if (mb_strlen($rawExcerpt) > 180) {
                  $excerpt .= '...';
              }
              $blogDate = !empty($row['created_at']) ? date("F j, Y", strtotime($row['created_at'])) : '';
            ?>
            <article class="bg-gray-50 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition flex flex-col justify-between">
              <div>
                <a href="blog_details.php?id=<?= $row['id']; ?>" class="block overflow-hidden">
                  <img src="uploads/<?= htmlspecialchars($row['image']); ?>" 
                       alt="<?= htmlspecialchars($row['title']); ?>" 
                       class="w-full h-48 object-cover hover:scale-105 transition duration-300">
                </a>
                <div class="p-6 pb-2">
                  <?php if (!empty($blogDate)): ?>
                    <p class="text-xs text-gray-500 mb-2 flex items-center">
                      <i class="fas fa-calendar-alt mr-2 text-green-600"></i>
                      <?= $blogDate; ?>
                    </p>
                  <?php endif; ?>
                  <h2 class="text-xl font-bold text-gray-900 mb-3 hover:text-green-600 transition">
                    <a href="blog_details.php?id=<?= $row['id']; ?>">
                      <?= htmlspecialchars($row['title']); ?>
                    </a>
                  </h2>
                  <p class="text-gray-600 text-sm leading-relaxed mb-4">
                    <?= htmlspecialchars($excerpt); ?>
                  </p>
                </div>
              </div>
              <div class="px-6 pb-6 pt-2">
                <a href="blog_details.php?id=<?= $row['id']; ?>" 
                   class="inline-flex items-center text-green-600 font-semibold hover:text-green-700 hover:underline text-sm">
                  Read Full Article <i class="fas fa-arrow-right ml-1.5 text-xs"></i>
                </a>
              </div>
            </article>
          <?php endwhile; ?>
        <?php else: ?>
          <p class="col-span-3 text-center text-gray-500 py-8">No blogs available at this moment. Please check back soon.</p>
        <?php endif; ?>
      </div>

      <!-- Pagination -->
      <div class="flex justify-center space-x-2">
        <?php if ($page > 1): ?>
          <a href="?page=<?= $page - 1; ?>" 
             class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
            <i class="fas fa-arrow-left"></i> Prev
          </a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <a href="?page=<?= $i; ?>" 
             class="px-4 py-2 <?= $i == $page ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700'; ?> rounded hover:bg-green-500 hover:text-white">
            <?= $i; ?>
          </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
          <a href="?page=<?= $page + 1; ?>" 
             class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
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
