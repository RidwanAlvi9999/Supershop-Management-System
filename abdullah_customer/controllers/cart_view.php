<?php
require_once "../config/database.php";
require_once "../core/session.php";
requireLogin();

$cart = $_SESSION['cart'] ?? [];
$total_price = 0;
?>

<h2>🛒 My Cart</h2>

<?php if (empty($cart)): ?>
    <p>Your cart is empty.</p>
<?php else: ?>

<table border="1" cellpadding="10">
<tr>
    <th>Product</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Subtotal</th>
    <th>Action</th>
</tr>

<?php foreach ($cart as $id => $qty): 
    $stmt = mysqli_prepare($conn, "SELECT name, price FROM products WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);

    $subtotal = $product['price'] * $qty;
    $total_price += $subtotal;
?>
<tr>
    <td><?= htmlspecialchars($product['name']) ?></td>
    <td><?= $product['price'] ?> BDT</td>
    <td><?= $qty ?></td>
    <td><?= $subtotal ?> BDT</td>
    <td>
        <a href="cart_remove.php?id=<?= $id ?>">❌ Remove</a>
    </td>
</tr>
<?php endforeach; ?>

<tr>
    <td colspan="3"><strong>Total Price</strong></td>
    <td colspan="2"><strong><?= $total_price ?> BDT</strong></td>
</tr>
</table>

<br>
<a href="checkout.php">✅ Checkout</a>

<?php endif; ?>

<br><br>
<a href="products.php">⬅ Continue Shopping</a>