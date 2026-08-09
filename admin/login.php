<?php
session_start();
include "../db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Get user by username
    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify password (if hashed in DB)
        if (password_verify($password, $user['password'])) {
            $_SESSION['admin'] = $user['username'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid username or password!";
        }
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login | GreenEdge</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
body {
    height: 100vh;
    background: linear-gradient(135deg, #1b5e20, #4caf50);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Segoe UI', sans-serif;
    overflow: hidden;
}

/* Floating background animation */
body::before {
    content: "";
    position: absolute;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.08) 20%, transparent 20%);
    background-size: 80px 80px;
    animation: moveBg 20s linear infinite;
}

@keyframes moveBg {
    from { transform: translate(0,0); }
    to { transform: translate(-80px,-80px); }
}

/* Glass Card */
.login-card {
    width: 400px;
    backdrop-filter: blur(15px);
    background: rgba(255,255,255,0.1);
    border-radius: 15px;
    padding: 35px;
    color: white;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    animation: fadeSlide 1s ease;
    position: relative;
    z-index: 2;
}

@keyframes fadeSlide {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.login-card h3 {
    font-weight: 700;
}

.form-control {
    background: rgba(255,255,255,0.2);
    border: none;
    color: white;
}

.form-control:focus {
    background: rgba(255,255,255,0.3);
    color: white;
    box-shadow: none;
    border: 1px solid #fff;
}

.form-control::placeholder {
    color: rgba(255,255,255,0.7);
}

/* Animated Button */
.btn-login {
    background: white;
    color: #1b5e20;
    font-weight: 600;
    transition: 0.3s;
}

.btn-login:hover {
    background: #e8f5e9;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Error Alert */
.alert {
    animation: shake 0.4s ease;
}

@keyframes shake {
    0% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    50% { transform: translateX(5px); }
    75% { transform: translateX(-5px); }
    100% { transform: translateX(0); }
}

.logo-icon {
    font-size: 40px;
    margin-bottom: 10px;
}
</style>
</head>

<body>

<div class="login-card text-center">

    <div class="logo-icon">
        <i class="fas fa-leaf"></i>
    </div>

    <h3 class="mb-4">GreenEdge Admin</h3>

    <?php if ($error): ?>
        <div class="alert alert-danger py-2"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">

        <div class="mb-3 text-start">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3 text-start">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-login w-100 mt-3">
            Login
        </button>

    </form>

</div>

</body>
</html>