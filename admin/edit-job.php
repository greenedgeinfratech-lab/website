<?php
session_start();
include('../db.php');

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: manage_career.php");
    exit;
}

$id = (int)$_GET['id'];

// Fetch opportunity
$opportunity = $conn->query("SELECT * FROM career_opportunities WHERE id=$id")->fetch_assoc();

// Fetch benefits
$benefits = $conn->query("SELECT * FROM career_benefits WHERE opportunity_id=$id")->fetch_all(MYSQLI_ASSOC);

// Fetch criteria
$criteria = $conn->query("SELECT * FROM who_can_apply WHERE opportunity_id=$id")->fetch_all(MYSQLI_ASSOC);

// Fetch poster
$poster = $conn->query("SELECT * FROM career_posters WHERE opportunity_id=$id LIMIT 1")->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $type = $_POST['type'];
    $location = $conn->real_escape_string($_POST['location']);
    $email = $conn->real_escape_string($_POST['application_email']);

    $conn->query("UPDATE career_opportunities SET title='$title', description='$description', type='$type', location='$location', application_email='$email' WHERE id=$id");

    // Update benefits
    $conn->query("DELETE FROM career_benefits WHERE opportunity_id=$id");
    if (!empty($_POST['benefits'])) {
        foreach ($_POST['benefits'] as $b) {
            if ($b != '') {
                $conn->query("INSERT INTO career_benefits (opportunity_id, benefit_text) VALUES ($id,'".$conn->real_escape_string($b)."')");
            }
        }
    }

    // Update criteria
    $conn->query("DELETE FROM who_can_apply WHERE opportunity_id=$id");
    if (!empty($_POST['criteria'])) {
        foreach ($_POST['criteria'] as $c) {
            if ($c != '') {
                $conn->query("INSERT INTO who_can_apply (opportunity_id, criteria) VALUES ($id,'".$conn->real_escape_string($c)."')");
            }
        }
    }

    // Update poster
    if (isset($_FILES['poster']) && $_FILES['poster']['error']==0) {
        $targetDir = "../uploads/";
        $fileName = time() . '_' . basename($_FILES['poster']['name']);
        $targetFilePath = $targetDir . $fileName;
        if (move_uploaded_file($_FILES['poster']['tmp_name'], $targetFilePath)) {
            if ($poster) {
                unlink($targetDir.$poster['image_path']); // delete old poster
                $conn->query("UPDATE career_posters SET image_path='$fileName', alt_text='".$conn->real_escape_string($_POST['alt_text'])."' WHERE id=".$poster['id']);
            } else {
                $conn->query("INSERT INTO career_posters (opportunity_id,image_path,alt_text) VALUES ($id,'$fileName','".$conn->real_escape_string($_POST['alt_text'])."')");
            }
        }
    }

    header("Location: manage_career.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Career Opportunity</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<style>
  *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    background-color: #f8f9fa;
    overflow-x: hidden;
  }

  /* SIDEBAR */
  .sidebar {
    width: 280px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #2e7d32;
    color: #fff;
    padding-top: 20px;
    z-index: 1000;
  }

  .sidebar a {
    color: white;
    display: block;
    padding: 12px 20px;
    text-decoration: none;
    transition: 0.3s;
  }

  .sidebar a:hover {
    background: rgba(255,255,255,0.1);
  }

  /* MAIN CONTENT */
  .main-content {
    margin-left: 280px; /* SAME as sidebar width */
    padding: 30px;
    width: calc(100% - 280px);
    min-height: 100vh;
  }

  .container-fluid{
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
  }

  textarea.form-control{
    min-height: 120px;
  }

  img.preview {
    border-radius: 5px;
    margin-top: 10px;
    border: 1px solid #ddd;
    padding: 5px;
    background: #fff;
  }

  /* MOBILE RESPONSIVE */
  @media(max-width: 768px){

    .sidebar{
      width: 230px;
    }

    .main-content{
      margin-left: 230px;
      width: calc(100% - 230px);
      padding: 15px;
    }
  }

  @media(max-width: 576px){

    .sidebar{
      position: relative;
      width: 100%;
      height: auto;
    }

    .main-content{
      margin-left: 0;
      width: 100%;
    }
  }
