<?php
// frontend/views/users/show.php
$pageTitle = 'Détails utilisateur';
$title = htmlspecialchars($targetUser['first_name'] . ' ' . $targetUser['last_name']) . ' - FretPlanner';
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
    <!-- Sidebar (même que users/index) -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <a href="<?= $config['app']['url'] ?>/frontend/<?= $isAdmin ? 'admin/dashboard' : 'dashboard' ?>" class="sidebar-brand">
                <i class="fas fa-truck-moving me-2"></i>
                <?= $config['app']['name'] ?>
            </a>
        </div>

        <div class="sidebar-nav">
            <ul class="nav flex-column">
                <?php if ($isAdmin): ?>
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
                <?php else: ?>
                    <li class="nav-item">
                        <a href="<?= $config['app']['url'] ?>/dashboard" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $config['app']['url'] ?>/users" class="nav-link active">
                            <i class="fas fa-users"></i>
                            <span>Équipe</span>
                        </a>
                    </li>
                <?php endif; ?>

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
                        <?= htmlspecialchars($targetUser['first_name'] . ' ' . $targetUser['last_name']) ?>
                    </h1>
                </div>

                <div class="header-actions">
                    <?php if ($isAdmin): ?>
                        <a href="<?= $config['app']['url'] ?>/users/edit?id=<?= $targetUser['id'] ?>" class="btn btn-primary me-2">
                            <i class="fas fa-edit me-2"></i>
                            Modifier
                        </a>
                    <?php endif; ?>
                    <a href="<?= $config['app']['url'] ?>/users" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Retour
                    </a>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="content">
            <div class="row">
                <!-- User Profile -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="user-avatar mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                                <?= strtoupper(substr($targetUser['first_name'], 0, 1)) ?>
                            </div>

                            <h4 class="mb-1"><?= htmlspecialchars($targetUser['first_name'] . ' ' . $targetUser['last_name']) ?></h4>

                            <div class="mb-3">
                                    <span class="badge <?= $targetUser['role'] === 'admin' ? 'badge-primary' : 'badge-secondary' ?> fs-6">
                                        <i class="fas <?= $targetUser['role'] === 'admin' ? 'fa-user-shield' : 'fa-user' ?> me-1"></i>
                                        <?= ucfirst($targetUser['role']) ?>
                                    </span>
                            </div>

                            <div class="mb-3">
                                    <span class="badge <?= $targetUser['is_active'] ? 'badge-success' : 'badge-danger' ?> fs-6">
                                        <i class="fas <?= $targetUser['is_active'] ? 'fa-check-circle' : 'fa-times-circle' ?> me-1"></i>
                                        <?= $targetUser['is_active'] ? 'Compte actif' : 'Compte inactif' ?>
                                    </span>
                            </div>

                            <?php if ($targetUser['id'] == $user['id']): ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Il s'agit de votre profil
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fas fa-address-card me-2"></i>
                                Informations de contact
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="text-muted small">Adresse email :</label>
                                <div class="fw-semibold">
                                    <i class="fas fa-envelope me-2 text-muted"></i>
                                    <?= htmlspecialchars($targetUser['email']) ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="text-muted small">Membre depuis :</label>
                                <div class="fw-semibold">
                                    <i class="fas fa-calendar me-2 text-muted"></i>
                                    <?= date('d/m/Y à H:i', strtotime($targetUser['created_at'])) ?>
                                </div>
                            </div>

                            <?php if (isset($targetUser['updated_at']) && $targetUser['updated_at'] !== $targetUser['created_at']): ?>
                                <div class="mb-3">
                                    <label class="text-muted small">Dernière modification :</label>
                                    <div class="fw-semibold">
                                        <i class="fas fa-clock me-2 text-muted"></i>
                                        <?= date('d/m/Y à H:i', strtotime($targetUser['updated_at'])) ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- User Details & Stats -->
                <div class="col-lg-8">
                    <!-- Permissions & Capabilities -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fas fa-key me-2"></i>
                                Permissions et accès
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if ($targetUser['role'] === 'admin'): ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-primary">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Accès administrateur
                                        </h6>
                                        <ul class="list-unstyled">
                                            <li><i class="fas fa-check text-success me-2"></i>Gestion des utilisateurs</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Toutes les expéditions</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Rapports complets</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Configuration système</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-primary">
                                            <i class="fas fa-shield-alt me-1"></i>
                                            Droits spéciaux
                                        </h6>
                                        <ul class="list-unstyled">
                                            <li><i class="fas fa-check text-success me-2"></i>Créer/modifier des comptes</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Accès aux statistiques</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Gestion des rôles</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Configuration avancée</li>
                                        </ul>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-secondary">
                                            <i class="fas fa-user me-1"></i>
                                            Accès utilisateur standard
                                        </h6>
                                        <ul class="list-unstyled">
                                            <li><i class="fas fa-check text-success me-2"></i>Dashboard personnel</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Ses propres expéditions</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Suivi des colis</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Profil utilisateur</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-muted">
                                            <i class="fas fa-times-circle me-1"></i>
                                            Accès restreint
                                        </h6>
                                        <ul class="list-unstyled">
                                            <li><i class="fas fa-times text-danger me-2"></i>Gestion des utilisateurs</li>
                                            <li><i class="fas fa-times text-danger me-2"></i>Configuration système</li>
                                            <li><i class="fas fa-times text-danger me-2"></i>Rapports globaux</li>
                                            <li><i class="fas fa-times text-danger me-2"></i>Statistiques complètes</li>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Activity Stats -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fas fa-chart-bar me-2"></i>
                                Statistiques d'activité
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <div class="stat-icon blue mx-auto mb-2" style="width: 50px; height: 50px;">
                                            <i class="fas fa-shipping-fast"></i>
                                        </div>
                                        <h4 class="mb-1">0</h4>
                                        <small class="text-muted">Expéditions</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <div class="stat-icon green mx-auto mb-2" style="width: 50px; height: 50px;">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <h4 class="mb-1">0</h4>
                                        <small class="text-muted">Terminées</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <div class="stat-icon yellow mx-auto mb-2" style="width: 50px; height: 50px;">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <h4 class="mb-1">0</h4>
                                        <small class="text-muted">En cours</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <div class="stat-icon blue mx-auto mb-2" style="width: 50px; height: 50px;">
                                            <i class="fas fa-euro-sign"></i>
                                        </div>
                                        <h4 class="mb-1">0€</h4>
                                        <small class="text-muted">Chiffre d'affaires</small>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="text-center text-muted">
                                <i class="fas fa-info-circle me-2"></i>
                                Les statistiques d'activité seront disponibles une fois le module d'expéditions implémenté.
                            </div>
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
</body>
</html>