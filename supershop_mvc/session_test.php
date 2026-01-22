<?php
require_once "core/session.php";

$_SESSION['user_id'] = 1;
$_SESSION['role'] = 'admin';

if (isLoggedIn()) {
    echo "Logged in as " . getUserRole();
}
