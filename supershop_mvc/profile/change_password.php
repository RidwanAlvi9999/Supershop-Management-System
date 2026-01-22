<?php
require_once "../config/database.php";
require_once "../core/security.php";
require_once "../core/session.php";

requireLogin();

$user_id = $_SESSION['user_id'];
$message = "";

// Form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $current_password = $_POST['current_password'] ?? '';
    $new_password     = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Basic validation
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $message = "All fields are required";
    } elseif ($new_password !== $confirm_password) {
        $message = "New passwords do not match";
    } elseif (strlen($new_password) < 6) {
        $message = "Password must be at least 6 characters";
    } else {
        // Get current password from DB
        $sql = "SELECT password FROM users WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        // Verify current password
        if ($user && verifyPassword($current_password, $user['password'])) {

            $hashed = hashPassword($new_password);

            $update = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $update);
            mysqli_stmt_bind_param($stmt, "si", $hashed, $user_id);
            mysqli_stmt_execute($stmt);

            $message = "Password updated successfully";
        } else {
            $message = "Current password is incorrect";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
</head>
<body>

<h2>Change Password</h2>

<?php if ($message): ?>
    <p style="color:red;"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST">

    <label>Current Password</label><br>
    <input type="password" name="current_password"><br><br>

    <label>New Password</label><br>
    <input type="password" name="new_password"><br><br>

    <label>Confirm New Password</label><br>
    <input type="password" name="confirm_password"><br><br>

    <button type="submit">Change Password</button>
</form>

<br>
<a href="view.php">⬅ Back to Profile</a><br><br>
<a href="/supershop_mvc/auth/logout.php">Logout</a>


</body>
</html>
