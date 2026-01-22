<?php
require_once "../config/database.php";
require_once "../core/session.php";

requireLogin();

// customer-only
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'customer') {
    header("Location: /supershop_mvc/unauthorized.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if ($subject !== "" && $message !== "") {
        $sql = "INSERT INTO support_messages (user_id, subject, message)
                VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iss", $user_id, $subject, $message);
        mysqli_stmt_execute($stmt);

        $success = true;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Support</title>
</head>
<body>

<h2>🆘 Customer Support</h2>

<?php if ($success): ?>
    <p style="color:green;">Support message sent successfully.</p>
<?php endif; ?>

<form method="POST">
    <label>Subject</label><br>
    <input type="text" name="subject" required><br><br>

    <label>Message</label><br>
    <textarea name="message" required></textarea><br><br>

    <button type="submit">Send</button>
</form>

<br>
<a href="/supershop_mvc/customer/dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>