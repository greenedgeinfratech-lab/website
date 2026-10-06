<?php
include 'db.php';

// Pagination setup
$limit = 6;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1) $page = 1;

$offset = ($page - 1) * $limit;

// Count total news
$totalQuery = $conn->query("SELECT COUNT(*) as total FROM news");
$totalNews = $totalQuery->fetch_assoc()['total'];
$totalPages = ceil($totalNews / $limit);

// Fetch news for current page
$stmt = $conn->prepare("SELECT * FROM news ORDER BY created_at DESC LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Latest News | GreenEdge Infratech</title>
  <meta name="description" content="Stay updated with the latest news, announcements, solar project milestones, and clean energy developments from GreenEdge Infratech.">
  <link rel="canonical" href="https://greenedgeinfratech.com/latest_news<?= ($page > 1) ? '?page=' . $page : ''; ?>" />
  <link rel="icon" href="assets/image/favicon.ico" type="image/x-icon">

  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://greenedgeinfratech.com/latest_news<?= ($page > 1) ? '?page=' . $page : ''; ?>" />
  <meta property="og:title" content="Latest News | GreenEdge Infratech" />
  <meta property="og:description" content="Stay updated with the latest news, announcements, solar project milestones, and clean energy developments from GreenEdge Infratech." />
  <meta property="og:image" content="https://greenedgeinfratech.com/assets/logo.png" />
  <meta property="og:site_name" content="GreenEdge Infratech" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div id="header"></div>

<!-- News Section -->
<section class="py-20 bg-white">
  <div class="container mx-auto px-4">

    <!-- Header -->
    <div class="text-center mb-16">
      <div class="inline-flex items-center space-x-2 bg-green-100 rounded-full px-4 py-2 mb-4">
        <i class="fas fa-newspaper text-green-600 w-4 h-4"></i>
        <span class="text-green-600 text-sm font-medium">Latest News</span>
      </div>
      <h1 class="text-4xl md:text-5xl font-bold mb-6">Explore Our News Updates</h1>
      <p class="text-xl text-gray-600 max-w-2xl mx-auto">
        Discover company updates, industry news, and important announcements.
      </p>
    </div>

    <!-- News Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">

      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="bg-gray-50 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">

            <a href="news_details.php?id=<?= $row['id']; ?>">
              <?php if ($row['image']): ?>
                <img src="uploads/<?= htmlspecialchars($row['image']); ?>"
                     alt="<?= htmlspecialchars($row['title']); ?>"
                     class="w-full h-48 object-cover hover:scale-105 transition duration-300">
              <?php else: ?>
                <img src="assets/default-news.jpg"
                     class="w-full h-48 object-cover">
              <?php endif; ?>
            </a>

            <div class="p-6">
              <p class="text-sm text-gray-500 mb-2">
                <i class="fas fa-calendar-alt mr-1"></i>
                <?= date("d M Y", strtotime($row['created_at'])); ?>
              </p>

              <h3 class="text-xl font-bold mb-2">
                <?= htmlspecialchars($row['title']); ?>
              </h3>

              <p class="text-gray-600 mb-4">
                <?= substr(strip_tags($row['content']), 0, 120); ?>...
              </p>

              <a href="news_details.php?id=<?= $row['id']; ?>"
                 class="text-green-600 font-semibold hover:underline">
                Read More <i class="fas fa-arrow-right ml-1"></i>
              </a>
            </div>

          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="col-span-3 text-center text-gray-500">
          No news available.
        </p>
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
