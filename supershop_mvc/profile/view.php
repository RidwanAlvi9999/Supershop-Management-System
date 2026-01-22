<?php
require_once "../config/database.php";
require_once "../core/session.php";

requireLogin();

$user_id = $_SESSION['user_id'];

$sql = "SELECT full_name, email, phone, address FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
</head>
<body>

<h2>My Profile</h2>

<p><strong>Name:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
<p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
<p><strong>Address:</strong> <?= htmlspecialchars($user['address']) ?></p>

<a href="update.php">Edit Profile</a><br><br>
<a href="/supershop_mvc/auth/logout.php">Logout</a>



</body>
</html>
