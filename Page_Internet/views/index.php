<?php
require_once '../models/Bdd.php';
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="styles.css?v=0">
</head>
<body>
    <?php include 'header.php'; ?>
    <section id="accueil">
        <h1>Bienvenue sur notre site de gestion de véhicules</h1>
        <?php if (isset($_SESSION['user_email'])): ?>
            <p>Bienvenue, <?= ($_SESSION['user_email']) ?> !</p>
        <?php else: ?>
            <p><a href="connexion.php">Connectez-vous</a> pour accéder à toutes les fonctionnalités.</p>
        <?php endif; ?>
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>
