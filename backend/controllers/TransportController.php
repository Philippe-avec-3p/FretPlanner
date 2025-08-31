<?php
// backend/controllers/TransportController.php

class TransportController extends BaseController {
    private $transportModel;
    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->transportModel = new Transport();
        $this->userModel = new User();
    }

    // Liste des transports
    public function index() {
        $currentUser = Session::getUser();
        $isAdmin = ($currentUser['role'] === 'admin');

        // Les admins voient tous les transports, les users seulement les leurs
        $transports = $this->transportModel->getAll($isAdmin ? null : $currentUser['id']);

        $viewPath = $this->config['paths']['views'] . '/transports/index.php';

        if (!file_exists($viewPath)) {
            throw new Exception("Vue transports/index non trouvée: $viewPath");
        }

        $config = $this->config;
        $user = $currentUser;
        $error = Session::flash('error');
        $success = Session::flash('success');

        require $viewPath;
    }

    // Afficher un transport
    public function show() {
        $id = $_GET['id'] ?? 0;
        $currentUser = Session::getUser();
        $isAdmin = ($currentUser['role'] === 'admin');

        if (!$id) {
            Session::flash('error', 'ID transport manquant');
            header('Location: /FretPlanner/transports');
            exit();
        }

        // Les admins peuvent voir tous les transports, les users seulement les leurs
        $transport = $this->transportModel->findById($id, $isAdmin ? null : $currentUser['id']);

        if (!$transport) {
            Session::flash('error', 'Transport non trouvé ou accès non autorisé');
            header('Location: /FretPlanner/transports');
            exit();
        }

        $viewPath = $this->config['paths']['views'] . '/transports/show.php';

        if (!file_exists($viewPath)) {
            throw new Exception("Vue transports/show non trouvée: $viewPath");
        }

        $config = $this->config;
        $user = $currentUser;

        require $viewPath;
    }

    // Formulaire de création
    public function create() {
        $currentUser = Session::getUser();

        // Générer une référence automatique
        $reference = $this->transportModel->generateReference();

        $viewPath = $this->config['paths']['views'] . '/transports/create.php';

        if (!file_exists($viewPath)) {
            throw new Exception("Vue transports/create non trouvée: $viewPath");
        }

        $config = $this->config;
        $user = $currentUser;
        $error = Session::flash('error');
        $success = Session::flash('success');

        require $viewPath;
    }

    // Sauvegarder un nouveau transport
    public function store() {
        $currentUser = Session::getUser();

        $pickupAddress = $_POST['pickup_address'] ?? '';
        $deliveryAddress = $_POST['delivery_address'] ?? '';
        $pickupDate = $_POST['pickup_date'] ?? '';
        $pickupTime = $_POST['pickup_time'] ?? null;
        $deliveryDate = $_POST['delivery_date'] ?? null;
        $deliveryTime = $_POST['delivery_time'] ?? null;
        $merchandise = $_POST['merchandise'] ?? '';
        $weight = $_POST['weight'] ?? null;
        $volume = $_POST['volume'] ?? null;
        $specialInstructions = $_POST['special_instructions'] ?? null;

        // Validation
        if (empty($pickupAddress) || empty($deliveryAddress) || empty($pickupDate) || empty($merchandise)) {
            Session::flash('error', 'Les champs adresse d\'enlèvement, adresse de livraison, date d\'enlèvement et marchandise sont requis');
            header('Location: /FretPlanner/transports/create');
            exit();
        }

        // Validation de la date
        if (strtotime($pickupDate) < strtotime('today')) {
            Session::flash('error', 'La date d\'enlèvement ne peut pas être dans le passé');
            header('Location: /FretPlanner/transports/create');
            exit();
        }

        try {
            $reference = $this->transportModel->generateReference();

            $transportId = $this->transportModel->create([
                'user_id' => $currentUser['id'],
                'reference' => $reference,
                'pickup_address' => $pickupAddress,
                'delivery_address' => $deliveryAddress,
                'pickup_date' => $pickupDate,
                'pickup_time' => $pickupTime,
                'delivery_date' => $deliveryDate,
                'delivery_time' => $deliveryTime,
                'merchandise' => $merchandise,
                'weight' => $weight ? floatval($weight) : null,
                'volume' => $volume ? floatval($volume) : null,
                'special_instructions' => $specialInstructions,
                'status' => 'pending'
            ]);

            Session::flash('success', 'Transport créé avec succès (Réf: ' . $reference . ')');
            header('Location: /FretPlanner/transports/show?id=' . $transportId);
            exit();

        } catch (Exception $e) {
            Session::flash('error', 'Erreur lors de la création: ' . $e->getMessage());
            header('Location: /FretPlanner/transports/create');
            exit();
        }
    }

    // Formulaire d'édition
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $currentUser = Session::getUser();
        $isAdmin = ($currentUser['role'] === 'admin');

        if (!$id) {
            Session::flash('error', 'ID transport manquant');
            header('Location: /FretPlanner/transports');
            exit();
        }

        $transport = $this->transportModel->findById($id, $isAdmin ? null : $currentUser['id']);

        if (!$transport) {
            Session::flash('error', 'Transport non trouvé ou accès non autorisé');
            header('Location: /FretPlanner/transports');
            exit();
        }

        // Les utilisateurs normaux ne peuvent modifier que leurs transports en statut 'pending' ou 'confirmed'
        if (!$isAdmin && !in_array($transport['status'], ['pending', 'confirmed'])) {
            Session::flash('error', 'Ce transport ne peut plus être modifié');
            header('Location: /FretPlanner/transports/show?id=' . $id);
            exit();
        }

        $viewPath = $this->config['paths']['views'] . '/transports/edit.php';

        if (!file_exists($viewPath)) {
            throw new Exception("Vue transports/edit non trouvée: $viewPath");
        }

        $config = $this->config;
        $user = $currentUser;
        $error = Session::flash('error');
        $success = Session::flash('success');

        require $viewPath;
    }

    // Mettre à jour un transport
    public function update() {
        $id = $_POST['id'] ?? 0;
        $currentUser = Session::getUser();
        $isAdmin = ($currentUser['role'] === 'admin');

        if (!$id) {
            Session::flash('error', 'ID transport manquant');
            header('Location: /FretPlanner/transports');
            exit();
        }

        $transport = $this->transportModel->findById($id, $isAdmin ? null : $currentUser['id']);

        if (!$transport) {
            Session::flash('error', 'Transport non trouvé ou accès non autorisé');
            header('Location: /FretPlanner/transports');
            exit();
        }

        $pickupAddress = $_POST['pickup_address'] ?? '';
        $deliveryAddress = $_POST['delivery_address'] ?? '';
        $pickupDate = $_POST['pickup_date'] ?? '';
        $pickupTime = $_POST['pickup_time'] ?? null;
        $deliveryDate = $_POST['delivery_date'] ?? null;
        $deliveryTime = $_POST['delivery_time'] ?? null;
        $merchandise = $_POST['merchandise'] ?? '';
        $weight = $_POST['weight'] ?? null;
        $volume = $_POST['volume'] ?? null;
        $specialInstructions = $_POST['special_instructions'] ?? null;
        $status = $_POST['status'] ?? $transport['status'];

        // Validation
        if (empty($pickupAddress) || empty($deliveryAddress) || empty($pickupDate) || empty($merchandise)) {
            Session::flash('error', 'Les champs adresse d\'enlèvement, adresse de livraison, date d\'enlèvement et marchandise sont requis');
            header('Location: /FretPlanner/transports/edit?id=' . $id);
            exit();
        }

        // Les utilisateurs normaux ne peuvent pas changer le statut
        if (!$isAdmin) {
            $status = $transport['status'];
        }

        try {
            $this->transportModel->update($id, [
                'pickup_address' => $pickupAddress,
                'delivery_address' => $deliveryAddress,
                'pickup_date' => $pickupDate,
                'pickup_time' => $pickupTime,
                'delivery_date' => $deliveryDate,
                'delivery_time' => $deliveryTime,
                'merchandise' => $merchandise,
                'weight' => $weight ? floatval($weight) : null,
                'volume' => $volume ? floatval($volume) : null,
                'special_instructions' => $specialInstructions,
                'status' => $status
            ]);

            Session::flash('success', 'Transport mis à jour avec succès');
            header('Location: /FretPlanner/transports/show?id=' . $id);
            exit();

        } catch (Exception $e) {
            Session::flash('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
            header('Location: /FretPlanner/transports/edit?id=' . $id);
            exit();
        }
    }

    // Supprimer un transport (admin seulement)
    public function delete() {
        $id = $_POST['id'] ?? 0;
        $currentUser = Session::getUser();
        $isAdmin = ($currentUser['role'] === 'admin');

        if (!$isAdmin) {
            Session::flash('error', 'Accès non autorisé');
            header('Location: /FretPlanner/transports');
            exit();
        }

        if (!$id) {
            Session::flash('error', 'ID transport manquant');
            header('Location: /FretPlanner/transports');
            exit();
        }

        try {
            $this->transportModel->delete($id);
            Session::flash('success', 'Transport supprimé avec succès');
        } catch (Exception $e) {
            Session::flash('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }

        header('Location: /FretPlanner/transports');
        exit();
    }
}