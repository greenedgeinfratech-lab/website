<?php
session_start();
date_default_timezone_set('Asia/Kolkata');

include('../db.php');

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// DELETE EVENT
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM events WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: manage_events.php");
    exit;
}

// Fetch all events
$sql = "SELECT * FROM events ORDER BY start_date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .content { margin-left:240px; padding:20px; }
        .table td, .table th { vertical-align: middle; }
        .event-thumb { width: 80px; height: 60px; object-fit: cover; border-radius: 5px; }
    </style>
</head>
<body>

<!-- Sidebar -->
<?php include('sidebar.php') ?>

<div class="content">

    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark rounded mb-4 bg-light">
        <div class="container-fluid">
            <a class="navbar-brand text-black fw-bold" href="#">Manage Events</a>
            <div>
                <a href="add_event.php" class="btn btn-success btn-lg">
                    <i class="fas fa-plus me-2"></i>Add Event
                </a>
            </div>
        </div>
    </nav>

    <!-- Card -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="fw-bold mb-4">All Events</h4>

            <div class="table-responsive">
                <table class="table table-striped align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th class="text-start">Title</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Location</th>
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

                                    <td class="text-start">
                                        <?= htmlspecialchars($row['title']); ?>
                                    </td>

                                    <td>
                                        <?php if(!empty($row['start_date'])): ?>
                                            <?= date("d M Y", strtotime($row['start_date'])); ?>
                                            <?php if($row['end_date'] != $row['start_date']): ?>
                                                <br>
                                                <small class="text-muted">
                                                    to <?= date("d M Y", strtotime($row['end_date'])); ?>
                                                </small>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if(!empty($row['start_time'])): ?>
                                            <?= date("h:i A", strtotime($row['start_time'])); ?>
                                            <?php if(!empty($row['end_time'])): ?>
                                                <br>
                                                <small class="text-muted">
                                                    to <?= date("h:i A", strtotime($row['end_time'])); ?>
                                                </small>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['location']); ?>
                                    </td>

                                    <td>
                                        <?php if (!empty($row['image'])): ?>
                                            <img src="/uploads/<?= htmlspecialchars($row['image']); ?>" 
                                                 class="event-thumb">
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>

                                    <td><?= $row['created_at']; ?></td>

                                    <td>
                                        <a href="edit_event.php?id=<?= $row['id']; ?>" 
                                           class="btn btn-sm btn-primary me-2">
                                           <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="manage_events.php?delete=<?= $row['id']; ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Are you sure you want to delete this event?');">
                                           <i class="fas fa-trash"></i>
                                        </a>
                                    </td>

                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-muted text-center py-4">
                                    No events found.
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
