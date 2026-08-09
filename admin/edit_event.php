<?php
session_start();
include('../db.php');

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: manage_events.php");
    exit;
}

$id = (int) $_GET['id'];

// Fetch event
$stmt = $conn->prepare("SELECT * FROM events WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();

if (!$event) {
    header("Location: manage_events.php");
    exit;
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $location = $_POST['location'];

    $imageName = $event['image']; // keep old image

    // If new image uploaded
    if (!empty($_FILES['image']['name'])) {

        $targetDir = "../uploads/";
        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {

            // delete old image
            if (!empty($event['image']) && file_exists($targetDir . $event['image'])) {
                unlink($targetDir . $event['image']);
            }

            $imageName = $fileName;
        }
    }

    // Update query
    $update = $conn->prepare("UPDATE events 
        SET title=?, description=?, start_date=?, end_date=?, start_time=?, end_time=?, location=?, image=? 
        WHERE id=?");

    $update->bind_param("ssssssssi",
        $title,
        $description,
        $start_date,
        $end_date,
        $start_time,
        $end_time,
        $location,
        $imageName,
        $id
    );

    $update->execute();

    header("Location: manage_events.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <style>
        body { background-color: #f8f9fa; display:flex; min-height:100vh; }
        .main-content { width:80%; padding:40px; }
        img.preview { border-radius:5px; margin-top:10px; }
    </style>
</head>
<body>

<?php include('sidebar.php'); ?>

<div class="main-content">
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Edit Event</h2>
        <a href="manage_events.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" enctype="multipart/form-data">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Event Title</label>
                    <input type="text" name="title" class="form-control"
                           value="<?= htmlspecialchars($event['title']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($event['description']); ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Start Date</label>
                        <input type="date" name="start_date" class="form-control"
                               value="<?= $event['start_date']; ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">End Date</label>
                        <input type="date" name="end_date" class="form-control"
                               value="<?= $event['end_date']; ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Start Time</label>
                        <input type="time" name="start_time" class="form-control"
                               value="<?= $event['start_time']; ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">End Time</label>
                        <input type="time" name="end_time" class="form-control"
                               value="<?= $event['end_time']; ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Location</label>
                    <input type="text" name="location" class="form-control"
                           value="<?= htmlspecialchars($event['location']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Event Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">

                    <?php if (!empty($event['image'])): ?>
                        <img src="../uploads/<?= htmlspecialchars($event['image']); ?>"
                             class="preview mt-2" width="200">
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-floppy-disk"></i> Update Event
                </button>

            </form>

        </div>
    </div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
