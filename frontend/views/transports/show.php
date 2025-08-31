<?php
// frontend/views/transports/show.php
$pageTitle = 'Transport ' . $transport['reference'];
$title = 'Transport ' . htmlspecialchars($transport['reference']) . ' - FretPlanner';
$isAdmin = ($user['role'] === 'admin');
$canEdit = ($isAdmin || in_array($transport['status'], ['pending', 'confirmed']));
$transportModel = new Transport();
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
    <!-- Sidebar (même que les autres pages) -->
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
                    <div>
                        <h1 class="header-title">Transport <?= htmlspecialchars($transport['reference']) ?></h1>
                        <span class="badge badge-<?= $transportModel->getStatusColor($transport['status']) ?> fs-6">
                                <?= $transportModel->getStatusLabel($transport['status']) ?>
                            </span>
                    </div>
                </div>

                <div class="header-actions">
                    <?php if ($canEdit): ?>
                        <a href="<?= $config['app']['url'] ?>/transports/edit?id=<?= $transport['id'] ?>" class="btn btn-primary me-2">
                            <i class="fas fa-edit me-2"></i>
                            Modifier
                        </a>
                    <?php endif; ?>
                    <a href="<?= $config['app']['url'] ?>/transports" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Retour
                    </a>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="content">
            <div class="row">
                <!-- Transport Timeline -->
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fas fa-route me-2"></i>
                                Suivi du transport
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <div class="timeline-item <?= in_array($transport['status'], ['pending', 'confirmed', 'pickup_ready', 'in_progress', 'delivered']) ? 'active' : '' ?>">
                                    <div class="timeline-marker bg-warning"></div>
                                    <div class="timeline-content">
                                        <h6>Demande créée</h6>
                                        <small class="text-muted"><?= date('d/m/Y H:i', strtotime($transport['created_at'])) ?></small>
                                    </div>
                                </div>

                                <div class="timeline-item <?= in_array($transport['status'], ['confirmed', 'pickup_ready', 'in_progress', 'delivered']) ? 'active' : '' ?>">
                                    <div class="timeline-marker bg-info"></div>
                                    <div class="timeline-content">
                                        <h6>Demande confirmée</h6>
                                        <small class="text-muted"><?= $transport['status'] != 'pending' ? 'Confirmé' : 'En attente' ?></small>
                                    </div>
                                </div>

                                <div class="timeline-item <?= in_array($transport['status'], ['pickup_ready', 'in_progress', 'delivered']) ? 'active' : '' ?>">
                                    <div class="timeline-marker bg-primary"></div>
                                    <div class="timeline-content">
                                        <h6>Prêt pour enlèvement</h6>
                                        <small class="text-muted">
                                            <?= date('d/m/Y', strtotime($transport['pickup_date'])) ?>
                                            <?= $transport['pickup_time'] ? ' à ' . date('H:i', strtotime($transport['pickup_time'])) : '' ?>
                                        </small>
                                    </div>
                                </div>

                                <div class="timeline-item <?= in_array($transport['status'], ['in_progress', 'delivered']) ? 'active' : '' ?>">
                                    <div class="timeline-marker bg-primary"></div>
                                    <div class="timeline-content">
                                        <h6>Transport en cours</h6>
                                        <small class="text-muted"><?= $transport['status'] == 'in_progress' ? 'En cours de transport' : 'En attente' ?></small>
                                    </div>
                                </div>

                                <div class="timeline-item <?= $transport['status'] == 'delivered' ? 'active' : '' ?>">
                                    <div class="timeline-marker bg-success"></div>
                                    <div class="timeline-content">
                                        <h6>Livraison effectuée</h6>
                                        <small class="text-muted">
                                            <?= $transport['delivery_date'] ? date('d/m/Y', strtotime($transport['delivery_date'])) : 'À définir' ?>
                                            <?= $transport['delivery_time'] ? ' à ' . date('H:i', strtotime($transport['delivery_time'])) : '' ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transport Info -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title">
                                <i class="fas fa-info-circle me-2"></i>
                                Informations générales
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="text-muted small">Référence :</label>
                                <div class="fw-semibold text-primary"><?= htmlspecialchars($transport['reference']) ?></div>
                            </div>

                            <?php if ($isAdmin): ?>
                                <div class="mb-3">
                                    <label class="text-muted small">Demandeur :</label>
                                    <div class="fw-semibold">
                                        <?= htmlspecialchars($transport['first_name'] . ' ' . $transport['last_name']) ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <label class="text-muted small">Statut :</label>
                                <div>
                                        <span class="badge badge-<?= $transportModel->getStatusColor($transport['status']) ?>">
                                            <?= $transportModel->getStatusLabel($transport['status']) ?>
                                        </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="text-muted small">Créé le :</label>
                                <div class="fw-semibold">
                                    <?= date('d/m/Y à H:i', strtotime($transport['created_at'])) ?>
                                </div>
                            </div>

                            <?php if ($transport['updated_at'] !== $transport['created_at']): ?>
                                <div class="mb-3">
                                    <label class="text-muted small">Dernière modification :</label>
                                    <div class="fw-semibold">
                                        <?= date('d/m/Y à H:i', strtotime($transport['updated_at'])) ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Transport Details -->
                <div class="col-lg-8">
                    <!-- Adresses -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                Adresses d'enlèvement et de livraison
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="border rounded p-3 bg-light">
                                        <h6 class="text-success mb-2">
                                            <i class="fas fa-arrow-up me-2"></i>
                                            Adresse d'enlèvement
                                        </h6>
                                        <div class="transport-address">
                                            <?= nl2br(htmlspecialchars($transport['pickup_address'])) ?>
                                        </div>
                                        <?php if ($transport['pickup_date']): ?>
                                            <hr>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                <?= date('d/m/Y', strtotime($transport['pickup_date'])) ?>
                                                <?= $transport['pickup_time'] ? ' à ' . date('H:i', strtotime($transport['pickup_time'])) : '' ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="border rounded p-3 bg-light">
                                        <h6 class="text-primary mb-2">
                                            <i class="fas fa-arrow-down me-2"></i>
                                            Adresse de livraison
                                        </h6>
                                        <div class="transport-address">
                                            <?= nl2br(htmlspecialchars($transport['delivery_address'])) ?>
                                        </div>
                                        <?php if ($transport['delivery_date']): ?>
                                            <hr>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                <?= date('d/m/Y', strtotime($transport['delivery_date'])) ?>
                                                <?= $transport['delivery_time'] ? ' à ' . date('H:i', strtotime($transport['delivery_time'])) : '' ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Marchandise -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fas fa-boxes me-2"></i>
                                Description de la marchandise
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6>Description :</h6>
                                <div class="border rounded p-3 bg-light">
                                    <?= nl2br(htmlspecialchars($transport['merchandise'])) ?>
                                </div>
                            </div>

                            <div class="row">
                                <?php if ($transport['weight']): ?>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center p-3 bg-light rounded">
                                            <div class="stat-icon blue me-3" style="width: 50px; height: 50px;">
                                                <i class="fas fa-weight-hanging"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold fs-4"><?= number_format($transport['weight'], 2) ?> kg</div>
                                                <small class="text-muted">Poids total</small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($transport['volume']): ?>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center p-3 bg-light rounded">
                                            <div class="stat-icon green me-3" style="width: 50px; height: 50px;">
                                                <i class="fas fa-cube"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold fs-4"><?= number_format($transport['volume'], 2) ?> m³</div>
                                                <small class="text-muted">Volume total</small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if ($transport['special_instructions']): ?>
                                <div class="mt-3">
                                    <h6>Instructions spéciales :</h6>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <?= nl2br(htmlspecialchars($transport['special_instructions'])) ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Actions -->
                    <?php if ($isAdmin || $canEdit): ?>
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title">
                                    <i class="fas fa-cogs me-2"></i>
                                    Actions
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex gap-2 flex-wrap">
                                    <?php if ($canEdit): ?>
                                        <a href="<?= $config['app']['url'] ?>/transports/edit?id=<?= $transport['id'] ?>" class="btn btn-primary">
                                            <i class="fas fa-edit me-2"></i>
                                            Modifier le transport
                                        </a>
                                    <?php endif; ?>

                                    <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                                        <i class="fas fa-print me-2"></i>
                                        Imprimer
                                    </button>

                                    <button type="button" class="btn btn-outline-info" onclick="copyReference()">
                                        <i class="fas fa-copy me-2"></i>
                                        Copier la référence
                                    </button>

                                    <?php if ($isAdmin): ?>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-warning dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-exchange-alt me-2"></i>
                                                Changer le statut
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus('confirmed')">
                                                        <span class="badge badge-info me-2">Confirmé</span>
                                                    </a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus('pickup_ready')">
                                                        <span class="badge badge-primary me-2">Prêt enlèvement</span>
                                                    </a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus('in_progress')">
                                                        <span class="badge badge-primary me-2">En cours</span>
                                                    </a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus('delivered')">
                                                        <span class="badge badge-success me-2">Livré</span>
                                                    </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus('delayed')">
                                                        <span class="badge badge-danger me-2">Retardé</span>
                                                    </a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus('cancelled')">
                                                        <span class="badge badge-danger me-2">Annulé</span>
                                                    </a></li>
                                            </ul>
                                        </div>

                                        <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                                            <i class="fas fa-trash me-2"></i>
                                            Supprimer
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= $config['paths']['assets'] ?>/js/app.js"></script>

