<?php
require_once "../core/session.php";
requireLogin();

$id = (int)$_GET['id'];
unset($_SESSION['cart'][$id]);

header("Location: cart_view.php");
exit;