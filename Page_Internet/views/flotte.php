<?php
// views/flotte.php
require_once '../controllers/VehiculeController.php';

$vehiculeController = new VehiculeController();
$vehicules = $vehiculeController->obtenirVehicules();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flotte de Véhicules</title>
    <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
    <header>
        <h1>Flotte de Véhicules</h1>
        <?php
        // views/index.php
        require_once 'header.php';
        ?>
    </header>
    <section id="vehicules">
        <?php if (empty($vehicules)) : ?>
            <p>Aucun véhicule disponible.</p>
        <?php else : ?>
            <?php foreach ($vehicules as $vehicule) : ?>
                <div class="vehicule-card">
                    <h2><?= htmlspecialchars($vehicule['marque'] . ' ' . $vehicule['Marques']) ?></h2>
                    <p>Année : <?= htmlspecialchars($vehicule['annee']) ?></p>
                    <p>Motorisation : <?= htmlspecialchars($vehicule['motorisation']) ?></p>
                    <a href="reservation.php?vehicule_id=<?= $vehicule['id']; ?>">Réserver</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</body>
</html>
