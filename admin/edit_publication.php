<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include '../db.php';

// Validate ID
$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM publications WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$publication = $stmt->get_result()->fetch_assoc();

if (!$publication) {
    header("Location: manage_publications.php");
    exit;
}

// Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    $stmt = $conn->prepare("UPDATE publications SET title=?, content=? WHERE id=?");
    $stmt->bind_param("ssi", $title, $content, $id);
    $stmt->execute();

    header("Location: manage_publications.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Publication</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body class="bg-light">

<?php include('sidebar.php'); ?>

<div class="content p-4" style="margin-left:250px; max-width:900px;">

    <h2 class="fw-bold mb-4">
        <i class="fas fa-pen-to-square me-2"></i> Edit Publication
    </h2>

    <form method="POST" class="card p-4 shadow-sm">

        <div class="mb-3">
            <label class="form-label fw-semibold">Title</label>
            <input type="text"
                   name="title"
                   class="form-control"
                   value="<?= htmlspecialchars($publication['title']); ?>"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Content</label>
            <div id="editor" style="height:300px;">
                <?= $publication['content']; ?>
            </div>
            <input type="hidden" name="content" id="hiddenContent">
        </div>

        <button type="submit" class="btn btn-primary px-4">
            <i class="fas fa-save me-1"></i> Update Publication
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
