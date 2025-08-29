<?php
// FretPlanner/frontend/simple-test.php

echo "<h1>Test simple - FretPlanner</h1>";

echo "<h2>1. Test des chemins:</h2>";
echo "Fichier actuel: " . __FILE__ . "<br>";
echo "Dossier actuel: " . __DIR__ . "<br>";

echo "<h2>2. Test REQUEST_URI:</h2>";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD'] . "<br>";

echo "<h2>3. Test de chargement du backend:</h2>";
try {
    require_once __DIR__ . '/../backend/core/Session.php';
    require_once __DIR__ . '/../backend/core/Router.php';
    echo "✅ Classes chargées<br>";

    // Test simple du routeur
    $router = new Router();
    echo "✅ Routeur créé<br>";

    // Ajouter une route de test
    $router->get('/simple-test.php', function() {
        echo "<strong>🎉 ROUTE TROUVÉE!</strong>";
    });

    echo "<h2>4. Test de résolution:</h2>";
    echo "On va tester le routeur...<br>";

    // Simuler la résolution
    $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    echo "Path à tester: $requestPath<br>";

    // Tester la résolution
    $router->resolve();

} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "<br>";
    echo "Stack trace: " . $e->getTraceAsString();
}
?>