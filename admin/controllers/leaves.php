<?php
require_once "../config/database.php";
require_once "../core/session.php";

requireLogin();

if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header("Location: /supershop_mvc/unauthorized.php");
    exit;
}

// handle approve / reject
if (isset($_GET['action'], $_GET['id'])) {
    $id = (int)$_GET['id'];
    $action = $_GET['action'];

    if (in_array($action, ['approved', 'rejected'])) {
        $stmt = mysqli_prepare(
            $conn,
            "UPDATE leaves SET leave_status=? WHERE id=?"
        );
        mysqli_stmt_bind_param($stmt, "si", $action, $id);
        mysqli_stmt_execute($stmt);
    }

    header("Location: leaves.php");
    exit;
}

$sql = "
    SELECT 
        l.id,
        u.full_name,
        l.reason,
        l.leave_status,
        l.applied_at
    FROM leaves l
    JOIN users u ON l.employee_id = u.id
    ORDER BY l.applied_at DESC
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Approve Leaves</title>
</head>
<body>

<h2>📝 Approve Leave Requests</h2>

<?php if (mysqli_num_rows($result) === 0): ?>
    <p>No leave requests found.</p>
<?php else: ?>

<table border="1" cellpadding="10">
<tr>
    <th>Employee</th>
    <th>Reason</th>
    <th>Status</th>
    <th>Applied At</th>
    <th>Action</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= htmlspecialchars($row['full_name']) ?></td>
    <td><?= htmlspecialchars($row['reason']) ?></td>
    <td><?= ucfirst($row['leave_status']) ?></td>
    <td><?= htmlspecialchars($row['applied_at']) ?></td>
    <td>
        <?php if ($row['leave_status'] === 'pending'): ?>
            <a href="?action=approved&id=<?= $row['id'] ?>">✅ Approve</a> |
            <a href="?action=rejected&id=<?= $row['id'] ?>">❌ Reject</a>
        <?php else: ?>
            Done
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</table>

<?php endif; ?>

<br>
<a href="/supershop_mvc/admin/dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>