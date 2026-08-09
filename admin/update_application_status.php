<?php
include('../db.php');

if(isset($_POST['id']) && isset($_POST['status'])){

    $id = (int)$_POST['id'];
    $status = $_POST['status'];

    $allowed = ['pending','reviewed','shortlisted','rejected'];

    if(in_array($status, $allowed)){

        $stmt = $conn->prepare("UPDATE job_applications SET status=? WHERE id=?");
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();

        echo "Updated Successfully";
    }
}
?>