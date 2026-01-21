<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <!-- CSS -->
    <link rel="stylesheet" href="/old/public/CSS/register.css">
</head>
<body>

<div class="container">
    <div class="form-box">
        <h3>Register</h3>

        <form method="post" action="index.php?page=register" onsubmit="return validateRegister(this)">
            <input name="name" required placeholder="Full Name">

            <input type="email" name="email" required placeholder="Email">

            <select name="gender" required>
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>

            <input name="phone" required placeholder="Phone Number">

            <input type="date" name="dob" required>

            <input type="password" name="password" required placeholder="Password">

            <button type="submit">Register</button>
        </form>

        <!-- New Buttons -->
        <div class="bottom-buttons">
            <a class="btn" href="index.php?page=login">Already registered? Login</a>
            <a class="btn btn-secondary" href="index.php">Back to Home</a>
        </div>
    </div>
</div>

</body>
</html>
<script src="/old/public/js/validation.js"></script>

