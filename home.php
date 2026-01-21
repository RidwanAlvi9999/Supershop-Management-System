<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>

    <!-- CORRECT CSS PATH -->
    <link rel="stylesheet" href="/old/public/CSS/home.css">

</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <a href="index.php?page=home">Home</a>
    <a href="index.php?page=profile">Profile</a>
    <a href="index.php?page=logout">Logout</a>
</div>

<h2>Welcome <?= $_SESSION['user']['name'] ?></h2>

<table>
<tr>
<td width="50%" valign="top">

<h3>Items</h3>
<table>
<tr>
<th>Name</th><th>Price</th><th>Add</th>
</tr>

<?php foreach ($items as $i): ?>
<tr>
<td><?= $i['name'] ?></td>
<td><?= $i['price'] ?> ৳</td>
<td>
<form method="post">
    <input type="hidden" name="item_id" value="<?= $i['id'] ?>">
    <button name="add">Add</button>
</form>
</td>
</tr>
<?php endforeach; ?>

</table>
</td>

<td width="50%" valign="top">

<h3>Cart</h3>
<table>
<tr>
<th>Item</th><th>Price</th><th>Action</th>
</tr>

<?php $total = 0; ?>
<?php foreach ($cart as $c): ?>
<?php $total += $c['price']; ?>
<tr>
<td><?= $c['name'] ?></td>
<td><?= $c['price'] ?> ৳</td>
<td>
<form method="post">
    <input type="hidden" name="cart_id" value="<?= $c['cart_id'] ?>">
    <button name="remove">Remove</button>
</form>
</td>
</tr>
<?php endforeach; ?>

<tr>
<th>Total</th><th><?= $total ?> ৳</th><th></th>
</tr>
</table>

<form method="post">
    <button name="order">Place Order</button>
</form>

<?= $msg ?? '' ?>

</td>
</tr>
</table>

<hr>

<h3>Report</h3>
<form method="post">
<textarea name="report" required></textarea><br>
<button name="report_submit">Submit</button>
</form>

<?= $reportMsg ?? '' ?>

<hr>

<h3>Review</h3>
<form method="post">
<?php for($i=1;$i<=5;$i++): ?>
    <input type="radio" name="star" value="<?= $i ?>" required>
    <?= str_repeat("⭐", $i) ?>
<?php endfor; ?>
<br><br>
<button name="review_submit">Submit</button>
</form>

<?= $reviewMsg ?? '' ?>

</body>
</html>
