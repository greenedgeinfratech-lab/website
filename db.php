<?php
$host = "localhost";      // Database host (usually localhost)
$user = "u414903541_greenedge";           // Database username
$pass = "Gyanendra123!";               // Database password
$dbname = "u414903541_greenedge";     // Database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Set UTF-8 encoding
$conn->set_charset("utf8");
?>
