<?php
require_once '..\controllers\VehiculeController.php';
$vehiculeController = new VehiculeController();
$vehicules = $vehiculeController->getAllVehicules();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Location de véhicules</title>
    <link rel="stylesheet" href="..\public\styles.css">
</head>
<body>
<?php include '..\Layouts\header.php'; ?>
<h2>Nos véhicules disponibles</h2>

<?php if (isset($_SESSION['success'])): ?>
    <p style="color: green"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <p style="color: red"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<div class="vehicules">
    <?php foreach ($vehicules as $v): ?>
        <div class="vehicule">
            <h3><?= ($v['nom']) ?> - <?= ($v['marque']) ?> <?= ($v['modele']) ?></h3>
            <?php if (!empty($v['image'])): ?>
                <img src="<?= $v['image'] ?>" alt="Image de <?= ($v['nom']) ?>" width="200">
            <?php endif; ?>
            <p>Motorisation : <?= ($v['motorisation']) ?></p>
            <p>Prix / jour : <?= number_format($v['prix_journalier'], 2) ?> €</p>
            <p>Boîte automatique : <?= $v['boite_auto'] ? 'Oui' : 'Non' ?></p>
            <p>Nombre de places : <?= $v['nb_places'] ?></p>

            <?php if (isset($_SESSION['user'])): ?>
                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                    <a href="modifier_vehicule.php?id=<?= $v['id'] ?>">Modifier</a> |
                    <a href="supprimer_vehicule.php?id=<?= $v['id'] ?>" onclick="return confirm('Supprimer ce véhicule ?');">Supprimer</a>
                <?php else: ?>
                    <a href="reservation.php?id_vehicule=<?= $v['id'] ?>">Réserver</a>
                <?php endif; ?>
            <?php else: ?>
                <p><a href="connexion.php">Connectez-vous pour réserver</a></p>
            <?php endif; ?>
        </div>
        <hr>
    <?php endforeach; ?>
</div>
<?php include '..\Layouts\footer.php'; ?>
</body>
</html>
