<?php
require_once "../config/database.php";
require_once "../core/session.php";

/**
 * Admin security check
 */
requireLogin();

if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header("Location: /supershop_mvc/unauthorized.php");
    exit;
}

/**
 * Update role name (optional feature)
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role_id   = $_POST['role_id'] ?? 0;
    $role_name = trim($_POST['role_name'] ?? '');

    if ($role_id > 0 && $role_name !== '') {
        $sql = "UPDATE roles SET role_name = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $role_name, $role_id);
        mysqli_stmt_execute($stmt);
    }
}

/**
 * Fetch roles
 */
$result = mysqli_query($conn, "SELECT * FROM roles ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Roles</title>
</head>
<body>

<h2>Manage Roles</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Role Name</th>
        <th>Action</th>
    </tr>

<?php while ($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= $row['id'] ?></td>

    <td>
        <form method="POST" style="margin:0;">
            <input type="hidden" name="role_id" value="<?= $row['id'] ?>">
            <input type="text" name="role_name"
                   value="<?= htmlspecialchars($row['role_name']) ?>">
    </td>

    <td>
            <button type="submit">Update</button>
        </form>
    </td>
</tr>
<?php endwhile; ?>

</table>

<br>
<a href="dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>
