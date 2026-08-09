<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $slug = trim($_POST['slug']);
    $description = trim($_POST['description']);
    $content = trim($_POST['content']);

    if (empty($name) || empty($slug)) {
        $error = "Product name and slug are required.";
    } else {
        // Handle image upload
        $image_path = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $allowedTypes = ['image/jpeg','image/png','image/webp','image/gif'];
            if (in_array($_FILES['image']['type'], $allowedTypes)) {
                $image_path = "uploads/".time()."_".basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], "../".$image_path);
            } else {
                $error = "Only JPG, PNG, WEBP, or GIF images are allowed.";
            }
        }

        if (!isset($error)) {
            $stmt = $conn->prepare("INSERT INTO products (name, slug, description, content, image_path) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $slug, $description, $content, $image_path);
            if ($stmt->execute()) {
                header("Location: manage_products.php");
                exit;
            } else {
                $error = "Database error: ".$stmt->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .sidebar {
      height: 100vh;
      position: fixed;
      left: 0;
      top: 0;
      background-color: #198754;
      color: #fff;
      width: 230px;
      padding-top: 20px;
    }
    .sidebar a {
      color: #fff;
      text-decoration: none;
      display: block;
      padding: 10px 20px;
      margin: 5px 0;
      border-radius: 4px;
    }
    .sidebar a:hover,
    .sidebar a.active {
      background-color: #157347;
    }
    .content {
      margin-left: 240px;
      padding: 40px;
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <?php include('sidebar.php') ?>

  <!-- Main Content -->
  <div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-bold"><i class="fa-solid fa-box-open me-2"></i>Add New Product</h2>
      <a href="manage_products.php" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i>Back to List
      </a>
    </div>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="card shadow-sm p-4" style="max-width: 700px;">
      <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Product Name</label>
          <input type="text" name="name" class="form-control" required value="<?= isset($name) ? htmlspecialchars($name) : '' ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Slug</label>
          <input type="text" name="slug" class="form-control" required value="<?= isset($slug) ? htmlspecialchars($slug) : '' ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Short Description</label>
          <textarea name="description" class="form-control" rows="3"><?= isset($description) ? htmlspecialchars($description) : '' ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Content</label>
          <textarea name="content" class="form-control" rows="6"><?= isset($content) ? htmlspecialchars($content) : '' ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Product Image</label>
          <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-success px-4">
          <i class="fa-solid fa-plus me-1"></i>Add Product
        </button>
        <a href="manage_products.php" class="btn btn-outline-secondary px-4">
          <i class="fa-solid fa-xmark me-1"></i>Cancel
        </a>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

