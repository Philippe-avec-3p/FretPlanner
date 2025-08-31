<?php
// backend/models/Transport.php

class Transport {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll($userId = null) {
        if ($userId) {
            // Pour les utilisateurs normaux - seulement leurs transports
            $sql = "SELECT t.*, u.first_name, u.last_name 
                    FROM transports t 
                    LEFT JOIN users u ON t.user_id = u.id 
                    WHERE t.user_id = ? 
                    ORDER BY t.pickup_date DESC";
            return $this->db->fetchAll($sql, [$userId]);
        } else {
            // Pour les admins - tous les transports
            $sql = "SELECT t.*, u.first_name, u.last_name 
                    FROM transports t 
                    LEFT JOIN users u ON t.user_id = u.id 
                    ORDER BY t.pickup_date DESC";
            return $this->db->fetchAll($sql);
        }
    }

    public function findById($id, $userId = null) {
        if ($userId) {
            // Pour les utilisateurs normaux - vérifier qu'ils possèdent ce transport
            $sql = "SELECT t.*, u.first_name, u.last_name 
                    FROM transports t 
                    LEFT JOIN users u ON t.user_id = u.id 
                    WHERE t.id = ? AND t.user_id = ?";
            return $this->db->fetch($sql, [$id, $userId]);
        } else {
            // Pour les admins - accès à tous les transports
            $sql = "SELECT t.*, u.first_name, u.last_name 
                    FROM transports t 
                    LEFT JOIN users u ON t.user_id = u.id 
                    WHERE t.id = ?";
            return $this->db->fetch($sql, [$id]);
        }
    }

    public function create($data) {
        $sql = "INSERT INTO transports (
                    user_id, reference, pickup_address, delivery_address, 
                    pickup_date, pickup_time, delivery_date, delivery_time,
                    merchandise, weight, volume, special_instructions,
                    status, documents_path
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $this->db->query($sql, [
            $data['user_id'],
            $data['reference'],
            $data['pickup_address'],
            $data['delivery_address'],
            $data['pickup_date'],
            $data['pickup_time'] ?? null,
            $data['delivery_date'] ?? null,
            $data['delivery_time'] ?? null,
            $data['merchandise'],
            $data['weight'] ?? null,
            $data['volume'] ?? null,
            $data['special_instructions'] ?? null,
            $data['status'] ?? 'pending',
            $data['documents_path'] ?? null
        ]);

        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $sql = "UPDATE transports SET 
                pickup_address = ?, delivery_address = ?, 
                pickup_date = ?, pickup_time = ?, delivery_date = ?, delivery_time = ?,
                merchandise = ?, weight = ?, volume = ?, special_instructions = ?,
                status = ?, documents_path = ?
                WHERE id = ?";

        return $this->db->query($sql, [
            $data['pickup_address'],
            $data['delivery_address'],
            $data['pickup_date'],
            $data['pickup_time'] ?? null,
            $data['delivery_date'] ?? null,
            $data['delivery_time'] ?? null,
            $data['merchandise'],
            $data['weight'] ?? null,
            $data['volume'] ?? null,
            $data['special_instructions'] ?? null,
            $data['status'],
            $data['documents_path'] ?? null,
            $id
        ]);
    }

    public function delete($id) {
        // Suppression logique - on marque comme supprimé
        $sql = "UPDATE transports SET status = 'deleted' WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }

    public function getStats($userId = null) {
        if ($userId) {
            $sql = "SELECT 
                        COUNT(*) as total_transports,
                        COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_transports,
                        COUNT(CASE WHEN status = 'in_progress' THEN 1 END) as in_progress_transports,
                        COUNT(CASE WHEN status = 'delivered' THEN 1 END) as delivered_transports,
                        COUNT(CASE WHEN status = 'cancelled' THEN 1 END) as cancelled_transports,
                        SUM(CASE WHEN weight IS NOT NULL THEN weight ELSE 0 END) as total_weight
                    FROM transports 
                    WHERE user_id = ? AND status != 'deleted'";
            return $this->db->fetch($sql, [$userId]);
        } else {
            $sql = "SELECT 
                        COUNT(*) as total_transports,
                        COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_transports,
                        COUNT(CASE WHEN status = 'in_progress' THEN 1 END) as in_progress_transports,
                        COUNT(CASE WHEN status = 'delivered' THEN 1 END) as delivered_transports,
                        COUNT(CASE WHEN status = 'cancelled' THEN 1 END) as cancelled_transports,
                        SUM(CASE WHEN weight IS NOT NULL THEN weight ELSE 0 END) as total_weight
                    FROM transports 
                    WHERE status != 'deleted'";
            return $this->db->fetch($sql);
        }
    }

    public function getRecentTransports($limit = 5, $userId = null) {
        if ($userId) {
            $sql = "SELECT t.*, u.first_name, u.last_name 
                    FROM transports t 
                    LEFT JOIN users u ON t.user_id = u.id 
                    WHERE t.user_id = ? AND t.status != 'deleted'
                    ORDER BY t.created_at DESC 
                    LIMIT ?";
            return $this->db->fetchAll($sql, [$userId, $limit]);
        } else {
            $sql = "SELECT t.*, u.first_name, u.last_name 
                    FROM transports t 
                    LEFT JOIN users u ON t.user_id = u.id 
                    WHERE t.status != 'deleted'
                    ORDER BY t.created_at DESC 
                    LIMIT ?";
            return $this->db->fetchAll($sql, [$limit]);
        }
    }

    public function generateReference() {
        $prefix = 'TR';
        $date = date('ymd');

        // Trouver le prochain numéro séquentiel pour aujourd'hui
        $sql = "SELECT MAX(CAST(SUBSTRING(reference, 9) AS UNSIGNED)) as last_num 
                FROM transports 
                WHERE reference LIKE ?";
        $pattern = $prefix . $date . '%';
        $result = $this->db->fetch($sql, [$pattern]);

        $nextNum = ($result['last_num'] ?? 0) + 1;

        return $prefix . $date . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
    }

    public function getStatusLabel($status) {
        $labels = [
            'pending' => 'En attente',
            'confirmed' => 'Confirmé',
            'pickup_ready' => 'Prêt enlèvement',
            'in_progress' => 'En cours',
            'delivered' => 'Livré',
            'cancelled' => 'Annulé',
            'delayed' => 'Retardé'
        ];

        return $labels[$status] ?? ucfirst($status);
    }

    public function getStatusColor($status) {
        $colors = [
            'pending' => 'warning',
            'confirmed' => 'info',
            'pickup_ready' => 'primary',
            'in_progress' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger',
            'delayed' => 'danger'
        ];

        return $colors[$status] ?? 'secondary';
    }
}