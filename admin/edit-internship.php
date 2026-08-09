<?php
session_start();
include('../db.php');

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Get internship ID
if (!isset($_GET['id'])) {
    header("Location: manage_internship.php");
    exit;
}

$id = (int)$_GET['id'];

// Fetch internship details
$result = $conn->query("SELECT * FROM internship_opportunities WHERE id = $id");
if ($result->num_rows == 0) {
    header("Location: manage_internship.php");
    exit;
}
$internship = $result->fetch_assoc();

// Fetch benefits
$benefits = [];
$benefits_res = $conn->query("SELECT * FROM internship_benefits WHERE opportunity_id = $id");
while ($row = $benefits_res->fetch_assoc()) {
    $benefits[] = $row;
}

// Fetch criteria
$criteria = [];
$criteria_res = $conn->query("SELECT * FROM internship_who_can_apply WHERE opportunity_id = $id");
while ($row = $criteria_res->fetch_assoc()) {
    $criteria[] = $row;
}

// Fetch poster
$poster_res = $conn->query("SELECT * FROM internship_posters WHERE opportunity_id = $id ORDER BY id DESC LIMIT 1");
$poster = $poster_res->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $type = $_POST['type'];
    $location = $conn->real_escape_string($_POST['location']);
    $email = $conn->real_escape_string($_POST['application_email']);

    // Update internship_opportunities
    $conn->query("UPDATE internship_opportunities 
                  SET title='$title', description='$description', type='$type', 
                      location='$location', application_email='$email' 
                  WHERE id=$id");

    // Delete old benefits and insert new ones
    $conn->query("DELETE FROM internship_benefits WHERE opportunity_id = $id");
    if (!empty($_POST['benefits'])) {
        foreach ($_POST['benefits'] as $benefit) {
            if ($benefit != '') {
                $conn->query("INSERT INTO internship_benefits (opportunity_id, benefit_text) 
                              VALUES ($id, '".$conn->real_escape_string($benefit)."')");
            }
        }
    }

    // Delete old criteria and insert new ones
    $conn->query("DELETE FROM internship_who_can_apply WHERE opportunity_id = $id");
    if (!empty($_POST['criteria'])) {
        foreach ($_POST['criteria'] as $c) {
            if ($c != '') {
                $conn->query("INSERT INTO internship_who_can_apply (opportunity_id, criteria) 
                              VALUES ($id, '".$conn->real_escape_string($c)."')");
            }
        }
    }

    // Upload new poster if provided
    if (isset($_FILES['poster']) && $_FILES['poster']['error'] == 0) {
        $targetDir = "../uploads/";
        $fileName = time() . '_' . basename($_FILES['poster']['name']);
        $targetFilePath = $targetDir . $fileName;
        if (move_uploaded_file($_FILES['poster']['tmp_name'], $targetFilePath)) {
            // Delete old poster
            $conn->query("DELETE FROM internship_posters WHERE opportunity_id = $id");
            $alt = $conn->real_escape_string($_POST['alt_text']);
            $conn->query("INSERT INTO internship_posters (opportunity_id, image_path, alt_text) 
                          VALUES ($id, '$fileName', '$alt')");
        }
    }

    header("Location: manage_internship.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Internship Opportunity</title>
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
        .current-poster {
            max-width: 200px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php include('sidebar.php') ?>

    <!-- Main Content -->
    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold"><i class="fa-solid fa-pen me-2"></i>Edit Internship Opportunity</h2>
            <a href="manage_internship.php" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i>Back to List
            </a>
        </div>

        <div class="card shadow-sm p-4">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($internship['title']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($internship['description']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select" required>
                        <option value="internship" <?= $internship['type'] == 'internship' ? 'selected' : '' ?>>Internship</option>
                        <option value="volunteer" <?= $internship['type'] == 'volunteer' ? 'selected' : '' ?>>Volunteer</option>
                        <option value="fulltime" <?= $internship['type'] == 'fulltime' ? 'selected' : '' ?>>Fulltime</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($internship['location']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Application Email</label>
                    <input type="email" name="application_email" class="form-control" value="<?= htmlspecialchars($internship['application_email']) ?>" required>
                </div>

                <!-- Benefits -->
                <div class="mb-3">
                    <label class="form-label">Benefits</label>
                    <div id="benefits-wrapper">
                        <?php if (count($benefits) > 0): ?>
                            <?php foreach ($benefits as $benefit): ?>
                                <input type="text" name="benefits[]" class="form-control mb-2" value="<?= htmlspecialchars($benefit['benefit_text']) ?>" placeholder="Benefit">
                            <?php endforeach; ?>
                        <?php else: ?>
                            <input type="text" name="benefits[]" class="form-control mb-2" placeholder="Benefit">
                        <?php endif; ?>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addBenefit()">
                        <i class="fa-solid fa-plus me-1"></i>Add More
                    </button>
                </div>

                <!-- Who Can Apply -->
                <div class="mb-3">
                    <label class="form-label">Who Can Apply</label>
                    <div id="criteria-wrapper">
                        <?php if (count($criteria) > 0): ?>
                            <?php foreach ($criteria as $criterion): ?>
                                <input type="text" name="criteria[]" class="form-control mb-2" value="<?= htmlspecialchars($criterion['criteria']) ?>" placeholder="Criteria">
                            <?php endforeach; ?>
                        <?php else: ?>
                            <input type="text" name="criteria[]" class="form-control mb-2" placeholder="Criteria">
                        <?php endif; ?>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addCriteria()">
                        <i class="fa-solid fa-plus me-1"></i>Add More
                    </button>
                </div>

                <!-- Current Poster -->
                <?php if ($poster && !empty($poster['image_path'])): ?>
                    <div class="mb-3">
                        <label class="form-label">Current Poster</label>
                        <div>
                            <img src="/uploads/<?= htmlspecialchars($poster['image_path']); ?>" class="current-poster img-thumbnail">
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Poster Upload -->
                <div class="mb-3">
                    <label class="form-label">Upload New Poster (Leave empty to keep current)</label>
                    <input type="file" name="poster" class="form-control" accept="image/*">
                </div>

                <div class="mb-3">
                    <label class="form-label">Alt Text for New Poster</label>
                    <input type="text" name="alt_text" class="form-control">
                </div>

                <button type="submit" class="btn btn-success px-4">
                    <i class="fa-solid fa-floppy-disk me-1"></i>Update
                </button>
                <a href="manage_internship.php" class="btn btn-outline-secondary px-4">
                    <i class="fa-solid fa-xmark me-1"></i>Cancel
                </a>
            </form>
        </div>
    </div>

    <script>
        function addBenefit() {
            const div = document.createElement('div');
            div.innerHTML = '<input type="text" name="benefits[]" class="form-control mb-2" placeholder="Benefit">';
            document.getElementById('benefits-wrapper').appendChild(div);
        }
        function addCriteria() {
            const div = document.createElement('div');
            div.innerHTML = '<input type="text" name="criteria[]" class="form-control mb-2" placeholder="Criteria">';
            document.getElementById('criteria-wrapper').appendChild(div);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>