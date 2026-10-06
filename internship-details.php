<?php
require_once 'db.php';

if(isset($_POST['apply_internship'])){

    $internship_id = intval($_POST['internship_id']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $college = $conn->real_escape_string($_POST['college']);
    $course = $conn->real_escape_string($_POST['course']);
    $duration = $conn->real_escape_string($_POST['duration']);

    // File Upload
    if(isset($_FILES['resume']) && $_FILES['resume']['error'] === 0){

        $fileName = $_FILES['resume']['name'];
        $fileTmp = $_FILES['resume']['tmp_name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
        // Only PDF allowed
        if($fileExt !== 'pdf'){
            die("<script>alert('Only PDF files are allowed!'); window.history.back();</script>");
        }
    
        // Optional: File size limit (2MB example)
        if($_FILES['resume']['size'] > 2 * 1024 * 1024){
            die("<script>alert('File size must be less than 2MB!'); window.history.back();</script>");
        }
    
        $newFileName = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "", $fileName);
        $uploadPath = "uploads/internship_resumes/" . $newFileName;
    
        if(!move_uploaded_file($fileTmp, $uploadPath)){
            die("<script>alert('Resume upload failed!'); window.history.back();</script>");
        }
    
    } else {
        die("<script>alert('Resume is required!'); window.history.back();</script>");
    }

    $conn->query("INSERT INTO internship_applications (internship_id, name, email, phone, college, course, duration, resume_path, created_at)
                  VALUES ($internship_id, '$name', '$email', '$phone', '$college', '$course', '$duration', '$uploadPath', NOW())");

    echo "<script>alert('Internship Application Submitted Successfully!');</script>";
}

if(!isset($_GET['id'])){
    echo "Invalid Internship!";
    exit;
}

$id = intval($_GET['id']);

$result = $conn->query("SELECT * FROM internship_opportunities WHERE id = $id");

if($result->num_rows == 0){
    echo "Internship not found!";
    exit;
}

$internship = $result->fetch_assoc();

$poster = $conn->query("SELECT * FROM internship_posters 
                        WHERE opportunity_id = $id 
                        ORDER BY id DESC 
                        LIMIT 1");

$imagePath = "assets/image/internship.png"; // default image
$altText = "Internship Image";

if($poster->num_rows > 0){
    $img = $poster->fetch_assoc();
    $imagePath = "uploads/" . $img['image_path'];
    $altText = $img['alt_text'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($internship['title']); ?> | Internship at GEC - GreenEdge Infratech</title>
    <meta name="description" content="Internship opportunity for <?php echo htmlspecialchars($internship['title']); ?> at GreenEdge Infratech. <?php echo htmlspecialchars(mb_substr(trim(preg_replace('/\s+/', ' ', strip_tags($internship['description'] ?? ''))), 0, 110)); ?>">
    <link rel="canonical" href="https://greenedgeinfratech.com/internship-details<?= ($id > 0) ? '?id=' . $id : ''; ?>" />
    <link rel="icon" href="assets/image/favicon.ico" type="image/x-icon">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article" />
    <meta property="og:url" content="https://greenedgeinfratech.com/internship-details<?= ($id > 0) ? '?id=' . $id : ''; ?>" />
    <meta property="og:title" content="<?php echo htmlspecialchars($internship['title']); ?> | GreenEdge Infratech" />
    <meta property="og:description" content="Internship opportunity for <?php echo htmlspecialchars($internship['title']); ?> at GreenEdge Infratech." />
    <meta property="og:image" content="https://greenedgeinfratech.com/assets/logo.png" />
    <meta property="og:site_name" content="GreenEdge Infratech" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 font-sans text-gray-800">

<!-- Header -->
<div id="header"></div>

<!-- Hero -->
<section class="relative bg-[url('assets/image/about-bg.png')] bg-cover bg-center text-white py-20">
    <div class="absolute inset-0 bg-gradient-to-r from-green-900/90 via-green-700/70 to-transparent"></div>
    <div class="container mx-auto text-center px-6 relative z-10">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">
            <?php echo htmlspecialchars($internship['title']); ?>
        </h1>
        <p class="text-lg max-w-2xl mx-auto">
            Join GreenEdge Infratech as an intern and kickstart your career in sustainable infrastructure.
        </p>
    </div>
</section>

<!-- Internship Details Section -->
<section class="py-3">
<div class="container mx-auto px-6 max-w-6xl bg-white p-10 rounded-2xl shadow-lg">
 <div class="relative w-full h-[500px] overflow-hidden rounded-xl mb-6">

    <!-- Background (blur, fills full box) -->
    <img src="<?php echo htmlspecialchars($imagePath); ?>" 
         class="absolute w-full h-full object-cover blur-md scale-110">

    <!-- Main image (full visible, no crop) -->
    <img src="<?php echo htmlspecialchars($imagePath); ?>" 
         class="relative w-full h-full object-contain">

</div>
    <h2 class="text-4xl font-bold text-green-700 mb-6">
        <?php echo htmlspecialchars($internship['title']); ?>
    </h2>

    <div class="mb-6 text-gray-600 space-y-2 border-b pb-6">
        <p><strong>Type:</strong> 
            <span class="text-green-600 capitalize">
                <?php echo htmlspecialchars($internship['type']); ?>
            </span>
        </p>
        <p><strong>Location:</strong> 
            <?php echo htmlspecialchars($internship['location']); ?>
        </p>
        <p><strong>Posted On:</strong> 
            <?php echo date("d M Y", strtotime($internship['created_at'])); ?>
        </p>
    </div>

    <div class="text-gray-700 leading-relaxed mb-8">
        <?php echo nl2br($internship['description']); ?>
    </div>

    <button onclick="openModal()" 
       class="inline-block bg-green-700 text-white px-6 py-3 rounded-lg hover:bg-green-800 transition duration-300">
       Apply for Internship
    </button>

</div>
</section>

<!-- Application Modal -->
<div id="applyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-lg p-8 rounded-2xl shadow-2xl relative">

        <button onclick="closeModal()" 
            class="absolute top-3 right-3 text-gray-500 hover:text-red-500">
            ✕
        </button>

        <h2 class="text-2xl font-bold mb-6 text-green-700">
            Apply for Internship: <?php echo htmlspecialchars($internship['title']); ?>
        </h2>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">

            <input type="hidden" name="internship_id" value="<?php echo $internship['id']; ?>">

            <input type="text" name="name" placeholder="Full Name" required
                class="w-full border rounded-lg px-4 py-2">

            <input type="email" name="email" placeholder="Email Address" required
                class="w-full border rounded-lg px-4 py-2">

            <input type="text" name="phone" placeholder="Phone Number" required
                class="w-full border rounded-lg px-4 py-2">

            <input type="text" name="college" placeholder="College/University Name" required
                class="w-full border rounded-lg px-4 py-2">

            <input type="text" name="course" placeholder="Course Name (e.g., B.Tech, MBA)" required
                class="w-full border rounded-lg px-4 py-2">

            <select name="duration" required class="w-full border rounded-lg px-4 py-2">
                <option value="">Select Internship Duration</option>
                <option value="1 Month">1 Month</option>
                <option value="2 Months">2 Months</option>
                <option value="3 Months">3 Months</option>
                <option value="6 Months">6 Months</option>
            </select>

            <input type="file" name="resume" accept=".pdf" required
                class="w-full border rounded-lg px-4 py-2">
            
            <p class="text-xs text-gray-500">Upload your resume (PDF only, max 2MB)</p>

            <button type="submit" name="apply_internship"
                class="w-full bg-green-700 text-white py-2 rounded-lg hover:bg-green-800">
                Submit Application
            </button>

        </form>
    </div>
</div>
<!-- Footer -->
<div id="footer"></div>

<!-- Component JS -->
<script src="./assets/js/component.js"></script>

<script>
function openModal(){
    document.getElementById('applyModal').classList.remove('hidden');
    document.getElementById('applyModal').classList.add('flex');
}

function closeModal(){
    document.getElementById('applyModal').classList.add('hidden');
}
</script>

</body>
</html>