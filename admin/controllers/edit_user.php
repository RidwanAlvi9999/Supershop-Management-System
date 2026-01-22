<?php
require_once "../config/database.php";
require_once "../core/session.php";

requireLogin();
requireRole(['admin']);

$user_id = $_GET['id'] ?? 0;

// Fetch user
$sql = "SELECT id, role_id, status FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$user) {
    die("User not found");
}

// Update on submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role_id = $_POST['role_id'];
    $status  = $_POST['status'];

    $update = "UPDATE users SET role_id = ?, status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $update);
    mysqli_stmt_bind_param($stmt, "isi", $role_id, $status, $user_id);
    mysqli_stmt_execute($stmt);

    header("Location: users.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>

<h2>Edit User</h2>

<form method="POST">
    <label>Role</label><br>
    <select name="role_id">
        <option value="1" <?= $user['role_id']==1?'selected':'' ?>>Admin</option>
        <option value="2" <?= $user['role_id']==2?'selected':'' ?>>Employee</option>
        <option value="3" <?= $user['role_id']==3?'selected':'' ?>>Customer</option>
    </select><br><br>

    <label>Status</label><br>
    <select name="status">
        <option value="active" <?= $user['status']=='active'?'selected':'' ?>>Active</option>
        <option value="inactive" <?= $user['status']=='inactive'?'selected':'' ?>>Inactive</option>
    </select><br><br>

    <button type="submit">Update User</button>
</form>

<br>
<a href="users.php">⬅ Back to Users</a>

</body>
</html>
