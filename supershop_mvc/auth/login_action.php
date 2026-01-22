<?php
require_once "../config/database.php";
require_once "../core/security.php";
require_once "../core/session.php";

// Allow POST only
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /supershop_mvc/auth/login.php");
    exit;
}

// Get input
$email    = cleanInput($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// PHP Validation
if (!validateEmail($email) || empty($password)) {
    header("Location: /supershop_mvc/auth/login.php?error=1");
    exit;
}

// Fetch user
$sql = "
    SELECT users.id, users.password, roles.role_name
    FROM users
    JOIN roles ON users.role_id = roles.id
    WHERE users.email = ? AND users.status = 'active'
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($user = mysqli_fetch_assoc($result)) {

    // Verify password
    if (verifyPassword($password, $user['password'])) {

        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role_name'];


        // Redirect by role (ABSOLUTE PATHS)
        if ($user['role_name'] === 'admin') {
            header("Location: /supershop_mvc/admin/dashboard.php");
        } elseif ($user['role_name'] === 'employee') {
            header("Location: /supershop_mvc/employee/dashboard.php");
        } else {
            header("Location: /supershop_mvc/customer/dashboard.php");
        }
        exit;
    }
}

// Login failed
header("Location: /supershop_mvc/auth/login.php?error=1");
exit;
