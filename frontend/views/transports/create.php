<?php
// frontend/views/transports/create.php
$pageTitle = 'Nouveau transport';
$title = 'Créer un transport - FretPlanner';
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
                    <h1 class="header-title">Nouveau transport</h1>
                </div>

                <div class="header-actions">
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
            <form method="POST" action="<?= $config['app']['url'] ?>/transports/store" enctype="multipart/form-data">
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
                                                value="<?= $reference ?>"
                                                readonly
                                                style="background: #f8f9fa;"
                                            >
                                            <small class="text-muted">La référence sera générée automatiquement</small>
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
                                                value="<?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>"
                                                readonly
                                                style="background: #f8f9fa;"
                                            >
                                        </div>
                                    </div>
                                </div>
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
                                                placeholder="Entreprise ABC&#10;123 Rue de l'Industrie&#10;75001 Paris&#10;France"
                                                required
                                            ><?= htmlspecialchars($_POST['pickup_address'] ?? '') ?></textarea>
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
                                                placeholder="Client XYZ&#10;456 Avenue du Commerce&#10;69000 Lyon&#10;France"
                                                required
                                            ><?= htmlspecialchars($_POST['delivery_address'] ?? '') ?></textarea>
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
                                                min="<?= date('Y-m-d') ?>"
                                                value="<?= htmlspecialchars($_POST['pickup_date'] ?? '') ?>"
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
                                                value="<?= htmlspecialchars($_POST['pickup_time'] ?? '') ?>"
                                            >
                                            <small class="text-muted">Optionnel - Si vous avez un créneau préféré</small>
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
                                                value="<?= htmlspecialchars($_POST['delivery_date'] ?? '') ?>"
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
                                                value="<?= htmlspecialchars($_POST['delivery_time'] ?? '') ?>"
                                            >
                                            <small class="text-muted">Optionnel - Si vous avez un créneau préféré</small>
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
                                        placeholder="Équipements informatiques&#10;- 50 ordinateurs portables&#10;- 20 imprimantes&#10;- Accessoires divers&#10;&#10;Emballage : Cartons renforcés"
                                        required
                                    ><?= htmlspecialchars($_POST['merchandise'] ?? '') ?></textarea>
                                    <small class="text-muted">Décrivez précisément la marchandise, quantités, conditionnement, etc.</small>
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
                                                placeholder="500.5"
                                                value="<?= htmlspecialchars($_POST['weight'] ?? '') ?>"
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
                                                placeholder="2.5"
                                                value="<?= htmlspecialchars($_POST['volume'] ?? '') ?>"
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
                                        placeholder="Marchandise fragile - Manipulation avec précaution&#10;Livraison en étage sans ascenseur&#10;Contact sur place : M. Dupont - 06.12.34.56.78"
                                    ><?= htmlspecialchars($_POST['special_instructions'] ?? '') ?></textarea>
                                    <small class="text-muted">Instructions particulières, contraintes de manutention, contact sur place...</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Créer le transport
                            </button>
                            <a href="<?= $config['app']['url'] ?>/transports" class="btn btn-secondary">
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
                                    Informations
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <h6 class="text-primary">Statut initial</h6>
                                    <span class="badge badge-warning">En attente</span>
                                    <small class="d-block text-muted mt-1">
                                        Votre demande sera traitée par notre équipe dans les meilleurs délais.
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <h6 class="text-primary">Processus</h6>
                                    <ol class="list-unstyled">
                                        <li><i class="fas fa-circle text-primary me-2" style="font-size: 0.5rem;"></i>Création de la demande</li>
                                        <li><i class="fas fa-circle text-muted me-2" style="font-size: 0.5rem;"></i>Validation par notre équipe</li>
                                        <li><i class="fas fa-circle text-muted me-2" style="font-size: 0.5rem;"></i>Planification de l'enlèvement</li>
                                        <li><i class="fas fa-circle text-muted me-2" style="font-size: 0.5rem;"></i>Transport en cours</li>
                                        <li><i class="fas fa-circle text-muted me-2" style="font-size: 0.5rem;"></i>Livraison effectuée</li>
                                    </ol>
                                </div>

                                <div class="mb-3">
                                    <h6 class="text-primary">Conseils</h6>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check text-success me-2"></i>Soyez précis dans les descriptions</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Indiquez les contraintes d'accès</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Prévoyez les contacts sur place</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title">
                                    <i class="fas fa-phone me-2"></i>
                                    Besoin d'aide ?
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="text-muted">
                                    Notre équipe est là pour vous accompagner dans vos demandes de transport.
                                </p>
                                <div class="d-grid">
                                    <button type="button" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-phone me-2"></i>
                                        Nous contacter
                                    </button>
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
    // Auto-fill delivery date based on pickup date
    document.getElementById('pickup_date').addEventListener('change', function() {
        const pickupDate = new Date(this.value);
        const deliveryDate = new Date(pickupDate);
        deliveryDate.setDate(deliveryDate.getDate() + 1);

        const deliveryInput = document.getElementById('delivery_date');
        if (!deliveryInput.value) {
            deliveryInput.value = deliveryDate.toISOString().split('T')[0];
        }
    });

    // Auto-focus sur le premier champ
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

        // Vérifier que la date d'enlèvement n'est pas dans le passé
        const today = new Date().toISOString().split('T')[0];
        if (pickupDate < today) {
            e.preventDefault();
            alert('La date d\'enlèvement ne peut pas être dans le passé');
            document.getElementById('pickup_date').focus();
            return false;
        }
    });
</script>
</body>
</html>