<script>
    function copyReference() {
        const reference = '<?= $transport['reference'] ?>';
        navigator.clipboard.writeText(reference).then(function() {
            FretPlanner.notify('Référence copiée : ' + reference, 'success');
        }).catch(function(err) {
            console.error('Erreur lors de la copie : ', err);
        });
    }

    <?php if ($isAdmin): ?>
    function changeStatus(newStatus) {
        if (confirm('Êtes-vous sûr de vouloir changer le statut de ce transport ?')) {
            // Créer un formulaire pour envoyer la mise à jour du statut
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= $config['app']['url'] ?>/transports/update';

            // Ajouter les données du transport
            form.appendChild(createHiddenInput('id', '<?= $transport['id'] ?>'));
            form.appendChild(createHiddenInput('pickup_address', '<?= addslashes($transport['pickup_address']) ?>'));
            form.appendChild(createHiddenInput('delivery_address', '<?= addslashes($transport['delivery_address']) ?>'));
            form.appendChild(createHiddenInput('pickup_date', '<?= $transport['pickup_date'] ?>'));
            form.appendChild(createHiddenInput('pickup_time', '<?= $transport['pickup_time'] ?>'));
            form.appendChild(createHiddenInput('delivery_date', '<?= $transport['delivery_date'] ?>'));
            form.appendChild(createHiddenInput('delivery_time', '<?= $transport['delivery_time'] ?>'));
            form.appendChild(createHiddenInput('merchandise', '<?= addslashes($transport['merchandise']) ?>'));
            form.appendChild(createHiddenInput('weight', '<?= $transport['weight'] ?>'));
            form.appendChild(createHiddenInput('volume', '<?= $transport['volume'] ?>'));
            form.appendChild(createHiddenInput('special_instructions', '<?= addslashes($transport['special_instructions']) ?>'));
            form.appendChild(createHiddenInput('status', newStatus));

            document.body.appendChild(form);
            form.submit();
        }
    }

    function createHiddenInput(name, value) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value || '';
        return input;
    }

    function confirmDelete() {
        if (confirm('Êtes-vous sûr de vouloir supprimer définitivement ce transport ?\n\nCette action est irréversible !')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= $config['app']['url'] ?>/transports/delete';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'id';
            input.value = '<?= $transport['id'] ?>';

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    }
    <?php endif; ?>
</script>

<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }

    .timeline-marker {
        position: absolute;
        left: -23px;
        top: 5px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 3px solid white;
    }

    .timeline-item.active .timeline-marker {
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.2);
    }

    .timeline-item:not(.active) .timeline-marker {
        background: #e9ecef !important;
    }

    .transport-address {
        line-height: 1.6;
        white-space: pre-line;
    }

    @media print {
        .sidebar, .header-actions, .card:last-child {
            display: none !important;
        }

        .main-content {
            margin-left: 0 !important;
        }
    }
</style>
</body>
</html>