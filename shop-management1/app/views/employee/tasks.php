<?php
session_start();
require_once __DIR__ . '/../../../core/Auth.php';
require_once __DIR__ . '/../../controllers/EmployeeController.php';

if (!Auth::check()) {
    header('Location: ../auth/login.php');
    exit();
}

$employeeController = new EmployeeController();
$tasks = $employeeController->getTasks();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks - Shop Management</title>
    <link rel="stylesheet" href="../../../public/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <h1>Shop Management</h1>
            <div class="nav-links">
                <a href="dashboard.php">Dashboard</a>
                <a href="tasks.php" class="active">Tasks</a>
                <a href="attendance.php">Attendance</a>
                <a href="leave.php">Leave</a>
                <a href="../../../logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="page-header">
            <h2>My Tasks</h2>
        </div>

        <div class="table-container">
            <?php if (empty($tasks)): ?>
                <div class="empty-state">
                    <p>📋 No tasks assigned yet</p>
                    <p style="font-size: 14px; margin-top: 10px;">Check back later for new assignments</p>
                </div>
            <?php else: ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Task Title</th>
                            <th>Description</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($task['title']); ?></strong></td>
                                <td><?php echo htmlspecialchars($task['description'] ?? 'No description'); ?></td>
                                <td><span class="badge badge-<?php echo htmlspecialchars($task['priority']); ?>"><?php echo ucfirst(htmlspecialchars($task['priority'])); ?></span></td>
                                <td><span class="badge badge-<?php echo str_replace('-', '', htmlspecialchars($task['status'])); ?>"><?php echo ucfirst(str_replace('-', ' ', htmlspecialchars($task['status']))); ?></span></td>
                                <td><?php echo $task['due_date'] ? date('M d, Y', strtotime($task['due_date'])) : 'No due date'; ?></td>
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