<?php
require_once "../config/database.php";
require_once "../core/security.php";

// Allow only POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request");
}

// Get & clean inputs
$full_name = cleanInput($_POST['full_name'] ?? '');
$email     = cleanInput($_POST['email'] ?? '');
$password  = $_POST['password'] ?? '';
$role_id   = $_POST['role_id'] ?? '';

// PHP Validation
$errors = [];

if (!isRequired($full_name)) {
    $errors[] = "Full name is required";
}

if (!validateEmail($email)) {
    $errors[] = "Invalid email address";
}

if (strlen($password) < 6) {
    $errors[] = "Password must be at least 6 characters";
}

if (!in_array($role_id, ['1', '2', '3'])) {
    $errors[] = "Invalid role selected";
}

// If validation fails
if (!empty($errors)) {
    echo "<h3>Registration Error:</h3>";
    foreach ($errors as $error) {
        echo "<p>$error</p>";
    }
    echo '<a href="register.php">Go Back</a>';
    exit;
}

// Check if email already exists
$checkSql = "SELECT id FROM users WHERE email = ?";
$stmt = mysqli_prepare($conn, $checkSql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    echo "Email already registered. <a href='login.php'>Login</a>";
    exit;
}
mysqli_stmt_close($stmt);

// Hash password
$hashedPassword = hashPassword($password);

// Insert user
$sql = "INSERT INTO users (role_id, full_name, email, password) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "isss", $role_id, $full_name, $email, $hashedPassword);

if (mysqli_stmt_execute($stmt)) {
    header("Location: login.php?success=registered");
    exit;
} else {
    echo "Registration failed. Try again.";
}

mysqli_stmt_close($stmt);