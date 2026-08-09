<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include '../db.php';

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM news WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$news = $stmt->get_result()->fetch_assoc();

if (!$news) {
    header("Location: manage_news.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $content = $_POST['content'];

    if (!empty($_FILES['image']['name'])) {
        $image = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $image);
    } else {
        $image = $news['image'];
    }

    $stmt = $conn->prepare("UPDATE news SET title=?, content=?, image=? WHERE id=?");
    $stmt->bind_param("sssi", $title, $content, $image, $id);
    $stmt->execute();

    header("Location: manage_news.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit News</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Quill -->
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

  <style>
    body {
      min-height: 100vh;
      display: flex;
      background-color: #f8f9fa;
    }

    .main-content {
      width: 100%;
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

    .ql-editor img {
      max-width: 300px;
      height: auto;
      float: right;
      margin-left: 20px;
      margin-bottom: 10px;
    }
  </style>
</head>

<body>

  <!-- Sidebar -->
  <?php include('sidebar.php'); ?>

  <!-- Main Content -->
  <div class="main-content">
    <h2 class="fw-bold mb-4">Edit News</h2>

    <form method="POST" enctype="multipart/form-data" class="form-container">

      <div class="mb-3">
        <label class="form-label fw-semibold">Title</label>
        <input type="text" name="title"
               value="<?= htmlspecialchars($news['title']) ?>"
               required
               class="form-control">
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Content</label>
        <div id="editor" style="height:300px;">
            <?= $news['content'] ?>
        </div>

        <input type="hidden" name="content" id="hiddenContent">
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Image</label>
        <input type="file" name="image" class="form-control">

        <?php if($news['image']): ?>
          <p class="mt-2">Current Image:</p>
          <img src="../uploads/<?= $news['image'] ?>" width="150" class="preview">
        <?php endif; ?>
      </div>

      <button type="submit" class="btn btn-primary px-4">
        <i class="fa-solid fa-upload"></i> Update News
      </button>

    </form>
  </div>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Quill JS -->
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
