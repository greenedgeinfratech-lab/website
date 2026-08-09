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

    if (!empty($title) && !empty($content)) {

        $stmt = $conn->prepare("INSERT INTO publications (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $content);
        $stmt->execute();

        header("Location: manage_publications.php");
        exit;
    } else {
        $error = "Title and Content are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Publication</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body class="bg-light">

<?php include('sidebar.php'); ?>

<div class="content p-4" style="margin-left:250px; max-width:900px;">

    <h2 class="fw-bold mb-4">
        <i class="fas fa-file-lines me-2"></i> Add Publication
    </h2>

    <?php if(isset($error)): ?>
        <div class="alert alert-danger">
            <?= $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="card p-4 shadow-sm">

        <div class="mb-3">
            <label class="form-label fw-semibold">Title</label>
            <input type="text" name="title" class="form-control"
                   placeholder="Enter publication title" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Content</label>
            <div id="editor" style="height:300px;"></div>
            <input type="hidden" name="content" id="hiddenContent">
        </div>

        <button type="submit" class="btn btn-success px-4">
            <i class="fas fa-save me-1"></i> Save Publication
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
