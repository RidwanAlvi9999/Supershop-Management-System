<?php
require_once "../config/database.php";
require_once "../core/session.php";

requireLogin();

// admin only
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header("Location: /supershop_mvc/unauthorized.php");
    exit;
}

/* ---------- ASSIGN TASK ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $employee_id = (int)$_POST['employee_id'];
    $title = trim($_POST['title']);

    if ($employee_id && $title) {

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO tasks (employee_id, task_title)
             VALUES (?, ?)"
        );
        mysqli_stmt_bind_param($stmt, "is", $employee_id, $title);
        mysqli_stmt_execute($stmt);
    }
}

/* Fetch employees */
$employees = mysqli_query(
    $conn,
    "SELECT id, full_name
     FROM users
     WHERE role_id = (SELECT id FROM roles WHERE role_name='employee')"
);

/* ✅ FIX: use task_status instead of status */
$tasks = mysqli_query(
    $conn,
    "SELECT t.task_title, t.task_status, u.full_name
     FROM tasks t
     JOIN users u ON t.employee_id = u.id
     ORDER BY t.created_at DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Tasks</title>
</head>
<body>

<h2>🗂 Assign Tasks to Employees</h2>

<form method="POST">
    <label>Employee</label><br>
    <select name="employee_id" required>
        <option value="">Select Employee</option>
        <?php while ($e = mysqli_fetch_assoc($employees)): ?>
            <option value="<?= $e['id'] ?>">
                <?= htmlspecialchars($e['full_name']) ?>
            </option>
        <?php endwhile; ?>
    </select><br><br>

    <label>Task</label><br>
    <input type="text" name="title" required><br><br>

    <button type="submit">Assign Task</button>
</form>

<hr>

<h3>📋 Assigned Tasks</h3>

<table border="1" cellpadding="10">
<tr>
    <th>Employee</th>
    <th>Task</th>
    <th>Status</th>
</tr>

<?php while ($t = mysqli_fetch_assoc($tasks)): ?>
<tr>
    <td><?= htmlspecialchars($t['full_name']) ?></td>
    <td><?= htmlspecialchars($t['task_title']) ?></td>
    <!-- ✅ FIX HERE -->
    <td><?= ucfirst($t['task_status']) ?></td>
</tr>
<?php endwhile; ?>
</table>

<br>
<a href="/supershop_mvc/admin/dashboard.php">⬅ Back</a>

</body>
</html>