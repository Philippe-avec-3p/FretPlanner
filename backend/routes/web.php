<?php
// backend/routes/web.php

$router = new Router();

// Route racine - redirection vers login
$router->get('/', function() {
    header('Location: /FretPlanner/frontend/login');
    exit();
});

// Routes d'authentification (sans middleware pour commencer)
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);

// Routes protégées
$router->get('/logout', [AuthController::class, 'logout']);
$router->get('/dashboard', [DashboardController::class, 'userDashboard']);
$router->get('/admin/dashboard', [DashboardController::class, 'adminDashboard']);

// Route de test (à supprimer plus tard)
$router->get('/test-route', function() {
    echo "<h1>🎉 Route de test OK!</h1>";
    echo "<p>Le routeur fonctionne correctement.</p>";
    echo "<p><a href='/FretPlanner/frontend/login'>Aller à la page de login</a></p>";
});

return $router;