<?php
// frontend/views/transports/edit.php
$pageTitle = 'Modifier transport ' . $transport['reference'];
$title = 'Modifier ' . htmlspecialchars($transport['reference']) . ' - FretPlanner';
$isAdmin = ($user['role'] === 'admin');
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
                        <h1 class="header-title">Modifier <?= htmlspecialchars($transport['reference']) ?></h1>
                        <span class="badge badge-<?= $transportModel->getStatusColor($transport['status']) ?> fs-6">
                                <?= $transportModel->getStatusLabel($transport['status']) ?>
                            </span>
                    </div>
                </div>

                <div class="header-actions">
                    <a href="<?= $config['app']['url'] ?>/transports/show?id=<?= $transport['id'] ?>" class="btn btn-secondary me-2">
                        <i class="fas fa-eye me-2"></i>
                        Voir le transport
                    </a>
                    <a href="<?= $config['app']['url'] ?>/transports" class="btn btn-secondary">
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
            <form method="POST" action="<?= $config['app']['url'] ?>/transports/update">
                <input type="hidden" name="id" value="<?= $transport['id'] ?>">

                <div class="row">
                    <div class="col-lg-8">
                        <!-- Informations principales -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Informations du transport
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-hashtag me-1"></i>
                                                Référence
                                            </label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                value="<?= htmlspecialchars($transport['reference']) ?>"
                                                readonly
                                                style="background: #f8f9fa;"
                                            >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-user me-1"></i>
                                                Demandeur
                                            </label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                value="<?= htmlspecialchars($transport['first_name'] . ' ' . $transport['last_name']) ?>"
                                                readonly
                                                style="background: #f8f9fa;"
                                            >
                                        </div>
                                    </div>
                                </div>

                                <?php if ($isAdmin): ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="status" class="form-label">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Statut du transport
                                                </label>
                                                <select class="form-control" id="status" name="status">
                                                    <option value="pending" <?= $transport['status'] === 'pending' ? 'selected' : '' ?>>En attente</option>
                                                    <option value="confirmed" <?= $transport['status'] === 'confirmed' ? 'selected' : '' ?>>Confirmé</option>
                                                    <option value="pickup_ready" <?= $transport['status'] === 'pickup_ready' ? 'selected' : '' ?>>Prêt enlèvement</option>
                                                    <option value="in_progress" <?= $transport['status'] === 'in_progress' ? 'selected' : '' ?>>En cours</option>
                                                    <option value="delivered" <?= $transport['status'] === 'delivered' ? 'selected' : '' ?>>Livré</option>
                                                    <option value="cancelled" <?= $transport['status'] === 'cancelled' ? 'selected' : '' ?>>Annulé</option>
                                                    <option value="delayed" <?= $transport['status'] === 'delayed' ? 'selected' : '' ?>>Retardé</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

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
                                        <div class="form-group">
                                            <label for="pickup_address" class="form-label required">
                                                <i class="fas fa-arrow-up me-1 text-success"></i>
                                                Adresse d'enlèvement *
                                            </label>
                                            <textarea
                                                class="form-control"
                                                id="pickup_address"
                                                name="pickup_address"
                                                rows="4"
                                                required
                                            ><?= htmlspecialchars($transport['pickup_address']) ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="delivery_address" class="form-label required">
                                                <i class="fas fa-arrow-down me-1 text-primary"></i>
                                                Adresse de livraison *
                                            </label>
                                            <textarea
                                                class="form-control"
                                                id="delivery_address"
                                                name="delivery_address"
                                                rows="4"
                                                required
                                            ><?= htmlspecialchars($transport['delivery_address']) ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Planning -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    Planning d'enlèvement et de livraison
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-success">
                                            <i class="fas fa-arrow-up me-1"></i>
                                            Enlèvement
                                        </h6>

                                        <div class="form-group">
                                            <label for="pickup_date" class="form-label required">
                                                Date d'enlèvement *
                                            </label>
                                            <input
                                                type="date"
                                                class="form-control"
                                                id="pickup_date"
                                                name="pickup_date"
                                                value="<?= $transport['pickup_date'] ?>"
                                                required
                                            >
                                        </div>

                                        <div class="form-group">
                                            <label for="pickup_time" class="form-label">
                                                Heure d'enlèvement
                                            </label>
                                            <input
                                                type="time"
                                                class="form-control"
                                                id="pickup_time"
                                                name="pickup_time"
                                                value="<?= $transport['pickup_time'] ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <h6 class="text-primary">
                                            <i class="fas fa-arrow-down me-1"></i>
                                            Livraison
                                        </h6>

                                        <div class="form-group">
                                            <label for="delivery_date" class="form-label">
                                                Date de livraison souhaitée
                                            </label>
                                            <input
                                                type="date"
                                                class="form-control"
                                                id="delivery_date"
                                                name="delivery_date"
                                                value="<?= $transport['delivery_date'] ?>"
                                            >
                                        </div>

                                        <div class="form-group">
                                            <label for="delivery_time" class="form-label">
                                                Heure de livraison souhaitée
                                            </label>
                                            <input
                                                type="time"
                                                class="form-control"
                                                id="delivery_time"
                                                name="delivery_time"
                                                value="<?= $transport['delivery_time'] ?>"
                                            >
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
                                <div class="form-group">
                                    <label for="merchandise" class="form-label required">
                                        <i class="fas fa-box me-1"></i>
                                        Description de la marchandise *
                                    </label>
                                    <textarea
                                        class="form-control"
                                        id="merchandise"
                                        name="merchandise"
                                        rows="4"
                                        required
                                    ><?= htmlspecialchars($transport['merchandise']) ?></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="weight" class="form-label">
                                                <i class="fas fa-weight-hanging me-1"></i>
                                                Poids total (kg)
                                            </label>
                                            <input
                                                type="number"
                                                class="form-control"
                                                id="weight"
                                                name="weight"
                                                step="0.01"
                                                min="0"
                                                value="<?= $transport['weight'] ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="volume" class="form-label">
                                                <i class="fas fa-cube me-1"></i>
                                                Volume total (m³)
                                            </label>
                                            <input
                                                type="number"
                                                class="form-control"
                                                id="volume"
                                                name="volume"
                                                step="0.01"
                                                min="0"
                                                value="<?= $transport['volume'] ?>"
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="special_instructions" class="form-label">
                                        <i class="fas fa-sticky-note me-1"></i>
                                        Instructions spéciales
                                    </label>
                                    <textarea
                                        class="form-control"
                                        id="special_instructions"
                                        name="special_instructions"
                                        rows="3"
                                    ><?= htmlspecialchars($transport['special_instructions']) ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Sauvegarder les modifications
                            </button>
                            <a href="<?= $config['app']['url'] ?>/transports/show?id=<?= $transport['id'] ?>" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>
                                Annuler
                            </a>
                        </div>
                    </div>

                    <!-- Sidebar info -->
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Informations sur le transport
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="text-muted small">Référence :</label>
                                    <div class="fw-semibold text-primary"><?= htmlspecialchars($transport['reference']) ?></div>
                                </div>

                                <div class="mb-3">
                                    <label class="text-muted small">Statut actuel :</label>
                                    <div>
                                            <span class="badge badge-<?= $transportModel->getStatusColor($transport['status']) ?>">
                                                <?= $transportModel->getStatusLabel($transport['status']) ?>
                                            </span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="text-muted small">Créé le :</label>
                                    <div class="fw-semibold"><?= date('d/m/Y à H:i', strtotime($transport['created_at'])) ?></div>
                                </div>

                                <?php if ($transport['updated_at'] !== $transport['created_at']): ?>
                                    <div class="mb-3">
                                        <label class="text-muted small">Dernière modification :</label>
                                        <div class="fw-semibold"><?= date('d/m/Y à H:i', strtotime($transport['updated_at'])) ?></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if (!$isAdmin && !in_array($transport['status'], ['pending', 'confirmed'])): ?>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="card-title text-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Modifications limitées
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted">
                                        Ce transport est en statut "<?= $transportModel->getStatusLabel($transport['status']) ?>".
                                        Certaines modifications peuvent être limitées.
                                    </p>
                                    <p class="text-muted">
                                        Contactez notre équipe si vous avez besoin de modifications importantes.
                                    </p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title">
                                    <i class="fas fa-cogs me-2"></i>
                                    Actions avancées
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="<?= $config['app']['url'] ?>/transports/show?id=<?= $transport['id'] ?>" class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-eye me-2"></i>
                                        Voir le transport complet
                                    </a>

                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="duplicateTransport()">
                                        <i class="fas fa-copy me-2"></i>
                                        Dupliquer ce transport
                                    </button>

                                    <?php if ($isAdmin): ?>
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDelete()">
                                            <i class="fas fa-trash me-2"></i>
                                            Supprimer le transport
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= $config['paths']['assets'] ?>/js/app.js"></script>

