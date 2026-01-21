<?php
require_once __DIR__ . '/../../core/Database.php';

class EmployeeModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function create($data) {
        $sql = "INSERT INTO employees (name, email, password, phone, role, created_at) 
                VALUES (:name, :email, :password, :phone, :role, NOW())";
        
        $params = [
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
            ':phone' => $data['phone'],
            ':role' => $data['role'] ?? 'employee'
        ];
        
        try {
            return $this->db->query($sql, $params);
        } catch (PDOException $e) {
            error_log("Create Employee Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function findByEmail($email) {
        $sql = "SELECT * FROM employees WHERE email = :email LIMIT 1";
        try {
            $stmt = $this->db->query($sql, [':email' => $email]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Find By Email Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function findById($id) {
        $sql = "SELECT * FROM employees WHERE id = :id LIMIT 1";
        try {
            $stmt = $this->db->query($sql, [':id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Find By ID Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getTasks($employeeId) {
        $sql = "SELECT * FROM tasks WHERE employee_id = :id ORDER BY created_at DESC";
        try {
            $stmt = $this->db->query($sql, [':id' => $employeeId]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get Tasks Error: " . $e->getMessage());
            return [];
        }
    }
    
    public function getAttendance($employeeId) {
        $sql = "SELECT * FROM attendance WHERE employee_id = :id ORDER BY date DESC LIMIT 30";
        try {
            $stmt = $this->db->query($sql, [':id' => $employeeId]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get Attendance Error: " . $e->getMessage());
            return [];
        }
    }
    
    public function getLeaves($employeeId) {
        $sql = "SELECT * FROM leaves WHERE employee_id = :id ORDER BY created_at DESC";
        try {
            $stmt = $this->db->query($sql, [':id' => $employeeId]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get Leaves Error: " . $e->getMessage());
            return [];
        }
    }
    
    public function markAttendance($employeeId) {
        $sql = "INSERT INTO attendance (employee_id, date, check_in, status) 
                VALUES (:id, CURDATE(), NOW(), 'present')
                ON DUPLICATE KEY UPDATE check_in = NOW(), status = 'present'";
        try {
            return $this->db->query($sql, [':id' => $employeeId]);
        } catch (PDOException $e) {
            error_log("Mark Attendance Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function applyLeave($data) {
        $sql = "INSERT INTO leaves (employee_id, start_date, end_date, reason, status, created_at) 
                VALUES (:employee_id, :start_date, :end_date, :reason, 'pending', NOW())";
        try {
            return $this->db->query($sql, $data);
        } catch (PDOException $e) {
            error_log("Apply Leave Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getAllEmployees() {
        $sql = "SELECT id, name, email, phone, role, created_at FROM employees ORDER BY created_at DESC";
        try {
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get All Employees Error: " . $e->getMessage());
            return [];
        }
    }
    
    public function updateEmployee($id, $data) {
        $sql = "UPDATE employees SET name = :name, email = :email, phone = :phone, role = :role WHERE id = :id";
        $params = [
            ':id' => $id,
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':phone' => $data['phone'],
            ':role' => $data['role']
        ];
        
        try {
            return $this->db->query($sql, $params);
        } catch (PDOException $e) {
            error_log("Update Employee Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function deleteEmployee($id) {
        $sql = "DELETE FROM employees WHERE id = :id";
        try {
            return $this->db->query($sql, [':id' => $id]);
        } catch (PDOException $e) {
            error_log("Delete Employee Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getTodayAttendance($employeeId) {
        $sql = "SELECT * FROM attendance WHERE employee_id = :id AND date = CURDATE() LIMIT 1";
        try {
            $stmt = $this->db->query($sql, [':id' => $employeeId]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Get Today Attendance Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getAttendanceStats($employeeId) {
        $sql = "SELECT 
                    COUNT(*) as total_days,
                    SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present_days,
                    SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent_days
                FROM attendance 
                WHERE employee_id = :id";
        try {
            $stmt = $this->db->query($sql, [':id' => $employeeId]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Get Attendance Stats Error: " . $e->getMessage());
            return ['total_days' => 0, 'present_days' => 0, 'absent_days' => 0];
        }
    }
    
    public function getTaskStats($employeeId) {
        $sql = "SELECT 
                    COUNT(*) as total_tasks,
                    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_tasks,
                    SUM(CASE WHEN status = 'in-progress' THEN 1 ELSE 0 END) as in_progress_tasks,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_tasks
                FROM tasks 
                WHERE employee_id = :id";
        try {
            $stmt = $this->db->query($sql, [':id' => $employeeId]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Get Task Stats Error: " . $e->getMessage());
            return ['total_tasks' => 0, 'completed_tasks' => 0, 'in_progress_tasks' => 0, 'pending_tasks' => 0];
        }
    }
    
    public function getLeaveBalance($employeeId) {
        $sql = "SELECT 
                    COUNT(*) as total_leaves,
                    SUM(DATEDIFF(end_date, start_date) + 1) as days_taken
                FROM leaves 
                WHERE employee_id = :id AND status = 'approved'";
        try {
            $stmt = $this->db->query($sql, [':id' => $employeeId]);
            $result = $stmt->fetch();
            $total_allowed = 20; 
            $days_taken = $result['days_taken'] ?? 0;
            return $total_allowed - $days_taken;
        } catch (PDOException $e) {
            error_log("Get Leave Balance Error: " . $e->getMessage());
            return 20;
        }
    }
}
?>