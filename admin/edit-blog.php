<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include '../db.php';

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM blogs WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$blog = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // If new image uploaded
    if (!empty($_FILES['image']['name'])) {
        $image = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $image);
    } else {
        $image = $blog['image'];
    }

    $stmt = $conn->prepare("UPDATE blogs SET title=?, content=?, image=? WHERE id=?");
    $stmt->bind_param("sssi", $title, $content, $image, $id);
    $stmt->execute();
    header("Location: manage_blogs.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Blog</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <style>
    body {
      min-height: 100vh;
      display: flex;
      background-color: #f8f9fa;
    }
    .sidebar {
      width: 20%;
      background-color: #343a40;
      color: white;
      min-height: 100vh;
      padding-top: 20px;
    }
    .sidebar a {
      color: white;
      display: block;
      padding: 12px 20px;
      text-decoration: none;
      transition: background 0.3s;
    }
    .sidebar a:hover {
      background-color: #495057;
    }
    .main-content {
      width: 80%;
      padding: 40px;
    }
    .form-container {
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      max-width: 700px;
    }
    img.preview {
      border-radius: 5px;
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <?php include('sidebar.php') ?>

  <!-- Main Content -->
  <div class="main-content">
    <h2 class="fw-bold mb-4">Edit Blog</h2>
    <form method="POST" enctype="multipart/form-data" class="form-container">
      <div class="mb-3">
        <label class="form-label fw-semibold">Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($blog['title']) ?>" required class="form-control">
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Content</label>
        <div id="editor" style="height:300px;">
            <?= $blog['content'] ?>
        </div>
        
        <input type="hidden" name="content" id="hiddenContent"> 

      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Image</label>
        <input type="file" name="image" class="form-control">
        <?php if($blog['image']): ?>
          <p class="mt-2">Current Image:</p>
          <img src="../uploads/<?= $blog['image'] ?>" width="150" class="preview">
        <?php endif; ?>
      </div>

      <button type="submit" class="btn btn-primary px-4">
        <i class="fa-solid fa-upload"></i> Update
      </button>
    </form>
  </div>
    
    
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
var quill = new Quill('#editor', {
  theme: 'snow',
  modules: {
    toolbar: [
      [{ 'header': [1, 2, 3, false] }],
      ['bold', 'italic', 'underline'],
      [{ 'align': [] }],     // 👈 ALIGNMENT OPTION
      [{ 'list': 'ordered'}, { 'list': 'bullet' }],
      ['link', 'image'],
      ['clean']
    ]
  }
});

// On form submit
document.querySelector('form').onsubmit = function() {
    document.querySelector('#hiddenContent').value = quill.root.innerHTML;
};
</script>

</body>
</html>
