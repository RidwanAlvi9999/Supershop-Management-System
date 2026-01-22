<?php
require_once "../config/database.php";
require_once "../core/session.php";

requireLogin();

// customer-only
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'customer') {
    header("Location: /supershop_mvc/unauthorized.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "
    SELECT 
        pu.id,
        pu.product_id,
        p.name,
        pu.quantity,
        pu.status,
        pu.created_at
    FROM purchases pu
    JOIN products p ON pu.product_id = p.id
    WHERE pu.user_id = ?
    ORDER BY pu.created_at DESC
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Purchases</title>
</head>
<body>

<h2>📦 My Purchases / Contracts</h2>

<?php if (mysqli_num_rows($result) === 0): ?>
    <p>No purchases yet.</p>
<?php else: ?>

<table border="1" cellpadding="10">
<tr>
    <th>Product</th>
    <th>Qty</th>
    <th>Status</th>
    <th>Date</th>
    <th>Action</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td><?= (int)$row['quantity'] ?></td>
    <td><?= ucfirst(htmlspecialchars($row['status'])) ?></td>
    <td><?= htmlspecialchars($row['created_at']) ?></td>
    <td>
        <?php if ($row['status'] === 'active'): ?>
            <a href="cancel.php?id=<?= $row['id'] ?>">❌ Cancel</a> |
            <a href="review.php?product_id=<?= $row['product_id'] ?>">⭐ Review</a>
        <?php else: ?>
            <a href="review.php?product_id=<?= $row['product_id'] ?>">⭐ Review</a>
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</table>

<?php endif; ?>

<br>
<a href="/supershop_mvc/customer/dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>