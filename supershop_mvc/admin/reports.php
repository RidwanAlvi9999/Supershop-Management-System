<?php
require_once "../config/database.php";
require_once "../core/session.php";

requireLogin();

if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header("Location: /supershop_mvc/unauthorized.php");
    exit;
}

// Simple report
$totalUsers = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM users")
)['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Reports</title>
</head>
<body>

<h2>View Reports</h2>
<p>Total Users: <?= $totalUsers ?></p>

<a href="dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>
