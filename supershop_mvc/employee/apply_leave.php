<?php
require_once "../config/database.php";
require_once "../core/session.php";

requireLogin();

// employee-only
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'employee') {
    header("Location: /supershop_mvc/unauthorized.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = "";

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $leave_date = $_POST['leave_date'] ?? '';
    $reason     = trim($_POST['reason'] ?? '');

    if ($leave_date && $reason) {
        $sql = "INSERT INTO leaves (user_id, leave_date, reason)
                VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iss", $user_id, $leave_date, $reason);
        mysqli_stmt_execute($stmt);

        $message = "Leave request submitted successfully";
    } else {
        $message = "All fields are required";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Apply for Leave</title>
</head>
<body>

<h2>Apply for Leave</h2>

<?php if ($message): ?>
<p style="color:green;"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST">
    <label>Leave Date</label><br>
    <input type="date" name="leave_date" required><br><br>

    <label>Reason</label><br>
    <textarea name="reason" required></textarea><br><br>

    <button type="submit">Submit Leave Request</button>
</form>

<br>
<a href="dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>