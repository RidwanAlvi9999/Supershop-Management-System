<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <script>
        function validateLogin() {
            let email = document.forms["loginForm"]["email"].value;
            let password = document.forms["loginForm"]["password"].value;

            if (email === "" || password === "") {
                alert("Email and password are required");
                return false;
            }

            if (!email.includes("@")) {
                alert("Invalid email format");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>

<h2>User Login</h2>

<?php
if (isset($_GET['success'])) {
    echo "<p style='color:green;'>Registration successful! Please login.</p>";
}

if (isset($_GET['error'])) {
    echo "<p style='color:red;'>Invalid email or password.</p>";
}
?>

<form name="loginForm" method="POST" action="login_action.php" onsubmit="return validateLogin();">

    <label>Email</label><br>
    <input type="email" name="email"><br><br>

    <label>Password</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit">Login</button>

</form>

<br>
<a href="register.php">Create new account</a>

</body>
</html>