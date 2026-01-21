<?php
class Auth {
    public static function check() {
        return isset($_SESSION['employee_id']);
    }
    
    public static function user() {
        if (self::check()) {
            return [
                'id' => $_SESSION['employee_id'],
                'name' => $_SESSION['employee_name'],
                'email' => $_SESSION['employee_email'],
                'role' => $_SESSION['employee_role']
            ];
        }
        return null;
    }
    
    public static function login($employee) {
        $_SESSION['employee_id'] = $employee['id'];
        $_SESSION['employee_name'] = $employee['name'];
        $_SESSION['employee_email'] = $employee['email'];
        $_SESSION['employee_role'] = $employee['role'];
    }
    
    public static function logout() {
        session_unset();
        session_destroy();
    }
    
    public static function id() {
        return $_SESSION['employee_id'] ?? null;
    }
}
?>