<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
include('../db.php');

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

/* =========================
   DELETE APPLICATION
========================= */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM job_applications WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: manage_job_applications.php");
    exit;
}

/* =========================
   FETCH DATA (JOIN WITH CAREER)
========================= */
$sql = "SELECT ja.*, co.title AS job_title 
        FROM job_applications ja
        LEFT JOIN career_opportunities co ON ja.job_id = co.id
        ORDER BY ja.created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Job Applications</title>
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
            <span class="navbar-brand fw-bold">Job Applications</span>
        </div>
    </nav>

    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="fw-bold mb-4">All Applications</h4>

            <div class="table-responsive">
                <table class="table table-striped align-middle text-center">

                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Job Title</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Resume</th>
                            <th>Status</th>
                            <th>Applied At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>

                                    <td><?= $row['id']; ?></td>

                                    <td class="text-start fw-semibold text-success">
                                        <?= htmlspecialchars($row['job_title']); ?>
                                    </td>

                                    <td><?= htmlspecialchars($row['name']); ?></td>
                                    <td><?= htmlspecialchars($row['email']); ?></td>
                                    <td><?= htmlspecialchars($row['phone']); ?></td>

                                    <td>
                                        <a href="/<?= $row['resume_path']; ?>"  
                                           target="_blank"
                                           class="btn btn-sm btn-primary">
                                           <i class="fas fa-file"></i>
                                        </a>
                                    </td>

                                    <td>
                                        <select class="form-select form-select-sm status-dropdown 
                                            <?= 
                                                $row['status']=='pending' ? 'bg-secondary text-white' : 
                                                ($row['status']=='reviewed' ? 'bg-primary text-white' : 
                                                ($row['status']=='shortlisted' ? 'bg-success text-white' : 
                                                ($row['status']=='rejected' ? 'bg-danger text-white' : '')))
                                            ?>"
                                            data-id="<?= $row['id']; ?>">
                                    
                                            <option value="pending" <?= $row['status']=='pending'?'selected':''; ?>>Pending</option>
                                            <option value="reviewed" <?= $row['status']=='reviewed'?'selected':''; ?>>Reviewed</option>
                                            <option value="shortlisted" <?= $row['status']=='shortlisted'?'selected':''; ?>>Shortlisted</option>
                                            <option value="rejected" <?= $row['status']=='rejected'?'selected':''; ?>>Rejected</option>
                                    
                                        </select>
                                    </td>

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
                                           onclick="return confirm('Delete this application?');">
                                           <i class="fas fa-trash"></i>
                                        </a>
                                    </td>

                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-muted py-4">
                                    No applications found.
                                </td>
                            </tr>
                        <?php endif; ?>

                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

<!-- Toast Container -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
  <div id="statusToast" class="toast align-items-center text-white bg-success border-0" role="alert">
    <div class="d-flex">
      <div class="toast-body">
        Status Updated Successfully!
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('.status-dropdown').forEach(function(select){

    select.addEventListener('change', function(){

        let applicationId = this.dataset.id;
        let newStatus = this.value;
        let dropdown = this;

        fetch('update_application_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id=' + applicationId + '&status=' + newStatus
        })
        .then(response => response.text())
        .then(data => {

            // Remove old bg classes
            dropdown.classList.remove('bg-secondary','bg-primary','bg-success','bg-danger');

            if(newStatus === 'pending'){
                dropdown.classList.add('bg-secondary','text-white');
            }
            if(newStatus === 'reviewed'){
                dropdown.classList.add('bg-primary','text-white');
            }
            if(newStatus === 'shortlisted'){
                dropdown.classList.add('bg-success','text-white');
            }
            if(newStatus === 'rejected'){
                dropdown.classList.add('bg-danger','text-white');
            }

            // Show Toast
            let toastEl = document.getElementById('statusToast');
            let toast = new bootstrap.Toast(toastEl);
            toast.show();

        });

    });

});
</script>
</body>
</html>

<?php $conn->close(); ?>