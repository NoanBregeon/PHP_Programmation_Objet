<?php
require_once '../controllers/VehiculeController.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    $_SESSION['error'] = "Accès refusé.";
    header("Location: flotte.php");
    exit();
}

if (!isset($_GET['id'])) {
    $_SESSION['error'] = "ID du véhicule manquant.";
    header("Location: flotte.php");
    exit();
}

$id = $_GET['id'];
$controller = new VehiculeController();

if ($controller->supprimerVehicule($id)) {
    $_SESSION['success'] = "Véhicule supprimé avec succès.";
} else {
    $_SESSION['error'] = "Erreur lors de la suppression du véhicule.";
}

header("Location: flotte.php");
exit();
?>
