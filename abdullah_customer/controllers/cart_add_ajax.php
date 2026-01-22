<?php
require_once "../core/session.php";
requireLogin();

header('Content-Type: application/json');

$id  = (int)($_POST['id'] ?? 0);
$qty = (int)($_POST['qty'] ?? 1);

if ($id <= 0 || $qty <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Increase quantity if exists
if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id] += $qty;
} else {
    $_SESSION['cart'][$id] = $qty;
}

echo json_encode([
    'success' => true,
    'message' => 'Added to cart successfully'
]);