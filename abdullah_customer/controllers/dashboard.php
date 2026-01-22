<?php
require_once "../core/session.php";
require_once "../config/config.php";

requireLogin();

// customer-only access
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'customer') {
    header("Location: " . BASE_URL . "/unauthorized.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard</title>

    <!-- ✅ CSS using BASE_URL -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/dashboard.css">
</head>
<body>

<div class="dashboard-container">

    <h2>Customer Dashboard</h2>
    <p>Welcome, Customer!</p>

    <ul class="menu">
        <li>
            <a href="<?= BASE_URL ?>/customer/products.php">
                🛒 Browse Products
            </a>
        </li>

        <li>
            <a href="<?= BASE_URL ?>/customer/my_orders.php">
                📦 My Purchases
            </a>
        </li>

        <li>
            <a href="<?= BASE_URL ?>/customer/support.php">
                🆘 Customer Support
            </a>
        </li>

        <li>
            <a href="<?= BASE_URL ?>/customer/review.php">
                ⭐ Reviews & Ratings
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