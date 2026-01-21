<?php
session_start();
require_once __DIR__ . '/../../../core/Auth.php';
require_once __DIR__ . '/../../models/EmployeeModel.php';

if (!Auth::check()) {
    header('Location: ../auth/login.php');
    exit();
}

$user = Auth::user();
$employeeModel = new EmployeeModel();

$taskStats = $employeeModel->getTaskStats(Auth::id());
$attendanceStats = $employeeModel->getAttendanceStats(Auth::id());
$leaveBalance = $employeeModel->getLeaveBalance(Auth::id());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Shop Management</title>
    <link rel="stylesheet" href="../../../public/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <h1>Shop Management</h1>
            <div class="nav-links">
                <a href="dashboard.php" class="active">Dashboard</a>
                <a href="tasks.php">Tasks</a>
                <a href="attendance.php">Attendance</a>
                <a href="leave.php">Leave</a>
                <a href="../../../logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="dashboard-header">
            <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h2>
            <p>Employee Dashboard</p>
        </div>

        <div class="dashboard-grid">
            <div class="card">
                <div class="card-icon">📋</div>
                <h3>My Tasks</h3>
                <p class="card-number"><?php echo $taskStats['total_tasks'] ?? 0; ?></p>
                <p class="card-text">Completed: <?php echo $taskStats['completed_tasks'] ?? 0; ?></p>
                <p class="card-text">In Progress: <?php echo $taskStats['in_progress_tasks'] ?? 0; ?></p>
                <a href="tasks.php" class="card-link">View All Tasks →</a>
            </div>

            <div class="card">
                <div class="card-icon">✓</div>
                <h3>Attendance</h3>
                <p class="card-number"><?php echo $attendanceStats['present_days'] ?? 0; ?> days</p>
                <p class="card-text">Total: <?php echo $attendanceStats['total_days'] ?? 0; ?> days</p>
                <p class="card-text">Absent: <?php echo $attendanceStats['absent_days'] ?? 0; ?> days</p>
                <a href="attendance.php" class="card-link">View History →</a>
            </div>

            <div class="card">
                <div class="card-icon">📅</div>
                <h3>Leave Balance</h3>
                <p class="card-number"><?php echo $leaveBalance; ?> days</p>
                <p class="card-text">Remaining leave days</p>
                <a href="leave.php" class="card-link">Apply Leave →</a>
            </div>

            <div class="card">
                <div class="card-icon">👤</div>
                <h3>Profile</h3>
                <p class="card-text"><strong><?php echo htmlspecialchars($user['name']); ?></strong></p>
                <p class="card-text"><?php echo htmlspecialchars($user['email']); ?></p>
                <p class="card-text">Role: <?php echo htmlspecialchars(ucfirst($user['role'])); ?></p>
            </div>
        </div>
    </div>
    
    <script src="../../../public/js/employee.js"></script>
</body>
</html>