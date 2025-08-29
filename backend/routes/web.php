<?php
// backend/routes/web.php

$router = new Router();

// Route racine - redirection vers login
$router->get('/', function() {
    header('Location: /FretPlanner/frontend/login');
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

// Routes utilisateurs pour admins seulement
$router->get('/users/create', [UserController::class, 'create']);
$router->post('/users/store', [UserController::class, 'store']);
$router->get('/users/show', [UserController::class, 'show']); // ?id=X
$router->get('/users/edit', [UserController::class, 'edit']); // ?id=X
$router->post('/users/update', [UserController::class, 'update']);
$router->post('/users/delete', [UserController::class, 'delete']);

// Route de test avec debug pour les routes utilisateurs
$router->get('/debug-users', function() {
    echo "<h1>Debug Routes Utilisateurs</h1>";
    echo "<h2>Routes testées :</h2>";
    echo "<a href='/FretPlanner/frontend/users'>Liste utilisateurs</a><br>";
    echo "<a href='/FretPlanner/frontend/users/create'>Créer utilisateur</a><br>";
    echo "<a href='/FretPlanner/frontend/users/show?id=1'>Voir utilisateur 1</a><br>";
    echo "<a href='/FretPlanner/frontend/users/edit?id=1'>Modifier utilisateur 1</a><br>";
    echo "<h2>Utilisateur connecté :</h2>";
    $user = Session::getUser();
    echo $user ? "Connecté : " . $user['email'] . " (" . $user['role'] . ")" : "Non connecté";
});

return $router;