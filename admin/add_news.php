<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (empty($title) || empty($content)) {
        $error = "Title and content cannot be empty.";
    } else {

        $image = NULL;

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

            if (in_array($_FILES['image']['type'], $allowedTypes)) {
                $image = time() . "_" . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $image);
            } else {
                $error = "Only JPG, PNG, GIF, or WEBP images are allowed.";
            }
        }

        if (!isset($error)) {
            $stmt = $conn->prepare("INSERT INTO news (title, content, image) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $title, $content, $image);

            if ($stmt->execute()) {
                header("Location: manage_news.php");
                exit;
            } else {
                $error = "Database error: " . $stmt->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add News</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <style>
        .ql-editor img {
            max-width: 300px;
            height: auto;
            float: right;
            margin-left: 20px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body class="bg-light">

<div class="container-fluid">
    <div class="row min-vh-100">

        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 text-white">
            <?php include('sidebar.php'); ?>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-5">
            <h1 class="fw-bold mb-4">Add Latest News</h1>

            <?php if (isset($error)) : ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm p-4" style="max-width: 700px;">
                <form method="POST" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label class="form-label">News Title</label>
                        <input type="text" name="title"
                               class="form-control"
                               placeholder="Enter news title"
                               required
                               value="<?= isset($title) ? htmlspecialchars($title) : '' ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">News Content</label>
                        <div id="editor" style="height: 300px;"></div>
                        <input type="hidden" name="content" id="hiddenContent">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-success px-4">
                        <i class="fas fa-save me-1"></i> Save News
                    </button>

                </form>
            </div>
        </div>

    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
