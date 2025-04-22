<?php
require_once '../controllers/ReservationController.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../connexion.php');
    exit();
}

$reservationController = new ReservationController();
$reservations = $reservationController->getReservationsByUser($_SESSION['user']['id']);

$today = date('Y-m-d');
$active = [];
$expired = [];

foreach ($reservations as $r) {
    if ($r['date_fin'] < $today) {
        $expired[] = $r;
    } else {
        $active[] = $r;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes réservations - Location de véhicules</title>
    <link rel="stylesheet" href="..\public\styles.css">
</head>
    <body>
    <?php include '../Layouts/header.php'; ?>
    <h2>Mes réservations à venir / en cours</h2>
    <?php if (!empty($active)): ?>
    <table>
        <tr>
            <th>Véhicule</th>
            <th>Date début</th>
            <th>Date fin</th>
            <th>Action</th>
        </tr>
        <?php foreach ($active as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['nom_vehicule']) ?></td>
                <td><?= htmlspecialchars($r['date_debut']) ?></td>
                <td><?= htmlspecialchars($r['date_fin']) ?></td>
                <td><a href="supprimer_reservation.php?id=<?= $r['id'] ?>" class="btn-supprimer">🗑️ Supprimer</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <p>Vous n'avez aucune réservation en cours.</p>
    <?php endif; ?>
    <h2>Réservations expirées</h2>
    <?php if (!empty($expired)): ?>
    <table>
        <tr>
            <th>Véhicule</th>
            <th>Date début</th>
            <th>Date fin</th>
        </tr>
        <?php foreach ($expired as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['nom_vehicule']) ?></td>
                <td><?= htmlspecialchars($r['date_debut']) ?></td>
                <td><?= htmlspecialchars($r['date_fin']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <p>Vous n'avez aucune réservation expirée.</p>
    <?php endif; ?>
    <?php include '../Layouts/footer.php'; ?>
    </body>
</html>