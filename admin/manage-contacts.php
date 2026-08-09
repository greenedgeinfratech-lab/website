<?php
session_start();
date_default_timezone_set('Asia/Kolkata');

if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}

include '../db.php';

/* =========================
   EXPORT CSV
========================= */
if (isset($_GET['export']) && $_GET['export'] == 'csv') {

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=contact_inquiries.csv');

    $output = fopen('php://output', 'w');

    // CSV Header Row
    fputcsv($output, [
        'ID',
        'First Name',
        'Last Name',
        'Email',
        'Phone',
        'Property Type',
        'Message',
        'Created At (IST)'
    ]);

    $exportQuery = $conn->query("SELECT * FROM contact_inquiries ORDER BY id DESC");

    while ($row = $exportQuery->fetch_assoc()) {

        $utcTime = new DateTime($row['created_at'], new DateTimeZone('UTC'));
        $utcTime->setTimezone(new DateTimeZone('Asia/Kolkata'));

        fputcsv($output, [
            $row['id'],
            $row['first_name'],
            $row['last_name'],
            $row['email'],
            $row['phone'],
            $row['property_type'],
            $row['message'],
            $utcTime->format("d M Y, h:i A")
        ]);
    }

    fclose($output);
    exit;
}

/* =========================
   DELETE CONTACT
========================= */
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  $conn->query("DELETE FROM contact_inquiries WHERE id=$id");
  header("Location: manage-contacts.php");
  exit;
}

/* =========================
   FETCH CONTACTS
========================= */
$result = $conn->query("SELECT * FROM contact_inquiries ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Manage Contact Inquiries</title>
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
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">All Contact Messages</h4>
        
            <a href="manage-contacts.php?export=csv" 
               class="btn btn-success">
               <i class="fas fa-file-csv me-2"></i> Export as CSV
            </a>
        </div>

        <div class="table-responsive">
          <table class="table table-striped align-middle text-center">
            <thead class="table-light">
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Property Type</th>
                <th>Message</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                  <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><?= htmlspecialchars($row['phone']); ?></td>
                    <td><?= htmlspecialchars($row['property_type']); ?></td>
                    <td class="text-start">
                      <?php
                      $maxLength = 60;
                      $msg = htmlspecialchars($row['message']);
                      echo strlen($msg) > $maxLength ? substr($msg, 0, $maxLength) . '...' : $msg;
                      ?>
                    </td>
                   <td>
                    <?php
                      $utcTime = new DateTime($row['created_at'], new DateTimeZone('UTC'));
                      $utcTime->setTimezone(new DateTimeZone('Asia/Kolkata'));
                      echo $utcTime->format("d M Y, h:i A");
                    ?>
                    </td>
                    <td>
                      <a href="manage-contacts.php?delete=<?= $row['id']; ?>"
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('Are you sure you want to delete this inquiry?');">
                        Delete
                      </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="8" class="text-muted text-center py-4">
                    No contact inquiries found.
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php $conn->close(); ?>
