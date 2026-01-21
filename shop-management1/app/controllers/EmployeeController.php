<?php
require_once __DIR__ . '/../models/EmployeeModel.php';
require_once __DIR__ . '/../../core/Auth.php';

class EmployeeController {
    private $employeeModel;
    
    public function __construct() {
        $this->employeeModel = new EmployeeModel();
    }
    
    public function getTasks() {
        $employeeId = Auth::id();
        return $this->employeeModel->getTasks($employeeId);
    }
    
    public function getAttendance() {
        $employeeId = Auth::id();
        return $this->employeeModel->getAttendance($employeeId);
    }
    
    public function markAttendance() {
        $employeeId = Auth::id();
        $this->employeeModel->markAttendance($employeeId);
        return ['success' => true, 'message' => 'Attendance marked successfully'];
    }
    
    public function getLeaves() {
        $employeeId = Auth::id();
        return $this->employeeModel->getLeaves($employeeId);
    }
    
    public function applyLeave() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                ':employee_id' => Auth::id(),
                ':start_date' => $_POST['start_date'],
                ':end_date' => $_POST['end_date'],
                ':reason' => $_POST['reason']
            ];
            
            $this->employeeModel->applyLeave($data);
            return ['success' => true, 'message' => 'Leave application submitted'];
        }
    }
}
?>