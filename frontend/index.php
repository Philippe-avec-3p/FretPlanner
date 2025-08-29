<?php
// frontend/index.php

// Démarrage de l'application
require_once __DIR__ . '/../backend/bootstrap.php';

// Récupération du routeur
$router = require __DIR__ . '/../backend/routes/web.php';

// Résolution de la route
$router->resolve();