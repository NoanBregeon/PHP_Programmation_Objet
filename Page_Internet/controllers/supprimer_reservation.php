<?php
require_once '../controllers/ReservationController.php';
session_start();

// Vérification des droits d'accès
if (!isset($_SESSION['user']) || !isset($_GET['id'])) {
    header('Location: mes_reservations.php');
    exit();
}

$id = $_GET['id'];
$id_utilisateur = $_SESSION['user']['id'];
$controller = new ReservationController();

if ($controller->supprimerReservationParId($id, $id_utilisateur)) {
    $_SESSION['success'] = "Réservation supprimée avec succès.";
} else {
    $_SESSION['error'] = "Erreur lors de la suppression de la réservation.";
}

header('Location: mes_reservations.php');
exit();
?>