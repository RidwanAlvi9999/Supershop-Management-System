<?php
require_once "../config/config.php";
require_once "../config/database.php";
require_once "../core/session.php";

requireLogin();

if ($_SESSION['role'] !== 'customer') {
    header("Location: " . BASE_URL . "/unauthorized.php");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM products WHERE quantity > 0");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Product Catalog</title>

    <!-- Optional CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/dashboard.css">

    <!-- ✅ External Ajax JS -->
    <script src="<?= BASE_URL ?>/public/js/cart.js" defer></script>
</head>
<body>

<div class="dashboard-container">

<h2>🛒 Product Catalog</h2>

<table border="1" cellpadding="10" width="100%">
<tr>
    <th>Image</th>
    <th>Name</th>
    <th>Price</th>
    <th>Stock</th>
    <th>Qty</th>
    <th>Action</th>
</tr>

<?php while ($p = mysqli_fetch_assoc($result)): ?>
<tr>
    <td>
        <?php if (!empty($p['image'])): ?>
            <img src="<?= BASE_URL ?>/uploads/products/<?= htmlspecialchars($p['image']) ?>" width="80">
        <?php else: ?>
            No image
        <?php endif; ?>
    </td>

    <td><?= htmlspecialchars($p['name']) ?></td>
    <td><?= htmlspecialchars($p['price']) ?> BDT</td>
    <td><?= htmlspecialchars($p['quantity']) ?></td>

    <td>
        <input
            type="number"
            id="qty<?= $p['id'] ?>"
            value="1"
            min="1"
            max="<?= $p['quantity'] ?>">
    </td>

    <td>
        <button onclick="addToCart(<?= $p['id'] ?>)">
            ➕ Add to Cart
        </button>
    </td>
</tr>
<?php endwhile; ?>
</table>

<p id="msg" style="color:green; font-weight:bold;"></p>

<br>
<a href="<?= BASE_URL ?>/customer/cart_view.php">🛒 View Cart</a> |
<a href="<?= BASE_URL ?>/customer/dashboard.php">⬅ Back</a>

</div>

</body>
</html>