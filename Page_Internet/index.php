<?php
session_start();
require_once 'models\Bdd.php';
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
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>