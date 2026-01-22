<?php
require_once "../config/database.php";
require_once "../core/session.php";

requireLogin();

$id = (int)($_GET['id'] ?? 0);

$sql = "UPDATE purchases SET status='cancelled' WHERE id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

header("Location: my_orders.php");
exit;