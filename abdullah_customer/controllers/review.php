<?php
require_once "../config/database.php";
require_once "../core/session.php";

requireLogin();

// customer-only access
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'customer') {
    header("Location: /supershop_mvc/unauthorized.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* ✅ GET product_id (first load) OR POST product_id (submit) */
$product_id = 0;
if (isset($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id'];
} elseif (isset($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];
}

if ($product_id <= 0) {
    header("Location: my_orders.php");
    exit;
}

/* ✅ CHECK: customer really purchased this product */
$check = mysqli_prepare(
    $conn,
    "SELECT id FROM purchases WHERE user_id=? AND product_id=? LIMIT 1"
);
mysqli_stmt_bind_param($check, "ii", $user_id, $product_id);
mysqli_stmt_execute($check);
$check_result = mysqli_stmt_get_result($check);

if (mysqli_num_rows($check_result) === 0) {
    header("Location: my_orders.php");
    exit;
}

$message = "";

/* ---------- SUBMIT REVIEW ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = (int)$_POST['rating'];
    $review = trim($_POST['review']);

    if ($rating < 1 || $rating > 5) {
        $message = "Invalid rating.";
    } else {
        $sql = "
            INSERT INTO reviews (user_id, product_id, rating, review)
            VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
                rating = VALUES(rating),
                review = VALUES(review)
        ";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iiis", $user_id, $product_id, $rating, $review);
        mysqli_stmt_execute($stmt);

        $message = "Review saved successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Review Product</title>
</head>
<body>

<h2>⭐ Review & Rating</h2>

<?php if ($message): ?>
<p style="color:green"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST">
    <!-- ✅ KEEP product_id during POST -->
    <input type="hidden" name="product_id" value="<?= $product_id ?>">

    <label>Rating (1–5)</label><br>
    <input type="number" name="rating" min="1" max="5" required><br><br>

    <label>Review</label><br>
    <textarea name="review"></textarea><br><br>

    <button type="submit">Save Review</button>
</form>

<br>
<a href="/supershop_mvc/customer/my_orders.php">⬅ Back to Purchases</a>

</body>
</html>