<?php
require_once 'db.php';

// Fetch all opportunities
$opportunities = $conn->query("SELECT * FROM career_opportunities ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career at GEI | GreenEdge Infratech</title>
    <link rel="icon" href="assets/image/favicon.ico" type="image/x-icon">
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
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Exciting Internship & Volunteer Opportunities at Greenedge Infratech!</h1>
        </div>
    </section>
    
    <!-- Internship & Volunteer Opportunities Section -->
    <section class="py-16 bg-gray-50">
      <div class="container mx-auto px-6 max-w-6xl">
    
        <?php if($opportunities->num_rows > 0): ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        <?php while($op = $opportunities->fetch_assoc()): ?>
        
        <div class="bg-white rounded-2xl border border-gray-200 
                    shadow-lg hover:shadow-2xl 
                    hover:-translate-y-1 transform transition duration-300 
                    overflow-hidden flex flex-col">
        
            <!-- IMAGE -->
<!-- IMAGE -->
<?php
  $poster = $conn->query("SELECT * FROM career_posters 
    WHERE opportunity_id = ".$op['id']." 
    ORDER BY id DESC 
    LIMIT 1");

  if($poster->num_rows > 0):
    $img = $poster->fetch_assoc();
?>

<div class="relative w-full h-64 overflow-hidden rounded-t-2xl">

    <!-- Blur Background -->
    <img src="uploads/<?php echo htmlspecialchars($img['image_path']); ?>"
         class="absolute w-full h-full object-cover blur-md scale-110">

    <!-- Main Image -->
    <img src="uploads/<?php echo htmlspecialchars($img['image_path']); ?>"
         class="relative w-full h-full object-contain">

</div>

<?php else: ?>

<div class="relative w-full h-64 overflow-hidden rounded-t-2xl">

    <img src="assets/image/career.png"
         class="absolute w-full h-full object-cover blur-md scale-110">

    <img src="assets/image/career.png"
         class="relative w-full h-full object-contain">

</div>

<?php endif; ?>
        
            <!-- CONTENT -->
            <div class="p-6 flex flex-col flex-grow">
                <h2 class="text-lg font-semibold mb-3 text-green-700">
                    <?php echo htmlspecialchars($op['title']); ?>
                </h2>
        
                <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                    <?php echo substr(strip_tags($op['description']), 0, 120); ?>...
                </p>
        
                <div class="text-sm space-y-1 mb-4">
                    <p><strong>Type:</strong> 
                        <span class="text-green-600 capitalize">
                            <?php echo $op['type']; ?>
                        </span>
                    </p>
                    <p><strong>Location:</strong> 
                        <?php echo htmlspecialchars($op['location']); ?>
                    </p>
                </div>
        
                <a href="career-details.php?id=<?php echo $op['id']; ?>" 
                   class="mt-auto bg-green-700 text-white text-center py-2.5 rounded-lg 
                          hover:bg-green-800 transition duration-300">
                   View Details
                </a>
            </div>
        
        </div>
        
        <?php endwhile; ?>
        
        </div>
        <?php else: ?>
        <p class="text-center text-gray-500">No opportunities available right now.</p>
        <?php endif; ?>
        
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