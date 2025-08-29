<?php
// backend/controllers/BaseController.php

class BaseController {
    protected $config;

    public function __construct() {
        $this->config = require __DIR__ . '/../config/config.php';
    }

    protected function view($viewName, $data = []) {
        $viewPath = $this->config['paths']['views'] . '/' . $viewName . '.php';

        if (!file_exists($viewPath)) {
            throw new Exception("Vue non trouvée: $viewName");
        }

        // Extraire les données pour les rendre disponibles dans la vue
        extract($data);

        // Variables globales disponibles dans toutes les vues
        $config = $this->config;
        $user = Session::getUser();

        require $viewPath;
    }

    protected function redirect($path) {
        $router = new Router();
        $router->redirect($path);
    }

    protected function json($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    protected function back() {
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        header("Location: $referer");
        exit();
    }
}