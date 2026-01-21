<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>

    <!-- Correct CSS Path -->
    <link rel="stylesheet" href="/old/public/CSS/profile.css">
</head>
<body>

<div class="container">

    <div class="navbar">
        <a href="index.php?page=home">⬅ Back to Home</a> |
        <a href="index.php?page=logout">Logout</a>
    </div>

    <h2>My Profile</h2>

    <?php if (!empty($_SESSION['success'])): ?>
        <p class="success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
    <?php endif; ?>

    <form method="post" action="index.php?page=profile_update">

        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Gender:</label>
        <select name="gender">
            <option value="male" <?= $user['gender']=='male'?'selected':'' ?>>Male</option>
            <option value="female" <?= $user['gender']=='female'?'selected':'' ?>>Female</option>
        </select>

        <label>Phone:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">

        <label>Date of Birth:</label>
        <input type="date" name="dob" value="<?= $user['dob'] ?>">

        <label>New Password (optional):</label>
        <input type="password" name="password">

        <button type="submit">Update Profile</button>
    </form>

</div>

</body>
</html>
