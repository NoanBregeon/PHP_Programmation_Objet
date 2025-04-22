<?php
require_once 'VehiculeController.php';
session_start();

// Vérification des droits d'accès
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    $_SESSION['error'] = "Accès refusé.";
    header("Location: flotte.php");
    exit();
}

// Vérification de l'ID du véhicule
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "ID du véhicule manquant.";
    header("Location: flotte.php");
    exit();
}

$id = $_GET['id'];
$controller = new VehiculeController();

if ($controller->supprimerVehiculeParId($id)) {
    $_SESSION['success'] = "Véhicule supprimé avec succès.";
} else {
    $_SESSION['error'] = "Erreur lors de la suppression du véhicule.";
}

header("Location: flotte.php");
exit();
?>