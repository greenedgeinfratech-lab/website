<?php
include '../db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Fetch Users
$adminUsers = [];
$result = $conn->query("SELECT * FROM admin_users ORDER BY id DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $adminUsers[] = $row;
    }
}

// Fetch Blogs
$blogs = [];
$result = $conn->query("SELECT * FROM blogs ORDER BY id DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $blogs[] = $row;
    }
}

// Fetch Products
$products = [];
$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Fetch Solar Requests
$solarRequests = [];
$result = $conn->query("SELECT * FROM solar_requests ORDER BY id DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $solarRequests[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenEdge Admin Panel</title>
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
                <h4 id="section-title">Users</h4>

                <!-- Admin Users Section -->
                <div id="admin-users" class="dashboard-section active">
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#adminUserModal"><i class="fas fa-plus"></i> Add User</button>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Full Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($adminUsers)): ?>
                                <?php foreach ($adminUsers as $user): ?>
                                    <tr>
                                        <td><?= $user['id'] ?></td>
                                        <td><?= htmlspecialchars($user['username']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td><?= htmlspecialchars($user['full_name']) ?></td>
                                        <td>
                                            <?= $user['is_active'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>' ?>
                                        </td>
                                        <td>
                                            <a href="edit_admin.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                            <a href="delete_admin.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this user?')"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No admin users found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Repeat similar sections for Blogs, Products, Solar Requests -->
            </div>
        </div>
    </div>

    <!-- Add Admin User Modal -->
    <div class="modal fade" id="adminUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="add_admin.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Admin User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="username" placeholder="Username" class="form-control mb-2" required>
                        <input type="email" name="email" placeholder="Email" class="form-control mb-2" required>
                        <input type="text" name="full_name" placeholder="Full Name" class="form-control mb-2">
                        <input type="password" name="password" placeholder="Password" class="form-control mb-2" required>
                        <div class="form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" checked>
                            <label class="form-check-label">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="save_admin" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.sidebar .nav-link').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                const target = this.dataset.target;
                document.querySelectorAll('.dashboard-section').forEach(s => s.classList.remove('active'));
                document.getElementById(target).classList.add('active');
                document.getElementById('section-title').textContent = this.textContent.trim();
            });
        });
    </script>
</body>

</html>