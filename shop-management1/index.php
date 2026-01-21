<?php
session_start();
require_once 'core/Database.php';
require_once 'core/Auth.php';

if (!Auth::check()) {
    header('Location: app/views/auth/login.php');
    exit();
}

header('Location: app/views/employee/dashboard.php');
exit();
?>