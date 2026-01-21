<?php
require_once __DIR__ . '/../../core/Database.php';

class Shop {

    private $db;

    public function __construct() {
        $this->db = Database::connect(); // mysqli connection
    }

    /* ================= ITEMS ================= */

    public function getItems() {
        $result = $this->db->query("SELECT * FROM items");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /* ================= CART ================= */

    public function addToCart($userId, $itemId) {

        // Check if item already exists in cart
        $stmt = $this->db->prepare(
            "SELECT id, quantity FROM cart WHERE user_id = ? AND item_id = ?"
        );
        $stmt->bind_param("ii", $userId, $itemId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            // Update quantity
            $stmt = $this->db->prepare(
                "UPDATE cart SET quantity = quantity + 1 WHERE id = ?"
            );
            $stmt->bind_param("i", $row['id']);
            $stmt->execute();
        } else {
            // Insert new cart item
            $stmt = $this->db->prepare(
                "INSERT INTO cart (user_id, item_id, quantity) VALUES (?, ?, 1)"
            );
            $stmt->bind_param("ii", $userId, $itemId);
            $stmt->execute();
        }
    }

    public function getCart($userId) {
        $stmt = $this->db->prepare(
            "SELECT cart.id AS cart_id, items.name, items.price
             FROM cart
             JOIN items ON cart.item_id = items.id
             WHERE cart.user_id = ?"
        );
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function removeFromCart($cartId) {
        $stmt = $this->db->prepare("DELETE FROM cart WHERE id = ?");
        $stmt->bind_param("i", $cartId);
        return $stmt->execute();
    }

    /* ================= ORDER ================= */

    public function placeOrder($userId, $total) {

        $this->db->begin_transaction();

        // Insert order
        $stmt = $this->db->prepare(
            "INSERT INTO orders (user_id, total) VALUES (?, ?)"
        );
        $stmt->bind_param("id", $userId, $total);
        $stmt->execute();

        // Clear cart
        $stmt = $this->db->prepare(
            "DELETE FROM cart WHERE user_id = ?"
        );
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        $this->db->commit();
    }

    /* ================= REPORT ================= */

    public function saveReport($userId, $msg) {
        $stmt = $this->db->prepare(
            "INSERT INTO reports (user_id, message) VALUES (?, ?)"
        );
        $stmt->bind_param("is", $userId, $msg);
        return $stmt->execute();
    }

    /* ================= REVIEW ================= */

    public function saveReview($userId, $star) {
        $stmt = $this->db->prepare(
            "INSERT INTO reviews (user_id, star) VALUES (?, ?)"
        );
        $stmt->bind_param("ii", $userId, $star);
        return $stmt->execute();
    }
}
