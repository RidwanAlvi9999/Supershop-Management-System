<?php
require_once "../config/database.php";
require_once "../core/session.php";

requireLogin();

// employee-only
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'employee') {
    header("Location: /supershop_mvc/unauthorized.php");
    exit;
}

$employee_id = $_SESSION['user_id'];

// Update task status
if (isset($_GET['id'], $_GET['status'])) {
    $task_id = intval($_GET['id']);
    $status  = $_GET['status'];

    if (in_array($status, ['pending', 'in_progress', 'completed'])) {
        $sql = "UPDATE tasks 
                SET status = ? 
                WHERE id = ? AND employee_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sii", $status, $task_id, $employee_id);
        mysqli_stmt_execute($stmt);
    }
}

// Fetch employee tasks
$sql = "SELECT task_title, task_description, status 
        FROM tasks 
        WHERE employee_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $employee_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Tasks</title>
</head>
<body>

<h2>My Tasks</h2>

<table border="1" cellpadding="10">
<tr>
    <th>Title</th>
    <th>Description</th>
    <th>Status</th>
    <th>Update</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= htmlspecialchars($row['task_title']) ?></td>
    <td><?= htmlspecialchars($row['task_description']) ?></td>
    <td><?= $row['status'] ?></td>
    <td>
        <a href="?id=<?= $row['id'] ?? '' ?>&status=pending">Pending</a> |
        <a href="?id=<?= $row['id'] ?? '' ?>&status=in_progress">In Progress</a> |
        <a href="?id=<?= $row['id'] ?? '' ?>&status=completed">Completed</a>
    </td>
</tr>
<?php endwhile; ?>

</table>

<br>
<a href="dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>