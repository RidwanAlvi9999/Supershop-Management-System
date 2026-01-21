<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {

    private $user;

    public function __construct(){
        $this->user = new User();
    }

    
    public function register(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // JSON request check
            $isJson = isset($_SERVER['HTTP_X_REQUESTED_WITH']);

            if (strlen($_POST['password']) < 6) {
                return $this->respond($isJson, false, "Password must be at least 6 characters");
            }

            $result = $this->user->register($_POST);

            if (!$result) {
                return $this->respond($isJson, false, "Email already registered");
            }

            return $this->respond(
                $isJson,
                true,
                "Registration successful",
                "index.php?page=login"
            );
        }

        require __DIR__ . '/../views/auth/register.php';
    }

   
    public function login(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $isJson = isset($_SERVER['HTTP_X_REQUESTED_WITH']);

            $u = $this->user->findByEmail($_POST['email']);

            if (!$u) {
                return $this->respond($isJson, false, "Email not found");
            }

            if (empty($u['password'])) {
                return $this->respond($isJson, false, "Password not set for this account");
            }

            if (!password_verify($_POST['password'], $u['password'])) {
                return $this->respond($isJson, false, "Invalid password");
            }

            $_SESSION['user'] = $u;

            return $this->respond(
                $isJson,
                true,
                "Login successful",
                "index.php?page=home"
            );
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    
    public function logout(){
        session_destroy();
        header("Location: index.php");
        exit;
    }


    public function forgot(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $isJson = isset($_SERVER['HTTP_X_REQUESTED_WITH']);

            $token = bin2hex(random_bytes(16));
            $this->user->saveToken($_POST['email'], $token);

            return $this->respond(
                $isJson,
                true,
                "Reset token generated",
                null,
                ['token' => $token]
            );
        }

        require __DIR__ . '/../views/auth/forgot.php';
    }

   
    public function change(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $isJson = isset($_SERVER['HTTP_X_REQUESTED_WITH']);

            if (strlen($_POST['password']) < 6) {
                return $this->respond($isJson, false, "Password must be at least 6 characters");
            }

            $this->user->resetPassword($_POST['token'], $_POST['password']);

            return $this->respond(
                $isJson,
                true,
                "Password updated",
                "index.php?page=login"
            );
        }

        require __DIR__ . '/../views/auth/change.php';
    }

    
    private function respond($json, $status, $message, $redirect = null, $extra = []){

        if ($json) {
            header('Content-Type: application/json');
            echo json_encode(array_merge([
                'status'   => $status,
                'message'  => $message,
                'redirect' => $redirect
            ], $extra));
            exit;
        }

        // fallback (non-JS)
        if (!$status) {
            $error = $message;
            return;
        }

        if ($redirect) {
            header("Location: $redirect");
            exit;
        }
    }
}
