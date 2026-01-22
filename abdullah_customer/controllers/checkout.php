<?php
require_once "../config/database.php";
require_once "../core/session.php";

requireLogin();

$user_id = $_SESSION['user_id'];
$cart = $_SESSION['cart'] ?? [];

foreach ($cart as $pid => $qty) {

    mysqli_query($conn,
        "INSERT INTO purchases (user_id, product_id, quantity)
         VALUES ($user_id, $pid, $qty)"
    );

    mysqli_query($conn,
        "UPDATE products SET quantity = quantity - $qty WHERE id=$pid"
    );
}

unset($_SESSION['cart']);

echo "Purchase completed successfully!";
echo '<br><a href="dashboard.php">Back to Dashboard</a>';