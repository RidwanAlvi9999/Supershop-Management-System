<?php
require_once "../config/database.php";
require_once "../core/session.php";

header("Content-Type: application/json");

requireLogin();

if ($_SESSION['role'] !== 'customer') {
    echo json_encode([
        "status" => "error",
        "message" => "Unauthorized"
    ]);
    exit;
}

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);
$product_id = (int)($data['product_id'] ?? 0);
$user_id = $_SESSION['user_id'];

if ($product_id <= 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid product"
    ]);
    exit;
}

// Insert purchase (quantity = 1)
$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO purchases (user_id, product_id, quantity, status)
     VALUES (?, ?, 1, 'active')"
);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
mysqli_stmt_execute($stmt);

echo json_encode([
    "status" => "success",
    "message" => "Product added to cart successfully!"
]);