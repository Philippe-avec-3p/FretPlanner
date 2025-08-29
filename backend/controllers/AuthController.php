<?php
// backend/controllers/AuthController.php

class AuthController extends BaseController {
    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
    }

    public function showLogin() {
        $error = Session::flash('error');

        // Inclure directement le fichier login.php qui contient le HTML complet
        $viewPath = $this->config['paths']['views'] . '/auth/login.php';

        if (!file_exists($viewPath)) {
            throw new Exception("Vue login non trouvée: $viewPath");
        }

        // Variables disponibles dans la vue
        $config = $this->config;

        require $viewPath;
    }

    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validation simple
        if (empty($email) || empty($password)) {
            Session::flash('error', 'Veuillez remplir tous les champs');
            header('Location: /FretPlanner/frontend/login');
            exit();
        }

        // Vérifier l'utilisateur
        $user = $this->userModel->findByEmail($email);

        if (!$user || !$this->userModel->verifyPassword($password, $user['password'])) {
            Session::flash('error', 'Email ou mot de passe incorrect');
            header('Location: /FretPlanner/frontend/login');
            exit();
        }

        // Connexion réussie
        Session::login($user);

        // Redirection selon le rôle
        if ($user['role'] === 'admin') {
            header('Location: /FretPlanner/frontend/admin/dashboard');
            exit();
        } else {
            header('Location: /FretPlanner/frontend/dashboard');
            exit();
        }
    }

    public function logout() {
        Session::logout();
        header('Location: /FretPlanner/frontend/login');
        exit();
    }
}