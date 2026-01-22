<?php
require_once "../core/session.php";

requireLogin();

// strict admin check
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header("Location: /supershop_mvc/unauthorized.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>

<h2>Admin Dashboard</h2>
<p>Welcome, Admin!</p>

<ul>
    <li><a href="/supershop_mvc/admin/users.php">Manage Users</a></li>
    <li><a href="/supershop_mvc/admin/roles.php">Manage Roles</a></li>
    <li><a href="/supershop_mvc/admin/reports.php">View Reports</a></li>
    <li><a href="/supershop_mvc/admin/approve_leaves.php">Approve Leaves</a></li>
</ul>

<hr>

<a href="/supershop_mvc/profile/view.php">👤 View Profile</a><br><br>
<a href="/supershop_mvc/profile/change_password.php">🔑 Change Password</a><br><br>
<a href="/supershop_mvc/auth/logout.php">🚪 Logout</a>

</body>
</html>