<?php
require_once "../config/config.php";
require_once "../core/session.php";

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once "../config/database.php";
    require_once "../core/security.php";

    $name     = cleanInput($_POST['name'] ?? '');
    $email    = cleanInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$name || !$email || !$password) {
        $error = "All fields are required.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // default role = customer
        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO users (full_name, email, password, role_id)
             VALUES (?, ?, ?, (SELECT id FROM roles WHERE role_name='customer'))"
        );
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hash);

        if (mysqli_stmt_execute($stmt)) {
            $success = "Account created successfully! You can login now.";
        } else {
            $error = "Email already exists.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Create Account</title>

    <!-- SAME CSS AS LOGIN -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/login.css">
</head>
<body>

<div class="login-box">

    <h2>Create Account</h2>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="background:#d1e7dd;color:#0f5132;padding:10px;border-radius:4px;text-align:center;">
            <?= htmlspecialchars($success) ?>
        </p>
    <?php endif; ?>

    <form method="POST">

        <label>Full Name</label>
        <input type="text" name="name" required placeholder="Your name">

        <label>Email</label>
        <input type="email" name="email" required placeholder="example@email.com">

        <label>Password</label>
        <input type="password" name="password" required placeholder="••••••••">

        <button type="submit">Register</button>

    </form>

    <p class="register-link">
        Already have an account?
        <a href="<?= BASE_URL ?>/auth/login.php">Login here</a>
    </p>

</div>

</body>
</html>