<?php
// backend/config/config.php

return [
    'app' => [
        'name' => 'FretPlanner',
        'url' => 'http://localhost/fretplanner',
        'timezone' => 'Europe/Paris'
    ],
    'session' => [
        'name' => 'fretplanner_session',
        'lifetime' => 3600, // 1 heure
    ],
    'paths' => [
        'views' => __DIR__ . '/../../frontend/views',
        'assets' => '/fretplanner/frontend/assets'
    ]
];