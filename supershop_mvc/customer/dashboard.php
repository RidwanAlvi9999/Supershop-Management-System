<?php
require_once "../core/session.php";

requireLogin();
requireRole(['customer']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Dashboard</title>
</head>
<body>

<h2>Customer Dashboard</h2>
<p>Welcome, Customer!</p>

<ul>
    <li><a href="#">Browse Products</a></li>
    <li><a href="#">My Purchases</a></li>
    <li><a href="#">Cancel Contract</a></li>
    <li><a href="#">Support & Reviews</a></li>
</ul>

<hr>

<!-- ✅ PROFILE LINKS (ADDED) -->
<a href="/supershop_mvc/profile/view.php">👤 View Profile</a><br><br>
<a href="/supershop_mvc/profile/change_password.php">🔑 Change Password</a><br><br>

<!-- LOGOUT -->
<a href="/supershop_mvc/auth/logout.php">🚪 Logout</a>

</body>
</html>