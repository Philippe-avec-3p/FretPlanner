<?php
// backend/controllers/DashboardController.php

class DashboardController extends BaseController {
    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
    }

    public function userDashboard() {
        $user = Session::getUser();
        $stats = [
            'total_shipments' => 0,
            'pending_shipments' => 0,
            'completed_shipments' => 0,
            'total_revenue' => 0
        ];

        // Le fichier s'appelle user.php, pas dashboard/user.php
        $this->renderUserDashboard($user, $stats);
    }

    public function adminDashboard() {
        $user = Session::getUser();
        $users = $this->userModel->getAllUsers();

        $stats = [
            'total_users' => count($users),
            'total_shipments' => 0,
            'pending_shipments' => 0,
            'total_revenue' => 0,
            'active_users' => count(array_filter($users, function($u) { return $u['is_active']; }))
        ];

        // Le fichier s'appelle admin.php, pas dashboard/admin.php
        $this->renderAdminDashboard($user, $stats, $users);
    }

    private function renderUserDashboard($user, $stats) {
        // Inclure directement le fichier car il contient déjà le HTML complet
        $viewPath = $this->config['paths']['views'] . '/dashboard/user.php';

        if (!file_exists($viewPath)) {
            throw new Exception("Vue user non trouvée: $viewPath");
        }

        // Variables disponibles dans la vue
        $config = $this->config;

        require $viewPath;
    }

    private function renderAdminDashboard($user, $stats, $users) {
        // Inclure directement le fichier car il contient déjà le HTML complet
        $viewPath = $this->config['paths']['views'] . '/dashboard/admin.php';

        if (!file_exists($viewPath)) {
            throw new Exception("Vue admin non trouvée: $viewPath");
        }

        // Variables disponibles dans la vue
        $config = $this->config;

        require $viewPath;
    }
}