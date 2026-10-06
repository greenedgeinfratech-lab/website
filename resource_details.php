<?php
include 'db.php';

if(!isset($_GET['id'])){
    echo "Invalid Resource!";
    exit;
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM resources WHERE id=$id");

if($result->num_rows == 0){
    echo "Resource not found!";
    exit;
}

$resource = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($resource['title']); ?> | GreenEdge Infratech</title>
<meta name="description" content="<?= htmlspecialchars(mb_substr(trim(preg_replace('/\s+/', ' ', strip_tags($resource['content'] ?? ''))), 0, 155)); ?>">
<link rel="canonical" href="https://greenedgeinfratech.com/resource_details<?= ($id > 0) ? '?id=' . $id : ''; ?>" />
<link rel="icon" href="assets/image/favicon.ico">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="article" />
<meta property="og:url" content="https://greenedgeinfratech.com/resource_details<?= ($id > 0) ? '?id=' . $id : ''; ?>" />
<meta property="og:title" content="<?= htmlspecialchars($resource['title']); ?> | GreenEdge Infratech" />
<meta property="og:description" content="<?= htmlspecialchars(mb_substr(trim(preg_replace('/\s+/', ' ', strip_tags($resource['content'] ?? ''))), 0, 155)); ?>" />
<meta property="og:image" content="https://greenedgeinfratech.com/assets/logo.png" />
<meta property="og:site_name" content="GreenEdge Infratech" />

<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div id="header"></div>

<section class="py-20 bg-white">
<div class="container mx-auto px-6 max-w-4xl">

    <h1 class="text-4xl font-bold mb-6">
        <?= htmlspecialchars($resource['title']); ?>
    </h1>

    <div class="text-gray-700 leading-relaxed">
        <?= $resource['content']; ?>
    </div>

</div>
</section>

<div id="footer"></div>
<script src="./assets/js/component.js"></script>
</body>
</html>