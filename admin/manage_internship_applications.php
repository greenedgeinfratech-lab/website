<?php
session_start();
include('../db.php');

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Fetch all internship applications
$sql = "SELECT ia.*, io.title as internship_title 
        FROM internship_applications ia 
        JOIN internship_opportunities io ON ia.internship_id = io.id 
        ORDER BY ia.created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Internship Applications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { height:100vh; position:fixed; left:0; top:0; background-color:#198754; color:#fff; width:230px; padding-top:20px; }
        .sidebar a { color:#fff; text-decoration:none; display:block; padding:10px 20px; margin:5px 0; border-radius:4px; }
        .sidebar a:hover, .sidebar a.active { background-color:#157347; }
        .content { margin-left:240px; padding:20px; }
    </style>
</head>
<body>

<?php include('sidebar.php') ?>

<div class="content">
    <nav class="navbar navbar-expand-lg navbar-dark rounded mb-4 bg-light">
        <div class="container-fluid">
            <a class="navbar-brand text-black fw-bold" href="#">Internship Applications</a>
        </div>
    </nav>

    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="fw-bold mb-4">All Internship Applications</h4>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Internship</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>College</th>
                            <th>Course</th>
                            <th>Duration</th>
                            <th>Resume</th>
                            <th>Applied On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row['id']; ?></td>
                                    <td><?= htmlspecialchars($row['internship_title']); ?></td>
                                    <td><?= htmlspecialchars($row['name']); ?></td>
                                    <td><?= htmlspecialchars($row['email']); ?></td>
                                    <td><?= htmlspecialchars($row['phone']); ?></td>
                                    <td><?= htmlspecialchars($row['college']); ?></td>
                                    <td><?= htmlspecialchars($row['course']); ?></td>
                                    <td><?= htmlspecialchars($row['duration']); ?></td>
                                    <td>
                                        <a href="/uploads/internship_resumes/<?= $row['resume_path']; ?>" target="_blank" class="btn btn-sm btn-primary">
                                            View Resume
                                        </a>
                                    </td>
                                    <td><?= $row['created_at']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="text-center">No applications found.</td>
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