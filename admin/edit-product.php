<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include '../db.php';

// Get product ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage_products.php");
    exit;
}
$product_id = (int)$_GET['id'];

// Fetch product data
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    header("Location: manage_products.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $slug = trim($_POST['slug']);
    $description = trim($_POST['description']);
    $content = trim($_POST['content']);

    if (empty($name) || empty($slug)) {
        $error = "Product name and slug are required.";
    } else {
        // Handle image upload
        $image_path = $product['image_path']; // keep existing image by default
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
            $stmt = $conn->prepare("UPDATE products SET name=?, slug=?, description=?, content=?, image_path=? WHERE id=?");
            $stmt->bind_param("sssssi", $name, $slug, $description, $content, $image_path, $product_id);
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
  <title>Edit Product</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

  <style>
    body {
      display: flex;
      min-height: 100vh;
      background-color: #f8f9fa;
    }

    /* Sidebar Styling */
    .sidebar {
      width: 20%;
      background-color: #343a40;
      color: white;
      padding-top: 20px;
      min-height: 100vh;
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      padding: 12px 20px;
      transition: background 0.3s;
    }

    .sidebar a:hover {
      background-color: #495057;
    }

    .main-content {
      width: 80%;
      padding: 40px;
    }

    img.preview {
      border-radius: 5px;
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <?php include('sidebar.php') ?>

  <!-- Main Content -->
  <div class="main-content">
    <div class="container-fluid">
      <h2 class="fw-bold mb-4">Edit Product</h2>

      <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
        <div class="mb-3">
          <label class="form-label fw-semibold">Product Name</label>
          <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($product['name']); ?>">
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Slug</label>
          <input type="text" name="slug" class="form-control" required value="<?= htmlspecialchars($product['slug']); ?>">
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Short Description</label>
          <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($product['description']); ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Content</label>
          <textarea name="content" class="form-control" rows="6"><?= htmlspecialchars($product['content']); ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Product Image</label>
          <?php if ($product['image_path']): ?>
            <div class="mb-2">
              <img src="../<?= $product['image_path'] ?>" alt="Product Image" class="preview" style="max-width:150px;">
            </div>
          <?php endif; ?>
          <input type="file" name="image" class="form-control">
          <small class="text-muted">Leave blank to keep existing image.</small>
        </div>

        <button type="submit" class="btn btn-primary">
          <i class="fa-solid fa-pen-to-square"></i> Update Product
        </button>
        <a href="manage_products.php" class="btn btn-secondary">
          <i class="fa-solid fa-arrow-left"></i> Back
        </a>
      </form>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
