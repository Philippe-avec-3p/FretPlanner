<?php
// backend/bootstrap.php

// Chargement automatique des classes AVANT tout
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/core/',
        __DIR__ . '/controllers/',
        __DIR__ . '/models/',
        __DIR__ . '/middlewares/',
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Charger manuellement les classes essentielles pour s'assurer qu'elles sont disponibles
require_once __DIR__ . '/core/Session.php';
require_once __DIR__ . '/core/Router.php';
require_once __DIR__ . '/models/Database.php';
require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/models/Transport.php';
require_once __DIR__ . '/controllers/BaseController.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/DashboardController.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/TransportController.php';

// Configuration du fuseau horaire
$config = require __DIR__ . '/config/config.php';
date_default_timezone_set($config['app']['timezone']);

// Démarrer la session (après le chargement des classes)
Session::start();

// Gestion des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Headers de sécurité
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');