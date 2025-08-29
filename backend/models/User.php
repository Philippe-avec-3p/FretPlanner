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

    public function update($id, $data) {
        $sql = "UPDATE users SET email = ?, first_name = ?, last_name = ?, role = ?, is_active = ? WHERE id = ?";

        return $this->db->query($sql, [
            $data['email'],
            $data['first_name'],
            $data['last_name'],
            $data['role'],
            $data['is_active'],
            $id
        ]);
    }

    public function delete($id) {
        // Suppression logique (soft delete) - on désactive l'utilisateur
        $sql = "UPDATE users SET is_active = 0 WHERE id = ?";
        return $this->db->query($sql, [$id]);
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

    public function getActiveUsers() {
        $sql = "SELECT id, email, first_name, last_name, role, is_active, created_at 
                FROM users WHERE is_active = 1 ORDER BY created_at DESC";
        return $this->db->fetchAll($sql);
    }

    public function getUserStats() {
        $sql = "SELECT 
                    COUNT(*) as total_users,
                    COUNT(CASE WHEN is_active = 1 THEN 1 END) as active_users,
                    COUNT(CASE WHEN role = 'admin' THEN 1 END) as admin_users,
                    COUNT(CASE WHEN role = 'user' THEN 1 END) as regular_users
                FROM users";
        return $this->db->fetch($sql);
    }
}