</style>
</head>
<body>

  <!-- Sidebar -->
  <?php include('sidebar.php') ?>

  <!-- Main Content -->
  <div class="main-content">
    <div class="container-fluid">
      <h2 class="mb-4 fw-bold">Edit Career Opportunity</h2>
      <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label fw-semibold">Title</label>
          <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($opportunity['title']); ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Description</label>
          <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($opportunity['description']); ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Type</label>
          <select name="type" class="form-select" required>
            <option value="internship" <?= $opportunity['type']=='internship'?'selected':'' ?>>Internship</option>
            <option value="volunteer" <?= $opportunity['type']=='volunteer'?'selected':'' ?>>Volunteer</option>
            <option value="fulltime" <?= $opportunity['type']=='fulltime'?'selected':'' ?>>Fulltime</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Location</label>
          <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($opportunity['location']); ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Application Email</label>
          <input type="email" name="application_email" class="form-control" value="<?= htmlspecialchars($opportunity['application_email']); ?>" required>
        </div>

        <!-- Benefits -->
        <div class="mb-3">
          <label class="form-label fw-semibold">Benefits</label>
          <div id="benefits-wrapper">
            <?php foreach ($benefits as $b): ?>
              <input type="text" name="benefits[]" class="form-control mb-2" value="<?= htmlspecialchars($b['benefit_text']); ?>">
            <?php endforeach; ?>
            <input type="text" name="benefits[]" class="form-control mb-2" placeholder="Add more">
          </div>
          <button type="button" class="btn btn-secondary btn-sm" onclick="addBenefit()">
            <i class="fa-solid fa-plus"></i> Add More
          </button>
        </div>

        <!-- Who Can Apply -->
        <div class="mb-3">
          <label class="form-label fw-semibold">Who Can Apply</label>
          <div id="criteria-wrapper">
            <?php foreach ($criteria as $c): ?>
              <input type="text" name="criteria[]" class="form-control mb-2" value="<?= htmlspecialchars($c['criteria']); ?>">
            <?php endforeach; ?>
            <input type="text" name="criteria[]" class="form-control mb-2" placeholder="Add more">
          </div>
          <button type="button" class="btn btn-secondary btn-sm" onclick="addCriteria()">
            <i class="fa-solid fa-plus"></i> Add More
          </button>
        </div>

        <!-- Poster Upload -->
        <div class="mb-3">
          <label class="form-label fw-semibold">Poster Image</label>
          <input type="file" name="poster" class="form-control" accept="image/*">
          <?php if ($poster): ?>
            <img src="../uploads/<?= $poster['image_path']; ?>" alt="<?= htmlspecialchars($poster['alt_text']); ?>" class="mt-2 preview" width="150">
          <?php endif; ?>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Alt Text for Poster</label>
          <input type="text" name="alt_text" class="form-control" value="<?= htmlspecialchars($poster['alt_text'] ?? ''); ?>">
        </div>

        <button type="submit" class="btn btn-success">
          <i class="fa-solid fa-floppy-disk"></i> Update Opportunity
        </button>
        <a href="manage_career.php" class="btn btn-secondary">
          <i class="fa-solid fa-xmark"></i> Cancel
        </a>
      </form>
    </div>
  </div>

  <script>
    function addBenefit() {
      let div = document.createElement('div');
      div.innerHTML = '<input type="text" name="benefits[]" class="form-control mb-2" placeholder="Benefit">';
      document.getElementById('benefits-wrapper').appendChild(div);
    }
    function addCriteria() {
      let div = document.createElement('div');
      div.innerHTML = '<input type="text" name="criteria[]" class="form-control mb-2" placeholder="Criteria">';
      document.getElementById('criteria-wrapper').appendChild(div);
    }
  </script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
