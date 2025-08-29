<?php
// backend/controllers/UserController.php

class UserController extends BaseController {
    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
    }

    // Liste des utilisateurs (pour les admins ET les users)
    public function index() {
        $currentUser = Session::getUser();
        $users = $this->userModel->getAllUsers();

        // Si c'est un user normal, on montre juste la liste
        $viewPath = $this->config['paths']['views'] . '/users/index.php';

        if (!file_exists($viewPath)) {
            throw new Exception("Vue users/index non trouvée: $viewPath");
        }

        $config = $this->config;
        $user = $currentUser; // Pour la sidebar

        require $viewPath;
    }

    // Afficher un utilisateur (admins seulement)
    public function show() {
        $id = $_GET['id'] ?? 0;

        if (!$id) {
            Session::flash('error', 'ID utilisateur manquant');
            header('Location: /FretPlanner/frontend/users');
            exit();
        }

        $targetUser = $this->userModel->findById($id);

        if (!$targetUser) {
            Session::flash('error', 'Utilisateur non trouvé');
            header('Location: /FretPlanner/frontend/users');
            exit();
        }

        $viewPath = $this->config['paths']['views'] . '/users/show.php';

        if (!file_exists($viewPath)) {
            throw new Exception("Vue users/show non trouvée: $viewPath");
        }

        $config = $this->config;
        $user = Session::getUser(); // Pour la sidebar

        require $viewPath;
    }

    // Formulaire de création (admins seulement)
    public function create() {
        $viewPath = $this->config['paths']['views'] . '/users/create.php';

        if (!file_exists($viewPath)) {
            throw new Exception("Vue users/create non trouvée: $viewPath");
        }

        $config = $this->config;
        $user = Session::getUser(); // Pour la sidebar
        $error = Session::flash('error');
        $success = Session::flash('success');

        require $viewPath;
    }

    // Sauvegarder un nouvel utilisateur
    public function store() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $firstName = $_POST['first_name'] ?? '';
        $lastName = $_POST['last_name'] ?? '';
        $role = $_POST['role'] ?? 'user';

        // Validation
        if (empty($email) || empty($password) || empty($firstName) || empty($lastName)) {
            Session::flash('error', 'Tous les champs sont requis');
            header('Location: /FretPlanner/frontend/users/create');
            exit();
        }

        // Vérifier si l'email existe déjà
        if ($this->userModel->findByEmail($email)) {
            Session::flash('error', 'Cet email est déjà utilisé');
            header('Location: /FretPlanner/frontend/users/create');
            exit();
        }

        try {
            $this->userModel->create([
                'email' => $email,
                'password' => $password,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'role' => $role
            ]);

            Session::flash('success', 'Utilisateur créé avec succès');
            header('Location: /FretPlanner/frontend/users');
            exit();

        } catch (Exception $e) {
            Session::flash('error', 'Erreur lors de la création: ' . $e->getMessage());
            header('Location: /FretPlanner/frontend/users/create');
            exit();
        }
    }

    // Formulaire d'édition (admins seulement)
    public function edit() {
        $id = $_GET['id'] ?? 0;

        if (!$id) {
            Session::flash('error', 'ID utilisateur manquant');
            header('Location: /FretPlanner/frontend/users');
            exit();
        }

        $targetUser = $this->userModel->findById($id);

        if (!$targetUser) {
            Session::flash('error', 'Utilisateur non trouvé');
            header('Location: /FretPlanner/frontend/users');
            exit();
        }

        $viewPath = $this->config['paths']['views'] . '/users/edit.php';

        if (!file_exists($viewPath)) {
            throw new Exception("Vue users/edit non trouvée: $viewPath");
        }

        $config = $this->config;
        $user = Session::getUser(); // Pour la sidebar
        $error = Session::flash('error');
        $success = Session::flash('success');

        require $viewPath;
    }

    // Mettre à jour un utilisateur
    public function update() {
        $id = $_POST['id'] ?? 0;
        $email = $_POST['email'] ?? '';
        $firstName = $_POST['first_name'] ?? '';
        $lastName = $_POST['last_name'] ?? '';
        $role = $_POST['role'] ?? 'user';
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if (!$this->userModel->findById($id)) {
            Session::flash('error', 'Utilisateur non trouvé');
            header('Location: /FretPlanner/frontend/users');
            exit();
        }

        try {
            $this->userModel->update($id, [
                'email' => $email,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'role' => $role,
                'is_active' => $isActive
            ]);

            Session::flash('success', 'Utilisateur mis à jour avec succès');
            header('Location: /FretPlanner/frontend/users');
            exit();

        } catch (Exception $e) {
            Session::flash('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
            header('Location: /FretPlanner/frontend/users/' . $id . '/edit');
            exit();
        }
    }

    // Supprimer un utilisateur (admins seulement)
    public function delete() {
        $id = $_POST['id'] ?? 0;
        $currentUser = Session::getUser();

        // On ne peut pas se supprimer soi-même
        if ($id == $currentUser['id']) {
            Session::flash('error', 'Vous ne pouvez pas supprimer votre propre compte');
            header('Location: /FretPlanner/frontend/users');
            exit();
        }

        try {
            $this->userModel->delete($id);
            Session::flash('success', 'Utilisateur supprimé avec succès');
        } catch (Exception $e) {
            Session::flash('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }

        header('Location: /FretPlanner/frontend/users');
        exit();
    }
}