<?php
require_once 'VehiculeController.php';
session_start();

$controller = new VehiculeController();
$controller->checkAdminSession();

$id = $_GET['id'] ?? null;

if ($id && $controller->supprimerVehiculeParId($id)) {
    $_SESSION['success'] = "Véhicule supprimé avec succès.";
} else {
    $_SESSION['error'] = $controller->getError() ?? "Erreur lors de la suppression du véhicule.";
}

header('Location: ../views/flotte.php');
exit();
?>