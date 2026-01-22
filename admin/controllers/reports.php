<?php
require_once "../config/database.php";
require_once "../core/session.php";

requireLogin();

// admin-only
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header("Location: /supershop_mvc/unauthorized.php");
    exit;
}

$sql = "
    SELECT 
        u.full_name,
        p.name AS product_name,
        pu.quantity,
        pu.status,
        pu.created_at
    FROM purchases pu
    JOIN users u ON pu.user_id = u.id
    JOIN products p ON pu.product_id = p.id
    ORDER BY pu.created_at DESC
";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reports</title>
</head>
<body>

<h2>📊 Sales / Purchase Reports</h2>

<table border="1" cellpadding="10">
<tr>
    <th>Customer</th>
    <th>Product</th>
    <th>Qty</th>
    <th>Status</th>
    <th>Date</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= htmlspecialchars($row['full_name']) ?></td>
    <td><?= htmlspecialchars($row['product_name']) ?></td>
    <td><?= $row['quantity'] ?></td>
    <td><?= ucfirst($row['status']) ?></td>
    <td><?= $row['created_at'] ?></td>
</tr>
<?php endwhile; ?>
</table>

<br>
<a href="/supershop_mvc/admin/dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>