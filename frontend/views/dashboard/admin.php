<?php
// frontend/views/dashboard/admin.php
$pageTitle = 'Dashboard Administrateur';
$title = 'Dashboard Admin - FretPlanner';
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
                    <a href="<?= $config['app']['url'] ?>/admin/dashboard" class="nav-link active">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard Admin</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $config['app']['url'] ?>/admin/users" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Utilisateurs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $config['app']['url'] ?>/admin/shipments" class="nav-link">
                        <i class="fas fa-shipping-fast"></i>
                        <span>Expéditions</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $config['app']['url'] ?>/admin/reports" class="nav-link">
                        <i class="fas fa-chart-bar"></i>
                        <span>Rapports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $config['app']['url'] ?>/admin/settings" class="nav-link">
                        <i class="fas fa-cogs"></i>
                        <span>Configuration</span>
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
                    <h1 class="header-title">Dashboard Administrateur</h1>
                </div>

                <div class="header-actions">
                    <div class="dropdown">
                        <a href="#" class="user-menu dropdown-toggle" data-bs-toggle="dropdown">
                            <div class="user-avatar">
                                <?= strtoupper(substr($user['first_name'], 0, 1)) ?>
                            </div>
                            <div class="d-none d-sm-block">
                                <div class="fw-semibold"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></div>
                                <small class="text-muted">Administrateur</small>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= $config['app']['url'] ?>/profile"><i class="fas fa-user me-2"></i>Mon Profil</a></li>
                            <li><a class="dropdown-item" href="<?= $config['app']['url'] ?>/admin/settings"><i class="fas fa-cog me-2"></i>Configuration</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= $config['app']['url'] ?>/logout" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?')"><i class="fas fa-sign-out-alt me-2"></i>Déconnexion</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="content">
            <!-- Welcome message -->
            <div class="mb-4">
                <h2>Tableau de bord administrateur</h2>
                <p class="text-muted">Vue d'ensemble de la plateforme FretPlanner.</p>
            </div>

            <!-- Stats cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-value"><?= $stats['total_users'] ?></div>
                    <div class="stat-label">Utilisateurs totaux</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stat-value"><?= $stats['active_users'] ?></div>
                    <div class="stat-label">Utilisateurs actifs</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon yellow">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <div class="stat-value"><?= $stats['total_shipments'] ?></div>
                    <div class="stat-label">Expéditions totales</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fas fa-euro-sign"></i>
                    </div>
                    <div class="stat-value"><?= number_format($stats['total_revenue'], 0, ',', ' ') ?>€</div>
                    <div class="stat-label">Chiffre d'affaires total</div>
                </div>
            </div>

            <!-- Admin actions -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Actions administrateur</h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6 col-lg-3">
                            <a href="<?= $config['app']['url'] ?>/frontend/admin/shipments" class="btn btn-primary w-100">
                                <i class="fas fa-shipping-fast me-2"></i>
                                Nouvelle expédition
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <a href="<?= $config['app']['url'] ?>/frontend/admin/reports" class="btn btn-outline-primary w-100">
                                <i class="fas fa-chart-line me-2"></i>
                                Générer rapport
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <a href="<?= $config['app']['url'] ?>/frontend/admin/shipments" class="btn btn-outline-primary w-100">
                                <i class="fas fa-list me-2"></i>
                                Toutes les expéditions
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <a href="<?= $config['app']['url'] ?>/frontend/admin/settings" class="btn btn-outline-primary w-100">
                                <i class="fas fa-cogs me-2"></i>
                                Configuration
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent activity au lieu de la gestion des utilisateurs -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Activité récente</h3>
                </div>
                <div class="card-body">
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-history fa-2x mb-3 d-block"></i>
                        Aucune activité récente à afficher.
                        <br><br>
                        <small>
                            Pour gérer les utilisateurs, utilisez le menu <strong>"Utilisateurs"</strong> dans la barre latérale.
                        </small>
                    </div>
                </div>
            </div>

            <!-- System info -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Activité récente</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-history fa-2x mb-3 d-block"></i>
                                Aucune activité récente à afficher.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Informations système</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Version PHP:</strong> <?= PHP_VERSION ?>
                            </div>
                            <div class="mb-3">
                                <strong>Serveur:</strong> <?= $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' ?>
                            </div>
                            <div class="mb-3">
                                <strong>Base de données:</strong> MariaDB (Port 3307)
                            </div>
                            <div>
                                <strong>Statut:</strong>
                                <span class="badge badge-success">Opérationnel</span>
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