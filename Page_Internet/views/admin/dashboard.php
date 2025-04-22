<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>DashBoard Admin - Location de véhicules</title>
    <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
<?php include __DIR__ . '/../../layouts/header.php'; ?>

<h2>Tableau de bord administrateur</h2>

<ul>
    <li><a href="ajouter_vehicule.php">➕ Ajouter un véhicule</a></li>
    <li><a href="index.php?controller=vehicule&action=flotte">🚗 Gérer les véhicules (flotte)</a></li>
    <li><a href="admin_reservations.php">📅 Voir toutes les réservations</a></li>
</ul>

<?php if (isset($_SESSION['success'])): ?>
    <p style="color: green"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></p>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <p style="color: red"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
<?php endif; ?>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>
</body>
</html>
