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
    $conn->query("DELETE FROM publications WHERE id=$id");
    header("Location: manage_publications.php");
    exit;
}

$result = $conn->query("SELECT * FROM publications ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Publications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body class="bg-light">

<?php include('sidebar.php'); ?>

<div class="content p-4" style="margin-left:250px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-file-lines me-2"></i>Manage Publications</h2>
        <a href="add_publication.php" class="btn btn-success">
            <i class="fas fa-plus"></i> Add Publication
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th class="text-start">Title</th>
                        <th class="text-start">Content</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                <?php if($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>

                            <td class="text-start">
                                <?= htmlspecialchars($row['title']); ?>
                            </td>

                            <td class="text-start">
                                <?= substr(strip_tags($row['content']), 0, 80); ?>...
                            </td>

                            <td><?= date("d M Y", strtotime($row['created_at'])); ?></td>

                            <td>
                                <a href="edit_publication.php?id=<?= $row['id']; ?>" 
                                   class="btn btn-sm btn-primary">
                                   <i class="fas fa-edit"></i>
                                </a>

                                <a href="?delete=<?= $row['id']; ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Delete this publication?');">
                                   <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No publications found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

</body>
</html>
