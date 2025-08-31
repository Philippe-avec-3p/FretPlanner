<?php
// backend/config/config.php

return [
    'app' => [
        'name' => 'FretPlanner',
        'url' => 'http://localhost/FretPlanner',  // Maintenant depuis la racine
        'timezone' => 'Europe/Paris'
    ],
    'session' => [
        'name' => 'fretplanner_session',
        'lifetime' => 3600, // 1 heure
    ],
    'paths' => [
        'views' => __DIR__ . '/../../frontend/views',
        'assets' => '/FretPlanner/assets'  // Retirer frontend du chemin des assets
    ]
];