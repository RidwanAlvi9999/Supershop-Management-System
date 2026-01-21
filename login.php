<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- LOGIN CSS -->
    <link rel="stylesheet" href="/old/public/CSS/login.css">
</head>
<body>

<div class="login-container">

    <div class="login-box">
        <h3>Sign In</h3>

        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- LOGIN TABLE FORM -->
<form method="post" onsubmit="return validateLogin(this)">

            <table class="login-table">
                <tr>
                    <td>Email</td>
                    <td><input type="email" name="email" required></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit">Login</button>
                    </td>
                </tr>
            </table>
        </form>

        <div class="login-footer">
            <a href="index.php?page=forgot">Forgot your password?</a>
        </div>

        <!-- NEW BUTTON -->
        <div class="login-footer">
            <a class="register-link" href="index.php?page=register">
                Don’t have an account? Register
            </a>
        </div>

    </div>

</div>

</body>
</html>
<script src="/old/public/js/validation.js"></script>

