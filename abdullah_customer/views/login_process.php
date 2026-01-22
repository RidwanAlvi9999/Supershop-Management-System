<?php
require_once "../config/config.php";
require_once "../config/database.php";
require_once "../core/session.php";

// Allow POST only
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
}

// Get form data
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Basic validation
if ($email === '' || $password === '') {
    header("Location: " . BASE_URL . "/auth/login.php?error=1");
    exit;
}

// Fetch user
$sql = "
    SELECT u.id, u.password, r.role_name
    FROM users u
    JOIN roles r ON u.role_id = r.id
    WHERE u.email = ? AND u.status = 'active'
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($user = mysqli_fetch_assoc($result)) {

    // Verify password
    if (password_verify($password, $user['password'])) {

        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role']    = $user['role_name'];

        // Redirect by role
        if ($user['role_name'] === 'admin') {
            header("Location: " . BASE_URL . "/admin/dashboard.php");
        } elseif ($user['role_name'] === 'employee') {
            header("Location: " . BASE_URL . "/employee/dashboard.php");
        } else {
            header("Location: " . BASE_URL . "/customer/dashboard.php");
        }
        exit;
    }
}

// Login failed
header("Location: " . BASE_URL . "/auth/login.php?error=1");
exit;