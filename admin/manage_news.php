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
  $conn->query("DELETE FROM news WHERE id=$id");
  header("Location: manage_news.php");
  exit;
}

// Fetch all news
$result = $conn->query("SELECT * FROM news ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Manage News</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background-color: #f8f9fa;
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
        <a class="navbar-brand text-black fw-bold" href="#">Manage Latest News</a>
        <div>
          <a href="add_news.php" class="btn btn-success btn-lg">
            <i class="fas fa-plus"></i> Add News
          </a>
        </div>
      </div>
    </nav>

    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="fw-bold mb-4">All News</h4>

        <div class="table-responsive">
          <table class="table table-striped align-middle text-center">
            <thead class="table-light">
              <tr>
                <th>ID</th>
                <th class="text-start">Title</th>
                <th class="text-start">Content</th>
                <th>Created At</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>

              <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                  <tr>
                    <td><?= $row['id']; ?></td>

                    <td class="text-start">
                      <?= htmlspecialchars($row['title']); ?>
                    </td>

                    <td class="text-start">
                      <?php
                      $maxLength = 50;
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
                      <a href="edit_news.php?id=<?= $row['id']; ?>" 
                         class="btn btn-sm btn-primary me-2">
                         Edit
                      </a>

                      <a href="manage_news.php?delete=<?= $row['id']; ?>" 
                         class="btn btn-sm btn-danger"
                         onclick="return confirm('Are you sure you want to delete this news?');">
                         Delete
                      </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5" class="text-muted text-center py-4">
                    No news found.
                  </td>
                </tr>
              <?php endif; ?>

            </tbody>
          </table>
        </div>

      </div>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php $conn->close(); ?>
