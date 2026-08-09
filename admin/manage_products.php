<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include '../db.php';

// Handle delete request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM products WHERE id=$id");
    header("Location: manage_products.php");
    exit;
}

// Fetch all products
$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        body {
            min-height: 100vh;
        }

        .sidebar {
            min-height: 100vh;
            flex: 0 0 20%;
            /* 20% width */
            max-width: 20%;
            background-color: #198754;
            /* Optional: sidebar color */
            color: #fff;
            padding-top: 0 !important;
        }

        .main-content {
            flex: 0 0 80%;
            /* 80% width */
            max-width: 80%;
            /* padding: 2rem; */
        }

        .sidebar .nav-link.active {
            background-color: #145c32;
            color: #fff;
        }
    </style>
</head>

<body class="bg-light">
    <div class="d-flex">

        <!-- Sidebar -->
        <div class="sidebar">
            <?php include('sidebar.php') ?>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="flex-grow-1">
                <!-- Navbar / Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-black fw-bold">All Products</h2>
                    <div>
                        <a href="add-product.php" class="btn btn-success btn-lg ms-2">Add Product</a>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result->num_rows > 0): ?>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $row['id']; ?></td>
                                                <td><?= htmlspecialchars($row['name']); ?></td>
                                                <td><?= htmlspecialchars($row['slug']); ?></td>
                                                <td class="text-start">
                                                    <?php
                                                    $maxLength = 50;
                                                    $desc = htmlspecialchars(strip_tags($row['description']));
                                                    echo strlen($desc) > $maxLength ? substr($desc, 0, $maxLength) . "..." : $desc;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php if ($row['image_path']): ?>
                                                        <img src="../<?= $row['image_path']; ?>" alt="Product Image" width="80">
                                                    <?php else: ?>
                                                        N/A
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= $row['created_at']; ?></td>
                                                <td>
                                                    <a href="edit-product.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-primary me-2">Edit</a>
                                                    <a href="manage_products.php?delete=<?= $row['id']; ?>"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this product?');">
                                                        Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-muted text-center py-4">No products found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- End Main Content -->
        </div>

    </div> <!-- End Flex Container -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php $conn->close(); ?>