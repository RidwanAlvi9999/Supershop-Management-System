<?php
require_once "../core/session.php";

requireLogin();

// employee-only access
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'employee') {
    header("Location: /supershop_mvc/unauthorized.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Dashboard</title>
</head>
<body>

<h2>Employee Dashboard</h2>
<p>Welcome, Employee!</p>

<h3>Employee Features</h3>
<ul>
    <li>
        <a href="/supershop_mvc/employee/tasks.php">
            View Assigned Tasks
        </a>
    </li>

    <li>
        <a href="/supershop_mvc/employee/tasks.php">
            Update Task Status
        </a>
    </li>

    <li>
        <a href="/supershop_mvc/employee/attendance_salary.php">
            View Attendance & Salary
        </a>
    </li>

    <li>
        <a href="/supershop_mvc/employee/apply_leave.php">
            Apply for Leave
        </a>
    </li>

    <!-- ✅ TEMPORARY DEBUG LINK (REMOVE AFTER TEST) -->
    <li>
        <a href="/supershop_mvc/employee/path_test.php">
            🔧 Path Test
        </a>
    </li>
</ul>

<hr>

<h3>Account</h3>
<a href="/supershop_mvc/profile/view.php">👤 View Profile</a><br><br>
<a href="/supershop_mvc/profile/change_password.php">🔑 Change Password</a><br><br>
<a href="/supershop_mvc/auth/logout.php">🚪 Logout</a>

</body>
</html>