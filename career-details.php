<?php
require_once 'db.php';

if(isset($_POST['apply_job'])){

    $job_id = intval($_POST['job_id']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);

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
        $uploadPath = "uploads/resumes/" . $newFileName;
    
        if(!move_uploaded_file($fileTmp, $uploadPath)){
            die("<script>alert('Resume upload failed!'); window.history.back();</script>");
        }
    
    } else {
        die("<script>alert('Resume is required!'); window.history.back();</script>");
    }

    $conn->query("INSERT INTO job_applications (job_id, name, email, phone, resume_path, created_at)
                  VALUES ($job_id, '$name', '$email', '$phone', '$uploadPath', NOW())");

    echo "<script>alert('Application Submitted Successfully!');</script>";
}

if(!isset($_GET['id'])){
    echo "Invalid Job!";
    exit;
}

$id = intval($_GET['id']);

$result = $conn->query("SELECT * FROM career_opportunities WHERE id = $id");

if($result->num_rows == 0){
    echo "Job not found!";
    exit;
}

$job = $result->fetch_assoc();
// Fetch Benefits
$benefits = $conn->query("
    SELECT benefit_text 
    FROM career_benefits 
    WHERE opportunity_id = $id
");

// Fetch Who Can Apply
$criteria = $conn->query("
    SELECT criteria 
    FROM who_can_apply 
    WHERE opportunity_id = $id
");

$poster = $conn->query("SELECT * FROM career_posters 
                        WHERE opportunity_id = $id 
                        ORDER BY id DESC 
                        LIMIT 1");

$imagePath = "assets/image/career.png"; // default image
$altText = "Career Image";

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
    <title><?php echo htmlspecialchars($job['title']); ?> | GreenEdge Infratech</title>
    <meta name="description" content="Career opportunity for <?php echo htmlspecialchars($job['title']); ?> at GreenEdge Infratech. <?php echo htmlspecialchars(mb_substr(trim(preg_replace('/\s+/', ' ', strip_tags($job['description'] ?? ''))), 0, 110)); ?>">
    <link rel="canonical" href="https://greenedgeinfratech.com/career-details<?= ($id > 0) ? '?id=' . $id : ''; ?>" />
    <link rel="icon" href="assets/image/favicon.ico" type="image/x-icon">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article" />
    <meta property="og:url" content="https://greenedgeinfratech.com/career-details<?= ($id > 0) ? '?id=' . $id : ''; ?>" />
    <meta property="og:title" content="<?php echo htmlspecialchars($job['title']); ?> | GreenEdge Infratech" />
    <meta property="og:description" content="Career opportunity for <?php echo htmlspecialchars($job['title']); ?> at GreenEdge Infratech." />
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
            <?php echo htmlspecialchars($job['title']); ?>
        </h1>
        <p class="text-lg max-w-2xl mx-auto">
            Join GreenEdge Infratech and be part of a team shaping sustainable infrastructure solutions.
        </p>
    </div>
</section>

<!-- Job Details Section -->
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
        <?php echo htmlspecialchars($job['title']); ?>
    </h2>

    <div class="mb-6 text-gray-600 space-y-2 border-b pb-6">
        <p><strong>Type:</strong> 
            <span class="text-green-600 capitalize">
                <?php echo htmlspecialchars($job['type']); ?>
            </span>
        </p>
        <p><strong>Location:</strong> 
            <?php echo htmlspecialchars($job['location']); ?>
        </p>
        <p><strong>Posted On:</strong> 
            <?php echo date("d M Y", strtotime($job['created_at'])); ?>
        </p>
    </div>

<!-- Description -->
<div class="mb-10">
    <h2 class="text-2xl font-bold text-green-700 mb-4">
        Job Description
    </h2>

    <div class="text-gray-700 leading-relaxed">
        <?php echo nl2br(htmlspecialchars($job['description'])); ?>
    </div>
</div>

<!-- Benefits -->
<?php if($benefits->num_rows > 0): ?>
<div class="mb-10">
    <h2 class="text-2xl font-bold text-green-700 mb-4">
        Benefits
    </h2>

    <ul class="space-y-3">
        <?php while($benefit = $benefits->fetch_assoc()): ?>
            <li class="flex items-start gap-3 text-gray-700">
                <i class="fa-solid fa-circle-check text-green-600 mt-1"></i>
                <span>
                    <?php echo htmlspecialchars($benefit['benefit_text']); ?>
                </span>
            </li>
        <?php endwhile; ?>
    </ul>
</div>
<?php endif; ?>

<!-- Who Can Apply -->
<?php if($criteria->num_rows > 0): ?>
<div class="mb-10">
    <h2 class="text-2xl font-bold text-green-700 mb-4">
        Who Can Apply
    </h2>

    <ul class="space-y-3">
        <?php while($c = $criteria->fetch_assoc()): ?>
            <li class="flex items-start gap-3 text-gray-700">
                <i class="fa-solid fa-user-check text-green-600 mt-1"></i>
                <span>
                    <?php echo htmlspecialchars($c['criteria']); ?>
                </span>
            </li>
        <?php endwhile; ?>
    </ul>
</div>
<?php endif; ?>

<a href="https://forms.gle/wcxJzYkXwwbcS7216" 
   target="_blank"
   class="inline-block bg-green-700 text-white px-6 py-3 rounded-lg hover:bg-green-800 transition duration-300">
   Apply Now
</a>

</div>
</section>

<!-- Application Modal -->

<!-- Footer -->
<div id="footer"></div>

<!-- Component JS -->
<script src="./assets/js/component.js"></script>



</body>
</html>