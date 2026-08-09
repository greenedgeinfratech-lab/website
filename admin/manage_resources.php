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
    $conn->query("DELETE FROM resources WHERE id=$id");
    header("Location: manage_resources.php");
    exit;
}

$result = $conn->query("SELECT * FROM resources ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Resources</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- ✅ Font Awesome (Fix for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body class="bg-light">

<?php include('sidebar.php'); ?>

<div class="content p-4" style="margin-left:250px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="fas fa-book-open me-2"></i> Manage Resources
        </h2>

        <a href="add_resource.php" class="btn btn-success">
            <i class="fas fa-plus me-1"></i> Add Resource
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped align-middle text-center">

                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th class="text-start">Title</th>
                            <th class="text-start">Content</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php if($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id']; ?></td>

                                <td>
                                <?php if(!empty($row['image']) && file_exists("../uploads/resources/" . $row['image'])): ?>
                                    <img src="../uploads/resources/<?= htmlspecialchars($row['image']); ?>"
                                         width="60"
                                         height="60"
                                         style="object-fit:cover; border-radius:6px;">
                                <?php else: ?>
                                    <span class="text-muted">No Image</span>
                                <?php endif; ?>
                                </td>

                                <td class="text-start">
                                    <?= htmlspecialchars($row['title']); ?>
                                </td>

                                <td class="text-start">
                                    <?php
                                        $maxLength = 80;
                                        $content = strip_tags($row['content']);
                                        echo strlen($content) > $maxLength
                                            ? substr($content, 0, $maxLength) . '...'
                                            : $content;
                                    ?>
                                </td>

                                <td><?= date("d M Y", strtotime($row['created_at'])); ?></td>

                                <td>
                                    <a href="edit_resource.php?id=<?= $row['id']; ?>" 
                                       class="btn btn-sm btn-primary me-2">
                                       <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="?delete=<?= $row['id']; ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Delete this resource?');">
                                       <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-muted py-4">
                                No resources found.
                            </td>
                        </tr>
                    <?php endif; ?>

                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

</body>
</html>
