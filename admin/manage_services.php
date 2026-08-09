<?php
session_start();

// Database Configuration - Replace with your actual db.php content
try {
    $host = 'localhost';
    $dbname = 'u414903541_greenedge';
    $username = 'u414903541_greenedge';
    $password = 'Gyanendra123!';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Initialize variables
$title = $description = $image_path = "";
$id = 0;
$is_edit = false;
$success_msg = $error_msg = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['save'])) {
        // Create or Update service
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        
        // Handle image upload
        $image_path = $_POST['existing_image'] ?? '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $upload_dir = "assets/images/services/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $file_name = time() . '_' . basename($_FILES['image']['name']);
            $target_file = $upload_dir . $file_name;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            
            // Check if image file is actual image
            $check = getimagesize($_FILES['image']['tmp_name']);
            if ($check !== false) {
                // Check file size (5MB max)
                if ($_FILES['image']['size'] <= 5000000) {
                    // Allow certain file formats
                    if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                            $image_path = $target_file;
                            // Delete old image if exists and updating
                            if (isset($_POST['id']) && !empty($_POST['existing_image']) && file_exists($_POST['existing_image'])) {
                                unlink($_POST['existing_image']);
                            }
                        } else {
                            $error_msg = "Sorry, there was an error uploading your file.";
                        }
                    } else {
                        $error_msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    }
                } else {
                    $error_msg = "Sorry, your file is too large. Maximum size is 5MB.";
                }
            } else {
                $error_msg = "File is not an image.";
            }
        }
        
        if (empty($error_msg)) {
            try {
                if (isset($_POST['id']) && !empty($_POST['id'])) {
                    // Update existing service
                    $id = (int)$_POST['id'];
                    $stmt = $pdo->prepare("UPDATE services SET title = ?, description = ?, image_path = ?, is_active = ?, updated_at = NOW() WHERE id = ?");
                    if ($stmt->execute([$title, $description, $image_path, $is_active, $id])) {
                        $success_msg = "Service updated successfully!";
                    } else {
                        $error_msg = "Error updating service.";
                    }
                } else {
                    // Create new service
                    $stmt = $pdo->prepare("INSERT INTO services (title, description, image_path, is_active) VALUES (?, ?, ?, ?)");
                    if ($stmt->execute([$title, $description, $image_path, $is_active])) {
                        $success_msg = "Service created successfully!";
                        // Reset form
                        $title = $description = $image_path = "";
                    } else {
                        $error_msg = "Error creating service.";
                    }
                }
            } catch(PDOException $e) {
                $error_msg = "Database error: " . $e->getMessage();
            }
        }
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    
    try {
        // Get image path before deleting
        $stmt = $pdo->prepare("SELECT image_path FROM services WHERE id = ?");
        $stmt->execute([$id]);
        $service = $stmt->fetch();
        
        // Delete from database
        $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
        if ($stmt->execute([$id])) {
            // Delete image file if exists
            if ($service && !empty($service['image_path']) && file_exists($service['image_path'])) {
                unlink($service['image_path']);
            }
            $success_msg = "Service deleted successfully!";
        } else {
            $error_msg = "Error deleting service.";
        }
    } catch(PDOException $e) {
        $error_msg = "Database error: " . $e->getMessage();
    }
}

// Handle edit
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM services WHERE id = ?");
        $stmt->execute([$id]);
        $service = $stmt->fetch();
        
        if ($service) {
            $is_edit = true;
            $title = $service['title'];
            $description = $service['description'];
            $image_path = $service['image_path'];
            $id = $service['id'];
        }
    } catch(PDOException $e) {
        $error_msg = "Database error: " . $e->getMessage();
    }
}

// Handle toggle active status
if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    try {
        $stmt = $pdo->prepare("UPDATE services SET is_active = NOT is_active, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: " . str_replace("&toggle=$id", "", $_SERVER['REQUEST_URI']));
        exit();
    } catch(PDOException $e) {
        $error_msg = "Database error: " . $e->getMessage();
    }
}

