<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $question = trim($_POST['question']);
    $answer = trim($_POST['answer']);

    if (!empty($question) && !empty($answer)) {
        $stmt = $conn->prepare("INSERT INTO faqs (question, answer) VALUES (?, ?)");
        $stmt->bind_param("ss", $question, $answer);
        $stmt->execute();

        header("Location: manage_faq.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add FAQ</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<?php include('sidebar.php'); ?>

<div class="content p-4" style="margin-left:250px; max-width:800px;">
<h2>Add FAQ</h2>

<form method="POST" class="card p-4 shadow-sm">

    <div class="mb-3">
        <label class="form-label">Question</label>
        <input type="text" name="question" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Answer</label>
        <textarea name="answer" class="form-control" rows="5" required></textarea>
    </div>

    <button class="btn btn-success">Save FAQ</button>

</form>
</div>

</body>
</html>
