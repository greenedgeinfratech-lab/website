<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $content = $_POST['content'];
    
    $imageName = '';

    if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){
    
        $fileName = $_FILES['image']['name'];
        $fileTmp  = $_FILES['image']['tmp_name'];
        $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
        $allowed = ['jpg','jpeg','png','webp'];
    
        if(in_array($fileExt, $allowed)){
    
            $imageName = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "", $fileName);
            $uploadPath = "../uploads/resources/" . $imageName;
    
            if(!is_dir("../uploads/resources")){
                mkdir("../uploads/resources", 0755, true);
            }
    
            move_uploaded_file($fileTmp, $uploadPath);
        }
    }

    $stmt = $conn->prepare("INSERT INTO resources (title, content, image, created_at)
        VALUES ('$title', '$content', '$imageName', NOW())");
    $stmt->bind_param("ss", $title, $content);
    $stmt->execute();

    header("Location: manage_resources.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Resource</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include('sidebar.php'); ?>

<div class="content p-4" style="margin-left:250px;">
    <h2>Add Resource</h2>

    <form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Content</label>
            <div id="editor" style="height:300px;"></div>
            <input type="hidden" name="content" id="hiddenContent">
        </div>
        
        <div class="mb-3">
            <label>Featured Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <button class="btn btn-success">Save</button>
    </form>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
var quill = new Quill('#editor', { theme: 'snow' });

document.querySelector('form').onsubmit = function() {
    document.querySelector('#hiddenContent').value = quill.root.innerHTML;
};
</script>

</body>
</html>
