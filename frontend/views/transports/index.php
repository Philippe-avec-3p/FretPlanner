<?php
// frontend/views/transports/index.php
$pageTitle = 'Gestion des transports';
$title = 'Transports - FretPlanner';
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
                        <a href="<?= $config['app']['url'] ?>/users" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Utilisateurs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $config['app']['url'] ?>/transports" class="nav-link active">
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
                        <a href="<?= $config['app']['url'] ?>/users" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Équipe</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $config['app']['url'] ?>/transports" class="nav-link active">
                            <i class="fas fa-shipping-fast"></i>
                            <span>Mes Transports</span>
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
                        <?= $isAdmin ? 'Gestion des transports' : 'Mes transports' ?>
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

            <!-- Header actions -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <p class="text-muted">
                        <?= $isAdmin ? 'Gérez tous les transports de la plateforme.' : 'Gérez vos demandes de transport.' ?>
                    </p>
                </div>
                <a href="<?= $config['app']['url'] ?>/transports/create" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Nouveau transport
                </a>
            </div>

            <!-- Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <select class="form-select" id="statusFilter">
                                <option value="">Tous les statuts</option>
                                <option value="pending">En attente</option>
                                <option value="confirmed">Confirmé</option>
                                <option value="pickup_ready">Prêt enlèvement</option>
                                <option value="in_progress">En cours</option>
                                <option value="delivered">Livré</option>
                                <option value="cancelled">Annulé</option>
                                <option value="delayed">Retardé</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="dateFilter" placeholder="Date d'enlèvement">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="searchFilter" placeholder="Rechercher une référence...">
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-secondary" onclick="clearFilters()">
                                <i class="fas fa-times me-2"></i>
                                Effacer les filtres
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transports list -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-shipping-fast me-2"></i>
                        Liste des transports (<?= count($transports) ?>)
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="transportsTable">
                            <thead>
                            <tr>
                                <th>Référence</th>
                                <?php if ($isAdmin): ?>
                                    <th>Client</th>
                                <?php endif; ?>
                                <th>Enlèvement</th>
                                <th>Livraison</th>
                                <th>Date enlèvement</th>
                                <th>Statut</th>
                                <th>Marchandise</th>
                                <th width="150">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($transports)): ?>
                                <?php
                                $transportModel = new Transport();
                                foreach ($transports as $transport):
                                    ?>
                                    <tr data-status="<?= $transport['status'] ?>" data-reference="<?= strtolower($transport['reference']) ?>" data-date="<?= $transport['pickup_date'] ?>">
                                        <td>
                                            <div class="fw-semibold text-primary"><?= htmlspecialchars($transport['reference']) ?></div>
                                            <small class="text-muted"><?= date('d/m/Y H:i', strtotime($transport['created_at'])) ?></small>
                                        </td>
                                        <?php if ($isAdmin): ?>
                                            <td>
                                                <div class="fw-semibold"><?= htmlspecialchars($transport['first_name'] . ' ' . $transport['last_name']) ?></div>
                                            </td>
                                        <?php endif; ?>
                                        <td>
                                            <small class="text-muted">
                                                <?= htmlspecialchars(substr($transport['pickup_address'], 0, 50)) ?>
                                                <?= strlen($transport['pickup_address']) > 50 ? '...' : '' ?>
                                            </small>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?= htmlspecialchars(substr($transport['delivery_address'], 0, 50)) ?>
                                                <?= strlen($transport['delivery_address']) > 50 ? '...' : '' ?>
                                            </small>
                                        </td>
                                        <td>
                                            <div class="fw-semibold"><?= date('d/m/Y', strtotime($transport['pickup_date'])) ?></div>
                                            <?php if ($transport['pickup_time']): ?>
                                                <small class="text-muted"><?= date('H:i', strtotime($transport['pickup_time'])) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                                    <span class="badge badge-<?= $transportModel->getStatusColor($transport['status']) ?>">
                                                        <?= $transportModel->getStatusLabel($transport['status']) ?>
                                                    </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?= htmlspecialchars(substr($transport['merchandise'], 0, 30)) ?>
                                                <?= strlen($transport['merchandise']) > 30 ? '...' : '' ?>
                                            </small>
                                            <?php if ($transport['weight']): ?>
                                                <br><small class="text-primary"><?= $transport['weight'] ?> kg</small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="<?= $config['app']['url'] ?>/transports/show?id=<?= $transport['id'] ?>"
                                                   class="btn btn-outline-primary" title="Voir">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <?php if ($isAdmin || in_array($transport['status'], ['pending', 'confirmed'])): ?>
                                                    <a href="<?= $config['app']['url'] ?>/transports/edit?id=<?= $transport['id'] ?>"
                                                       class="btn btn-outline-secondary" title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($isAdmin): ?>
                                                    <form method="POST" action="<?= $config['app']['url'] ?>/transports/delete"
                                                          style="display: inline;"
                                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce transport ?')">
                                                        <input type="hidden" name="id" value="<?= $transport['id'] ?>">
                                                        <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="<?= $isAdmin ? '8' : '7' ?>" class="text-center text-muted py-4">
                                        <i class="fas fa-shipping-fast fa-2x mb-3 d-block"></i>
                                        <?= $isAdmin ? 'Aucun transport dans le système.' : 'Vous n\'avez encore aucun transport.' ?>
                                        <br>
                                        <a href="<?= $config['app']['url'] ?>/transports/create" class="btn btn-primary btn-sm mt-2">
                                            <i class="fas fa-plus me-2"></i>
                                            Créer votre premier transport
                                        </a>
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

<script>
    // Filtres en temps réel
    function filterTable() {
        const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
        const dateFilter = document.getElementById('dateFilter').value;
        const searchFilter = document.getElementById('searchFilter').value.toLowerCase();
        const rows = document.querySelectorAll('#transportsTable tbody tr');

        rows.forEach(row => {
            if (row.cells.length === 1) return; // Skip empty row

            const status = row.getAttribute('data-status');
            const reference = row.getAttribute('data-reference');
            const date = row.getAttribute('data-date');

            let showRow = true;

            // Filter by status
            if (statusFilter && status !== statusFilter) {
                showRow = false;
            }

            // Filter by date
            if (dateFilter && date !== dateFilter) {
                showRow = false;
            }

            // Filter by search
            if (searchFilter && !reference.includes(searchFilter)) {
                showRow = false;
            }

            row.style.display = showRow ? '' : 'none';
        });
    }

    function clearFilters() {
        document.getElementById('statusFilter').value = '';
        document.getElementById('dateFilter').value = '';
        document.getElementById('searchFilter').value = '';
        filterTable();
    }

    // Event listeners
    document.getElementById('statusFilter').addEventListener('change', filterTable);
    document.getElementById('dateFilter').addEventListener('change', filterTable);
    document.getElementById('searchFilter').addEventListener('input', filterTable);
</script>
</body>
</html>