<?php
// frontend/views/auth/login.php
$title = 'Connexion - FretPlanner';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= $config['paths']['assets'] ?>/css/style.css" rel="stylesheet">
</head>
<body>
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <i class="fas fa-truck-moving"></i>
                <?= $config['app']['name'] ?>
            </div>
            <p class="auth-subtitle">Plateforme de gestion de fret</p>
        </div>

        <div class="auth-content">
            <?php if (isset($error) && $error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="/FretPlanner/frontend/login">
                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope me-2"></i>
                        Adresse email
                    </label>
                    <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            placeholder="votre@email.com"
                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                            required
                    >
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock me-2"></i>
                        Mot de passe
                    </label>
                    <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            required
                    >
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Se connecter
                    </button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <div class="mb-3">
                    <small class="text-muted">Comptes de démonstration :</small>
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <button type="button" class="btn btn-outline-primary btn-sm w-100" onclick="fillLogin('admin@fretplanner.com', 'password')">
                            <i class="fas fa-user-shield me-1"></i>
                            Admin
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="fillLogin('user@fretplanner.com', 'password')">
                            <i class="fas fa-user me-1"></i>
                            Utilisateur
                        </button>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="text-muted">Mot de passe des deux comptes : <code>password</code></small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= $config['paths']['assets'] ?>/js/app.js"></script>
<script>
    function fillLogin(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
    }

    // Auto-focus sur le premier champ
    document.getElementById('email').focus();
</script>
</body>
</html>