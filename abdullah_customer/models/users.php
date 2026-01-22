<?php
require_once "../config/database.php";
require_once "../core/session.php";

/**
 * SECURITY CHECK
 */
requireLogin();

// normalize role check (case-safe)
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header("Location: /supershop_mvc/unauthorized.php");
    exit;
}

/**
 * FETCH USERS
 */
$sql = "
    SELECT users.id, users.full_name, users.email, users.status, roles.role_name
    FROM users
    JOIN roles ON users.role_id = roles.id
    ORDER BY users.id DESC
";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
</head>
<body>

<h2>Manage Users</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

<?php while ($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlspecialchars($row['full_name']) ?></td>
    <td><?= htmlspecialchars($row['email']) ?></td>
    <td><?= htmlspecialchars($row['role_name']) ?></td>
    <td><?= htmlspecialchars($row['status']) ?></td>
    <td>
        <a href="edit_user.php?id=<?= $row['id'] ?>">Edit</a>
    </td>
</tr>
<?php endwhile; ?>

</table>

<br>
<a href="dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>
