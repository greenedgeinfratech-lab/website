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
  $conn->query("DELETE FROM blogs WHERE id=$id");
  header("Location: manage_blogs.php");
  exit;
}

// Fetch all blogs
$result = $conn->query("SELECT * FROM blogs ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Manage Blogs</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
      padding: 20px;
    }
  </style>
</head>

<body>

  <!-- Sidebar -->
  <?php include('sidebar.php') ?>

  <!-- Main Content -->
  <div class="content">
    <nav class="navbar navbar-expand-lg navbar-dark rounded mb-4">
      <div class="container-fluid">
        <a class="navbar-brand text-black fw-bold" href="#">Manage Blogs</a>
        <div>
          <a href="add-blog.php" class="btn btn-success btn-lg">Add Blog</a>
        </div>
      </div>
    </nav>

    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="fw-bold mb-4">All Blogs</h4>
        <div class="table-responsive">
          <table class="table table-striped align-middle text-center">
            <thead class="table-light">
              <tr>
                <th scope="col">ID</th>
                <th scope="col" class="text-start">Title</th>
                <th scope="col">content</th>
                <th scope="col">Created At</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                  <tr>
                    <td><?= $row['id']; ?></td>
                    <td class="text-start"><?= htmlspecialchars($row['title']); ?></td>
                    <td class="text-start">
                      <?php
                      $maxLength = 50; // maximum number of characters to display
                      $content = htmlspecialchars($row['content']);
                      if (strlen($content) > $maxLength) {
                        echo substr($content, 0, $maxLength) . '...';
                      } else {
                        echo $content;
                      }
                      ?>
                    </td>
                    <td><?= $row['created_at']; ?></td>
                    <td>
                      <a href="edit-blog.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-primary me-2">Edit</a>
                      <a href="manage_blogs.php?delete=<?= $row['id']; ?>"
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('Are you sure you want to delete this blog?');">Delete</a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5" class="text-muted text-center py-4">No blogs found.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS + Icons -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</body>

</html>
<?php $conn->close(); ?>