<?php
// auth.php
include '../db.php';
session_start();

// ---------- LOGIN FUNCTION ----------
function login($username, $password, $conn) {
    // Prepare and execute query
    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ? AND is_active = 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Check password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user_id'] = $user['id'];
        $_SESSION['admin_username'] = $user['username'];
        $_SESSION['admin_full_name'] = $user['full_name'];
        return true;
    }
    return false;
}

// ---------- CHECK LOGIN ----------
function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// ---------- REQUIRE LOGIN ----------
function requireAuth() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

// ---------- LOGOUT ----------
function logout() {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>
