<?php
// frontend/views/users/edit.php
$pageTitle = 'Modifier utilisateur';
$title = 'Modifier ' . htmlspecialchars($targetUser['first_name'] . ' ' . $targetUser['last_name']) . ' - FretPlanner';
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
            <a href="<?= $config['app']['url'] ?>/admin/dashboard" class="sidebar-brand">
                <i class="fas fa-truck-moving me-2"></i>
                <?= $config['app']['name'] ?>
            </a>
        </div>

        <div class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?= $config['app']['url'] ?>/admin/dashboard" class="nav-link">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard Admin</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $config['app']['url'] ?>/users" class="nav-link active">
                        <i class="fas fa-users"></i>
                        <span>Utilisateurs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $config['app']['url'] ?>/admin/transports" class="nav-link">
                        <i class="fas fa-shipping-fast"></i>
                        <span>Transports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $config['app']['url'] ?>/admin/reports" class="nav-link">
                        <i class="fas fa-chart-bar"></i>
                        <span>Rapports</span>
                    </a>
                </li>

                <hr style="border-color: rgba(255,255,255,0.1); margin: 1rem 0;">

                <li class="nav-item">
                    <a href="<?= $config['app']['url'] ?>/profile" class="nav-link">
                        <i class="fas fa-user"></i>
                        <span>Mon Profil</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $config['app']['url'] ?>/logout" class="nav-link" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?')">
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
                    <h1 class="header-title">
                        Modifier <?= htmlspecialchars($targetUser['first_name'] . ' ' . $targetUser['last_name']) ?>
                    </h1>
                </div>

                <div class="header-actions">
                    <a href="<?= $config['app']['url'] ?>/users/show?id=<?= $targetUser['id'] ?>" class="btn btn-secondary me-2">
                        <i class="fas fa-eye me-2"></i>
                        Voir le profil
                    </a>
                    <a href="<?= $config['app']['url'] ?>/users" class="btn btn-secondary">
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
                                <i class="fas fa-edit me-2"></i>
                                Modifier les informations
                            </h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?= $config['app']['url'] ?>/users/update">
                                <input type="hidden" name="id" value="<?= $targetUser['id'] ?>">

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
                                                    value="<?= htmlspecialchars($targetUser['first_name']) ?>"
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
                                                    value="<?= htmlspecialchars($targetUser['last_name']) ?>"
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
                                            value="<?= htmlspecialchars($targetUser['email']) ?>"
                                            required
                                    >
                                </div>

                                <div class="form-group">
                                    <label for="role" class="form-label">
                                        <i class="fas fa-user-tag me-1"></i>
                                        Rôle *
                                    </label>
                                    <select class="form-control" id="role" name="role" required>
                                        <option value="user" <?= $targetUser['role'] === 'user' ? 'selected' : '' ?>>
                                            Utilisateur
                                        </option>
                                        <option value="admin" <?= $targetUser['role'] === 'admin' ? 'selected' : '' ?>>
                                            Administrateur
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <div class="form-check">
                                        <input
                                                type="checkbox"
                                                class="form-check-input"
                                                id="is_active"
                                                name="is_active"
                                                value="1"
                                            <?= $targetUser['is_active'] ? 'checked' : '' ?>
                                        >
                                        <label class="form-check-label" for="is_active">
                                            <i class="fas fa-toggle-on me-1"></i>
                                            Compte actif
                                        </label>
                                        <small class="form-text text-muted">
                                            Si décoché, l'utilisateur ne pourra plus se connecter.
                                        </small>
                                    </div>
                                </div>

                                <?php if ($targetUser['id'] == $user['id']): ?>
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong>Attention :</strong> Vous modifiez votre propre profil.
                                        Veillez à ne pas vous retirer les droits d'administrateur ou désactiver votre compte.
                                    </div>
                                <?php endif; ?>

                                <div class="d-flex gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>
                                        Sauvegarder les modifications
                                    </button>
                                    <a href="<?= $config['app']['url'] ?>/users/show?id=<?= $targetUser['id'] ?>" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>
                                        Annuler
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- User Info -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fas fa-user me-2"></i>
                                Profil actuel
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="user-avatar mx-auto mb-3" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                <?= strtoupper(substr($targetUser['first_name'], 0, 1)) ?>
                            </div>

                            <h6><?= htmlspecialchars($targetUser['first_name'] . ' ' . $targetUser['last_name']) ?></h6>
                            <p class="text-muted small"><?= htmlspecialchars($targetUser['email']) ?></p>

                            <div class="mb-2">
                                    <span class="badge <?= $targetUser['role'] === 'admin' ? 'badge-primary' : 'badge-secondary' ?>">
                                        <?= ucfirst($targetUser['role']) ?>
                                    </span>
                            </div>

                            <div>
                                    <span class="badge <?= $targetUser['is_active'] ? 'badge-success' : 'badge-danger' ?>">
                                        <?= $targetUser['is_active'] ? 'Actif' : 'Inactif' ?>
                                    </span>
                            </div>

                            <hr>

                            <small class="text-muted">
                                Membre depuis le<br>
                                <?= date('d/m/Y', strtotime($targetUser['created_at'])) ?>
                            </small>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fas fa-cogs me-2"></i>
                                Actions avancées
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-outline-warning btn-sm" onclick="resetPassword()">
                                    <i class="fas fa-key me-2"></i>
                                    Réinitialiser le mot de passe
                                </button>

                                <a href="<?= $config['app']['url'] ?>/users/show?id=<?= $targetUser['id'] ?>" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-eye me-2"></i>
                                    Voir le profil complet
                                </a>

                                <?php if ($targetUser['id'] != $user['id']): ?>
                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDelete()">
                                        <i class="fas fa-trash me-2"></i>
                                        Supprimer le compte
                                    </button>
                                <?php endif; ?>
                            </div>

                            <hr>

                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Les modifications sont sauvegardées immédiatement.
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
    function resetPassword() {
        if (confirm('Voulez-vous vraiment réinitialiser le mot de passe de cet utilisateur ?')) {
            alert('Fonctionnalité à implémenter : réinitialisation du mot de passe');
        }
    }

    function confirmDelete() {
        if (confirm('Êtes-vous sûr de vouloir supprimer définitivement cet utilisateur ?\n\nCette action est irréversible !')) {
            // Créer et soumettre un formulaire de suppression
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= $config['app']['url'] ?>/users/delete';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'id';
            input.value = '<?= $targetUser['id'] ?>';

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Auto-focus sur le premier champ
    document.getElementById('first_name').focus();
</script>
</body>
</html>