<?php
require_once __DIR__ . '/../models/User.php';

class ProfileController {

    public function index(){
        // Check session
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $userModel = new User();
        $user = $userModel->findById($_SESSION['user']['id']);

        require __DIR__ . '/../views/auth/profile.php';
    }

    public function update(){
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $userModel = new User();

        // Update profile
        $result = $userModel->updateProfile($_SESSION['user']['id'], $_POST);

        if (!$result) {
            $_SESSION['error'] = "Email already exists!";
            header("Location: index.php?page=profile");
            exit;
        }

        if (!empty($_POST['password'])) {
            $userModel->updatePassword($_SESSION['user']['id'], $_POST['password']);
        }

        // Update session values
        $_SESSION['user']['name']  = $_POST['name'];
        $_SESSION['user']['email'] = $_POST['email'];

        $_SESSION['success'] = "Profile updated successfully";
        header("Location: index.php?page=profile");
    }
}
