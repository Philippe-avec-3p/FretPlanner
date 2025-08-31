<?php
// frontend/views/dashboard/user.php
$pageTitle = 'Dashboard';
$title = 'Dashboard - FretPlanner';
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
            <a href="<?= $config['app']['url'] ?>/dashboard" class="sidebar-brand">
                <i class="fas fa-truck-moving me-2"></i>
                <?= $config['app']['name'] ?>
            </a>
        </div>

        <div class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?= $config['app']['url'] ?>/dashboard" class="nav-link active">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $config['app']['url'] ?>/users" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Équipe</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $config['app']['url'] ?>/shipments/create" class="nav-link">
                        <i class="fas fa-plus-circle"></i>
                        <span>Nouvelle Expédition</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $config['app']['url'] ?>/tracking" class="nav-link">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Suivi</span>
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
                    <a href="<?= $config['app']['url'] ?>/settings" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span>Paramètres</span>
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
                    <h1 class="header-title">Dashboard</h1>
                </div>

                <div class="header-actions">
                    <div class="dropdown">
                        <a href="#" class="user-menu dropdown-toggle" data-bs-toggle="dropdown">
                            <div class="user-avatar">
                                <?= strtoupper(substr($user['first_name'], 0, 1)) ?>
                            </div>
                            <div class="d-none d-sm-block">
                                <div class="fw-semibold"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></div>
                                <small class="text-muted">Utilisateur</small>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= $config['app']['url'] ?>/profile"><i class="fas fa-user me-2"></i>Mon Profil</a></li>
                            <li><a class="dropdown-item" href="<?= $config['app']['url'] ?>/settings"><i class="fas fa-cog me-2"></i>Paramètres</a></li>
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
                <h2>Bonjour, <?= htmlspecialchars($user['first_name']) ?> !</h2>
                <p class="text-muted">Voici un aperçu de vos activités de fret.</p>
            </div>

            <!-- Stats cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <div class="stat-value"><?= $stats['total_transports'] ?></div>
                    <div class="stat-label">Total des transports</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon yellow">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-value"><?= $stats['pending_transports'] ?></div>
                    <div class="stat-label">En attente</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-value"><?= $stats['completed_transports'] ?></div>
                    <div class="stat-label">Terminés</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fas fa-weight-hanging"></i>
                    </div>
                    <div class="stat-value"><?= number_format($stats['total_weight'], 0) ?> kg</div>
                    <div class="stat-label">Poids total</div>
                </div>
            </div>

            <!-- Quick actions -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Actions rapides</h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6 col-lg-3">
                            <a href="<?= $config['app']['url'] ?>/transports/create" class="btn btn-primary w-100">
                                <i class="fas fa-plus-circle me-2"></i>
                                Nouveau transport
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <a href="<?= $config['app']['url'] ?>/tracking" class="btn btn-outline-primary w-100">
                                <i class="fas fa-search me-2"></i>
                                Suivi de transport
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <a href="<?= $config['app']['url'] ?>/transports" class="btn btn-outline-primary w-100">
                                <i class="fas fa-list me-2"></i>
                                Mes transports
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <a href="<?= $config['app']['url'] ?>/reports" class="btn btn-outline-primary w-100">
                                <i class="fas fa-chart-bar me-2"></i>
                                Rapports
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent transports -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Transports récents</h3>
                    <a href="<?= $config['app']['url'] ?>/transports" class="btn btn-sm btn-outline-primary">
                        Voir tout
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Référence</th>
                                <th>Destination</th>
                                <th>Statut</th>
                                <th>Date enlèvement</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-shipping-fast fa-2x mb-3 d-block"></i>
                                    Aucun transport pour le moment.<br>
                                    <a href="<?= $config['app']['url'] ?>/transports/create" class="btn btn-primary btn-sm mt-2">
                                        Créer votre premier transport
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
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