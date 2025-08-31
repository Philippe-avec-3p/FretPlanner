<?php
// frontend/views/users/index.php
$pageTitle = 'Gestion des utilisateurs';
$title = 'Utilisateurs - FretPlanner';
$currentUserRole = $user['role'];
$isAdmin = ($currentUserRole === 'admin');
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
            <a href="<?= $config['app']['url'] ?>/<?= $isAdmin ? 'admin/dashboard' : 'dashboard' ?>" class="sidebar-brand">
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
                    <li class="nav-item">
                        <a href="<?= $config['app']['url'] ?>/transports" class="nav-link">
                            <i class="fas fa-shipping-fast"></i>
                            <span>Mes transports</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $config['app']['url'] ?>/tracking" class="nav-link">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Suivi</span>
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
                        <?= $isAdmin ? 'Gestion des utilisateurs' : 'Notre équipe' ?>
                    </h1>
                </div>

                <div class="header-actions">
                    <div class="dropdown">
                        <a href="#" class="user-menu dropdown-toggle" data-bs-toggle="dropdown">
                            <div class="user-avatar">
                                <?= strtoupper(substr($user['first_name'], 0, 1)) ?>
                            </div>
                            <div class="d-none d-sm-block">
                                <div class="fw-semibold"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></div>
                                <small class="text-muted"><?= ucfirst($user['role']) ?></small>
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
            <!-- Alerts -->
            <?php if ($error = Session::flash('error')): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if ($success = Session::flash('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <!-- Header actions -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <p class="text-muted">
                        <?= $isAdmin ? 'Gérez les comptes utilisateurs de votre plateforme.' : 'Découvrez les membres de notre équipe.' ?>
                    </p>
                </div>
                <?php if ($isAdmin): ?>
                    <a href="<?= $config['app']['url'] ?>/users/create" class="btn btn-primary">
                        <i class="fas fa-user-plus me-2"></i>
                        Nouvel utilisateur
                    </a>
                <?php endif; ?>
            </div>

            <!-- Users list -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users me-2"></i>
                        Liste des utilisateurs (<?= count($users) ?>)
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Statut</th>
                                <th>Inscription</th>
                                <?php if ($isAdmin): ?>
                                    <th width="150">Actions</th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($users)): ?>
                                <?php foreach ($users as $userItem): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar me-3" style="width: 40px; height: 40px;">
                                                    <?= strtoupper(substr($userItem['first_name'], 0, 1)) ?>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold"><?= htmlspecialchars($userItem['first_name'] . ' ' . $userItem['last_name']) ?></div>
                                                    <?php if ($userItem['id'] == $user['id']): ?>
                                                        <small class="text-primary">C'est vous</small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($userItem['email']) ?></td>
                                        <td>
                                                    <span class="badge <?= $userItem['role'] === 'admin' ? 'badge-primary' : 'badge-secondary' ?>">
                                                        <i class="fas <?= $userItem['role'] === 'admin' ? 'fa-user-shield' : 'fa-user' ?> me-1"></i>
                                                        <?= ucfirst($userItem['role']) ?>
                                                    </span>
                                        </td>
                                        <td>
                                                    <span class="badge <?= $userItem['is_active'] ? 'badge-success' : 'badge-danger' ?>">
                                                        <i class="fas <?= $userItem['is_active'] ? 'fa-check-circle' : 'fa-times-circle' ?> me-1"></i>
                                                        <?= $userItem['is_active'] ? 'Actif' : 'Inactif' ?>
                                                    </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?= date('d/m/Y', strtotime($userItem['created_at'])) ?>
                                            </small>
                                        </td>
                                        <?php if ($isAdmin): ?>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?= $config['app']['url'] ?>/users/show?id=<?= $userItem['id'] ?>"
                                                       class="btn btn-outline-primary" title="Voir">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?= $config['app']['url'] ?>/users/edit?id=<?= $userItem['id'] ?>"
                                                       class="btn btn-outline-secondary" title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <?php if ($userItem['id'] != $user['id']): ?>
                                                        <form method="POST" action="<?= $config['app']['url'] ?>/users/delete"
                                                              style="display: inline;"
                                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                                            <input type="hidden" name="id" value="<?= $userItem['id'] ?>">
                                                            <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="<?= $isAdmin ? '6' : '5' ?>" class="text-center text-muted py-4">
                                        <i class="fas fa-users fa-2x mb-3 d-block"></i>
                                        Aucun utilisateur trouvé.
                                    </td>
                                </tr>
                            <?php endif; ?>
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