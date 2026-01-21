<?php
require_once __DIR__ . '/../../core/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function register($data) {

        // check duplicate email
        if ($this->emailExists($data['email'])) {
            return false;
        }

        $stmt = $this->db->prepare(
            "INSERT INTO users (name,email,gender,phone,dob,password)
             VALUES (?,?,?,?,?,?)"
        );

        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt->bind_param(
            "ssssss",
            $data['name'],
            $data['email'],
            $data['gender'],
            $data['phone'],
            $data['dob'],
            $hashedPassword
        );

        return $stmt->execute();
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function emailExists($email, $ignoreId = null) {
        $sql = "SELECT id FROM users WHERE email=?";
        $params = [$email];

        if ($ignoreId) {
            $sql .= " AND id != ?";
        }

        $stmt = $this->db->prepare($sql);

        if ($ignoreId) {
            $stmt->bind_param("si", $email, $ignoreId);
        } else {
            $stmt->bind_param("s", $email);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function saveToken($email, $token) {
        $stmt = $this->db->prepare(
            "UPDATE users SET reset_token=? WHERE email=?"
        );
        $stmt->bind_param("ss", $token, $email);
        return $stmt->execute();
    }

    public function resetPassword($token, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare(
            "UPDATE users SET password=?, reset_token=NULL WHERE reset_token=?"
        );
        $stmt->bind_param("ss", $hashedPassword, $token);
        return $stmt->execute();
    }

    public function updateProfile($id, $data) {

        // check duplicate email for update
        if ($this->emailExists($data['email'], $id)) {
            return false;
        }

        $stmt = $this->db->prepare(
            "UPDATE users SET name=?, email=?, gender=?, phone=?, dob=? WHERE id=?"
        );

        $stmt->bind_param(
            "sssssi",
            $data['name'],
            $data['email'],
            $data['gender'],
            $data['phone'],
            $data['dob'],
            $id
        );

        return $stmt->execute();
    }

    public function updatePassword($id, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare(
            "UPDATE users SET password=? WHERE id=?"
        );

        $stmt->bind_param("si", $hashedPassword, $id);
        return $stmt->execute();
    }
}
