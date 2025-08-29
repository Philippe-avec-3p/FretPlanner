<?php
// FretPlanner/frontend/test-post.php

echo "<h1>Test des requêtes POST</h1>";

echo "<h2>Informations de la requête:</h2>";
echo "METHOD: " . $_SERVER['REQUEST_METHOD'] . "<br>";
echo "URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "POST data: <pre>" . print_r($_POST, true) . "</pre>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<div style='background: #d4edda; padding: 10px; border: 1px solid #c3e6cb;'>";
    echo "✅ Requête POST reçue !<br>";
    echo "Email: " . ($_POST['email'] ?? 'Non défini') . "<br>";
    echo "Password: " . (isset($_POST['password']) ? '[DÉFINI]' : 'Non défini') . "<br>";
    echo "</div>";

    // Tester le chargement des classes
    try {
        require_once __DIR__ . '/../backend/bootstrap.php';
        echo "✅ Classes chargées<br>";

        $userModel = new User();
        echo "✅ UserModel créé<br>";

        if (!empty($_POST['email'])) {
            $user = $userModel->findByEmail($_POST['email']);
            echo "Utilisateur trouvé: " . ($user ? "OUI" : "NON") . "<br>";
            if ($user) {
                echo "Détails: " . $user['first_name'] . " " . $user['last_name'] . " (" . $user['role'] . ")<br>";
            }
        }

    } catch (Exception $e) {
        echo "❌ Erreur: " . $e->getMessage();
    }

} else {
    echo "<h2>Formulaire de test:</h2>";
    echo '<form method="POST" action="/FretPlanner/frontend/test-post.php">';
    echo '<input type="email" name="email" placeholder="Email" required><br><br>';
    echo '<input type="password" name="password" placeholder="Password" required><br><br>';
    echo '<button type="submit">Tester POST</button>';
    echo '</form>';
}
?>