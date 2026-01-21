<?php
session_start();
require_once __DIR__ . '/../../../core/Auth.php';
require_once __DIR__ . '/../../controllers/EmployeeController.php';

if (!Auth::check()) {
    header('Location: ../auth/login.php');
    exit();
}

$employeeController = new EmployeeController();

$message = '';
$messageType = 'success';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_attendance'])) {
    $result = $employeeController->markAttendance();
    if ($result['success']) {
        $message = $result['message'];
        $messageType = 'success';
    } else {
        $message = $result['message'] ?? 'Failed to mark attendance';
        $messageType = 'error';
    }
}

$attendance = $employeeController->getAttendance();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance - Shop Management</title>
    <link rel="stylesheet" href="../../../public/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <h1>Shop Management</h1>
            <div class="nav-links">
                <a href="dashboard.php">Dashboard</a>
                <a href="tasks.php">Tasks</a>
                <a href="attendance.php" class="active">Attendance</a>
                <a href="leave.php">Leave</a>
                <a href="../../../logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="page-header">
            <h2>Attendance</h2>
            <form method="POST" style="display: inline;">
                <button type="submit" name="mark_attendance" class="btn" style="width: auto; padding: 12px 30px;">Mark Today's Attendance</button>
            </form>
        </div>

        <?php if ($message): ?>
            <div class="alert <?php echo $messageType === 'success' ? 'alert-success' : ''; ?>" style="max-width: 600px; margin: 0 auto 20px;">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="table-container">
            <?php if (empty($attendance)): ?>
                <div class="empty-state">
                    <p>✓ No attendance records found</p>
                    <p style="font-size: 14px; margin-top: 10px;">Mark your first attendance above</p>
                </div>
            <?php else: ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($attendance as $record): ?>
                            <tr>
                                <td><?php echo date('l, M d, Y', strtotime($record['date'])); ?></td>
                                <td><?php echo $record['check_in'] ? date('h:i A', strtotime($record['check_in'])) : '-'; ?></td>
                                <td><?php echo isset($record['check_out']) && $record['check_out'] ? date('h:i A', strtotime($record['check_out'])) : '-'; ?></td>
                                <td><span class="badge badge-<?php echo htmlspecialchars($record['status']); ?>"><?php echo ucfirst(htmlspecialchars($record['status'])); ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="../../../public/js/employee.js"></script>
</body>
</html>