<?php
require_once "../core/session.php";
require_once "../config/config.php";

requireLogin();

// strict admin check
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header("Location: " . BASE_URL . "/unauthorized.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <!-- ✅ CSS using BASE_URL -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/dashboard.css">
</head>
<body>

<div class="dashboard-container">

    <h2>Admin Dashboard</h2>
    <p>Welcome, Admin!</p>

    <ul class="menu">
        <li>
            <a href="<?= BASE_URL ?>/admin/users.php">
                Manage Users
            </a>
        </li>

        <li>
            <a href="<?= BASE_URL ?>/admin/roles.php">
                Manage Roles
            </a>
        </li>

        <li>
            <a href="<?= BASE_URL ?>/admin/tasks.php">
                Assign Tasks
            </a>
        </li>

        <li>
            <a href="<?= BASE_URL ?>/admin/reports.php">
                View Reports
            </a>
        </li>

        <li>
            <a href="<?= BASE_URL ?>/admin/leaves.php">
                Approve Leaves
            </a>
        </li>
    </ul>

    <div class="bottom-links">
        <a href="<?= BASE_URL ?>/profile/view.php">
            👤 View Profile
        </a>

        <a href="<?= BASE_URL ?>/profile/change_password.php">
            🔑 Change Password
        </a>

        <a href="<?= BASE_URL ?>/auth/logout.php" class="logout">
            🚪 Logout
        </a>
    </div>

</div>

</body>
</html>