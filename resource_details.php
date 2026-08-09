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
<title><?= htmlspecialchars($resource['title']); ?> | GreenEdge</title>
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