<?php
session_start();
require_once 'core/Auth.php';

Auth::logout();
header('Location: app/views/auth/login.php');
exit();
?>