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
    $result = $authController->register();
    
    if ($result && $result['success']) {
        $message = 'Registration successful! Please login.';
        $messageType = 'success';

        header("refresh:2;url=login.php");
    } else {
        $message = $result['message'] ?? 'Registration failed. Please try again.';
        $messageType = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Shop Management</title>
    <link rel="stylesheet" href="../../../public/css/style.css">
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h2>📝 Employee Registration</h2>
            <?php if ($message): ?>
                <div class="alert <?php echo $messageType === 'success' ? 'alert-success' : ''; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="input-group">
                    <label>Full Name</label>
                    <input type="text" name="name" placeholder="Enter your full name" required>
                </div>
                
                <div class="input-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                
                <div class="input-group">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" placeholder="Enter your phone number" required>
                </div>
                
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Create a password" minlength="6" required>
                </div>
                
                <button type="submit" class="btn">Register</button>
            </form>
            
            <p class="form-footer">
                Already have an account? <a href="login.php">Login here</a>
            </p>
        </div>
    </div>
    
    <script src="../../../public/js/employee.js"></script>
</body>
</html>