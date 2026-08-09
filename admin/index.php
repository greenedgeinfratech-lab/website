<?php
session_start();
include '../db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Fetch Admin Users
$adminCount = 0;
$result = $conn->query("SELECT COUNT(*) as total FROM admin_users");
if ($result) {
    $row = $result->fetch_assoc();
    $adminCount = $row['total'];
}

// Fetch recent solar requests (limit 3 latest)
$solarRequestCount = 0;
$result = $conn->query("SELECT COUNT(*) as total FROM solar_requests");
if ($result) {
    $row = $result->fetch_assoc();
    $solarRequestCount = $row['total'];
}

$solarRequests = [];
$result = $conn->query("SELECT name, city, system_size 
                        FROM solar_requests 
                        ORDER BY id DESC 
                        LIMIT 3");

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $solarRequests[] = $row;
    }
}

// Fetch recent blogs (limit 3 latest)
$blogCount = 0;
$result = $conn->query("SELECT COUNT(*) as total FROM blogs");
if ($result) {
    $row = $result->fetch_assoc();
    $blogCount = $row['total'];
}

$recentBlogs = [];
$result = $conn->query("SELECT title, content, created_at 
                        FROM blogs 
                        ORDER BY id DESC 
                        LIMIT 3");

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recentBlogs[] = $row;
    }
}

// Fetch Products
$productCount = 0;
$result = $conn->query("SELECT COUNT(*) as total FROM products");
if ($result) {
    $row = $result->fetch_assoc();
    $productCount = $row['total'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenEdge Infratech - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2e7d32;
            --secondary-color: #4caf50;
            --light-color: #e8f5e9;
            --dark-color: #1b5e20;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }

        .sidebar {
            background-color: var(--primary-color);
            color: white;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            margin: 5px 0;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .header {
            background-color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card {
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border: none;
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid #eee;
            font-weight: 600;
            padding: 15px 20px;
            border-radius: 8px 8px 0 0 !important;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--dark-color);
            border-color: var(--dark-color);
        }

        .table th {
            background-color: var(--light-color);
            color: var(--dark-color);
        }

        .logo {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .logo h3 {
            font-weight: 700;
            margin: 0;
        }

        .logo span {
            color: var(--light-color);
            font-weight: 300;
        }

        .stats-card {
            text-align: center;
            padding: 20px;
            border-radius: 8px;
            color: white;
            margin-bottom: 20px;
        }

        .stats-card.blue {
            background-color: #2196f3;
        }

        .stats-card.green {
            background-color: var(--secondary-color);
        }

        .stats-card.orange {
            background-color: #ff9800;
        }

        .stats-card.purple {
            background-color: #9c27b0;
        }

        .stats-card .number {
            font-size: 2rem;
            font-weight: 700;
            margin: 10px 0;
        }

        .action-buttons .btn {
            margin-right: 5px;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .dashboard-section {
            display: none;
        }

        .dashboard-section.active {
            display: block;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include('sidebar.php') ?>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <!-- Header -->
                <div class="header">
                    <h4 id="section-title">Dashboard</h4>
                    <div class="user-info">
                        <span>Welcome, Admin</span>
                        <i class="fas fa-user-circle ms-2"></i>
                    </div>
                </div>

                <!-- Dashboard Section -->
                <div id="dashboard" class="dashboard-section active">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="stats-card blue">
                                <i class="fas fa-users fa-2x"></i>
                                <div class="number"><?= $adminCount ?></div>
                                <div>Admin Users</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card green">
                                <i class="fas fa-blog fa-2x"></i>
                                <div class="number"><?= $blogCount ?></div>
                                <div>Blog Posts</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card orange">
                                <i class="fas fa-solar-panel fa-2x"></i>
                                <div class="number"><?= $productCount ?></div>
                                <div>Products</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card purple">
                                <i class="fas fa-file-alt fa-2x"></i>
                                <div class="number"><?= $solarRequestCount ?></div>
                                <div>Solar Requests</div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <!-- Recent Solar Requests -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Recent Solar Requests</div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>City</th>
                                                <th>System Size</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($solarRequests)): ?>
                                                <?php foreach ($solarRequests as $req): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($req['name']) ?></td>
                                                        <td><?= htmlspecialchars($req['city']) ?></td>
                                                        <td><?= htmlspecialchars($req['system_size']) ?> kW</td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted">No recent requests</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Blog Posts -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Recent Blog Posts</div>
                                <div class="card-body">
                                    <div class="list-group">
                                        <?php if (!empty($recentBlogs)): ?>
                                            <?php foreach ($recentBlogs as $blog): ?>
                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <h6 class="mb-1"><?= htmlspecialchars($blog['title']) ?></h6>
                                                        <small>
                                                            <?= date("M d, Y", strtotime($blog['created_at'])) ?>
                                                        </small>
                                                    </div>
                                                    <p class="mb-1"><?= htmlspecialchars($blog['content']) ?></p>
                                                </a>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="text-center text-muted">No recent blog posts</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>

</html>