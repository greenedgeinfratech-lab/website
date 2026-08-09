<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include '../db.php';

// Validate ID
$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM resources WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resource = $stmt->get_result()->fetch_assoc();

if (!$resource) {
    header("Location: manage_resources.php");
    exit;
}

// Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $imageName = $resource['image']; // keep old image by default

    // If new image uploaded
    if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){

        $fileName = $_FILES['image']['name'];
        $fileTmp  = $_FILES['image']['tmp_name'];
        $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowed = ['jpg','jpeg','png','webp'];

        if(in_array($fileExt, $allowed)){

            $newImageName = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "", $fileName);
            $uploadDir = "../uploads/resources/";

            if(!is_dir($uploadDir)){
                mkdir($uploadDir, 0755, true);
            }

            $uploadPath = $uploadDir . $newImageName;

            if(move_uploaded_file($fileTmp, $uploadPath)){

                // Delete old image
                if(!empty($resource['image']) && file_exists($uploadDir . $resource['image'])){
                    unlink($uploadDir . $resource['image']);
                }

                $imageName = $newImageName;
            }
        }
    }

    $stmt = $conn->prepare("UPDATE resources SET title=?, content=?, image=? WHERE id=?");
    $stmt->bind_param("sssi", $title, $content, $imageName, $id);
    $stmt->execute();

    header("Location: manage_resources.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Resource</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>

<body class="bg-light">

<?php include('sidebar.php'); ?>

<div class="content p-4" style="margin-left:250px;">

    <h2 class="mb-4">Edit Resource</h2>

    <form method="POST" enctype="multipart/form-data"
      class="card p-4 shadow-sm" style="max-width:800px;">

        <div class="mb-3">
            <label class="form-label fw-semibold">Title</label>
            <input type="text" 
                   name="title" 
                   class="form-control"
                   value="<?= htmlspecialchars($resource['title']); ?>"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Content</label>
            <div id="editor" style="height:300px;">
                <?= $resource['content']; ?>
            </div>
            <input type="hidden" name="content" id="hiddenContent">
        </div>
        
        <div class="mb-3">
            <label class="form-label fw-semibold">Current Featured Image</label><br>
        
            <?php if(!empty($resource['image'])): ?>
                <img src="../uploads/resources/<?= $resource['image']; ?>" 
                     width="150" 
                     style="border-radius:8px; object-fit:cover;">
            <?php else: ?>
                <p class="text-muted">No Image Uploaded</p>
            <?php endif; ?>
        </div>
        
        <div class="mb-3">
            <label class="form-label fw-semibold">Change Featured Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary px-4">
            Update Resource
        </button>

    </form>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
var quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, 3, false] }],
            ['bold', 'italic', 'underline'],
            [{ 'align': [] }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['link', 'image'],
            ['clean']
        ]
    }
});

document.querySelector('form').onsubmit = function() {
    document.querySelector('#hiddenContent').value = quill.root.innerHTML;
};
</script>

</body>
</html>
