<?php
require_once __DIR__ . '/../../controllers/AdminController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$reservationController = new ReservationController();
$reservations = $reservationController->getAllReservations();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard réservations - Location de véhicules</title>
    <link rel="stylesheet" href="..\public\styles.css">
</head>
<body>
<?php include '..\layouts\header.php'; ?>
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
                    <td><?= htmlspecialchars($r['nom_utilisateur']) ?></td>
                    <td><?= htmlspecialchars($r['nom_vehicule']) ?></td>
                    <td><?= htmlspecialchars($r['date_debut']) ?></td>
                    <td><?= htmlspecialchars($r['date_fin']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <p style="color: green"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></p>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <p style="color: red"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
<?php endif; ?>
<?php include '..\layouts\footer.php'; ?>
</body>
</html>
