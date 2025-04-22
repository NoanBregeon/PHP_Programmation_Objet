<?php
require_once '../models/Bdd.php';
session_start();

if (!isset($_SESSION['user']) || !isset($_GET['id'])) {
    header('Location: mes_reservations.php');
    exit();
}

$conn = Bdd::getConnection();
$stmt = $conn->prepare("DELETE FROM reservations WHERE id = ? AND id_utilisateur = ?");
$stmt->execute([$_GET['id'], $_SESSION['user']['id']]);

$_SESSION['success'] = "Réservation supprimée avec succès.";
header('Location: mes_reservations.php');
exit();
?>