// Fetch all services with error handling
try {
    $stmt = $pdo->query("SELECT * FROM services ORDER BY created_at DESC");
    $services = $stmt->fetchAll();
} catch(PDOException $e) {
    $error_msg = "Error fetching services: " . $e->getMessage();
    $services = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .service-image {
            max-width: 100px;
            max-height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
        .card {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .status-badge {
            cursor: pointer;
        }
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-cogs me-2"></i>
                            Services Management
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Success/Error Messages -->
                        <?php if ($success_msg): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <?php echo $success_msg; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($error_msg): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?php echo $error_msg; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Service Form -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas <?php echo $is_edit ? 'fa-edit' : 'fa-plus'; ?> me-2"></i>
                                    <?php echo $is_edit ? 'Edit Service' : 'Add New Service'; ?>
                                </h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($image_path); ?>">
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="title" class="form-label">Service Title *</label>
                                                <input type="text" class="form-control" id="title" name="title" 
                                                       value="<?php echo htmlspecialchars($title); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="image" class="form-label">Service Image</label>
                                                <input type="file" class="form-control" id="image" name="image" 
                                                       accept="image/*">
                                                <?php if ($image_path): ?>
                                                    <div class="mt-2">
                                                        <small class="text-muted">Current Image:</small><br>
                                                        <img src="../<?php echo htmlspecialchars($service['image_path']); ?>" alt="Current" class="service-image mt-1">
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" 
                                                  rows="4"><?php echo htmlspecialchars($description); ?></textarea>
                                    </div>
                                    
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" 
                                               <?php echo ($is_edit && !isset($_POST['is_active'])) ? '' : 'checked'; ?>>
                                        <label class="form-check-label" for="is_active">Active Service</label>
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <button type="submit" name="save" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i>
                                            <?php echo $is_edit ? 'Update Service' : 'Create Service'; ?>
                                        </button>
                                        <?php if ($is_edit): ?>
                                            <a href="services.php" class="btn btn-secondary">
                                                <i class="fas fa-times me-1"></i> Cancel
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Services List -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-list me-2"></i>
                                    All Services (<?php echo count($services); ?>)
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php if (empty($services)): ?>
                                    <div class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No services found</h5>
                                        <p class="text-muted">Get started by adding your first service above.</p>
                                    </div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                    <th>Created</th>
                                                    <th>Updated</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($services as $service): ?>
                                                    <tr>
                                                        <td>
                                                            <?php if ($service['image_path']): ?>
                                                                <img src="<?php echo htmlspecialchars($service['image_path']); ?>" 
                                                                     alt="<?php echo htmlspecialchars($service['title']); ?>" 
                                                                     class="service-image">
                                                            <?php else: ?>
                                                                <span class="text-muted">No Image</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <strong><?php echo htmlspecialchars($service['title']); ?></strong>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                            $desc = $service['description'];
                                                            echo strlen($desc) > 100 ? substr($desc, 0, 100) . '...' : $desc;
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <span class="badge status-badge <?php echo $service['is_active'] ? 'bg-success' : 'bg-secondary'; ?>"
                                                                  onclick="toggleStatus(<?php echo $service['id']; ?>)">
                                                                <?php echo $service['is_active'] ? 'Active' : 'Inactive'; ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <small class="text-muted">
                                                                <?php echo date('M j, Y g:i A', strtotime($service['created_at'])); ?>
                                                            </small>
                                                        </td>
                                                        <td>
                                                            <small class="text-muted">
                                                                <?php echo date('M j, Y g:i A', strtotime($service['updated_at'])); ?>
                                                            </small>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="?edit=<?php echo $service['id']; ?>" 
                                                                   class="btn btn-outline-primary" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <a href="?delete=<?php echo $service['id']; ?>" 
                                                                   class="btn btn-outline-danger" 
                                                                   onclick="return confirm('Are you sure you want to delete this service?')"
                                                                   title="Delete">
                                                                    <i class="fas fa-trash"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleStatus(serviceId) {
            if (confirm('Are you sure you want to toggle the status of this service?')) {
                window.location.href = '?toggle=' + serviceId;
            }
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>