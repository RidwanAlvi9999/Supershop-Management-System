<?php
require_once __DIR__ . '/../models/Shop.php';

class ShopController {

    private $shop;

    public function __construct() {
        $this->shop = new Shop();
    }

    public function home() {

        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $userId = $_SESSION['user']['id'];

        // ADD TO CART
        if (isset($_POST['add'])) {
            $this->shop->addToCart($userId, $_POST['item_id']);
        }

        
        if (isset($_POST['order'])) {
            $cart = $this->shop->getCart($userId);
            $total = array_sum(array_column($cart, 'price'));
            $this->shop->placeOrder($userId, $total);
            $msg = "Order placed successfully!";
        }

        
        if (isset($_POST['report_submit'])) {
            $this->shop->saveReport($userId, $_POST['report']);
            $reportMsg = "Report submitted!";
        }

        
        if (isset($_POST['review_submit'])) {
            $this->shop->saveReview($userId, $_POST['star']);
            $reviewMsg = "Review submitted!";
        }

        // REMOVE FROM CART
if (isset($_POST['remove'])) {
    $this->shop->removeFromCart($_POST['cart_id']);
}

        $items = $this->shop->getItems();
        $cart  = $this->shop->getCart($userId);

        require __DIR__ . '/../views/home.php';
    }
}
