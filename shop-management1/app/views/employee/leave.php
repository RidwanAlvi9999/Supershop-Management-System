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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $employeeController->applyLeave();
    if ($result && $result['success']) {
        $message = $result['message'];
        $messageType = 'success';
    } else {
        $message = $result['message'] ?? 'Failed to submit leave application';
        $messageType = 'error';
    }
}

$leaves = $employeeController->getLeaves();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave - Shop Management</title>
    <link rel="stylesheet" href="../../../public/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <h1>Shop Management</h1>
            <div class="nav-links">
                <a href="dashboard.php">Dashboard</a>
                <a href="tasks.php">Tasks</a>
                <a href="attendance.php">Attendance</a>
                <a href="leave.php" class="active">Leave</a>
                <a href="../../../logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="page-header">
            <h2>Leave Application</h2>
        </div>

        <?php if ($message): ?>
            <div class="alert <?php echo $messageType === 'success' ? 'alert-success' : ''; ?>" style="max-width: 600px; margin: 0 auto 20px;">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="form-box leave-form">
            <h3>Apply for Leave</h3>
            <form method="POST" action="">
                <div class="input-group">
                    <label>Start Date</label>
                    <input type="date" name="start_date" min="<?php echo date('Y-m-d'); ?>" required>
                </div>
                
                <div class="input-group">
                    <label>End Date</label>
                    <input type="date" name="end_date" min="<?php echo date('Y-m-d'); ?>" required>
                </div>
                
                <div class="input-group">
                    <label>Reason</label>
                    <textarea name="reason" rows="4" placeholder="Enter reason for leave..." required></textarea>
                </div>
                
                <button type="submit" class="btn">Submit Application</button>
            </form>
        </div>

        <div class="table-container" style="margin-top: 30px;">
            <h3>Leave History</h3>
            <?php if (empty($leaves)): ?>
                <div class="empty-state">
                    <p>📅 No leave applications found</p>
                    <p style="font-size: 14px; margin-top: 10px;">Submit your first leave application above</p>
                </div>
            <?php else: ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Days</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Applied On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($leaves as $leave): ?>
                            <?php
                            $start = new DateTime($leave['start_date']);
                            $end = new DateTime($leave['end_date']);
                            $days = $end->diff($start)->days + 1;
                            ?>
                            <tr>
                                <td><?php echo date('M d, Y', strtotime($leave['start_date'])); ?></td>
                                <td><?php echo date('M d, Y', strtotime($leave['end_date'])); ?></td>
                                <td><strong><?php echo $days; ?> day<?php echo $days > 1 ? 's' : ''; ?></strong></td>
                                <td><?php echo htmlspecialchars($leave['reason']); ?></td>
                                <td><span class="badge badge-<?php echo htmlspecialchars($leave['status']); ?>"><?php echo ucfirst(htmlspecialchars($leave['status'])); ?></span></td>
                                <td><?php echo date('M d, Y', strtotime($leave['created_at'])); ?></td>
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