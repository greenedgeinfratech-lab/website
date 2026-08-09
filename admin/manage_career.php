<?php
session_start();
include('../db.php');

if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}

// DELETE career opportunity
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM career_opportunities WHERE id = $id");
    header("Location: manage_career.php");
    exit;
}

// Fetch all career opportunities
$sql = "SELECT * FROM career_opportunities ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Career Opportunities</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { height:100vh; position:fixed; left:0; top:0; background-color:#198754; color:#fff; width:230px; padding-top:20px; }
        .sidebar a { color:#fff; text-decoration:none; display:block; padding:10px 20px; margin:5px 0; border-radius:4px; }
        .sidebar a:hover, .sidebar a.active { background-color:#157347; }
        .content { margin-left:240px; padding:20px; }
        .table td, .table th { vertical-align: middle; }
        .poster-thumb { width: 60px; height: auto; }
    </style>
</head>
<body>

<!-- Sidebar -->
<?php include('sidebar.php') ?>

<div class="content">
    <nav class="navbar navbar-expand-lg navbar-dark rounded mb-4 bg-light">
        <div class="container-fluid">
            <a class="navbar-brand text-black fw-bold" href="#">Manage Career Opportunities</a>
            <div>
                <a href="add-career.php" class="btn btn-success btn-lg">Add Opportunity</a>
            </div>
        </div>
    </nav>

    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="fw-bold mb-4">All Career Opportunities</h4>
            <div class="table-responsive">
                <table class="table table-striped align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th class="text-start">Title</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Benefits</th>
                            <th>Who Can Apply</th>
                            <th>Poster</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <?php
                                // Fetch benefits
                                $benefits_res = $conn->query("SELECT benefit_text FROM career_benefits WHERE opportunity_id=".$row['id']);
                                $benefits = [];
                                while ($b = $benefits_res->fetch_assoc()) $benefits[] = $b['benefit_text'];

                                // Fetch criteria
                                $criteria_res = $conn->query("SELECT criteria FROM who_can_apply WHERE opportunity_id=".$row['id']);
                                $criteria = [];
                                while ($c = $criteria_res->fetch_assoc()) $criteria[] = $c['criteria'];

                                // Fetch poster
                                $poster_res = $conn->query("
                                    SELECT image_path 
                                    FROM career_posters 
                                    WHERE opportunity_id=".$row['id']." 
                                    ORDER BY id DESC 
                                    LIMIT 1
                                ");
                                $poster = $poster_res->fetch_assoc();
                                ?>
                                <tr>
                                    <td><?= $row['id']; ?></td>
                                    <td class="text-start"><?= htmlspecialchars($row['title']); ?></td>
                                    <td><?= ucfirst($row['type']); ?></td>
                                    <td><?= htmlspecialchars($row['location']); ?></td>
                                    <td class="text-start">
                                        <?php
                                        if ($benefits) {
                                            echo implode(', ', array_map('htmlspecialchars', $benefits));
                                        } else {
                                            echo '<span class="text-muted">-</span>';
                                        }
                                        ?>
                                    </td>
                                    <td class="text-start">
                                        <?php
                                        if ($criteria) {
                                            echo implode(', ', array_map('htmlspecialchars', $criteria));
                                        } else {
                                            echo '<span class="text-muted">-</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($poster && !empty($poster['image_path'])): ?>
                                            <img src="/uploads/<?= htmlspecialchars($poster['image_path']); ?>" 
                                                 alt="Poster" 
                                                 class="poster-thumb">
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $row['created_at']; ?></td>
                                    <td>
                                        <a href="edit-job.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-primary me-2">Edit</a>
                                        <a href="manage_career.php?delete=<?= $row['id']; ?>" class="btn btn-sm btn-danger"
                                           onclick="return confirm('Are you sure you want to delete this opportunity?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-muted text-center py-4">No career opportunities found.</td>
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
