<?php
require_once __DIR__ . '/../models/EmployeeModel.php';
require_once __DIR__ . '/../../core/Auth.php';

class AuthController {
    private $employeeModel;
    
    public function __construct() {
        $this->employeeModel = new EmployeeModel();
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'phone' => $_POST['phone'],
                'role' => 'employee'
            ];
            
            if ($this->employeeModel->findByEmail($data['email'])) {
                return ['success' => false, 'message' => 'Email already exists'];
            }
            
            $this->employeeModel->create($data);
            return ['success' => true, 'message' => 'Registration successful'];
        }
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $employee = $this->employeeModel->findByEmail($email);
            
            if ($employee && password_verify($password, $employee['password'])) {
                Auth::login($employee);
                return ['success' => true, 'message' => 'Login successful'];
            }
            
            return ['success' => false, 'message' => 'Invalid credentials'];
        }
    }
}
?>