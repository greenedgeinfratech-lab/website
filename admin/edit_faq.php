<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include '../db.php';

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM faqs WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$faq = $stmt->get_result()->fetch_assoc();

if (!$faq) {
    header("Location: manage_faq.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $question = trim($_POST['question']);
    $answer = trim($_POST['answer']);

    $stmt = $conn->prepare("UPDATE faqs SET question=?, answer=? WHERE id=?");
    $stmt->bind_param("ssi", $question, $answer, $id);
    $stmt->execute();

    header("Location: manage_faq.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit FAQ</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<?php include('sidebar.php'); ?>

<div class="content p-4" style="margin-left:250px; max-width:800px;">
<h2>Edit FAQ</h2>

<form method="POST" class="card p-4 shadow-sm">

    <div class="mb-3">
        <label class="form-label">Question</label>
        <input type="text" name="question" 
               value="<?= htmlspecialchars($faq['question']); ?>" 
               class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Answer</label>
        <textarea name="answer" class="form-control" rows="5" required><?= htmlspecialchars($faq['answer']); ?></textarea>
    </div>

    <button class="btn btn-primary">Update FAQ</button>

</form>
</div>

</body>
</html>
