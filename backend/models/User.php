<?php
// backend/models/User.php

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = ? AND is_active = 1";
        return $this->db->fetch($sql, [$email]);
    }

    public function findById($id) {
        $sql = "SELECT * FROM users WHERE id = ? AND is_active = 1";
        return $this->db->fetch($sql, [$id]);
    }

    public function create($data) {
        $sql = "INSERT INTO users (email, password, first_name, last_name, role) 
                VALUES (?, ?, ?, ?, ?)";

        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $this->db->query($sql, [
            $data['email'],
            $hashedPassword,
            $data['first_name'],
            $data['last_name'],
            $data['role'] ?? 'user'
        ]);

        return $this->db->lastInsertId();
    }

    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    public function isAdmin($user) {
        return $user['role'] === 'admin';
    }

    public function getAllUsers() {
        $sql = "SELECT id, email, first_name, last_name, role, is_active, created_at 
                FROM users ORDER BY created_at DESC";
        return $this->db->fetchAll($sql);
    }
}