<?php
// backend/bootstrap.php

// Chargement automatique des classes
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