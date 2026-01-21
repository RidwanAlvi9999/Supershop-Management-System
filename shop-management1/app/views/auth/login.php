<?php
session_start();
require_once __DIR__ . '/../../../core/Auth.php';
require_once __DIR__ . '/../../controllers/AuthController.php';

if (Auth::check()) {
    header('Location: ../employee/dashboard.php');
    exit();
}

$message = '';
$messageType = 'error';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController = new AuthController();
    $result = $authController->login();
    
    if ($result && $result['success']) {
        header('Location: ../employee/dashboard.php');
        exit();
    } else {
        $message = $result['message'] ?? 'Login failed. Please try again.';
        $messageType = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Shop Management</title>
    <link rel="stylesheet" href="../../../public/css/style.css">
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h2>🔐 Employee Login</h2>
            <?php if ($message): ?>
                <div class="alert <?php echo $messageType === 'success' ? 'alert-success' : ''; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="input-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>
                
                <button type="submit" class="btn">Login</button>
            </form>
            
            <p class="form-footer">
                Don't have an account? <a href="register.php">Register here</a>
            </p>
        </div>
    </div>
    
    <script src="../../../public/js/employee.js"></script>
</body>
</html>