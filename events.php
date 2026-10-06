<?php
include 'db.php';
$events = $conn->query("SELECT * FROM events ORDER BY event_date DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events | GreenEdge Infratech</title>
    <meta name="description" content="Discover upcoming events, workshops, webinars, and sustainability conferences hosted by GreenEdge Infratech.">
    <link rel="canonical" href="https://greenedgeinfratech.com/events" />
    <link rel="icon" href="assets/image/favicon.ico" type="image/x-icon">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://greenedgeinfratech.com/events" />
    <meta property="og:title" content="Events | GreenEdge Infratech" />
    <meta property="og:description" content="Discover upcoming events, workshops, webinars, and sustainability conferences hosted by GreenEdge Infratech." />
    <meta property="og:image" content="https://greenedgeinfratech.com/assets/logo.png" />
    <meta property="og:site_name" content="GreenEdge Infratech" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
    <section class="relative bg-[url('assets/image/about-bg.png')] bg-cover bg-center text-white py-20">
        <div class="absolute inset-0 bg-gradient-to-r from-green-900/90 via-green-700/70 to-transparent"></div>
        <div class="container mx-auto text-center px-6 relative z-10">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Events</h1>
        </div>
    </section>

    <section class="py-16 bg-gray-50">
      <div class="container mx-auto px-6 max-w-6xl">
    
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    
          <?php if($events->num_rows > 0): ?>
            <?php while($row = $events->fetch_assoc()): ?>
    
            <div class="bg-white rounded-2xl border border-gray-200 
                        shadow-md hover:shadow-2xl 
                        hover:-translate-y-2 transform transition duration-300 
                        overflow-hidden flex flex-col">
    
                <!-- Image -->
                <a href="event_details.php?id=<?= $row['id']; ?>">
                  <img src="uploads/<?= htmlspecialchars($row['image']); ?>"
                       class="w-full h-52 object-cover hover:scale-105 transition duration-300">
                </a>
    
              <!-- Content -->
              <div class="p-6 flex flex-col flex-grow">
    
                <!-- Date Badge -->
                <div class="inline-block bg-green-100 text-green-700 
                            px-3 py-1 rounded-full text-sm mb-3 w-fit">
                  <?= date("d M Y", strtotime($row['start_date'])); ?>
                </div>
    
                <h3 class="text-lg font-semibold mb-2">
                  <?= htmlspecialchars($row['title']); ?>
                </h3>
    
                <p class="text-gray-600 text-sm mb-4">
                  <?= substr(strip_tags($row['description']), 0, 100); ?>...
                </p>
    
                <div class="text-sm text-gray-500 mb-4">
                  <i class="fas fa-map-marker-alt text-green-600 mr-2"></i>
                  <?= htmlspecialchars($row['location']); ?>
                </div>
    
                <a href="event_details.php?id=<?= $row['id']; ?>" 
                   class="mt-auto text-green-600 font-semibold hover:underline">
                   View Details →
                </a>
    
              </div>
            </div>
    
            <?php endwhile; ?>
          <?php else: ?>
            <p class="col-span-3 text-center text-gray-500">
              No events available.
            </p>
          <?php endif; ?>
    
        </div>
    
      </div>
    </section>

    <div id="footer"></div>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
    <script src="./assets/js/component.js"></script>
</body>

</html>