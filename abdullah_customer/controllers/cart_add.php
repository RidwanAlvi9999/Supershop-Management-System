<?php
require_once "../core/session.php";
requireLogin();

$id  = (int)$_POST['id'];
$qty = (int)$_POST['qty'];

if ($qty < 1) {
    header("Location: products.php");
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// If product already in cart → add quantity
if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id] += $qty;
} else {
    $_SESSION['cart'][$id] = $qty;
}

header("Location: cart_view.php");
exit;