<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
include('../db.php');

// Optional: Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

/* =========================
   EXPORT CSV
========================= */
if (isset($_GET['export']) && $_GET['export'] == 'csv') {

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=solar_requests.csv');

    $output = fopen('php://output', 'w');

    // CSV Header Row
    fputcsv($output, [
        'ID',
        'Name',
        'City',
        'Phone',
        'Email',
        'System Size (kW)',
        'Estimated Cost (₹)',
        'Monthly Generation',
        'Payback Period (Years)',
        'Annual Savings (₹)',
        'Requested At (IST)'
    ]);

    $exportQuery = $conn->query("SELECT * FROM solar_requests ORDER BY created_at DESC");

    while ($row = $exportQuery->fetch_assoc()) {

        $date = new DateTime($row['created_at'], new DateTimeZone('UTC'));
        $date->setTimezone(new DateTimeZone('Asia/Kolkata'));

        fputcsv($output, [
            $row['id'],
            $row['name'],
            $row['city'],
            $row['phone'],
            $row['email'],
            $row['system_size'],
            $row['estimated_cost'],
            $row['monthly_generation'],
            $row['payback_period'],
            $row['annual_savings'],
            $date->format("d M Y, h:i A")
        ]);
    }

    fclose($output);
    exit;
}

// Fetch all solar requests using MySQLi
$limit = 10;

// Current page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$offset = ($page - 1) * $limit;

// Get total records
$totalQuery = $conn->query("SELECT COUNT(*) as total FROM solar_requests");
$totalRow = $totalQuery->fetch_assoc();
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $limit);

// Fetch limited data
$sql = "SELECT * FROM solar_requests 
        ORDER BY created_at DESC 
        LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);

// Handle Delete Request
if (isset($_GET['delete'])) {
    $deleteId = (int)$_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM solar_requests WHERE id = ?");
    $stmt->bind_param("i", $deleteId);
    $stmt->execute();
    $stmt->close();

    header("Location: solar_requests.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Solar Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
        }

        .sidebar {
            min-height: 100vh;
            flex: 0 0 20%;
            max-width: 20%;
            background-color: #198754;
            color: #fff;
            padding-top: 0 !important;
        }

        .main-content {
            flex: 0 0 80%;
            max-width: 80%;
        }

        .sidebar .nav-link.active {
            background-color: #145c32;
            color: #fff;
        }
        
        /* ===== Custom Pagination Color ===== */

        .pagination .page-link {
            color: #2E7D32;
            border-color: #2E7D32;
        }
        
        .pagination .page-link:hover {
            background-color: #2E7D32;
            color: #fff;
            border-color: #2E7D32;
        }
        
        .pagination .page-item.active .page-link {
            background-color: #2E7D32;
            border-color: #2E7D32;
            color: #fff;
        }
        
        .pagination .page-item.disabled .page-link {
            color: #aaa;
            border-color: #ddd;
        }
    </style>
</head>

<body class="bg-light">
    <div class="d-flex">

        <!-- Sidebar -->
        <div class="sidebar">
            <?php include('sidebar.php') ?>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="flex-grow-1">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-black fw-bold">All Solar Requests</h2>
                
                    <a href="solar_requests.php?export=csv" 
                       class="btn btn-success">
                       <i class="fas fa-file-csv me-2"></i> Export as CSV
                    </a>
                </div>


                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>City</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>System Size (kW)</th>
                                        <th>Estimated Cost (₹)</th>
                                        <th>Monthly Generation (Units)</th>
                                        <th>Payback Period (Years)</th>
                                        <th>Annual Savings (₹)</th>
                                        <th>Requested At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result->num_rows > 0): ?>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $row['id']; ?></td>
                                                <td><?= htmlspecialchars($row['name']); ?></td>
                                                <td><?= htmlspecialchars($row['city']); ?></td>
                                                <td><?= htmlspecialchars($row['phone']); ?></td>
                                                <td><?= htmlspecialchars($row['email']); ?></td>
                                                <td><?= htmlspecialchars($row['system_size']); ?></td>
                                                <td><?= htmlspecialchars($row['estimated_cost']); ?></td>
                                                <td><?= htmlspecialchars($row['monthly_generation']); ?></td>
                                                <td><?= htmlspecialchars($row['payback_period']); ?></td>
                                                <td><?= htmlspecialchars($row['annual_savings']); ?></td>
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
                                                       onclick="return confirm('Are you sure you want to delete this request?');">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="11" class="text-muted text-center py-4">No solar requests found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        <?php if ($totalPages > 1): ?>
                        <nav>
                          <ul class="pagination justify-content-center mt-4">
                        
                            <!-- Previous Button -->
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                              <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
                            </li>
                        
                            <!-- Page Numbers -->
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                              <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                              </li>
                            <?php endfor; ?>
                        
                            <!-- Next Button -->
                            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                              <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
                            </li>
                        
                          </ul>
                        </nav>
                        <?php endif; ?>
                    </div>
                </div>
            </div> <!-- End Main Content -->
        </div>

    </div> <!-- End Flex Container -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php $conn->close(); ?>
