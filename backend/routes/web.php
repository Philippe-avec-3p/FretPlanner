<?php
// backend/routes/web.php

$router = new Router();

// Route racine - redirection vers login
$router->get('/', function() {
    header('Location: /FretPlanner/login');
    exit();
});

// Routes d'authentification
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);

// Routes protégées
$router->get('/logout', [AuthController::class, 'logout']);
$router->get('/dashboard', [DashboardController::class, 'userDashboard']);
$router->get('/admin/dashboard', [DashboardController::class, 'adminDashboard']);

// Routes utilisateurs - accessible à tous les utilisateurs connectés
$router->get('/users', [UserController::class, 'index']);
$router->get('/users/create', [UserController::class, 'create']);
$router->post('/users/store', [UserController::class, 'store']);
$router->get('/users/show', [UserController::class, 'show']); // ?id=X
$router->get('/users/edit', [UserController::class, 'edit']); // ?id=X
$router->post('/users/update', [UserController::class, 'update']);
$router->post('/users/delete', [UserController::class, 'delete']);

// Routes transports - accessibles aux utilisateurs connectés
$router->get('/transports', [TransportController::class, 'index']);
$router->get('/transports/create', [TransportController::class, 'create']);
$router->post('/transports/store', [TransportController::class, 'store']);
$router->get('/transports/show', [TransportController::class, 'show']); // ?id=X
$router->get('/transports/edit', [TransportController::class, 'edit']); // ?id=X
$router->post('/transports/update', [TransportController::class, 'update']);
$router->post('/transports/delete', [TransportController::class, 'delete']); // Admin seulement

// Routes admin - redirections vers les routes utilisateurs normales
$router->get('/admin/users', function() {
    header('Location: /FretPlanner/users');
    exit();
});

$router->get('/admin/users/create', function() {
    header('Location: /FretPlanner/users/create');
    exit();
});

$router->get('/admin/users/show', function() {
    $id = $_GET['id'] ?? '';
    header('Location: /FretPlanner/users/show' . ($id ? '?id=' . $id : ''));
    exit();
});

$router->get('/admin/users/edit', function() {
    $id = $_GET['id'] ?? '';
    header('Location: /FretPlanner/users/edit' . ($id ? '?id=' . $id : ''));
    exit();
});

// Routes admin pour les transports - redirections
$router->get('/admin/transports', function() {
    header('Location: /FretPlanner/transports');
    exit();
});

$router->get('/admin/transports/create', function() {
    header('Location: /FretPlanner/transports/create');
    exit();
});

$router->get('/admin/transports/show', function() {
    $id = $_GET['id'] ?? '';
    header('Location: /FretPlanner/transports/show' . ($id ? '?id=' . $id : ''));
    exit();
});

$router->get('/admin/transports/edit', function() {
    $id = $_GET['id'] ?? '';
    header('Location: /FretPlanner/transports/edit' . ($id ? '?id=' . $id : ''));
    exit();
});

// Route de debug pour les routes utilisateurs
$router->get('/debug-users', function() {
    echo "<h1>Debug Routes Utilisateurs</h1>";
    echo "<h2>Routes testées :</h2>";
    echo "<a href='/FretPlanner/users'>Liste utilisateurs</a><br>";
    echo "<a href='/FretPlanner/users/create'>Créer utilisateur</a><br>";
    echo "<a href='/FretPlanner/users/show?id=1'>Voir utilisateur 1</a><br>";
    echo "<a href='/FretPlanner/users/edit?id=1'>Modifier utilisateur 1</a><br>";
    echo "<h2>Routes admin (redirections) :</h2>";
    echo "<a href='/FretPlanner/admin/users'>Admin - Liste utilisateurs</a><br>";
    echo "<a href='/FretPlanner/admin/users/create'>Admin - Créer utilisateur</a><br>";
    echo "<h2>Utilisateur connecté :</h2>";
    $user = Session::getUser();
    echo $user ? "Connecté : " . $user['email'] . " (" . $user['role'] . ")" : "Non connecté";
});

return $router;