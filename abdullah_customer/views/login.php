<?php
require_once "../config/config.php";
require_once "../core/session.php";

// If already logged in, redirect by role
if (isLoggedIn()) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: " . BASE_URL . "/admin/dashboard.php");
    } elseif ($_SESSION['role'] === 'employee') {
        header("Location: " . BASE_URL . "/employee/dashboard.php");
    } else {
        header("Location: " . BASE_URL . "/customer/dashboard.php");
    }
    exit;
}

$error = isset($_GET['error']) ? "Invalid email or password" : "";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>User Login</title>

    <!-- Login Page CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/login.css">
</head>
<body>

<div class="login-box">

    <h2>User Login</h2>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <!-- ✅ FORM WITH CORRECT ACTION -->
    <form method="POST" action="<?= BASE_URL ?>/auth/login_process.php">

        <label>Email</label>
        <input type="email" name="email" placeholder="ridwan@admin.com" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="••••••••" required>

        <button type="submit">Login</button>

    </form>

    <p class="register-link">
        Don’t have an account?
        <a href="<?= BASE_URL ?>/auth/register.php">Create new account</a>
    </p>

</div>

</body>
</html>