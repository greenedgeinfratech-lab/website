<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
include('../db.php');

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

/* =========================
   DELETE REGISTRATION
========================= */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM event_registrations WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: event_registrations.php");
    exit;
}

/* =========================
   FETCH DATA (JOIN WITH EVENTS)
========================= */
$sql = "SELECT er.*, e.title AS event_title 
        FROM event_registrations er
        LEFT JOIN events e ON er.event_id = e.id
        ORDER BY er.created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Event Registrations</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
body { background-color:#f8f9fa; }
.content { margin-left:240px; padding:20px; }
.table td, .table th { vertical-align:middle; }
</style>
</head>

<body>

<?php include('sidebar.php'); ?>

<div class="content">

    <nav class="navbar bg-light rounded mb-4">
        <div class="container-fluid">
            <span class="navbar-brand fw-bold">Event Registrations</span>
        </div>
    </nav>

    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="fw-bold mb-4">All Registrations</h4>

            <div class="table-responsive">
                <table class="table table-striped align-middle text-center">

                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Event</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Registered At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row['id']; ?></td>

                                    <td class="text-start fw-semibold text-success">
                                        <?= htmlspecialchars($row['event_title']); ?>
                                    </td>

                                    <td><?= htmlspecialchars($row['name']); ?></td>
                                    <td><?= htmlspecialchars($row['email']); ?></td>
                                    <td><?= htmlspecialchars($row['phone']); ?></td>

                                    <td>
                                        <?php
                                            $date = new DateTime($row['created_at'], new DateTimeZone('UTC'));
                                            $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
                                            echo $date->format("d M Y, h:i A");
                                        ?>
                                    </td>

                                    <td>
                                        <a href="?delete=<?= $row['id']; ?>"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Delete this registration?');">
                                           <i class="fas fa-trash"></i>
                                        </a>
                                    </td>

                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-muted py-4">
                                    No registrations found.
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
