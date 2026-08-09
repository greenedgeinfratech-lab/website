<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include '../db.php';

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("DELETE FROM blogs WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: dashboard.php");
exit;
?>
