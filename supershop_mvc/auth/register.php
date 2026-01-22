<?php
require_once "../core/security.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <script>
        function validateForm() {
            let name = document.forms["regForm"]["full_name"].value;
            let email = document.forms["regForm"]["email"].value;
            let password = document.forms["regForm"]["password"].value;

            if (name === "" || email === "" || password === "") {
                alert("All fields are required");
                return false;
            }

            if (!email.includes("@")) {
                alert("Invalid email");
                return false;
            }

            if (password.length < 6) {
                alert("Password must be at least 6 characters");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>

<h2>User Registration</h2>

<form name="regForm" method="POST" action="register_action.php" onsubmit="return validateForm();">

    <label>Full Name</label><br>
    <input type="text" name="full_name"><br><br>

    <label>Email</label><br>
    <input type="email" name="email"><br><br>

    <label>Password</label><br>
    <input type="password" name="password"><br><br>

    <label>User Role</label><br>
    <select name="role_id">
        <option value="1">Admin</option>
        <option value="2">Employee</option>
        <option value="3">Customer</option>
    </select><br><br>

    <button type="submit">Register</button>

</form>

<a href="login.php">Already have an account? Login</a>

</body>
</html>