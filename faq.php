<?php
include 'db.php';
$result = $conn->query("SELECT * FROM faqs ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FAQ | GreenEdge Infratech</title>
<meta name="description" content="Find answers to frequently asked questions about solar rooftop systems, PM Surya Ghar Yojana subsidies, solar installation, and maintenance with GreenEdge Infratech.">
<link rel="canonical" href="https://greenedgeinfratech.com/faq" />
<link rel="icon" href="assets/image/favicon.ico">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website" />
<meta property="og:url" content="https://greenedgeinfratech.com/faq" />
<meta property="og:title" content="FAQ | GreenEdge Infratech" />
<meta property="og:description" content="Find answers to frequently asked questions about solar rooftop systems, subsidies, and maintenance with GreenEdge Infratech." />
<meta property="og:image" content="https://greenedgeinfratech.com/assets/logo.png" />
<meta property="og:site_name" content="GreenEdge Infratech" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans text-gray-800 bg-gray-50">

<div id="header"></div>

<!-- Hero Section -->
<section class="relative bg-[url('assets/image/about-bg.png')] bg-cover bg-center text-white py-20">
    <div class="absolute inset-0 bg-gradient-to-r from-green-900/90 via-green-700/70 to-transparent"></div>
    <div class="container mx-auto text-center px-6 relative z-10">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">FAQ</h1>
    </div>
</section>

<section class="my-16">
<div class="container mx-auto px-6 max-w-4xl">
<h2 class="text-3xl font-bold mb-8 text-center">
Frequently Asked Questions
</h2>

<?php if ($result->num_rows > 0): ?>
    <?php $index = 0; ?>
    <?php while($row = $result->fetch_assoc()): ?>
        
        <div class="border border-gray-200 rounded-lg mb-4 bg-white shadow-sm">
            
            <button onclick="toggleFAQ(<?= $index ?>)"
                class="w-full text-left px-6 py-4 flex justify-between items-center font-semibold text-lg focus:outline-none">
                
                <?= htmlspecialchars($row['question']); ?>

                <i id="icon-<?= $index ?>" 
                   class="fas fa-chevron-down transition-transform duration-300"></i>
            </button>

            <div id="answer-<?= $index ?>" 
                 class="hidden px-6 pb-4 text-gray-600">
                <?= nl2br($row['answer']); ?>
            </div>

        </div>

        <?php $index++; ?>
    <?php endwhile; ?>
<?php else: ?>
    <p class="text-center text-gray-500">No FAQs available.</p>
<?php endif; ?>

</div>
</section>

<div id="footer"></div>

<script>
function toggleFAQ(index) {
    const answer = document.getElementById("answer-" + index);
    const icon = document.getElementById("icon-" + index);

    answer.classList.toggle("hidden");
    icon.classList.toggle("rotate-180");
}
</script>

<script src="./assets/js/component.js"></script>

</body>
</html>
