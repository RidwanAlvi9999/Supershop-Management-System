<?php
require_once "../config/database.php";
require_once "../core/security.php";
require_once "../core/session.php";

requireLogin();

$user_id = $_SESSION['user_id'] ?? 0;

// If form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $full_name = cleanInput($_POST['full_name'] ?? '');
    $phone     = cleanInput($_POST['phone'] ?? '');
    $address   = cleanInput($_POST['address'] ?? '');

    if (empty($full_name)) {
        die("Name is required");
    }

    $sql = "UPDATE users SET full_name = ?, phone = ?, address = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $full_name, $phone, $address, $user_id);
    mysqli_stmt_execute($stmt);

    header("Location: view.php");
    exit;
}

// Fetch existing data
$sql = "SELECT full_name, phone, address FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Safety fallback
$full_name = $user['full_name'] ?? '';
$phone     = $user['phone'] ?? '';
$address   = $user['address'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
</head>
<body>

<h2>Edit Profile</h2>

<form method="POST">

    <label>Full Name</label><br>
    <input type="text" name="full_name"
           value="<?= htmlspecialchars($full_name) ?>"><br><br>

    <label>Phone</label><br>
    <input type="text" name="phone"
           value="<?= htmlspecialchars($phone) ?>"><br><br>

    <label>Address</label><br>
    <textarea name="address"><?= htmlspecialchars($address) ?></textarea><br><br>

    <button type="submit">Update</button>
</form>

<br>

<a href="view.php">⬅ Back to Profile</a><br><br>

<a href="/supershop_mvc/auth/logout.php">Logout</a>


</body>
</html>