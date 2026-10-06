<?php
include 'db.php';
date_default_timezone_set('Asia/Kolkata');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();

if (!$event) {
    echo "Event not found.";
    exit;
}

$today = date("Y-m-d");

if ($today < $event['start_date']) {
    $eventStatus = "upcoming";
} elseif ($today >= $event['start_date'] && $today <= $event['end_date']) {
    $eventStatus = "ongoing";
} else {
    $eventStatus = "expired";
}

// AJAX Registration
if (isset($_POST['ajax_register'])) {

    $name  = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);

    $stmt = $conn->prepare("INSERT INTO event_registrations (event_id, name, email, phone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $id, $name, $email, $phone);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($event['title']); ?> | GreenEdge Infratech</title>
    <meta name="description" content="<?= htmlspecialchars(mb_substr(trim(preg_replace('/\s+/', ' ', strip_tags($event['description'] ?? ''))), 0, 155)); ?>">
    <link rel="canonical" href="https://greenedgeinfratech.com/event_details<?= ($id > 0) ? '?id=' . $id : ''; ?>" />
    <link rel="icon" href="assets/image/favicon.ico" type="image/x-icon">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article" />
    <meta property="og:url" content="https://greenedgeinfratech.com/event_details<?= ($id > 0) ? '?id=' . $id : ''; ?>" />
    <meta property="og:title" content="<?= htmlspecialchars($event['title']); ?> | GreenEdge Infratech" />
    <meta property="og:description" content="<?= htmlspecialchars(mb_substr(trim(preg_replace('/\s+/', ' ', strip_tags($event['description'] ?? ''))), 0, 155)); ?>" />
    <meta property="og:image" content="<?= !empty($event['image']) ? 'https://greenedgeinfratech.com/uploads/' . htmlspecialchars($event['image']) : 'https://greenedgeinfratech.com/assets/logo.png'; ?>" />
    <meta property="og:site_name" content="GreenEdge Infratech" />

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome (optional if using icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans text-gray-800">

<!-- Header -->
<div id="header"></div>

<!-- Hero Section -->
<section class="relative bg-[url('assets/image/about-bg.png')] bg-cover bg-center text-white py-16">
    <div class="absolute inset-0 bg-gradient-to-r from-green-900/90 via-green-700/70 to-transparent"></div>
    <div class="container mx-auto px-6 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-bold">
            <?= htmlspecialchars($event['title']); ?>
        </h1>
    </div>
</section>

<!-- Event Details -->
<section class="py-5 bg-gradient-to-br from-green-50 via-white to-green-50">
   <div class="container mx-auto px-6 max-w-6xl 
            bg-white shadow-2xl rounded-2xl 
            p-10 border border-green-100 
            hover:shadow-green-200 transition duration-300">

        <div class="flex flex-wrap items-center text-gray-500 mb-6 gap-6 text-sm">
            <div class="mb-6">
                <?php if($eventStatus == "upcoming"): ?>

                    <span class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-sm font-semibold">
                        Upcoming Event
                    </span>
                
                <?php elseif($eventStatus == "ongoing"): ?>
                
                    <span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-sm font-semibold">
                        Ongoing Event
                    </span>
                
                <?php else: ?>
                
                    <span class="bg-gray-200 text-gray-600 px-4 py-1 rounded-full text-sm font-semibold">
                        Event Completed
                    </span>
                
                <?php endif; ?>
            </div>
            <div>
                <i class="fas fa-calendar-alt text-green-600 mr-2"></i>
                <?= date("d M Y", strtotime($event['start_date'])); ?>
            </div>

            <?php if(!empty($event['event_time'])): ?>
            <div>
                <i class="fas fa-clock text-green-600 mr-2"></i>
                <?= date("h:i A", strtotime($event['event_time'])); ?>
            </div>
            <?php endif; ?>

            <div>
                <i class="fas fa-map-marker-alt text-green-600 mr-2"></i>
                <?= htmlspecialchars($event['location']); ?>
            </div>
        </div>

        <?php if(!empty($event['image'])): ?>
        <img src="uploads/<?= htmlspecialchars($event['image']); ?>" 
             class="w-full h-96 object-cover rounded-xl mb-8 shadow-xl hover:scale-[1.02] transition duration-500">
        <?php endif; ?>

        <div class="text-gray-700 leading-relaxed text-lg space-y-4">
            <?= nl2br(htmlspecialchars($event['description'])); ?>
        </div>
        
        <div class="mt-12 bg-green-50 border border-green-100 rounded-xl p-6 text-center">
            <h3 class="text-xl font-semibold mb-2 text-green-700">
                Interested in This Event?
            </h3>
            <p class="text-gray-600 mb-4">
                Stay updated with our latest renewable energy events and workshops.
            </p>
            <?php if($eventStatus == "upcoming" || $eventStatus == "ongoing"): ?>

                <button onclick="openModal()" 
                    class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                    Register Now
                </button>
            
            <?php else: ?>
            
                <div class="bg-red-100 text-red-600 px-6 py-3 rounded-lg font-semibold">
                    ❌ Event Already Expired
                </div>
            
            <?php endif; ?>
        </div>

        <!-- Back Button -->
        <div class="mt-10">
            <a href="events.php" 
               class="inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                ← Back to Events
            </a>
        </div>

    </div>
</section>

<!-- Registration Modal -->
<div id="registrationModal" 
     class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-md rounded-2xl p-8 shadow-2xl relative">

        <button onclick="closeModal()" 
                class="absolute top-3 right-3 text-gray-500 hover:text-red-500">
            ✕
        </button>

        <h3 class="text-2xl font-semibold mb-6 text-center text-green-700">
            Event Registration
        </h3>

        <form id="registrationForm" class="space-y-4">

        <input type="hidden" name="ajax_register" value="1">
    
        <div>
            <label class="block text-sm font-medium mb-1">Full Name</label>
            <input type="text" name="name" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-400 outline-none">
        </div>
    
        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-400 outline-none">
        </div>
    
        <div>
            <label class="block text-sm font-medium mb-1">Phone</label>
            <input type="text" name="phone" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-400 outline-none">
        </div>
    
        <button type="submit"
            class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
            Submit Registration
        </button>
    
        <div id="formMessage" class="text-center mt-3 text-sm font-semibold"></div>
    
    </form>


    </div>
</div>

<!-- Footer -->
<div id="footer"></div>

<!-- Load Header & Footer -->
<script src="./assets/js/component.js"></script>

<script>
function openModal() {
    document.getElementById('registrationModal').classList.remove('hidden');
    document.getElementById('registrationModal').classList.add('flex');
}

function closeModal() {
    document.getElementById('registrationModal').classList.add('hidden');
}

document.getElementById('registrationForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {

        const messageBox = document.getElementById('formMessage');

        if (data.status === "success") {

            messageBox.innerHTML = "✅ Registration Successful!";
            messageBox.classList.remove("text-red-600");
            messageBox.classList.add("text-green-600");

            document.getElementById('registrationForm').reset();

            setTimeout(() => {
                closeModal();
            }, 2000);

        } else {
            messageBox.innerHTML = "❌ Something went wrong!";
            messageBox.classList.remove("text-green-600");
            messageBox.classList.add("text-red-600");
        }
    })
    .catch(error => {
        console.error(error);
    });
});
</script>


</body>
</html>