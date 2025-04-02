<?php
require_once 'controllers/ReservationController.php';
session_start();

if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = "Veuillez vous connecter pour accéder à vos réservations.";
    header("Location: connexion.php");
    exit();
}

$reservationController = new ReservationController();
$reservations = $reservationController->getReservationsByUser($_SESSION['user']['id']);
?>

<h2>Mes réservations</h2>

<?php if (empty($reservations)) : ?>
    <p>Vous n'avez pas encore effectué de réservation.</p>
<?php else : ?>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Véhicule</th>
                <th>Date de début</th>
                <th>Date de fin</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $r) : ?>
                <tr>
                    <td><?= ($r['nom_vehicule']) ?></td>
                    <td><?= ($r['date_debut']) ?></td>
                    <td><?= ($r['date_fin']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <p style="color: green"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <p style="color: red"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>
