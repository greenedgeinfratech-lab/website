<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include '../db.php';

// Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM faqs WHERE id=$id");
    header("Location: manage_faq.php");
    exit;
}

$result = $conn->query("SELECT * FROM faqs ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage FAQs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body class="bg-light">

<?php include('sidebar.php'); ?>

<div class="content p-4" style="margin-left:250px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-question-circle me-2"></i>Manage FAQs</h2>
        <a href="add_faq.php" class="btn btn-success">
            <i class="fas fa-plus"></i> Add FAQ
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                <?php if($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= htmlspecialchars($row['question']); ?></td>
                            <td><?= substr(strip_tags($row['answer']), 0, 80); ?>...</td>
                            <td>
                                <a href="edit_faq.php?id=<?= $row['id']; ?>" 
                                   class="btn btn-sm btn-primary">
                                   <i class="fas fa-edit"></i>
                                </a>

                                <a href="?delete=<?= $row['id']; ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Delete this FAQ?');">
                                   <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            No FAQs available.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>

            </table>
        </div>
    </div>

</div>

</body>
</html>