<script>
    // Auto-focus sur le premier champ modifiable
    document.getElementById('pickup_address').focus();

    // Validation avant envoi
    document.querySelector('form').addEventListener('submit', function(e) {
        const pickupAddress = document.getElementById('pickup_address').value.trim();
        const deliveryAddress = document.getElementById('delivery_address').value.trim();
        const pickupDate = document.getElementById('pickup_date').value;
        const merchandise = document.getElementById('merchandise').value.trim();

        if (!pickupAddress || !deliveryAddress || !pickupDate || !merchandise) {
            e.preventDefault();
            alert('Veuillez remplir tous les champs obligatoires (marqués d\'un *)');
            return false;
        }
    });

    function duplicateTransport() {
        if (confirm('Voulez-vous créer un nouveau transport basé sur celui-ci ?')) {
            // Redirection vers la page de création avec les données pré-remplies
            const params = new URLSearchParams({
                'pickup_address': document.getElementById('pickup_address').value,
                'delivery_address': document.getElementById('delivery_address').value,
                'merchandise': document.getElementById('merchandise').value,
                'weight': document.getElementById('weight').value,
                'volume': document.getElementById('volume').value,
                'special_instructions': document.getElementById('special_instructions').value
            });

            window.location.href = '<?= $config['app']['url'] ?>/transports/create?' + params.toString();
        }
    }

    <?php if ($isAdmin): ?>
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
</body>
</html>