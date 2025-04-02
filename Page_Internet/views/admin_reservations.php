<?php
require_once '..\controllers\ReservationController.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérification des droits admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    $_SESSION['error'] = "Accès réservé aux administrateurs.";
    header("Location: index.php");
    exit();
}

$reservationController = new ReservationController();
$reservations = $reservationController->getAllReservations();
?>
<head>
    <meta charset="UTF-8">
    <title>Accueil - Location de véhicules</title>
    <link rel="stylesheet" href="..\public\styles.css">
</head>
<?php include '..\Layouts\header.php'; ?>
<h2>Réservations de tous les utilisateurs</h2>

<?php if (empty($reservations)) : ?>
    <p>Aucune réservation n’a encore été effectuée.</p>
<?php else : ?>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Utilisateur</th>
                <th>Véhicule</th>
                <th>Date de début</th>
                <th>Date de fin</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $r) : ?>
                <tr>
                    <td><?= ($r['nom_utilisateur']) ?></td>
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
<?php include '..\Layouts\footer.php'; ?>
