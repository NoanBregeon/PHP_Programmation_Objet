<?php
require_once __DIR__ . '/../../models/Vehicule.php';
require_once __DIR__ . '/../../controllers/MotorisationController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$motorisationController = new MotorisationController();

if (!isset($_GET['id'])) {
    $_SESSION['error'] = "ID du véhicule manquant.";
    header("Location: flotte.php");
    exit();
}

$id = $_GET['id'];
$vehicule = Vehicule::findById($id);

if (!$vehicule) {
    $_SESSION['error'] = "Véhicule introuvable.";
    header("Location: flotte.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Met ici ton code de modification
    // (soit en appelant une méthode static dans Vehicule ou via ton controller)
}

$motorisations = $motorisationController->getAllMotorisations();
?>
