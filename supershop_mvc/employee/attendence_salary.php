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
    <title>Attendance & Salary</title>
</head>
<body>

<h2>Attendance & Salary</h2>

<h3>Attendance Summary</h3>
<ul>
    <li>Total Working Days: 22</li>
    <li>Present Days: 20</li>
    <li>Absent Days: 2</li>
</ul>

<h3>Salary Details</h3>
<ul>
    <li>Basic Salary: 20,000 BDT</li>
    <li>Deductions: 1,000 BDT</li>
    <li><strong>Net Salary: 19,000 BDT</strong></li>
</ul>

<p><em>This is demo data for academic project presentation.</em></p>

<hr>

<a href="/supershop_mvc/employee/dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>