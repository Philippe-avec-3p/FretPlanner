<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard - FretPlanner' ?></title>

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
<?php
// Variables globales disponibles dans toutes les vues
$appName = $config['app']['name'];
$appUrl = $config['app']['url'];
$currentUser = $user;
$isAdmin = $user && $user['role'] === 'admin';
?>

<div class="app-container">
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <a href="<?= $appUrl ?>/dashboard" class="sidebar-brand">
                <i class="fas fa-truck-moving me-2"></i>
                <?= $appName ?>
            </a>
        </div>

        <div class="sidebar-nav">
            <ul class="nav flex-column">
                <?php if ($isAdmin): ?>
                    <li class="nav-item">
                        <a href="<?= $appUrl ?>/admin/dashboard" class="nav-link <?= ($_SERVER['REQUEST_URI'] == '/fretplanner/admin/dashboard') ? 'active' : '' ?>">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard Admin</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $appUrl ?>/admin/users" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Utilisateurs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $appUrl ?>/admin/shipments" class="nav-link">
                            <i class="fas fa-shipping-fast"></i>
                            <span>Expéditions</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $appUrl ?>/admin/reports" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Rapports</span>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="<?= $appUrl ?>/dashboard" class="nav-link <?= ($_SERVER['REQUEST_URI'] == '/fretplanner/dashboard') ? 'active' : '' ?>">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $appUrl ?>/shipments" class="nav-link">
                            <i class="fas fa-shipping-fast"></i>
                            <span>Mes Expéditions</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $appUrl ?>/shipments/create" class="nav-link">
                            <i class="fas fa-plus-circle"></i>
                            <span>Nouvelle Expédition</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $appUrl ?>/tracking" class="nav-link">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Suivi</span>
                        </a>
                    </li>
                <?php endif; ?>

                <hr style="border-color: rgba(255,255,255,0.1); margin: 1rem 0;">

                <li class="nav-item">
                    <a href="<?= $appUrl ?>/profile" class="nav-link">
                        <i class="fas fa-user"></i>
                        <span>Mon Profil</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $appUrl ?>/settings" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span>Paramètres</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $appUrl ?>/logout" class="nav-link" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?')">
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
                    <h1 class="header-title"><?= $pageTitle ?? 'Dashboard' ?></h1>
                </div>

                <div class="header-actions">
                    <div class="dropdown">
                        <a href="#" class="user-menu dropdown-toggle" data-bs-toggle="dropdown">
                            <div class="user-avatar">
                                <?= strtoupper(substr($currentUser['first_name'], 0, 1)) ?>
                            </div>
                            <div class="d-none d-sm-block">
                                <div class="fw-semibold"><?= htmlspecialchars($currentUser['first_name'] . ' ' . $currentUser['last_name']) ?></div>
                                <small class="text-muted"><?= ucfirst($currentUser['role']) ?></small>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= $appUrl ?>/profile"><i class="fas fa-user me-2"></i>Mon Profil</a></li>
                            <li><a class="dropdown-item" href="<?= $appUrl ?>/settings"><i class="fas fa-cog me-2"></i>Paramètres</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= $appUrl ?>/logout" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?')"><i class="fas fa-sign-out-alt me-2"></i>Déconnexion</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="content">
            <!-- Le contenu de la page sera inséré ici -->
        </div>
    </main>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= $config['paths']['assets'] ?>/js/app.js"></script>
</body>
</html>