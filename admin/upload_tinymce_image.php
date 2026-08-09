<?php
session_start();

if (!isset($_SESSION['admin'])) {
    http_response_code(403);
    exit;
}

if (!empty($_FILES['file']['name'])) {

    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $fileName = time() . "_" . basename($_FILES['file']['name']);
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {

        $url = "https://greenedgeinfratech.com/uploads/" . $fileName;
        echo $url;

    } else {
        http_response_code(500);
        echo "Upload failed";
    }

} else {
    http_response_code(400);
    echo "No file received";
}
