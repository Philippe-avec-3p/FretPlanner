<?php
// frontend/views/users/create.php
$pageTitle = 'Nouvel utilisateur';
$title = 'Créer un utilisateur - FretPlanner';
$isAdmin = ($user['role'] === 'admin');
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
<div class="app-container">
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <a href="<?= $config['app']['url'] ?>/frontend/admin/dashboard" class="sidebar-brand">
                <i class="fas fa-truck-moving me-2"></i>
                <?= $config['app']['name'] ?>
            </a>
        </div>

        <div class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?= $config['app']['url'] ?>/frontend/admin/dashboard" class="nav-link">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard Admin</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $config['app']['url'] ?>/frontend/users" class="nav-link active">
                        <i class="fas fa-users"></i>
                        <span>Utilisateurs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $config['app']['url'] ?>/frontend/admin/shipments" class="nav-link">
                        <i class="fas fa-shipping-fast"></i>
                        <span>Expéditions</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $config['app']['url'] ?>/frontend/admin/reports" class="nav-link">
                        <i class="fas fa-chart-bar"></i>
                        <span>Rapports</span>
                    </a>
                </li>

                <hr style="border-color: rgba(255,255,255,0.1); margin: 1rem 0;">

                <li class="nav-item">
                    <a href="<?= $config['app']['url'] ?>/frontend/profile" class="nav-link">
                        <i class="fas fa-user"></i>
                        <span>Mon Profil</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $config['app']['url'] ?>/frontend/logout" class="nav-link" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?')">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Déconnexion</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main content -->
    <main class="main-content">
        <!-- Header -->
        <header class="main-header">
            <div class="header-content">
                <div class="d-flex align-items-center">
                    <button class="btn btn-link d-md-none me-2" data-sidebar-toggle>
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="header-title">Nouvel utilisateur</h1>
                </div>

                <div class="header-actions">
                    <a href="<?= $config['app']['url'] ?>/frontend/users" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Retour à la liste
                    </a>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="content">
            <!-- Alerts -->
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <!-- Form -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user-plus me-2"></i>
                                Informations de l'utilisateur
                            </h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?= $config['app']['url'] ?>/frontend/users/store">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name" class="form-label">
                                                <i class="fas fa-user me-1"></i>
                                                Prénom *
                                            </label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="first_name"
                                                name="first_name"
                                                placeholder="John"
                                                value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>"
                                                required
                                            >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name" class="form-label">
                                                <i class="fas fa-user me-1"></i>
                                                Nom *
                                            </label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="last_name"
                                                name="last_name"
                                                placeholder="Doe"
                                                value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>"
                                                required
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-1"></i>
                                        Adresse email *
                                    </label>
                                    <input
                                        type="email"
                                        class="form-control"
                                        id="email"
                                        name="email"
                                        placeholder="john.doe@fretplanner.com"
                                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                        required
                                    >
                                </div>

                                <div class="form-group">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock me-1"></i>
                                        Mot de passe *
                                    </label>
                                    <input
                                        type="password"
                                        class="form-control"
                                        id="password"
                                        name="password"
                                        placeholder="Minimum 6 caractères"
                                        minlength="6"
                                        required
                                    >
                                    <small class="text-muted">Le mot de passe doit contenir au moins 6 caractères.</small>
                                </div>

                                <div class="form-group">
                                    <label for="role" class="form-label">
                                        <i class="fas fa-user-tag me-1"></i>
                                        Rôle *
                                    </label>
                                    <select class="form-control" id="role" name="role" required>
                                        <option value="user" <?= ($_POST['role'] ?? '') === 'user' ? 'selected' : '' ?>>
                                            <i class="fas fa-user"></i> Utilisateur
                                        </option>
                                        <option value="admin" <?= ($_POST['role'] ?? '') === 'admin' ? 'selected' : '' ?>>
                                            <i class="fas fa-user-shield"></i> Administrateur
                                        </option>
                                    </select>
                                    <small class="text-muted">
                                        <strong>Utilisateur :</strong> Accès limité aux fonctionnalités de base.<br>
                                        <strong>Administrateur :</strong> Accès complet à toutes les fonctionnalités.
                                    </small>
                                </div>

                                <div class="d-flex gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>
                                        Créer l'utilisateur
                                    </button>
                                    <a href="<?= $config['app']['url'] ?>/frontend/users" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>
                                        Annuler
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fas fa-info-circle me-2"></i>
                                Informations
                            </h5>
                        </div>
                        <div class="card-body">
                            <h6>Rôles disponibles :</h6>

                            <div class="mb-3">
                                    <span class="badge badge-secondary d-block p-2 mb-2">
                                        <i class="fas fa-user me-1"></i>
                                        <strong>Utilisateur</strong>
                                    </span>
                                <small class="text-muted">
                                    • Accès au dashboard personnel<br>
                                    • Gestion de ses propres expéditions<br>
                                    • Vue en lecture seule des équipes
                                </small>
                            </div>

                            <div class="mb-3">
                                    <span class="badge badge-primary d-block p-2 mb-2">
                                        <i class="fas fa-user-shield me-1"></i>
                                        <strong>Administrateur</strong>
                                    </span>
                                <small class="text-muted">
                                    • Gestion complète des utilisateurs<br>
                                    • Accès à toutes les expéditions<br>
                                    • Rapports et statistiques avancées<br>
                                    • Configuration système
                                </small>
                            </div>

                            <hr>

                            <h6>Sécurité :</h6>
                            <small class="text-muted">
                                • Le mot de passe sera automatiquement chiffré<br>
                                • L'utilisateur peut modifier son mot de passe plus tard<br>
                                • Tous les champs marqués * sont obligatoires
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= $config['paths']['assets'] ?>/js/app.js"></script>

<script>
    // Auto-focus sur le premier champ
    document.getElementById('first_name').focus();

    // Validation côté client
    document.querySelector('form').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;

        if (password.length < 6) {
            e.preventDefault();
            alert('Le mot de passe doit contenir au moins 6 caractères.');
            document.getElementById('password').focus();
            return false;
        }
    });
</script>
</body>
</html>