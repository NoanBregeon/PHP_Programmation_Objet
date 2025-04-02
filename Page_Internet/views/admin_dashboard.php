<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Sécurité : accès uniquement admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    $_SESSION['error'] = "Accès réservé à l’administrateur.";
    header("Location: index.php");
    exit();
}
?>
<head>
    <meta charset="UTF-8">
    <title>Accueil - Location de véhicules</title>
    <link rel="stylesheet" href="..\public\styles.css">
</head>
<?php include '..\Layouts\header.php'; ?>
<h2>Tableau de bord administrateur</h2>

<ul>
    <li><a href="ajouter_vehicule.php">➕ Ajouter un véhicule</a></li>
    <li><a href="flotte.php">🚗 Gérer les véhicules (flotte)</a></li>
    <li><a href="admin_reservations.php">📅 Voir toutes les réservations</a></li>
</ul>

<?php if (isset($_SESSION['success'])): ?>
    <p style="color: green"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <p style="color: red"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>
<?php include '..\Layouts\footer.php'; ?>