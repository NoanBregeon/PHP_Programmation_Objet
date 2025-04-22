<?php
require_once 'ReservationController.php';
session_start();

$controller = new ReservationController();
$controller->checkUserSession();

$id = $_GET['id'] ?? null;
$id_utilisateur = $_SESSION['user']['id'];

if ($id && $controller->supprimerReservationParId($id, $id_utilisateur)) {
    $_SESSION['success'] = "Réservation supprimée avec succès.";
} else {
    $_SESSION['error'] = $controller->getError() ?? "Erreur lors de la suppression de la réservation.";
}

header('Location: ../views/mes_reservations.php');
exit();
?>