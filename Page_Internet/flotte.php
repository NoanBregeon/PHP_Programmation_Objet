<?php
session_start();
require_once 'Models/Bdd.php';
require_once 'Models/Vehicule.php';

$vehiculeModel = new Vehicule($pdo);

// Supprimer un véhicule si l'ID est fourni et que l'utilisateur est admin
if (isset($_POST['supprimer']) && isset($_POST['id']) && $_SESSION['user']['Pseudo'] === 'Admin') {
    $id = $_POST['id'];
    $message = $vehiculeModel->supprimerVehicule($id);
}

$vehicules = $vehiculeModel->getVehicules();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos véhicules</title>
    <link rel="stylesheet" href="styles.css?v=0">
</head>
<body>    
    <?php include 'header.php'; ?>
    <section id="vehicules">
        <?php if (isset($message)): ?>
            <p><?php echo ($message); ?></p>
        <?php endif; ?>
        <?php if (!empty($vehicules)): ?>
            <ul>
                <?php foreach ($vehicules as $vehicule): ?>
                    <li>
                        <h2><?php echo ($vehicule->marque); ?></h2>
                        <p>Modèle: <?php echo ($vehicule['modele']); ?></p>
                        <p>Motorisation: <?php echo ($vehicule['motorisation']); ?></p>
                        <p>Places: <?php echo ($vehicule['places']); ?></p>
                        <p>Prix Journalié: <?php echo ($vehicule['prix']); ?></p>
                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['Pseudo'] === 'Admin'): ?>
                            <a href="modifier_vehicule.php?id=<?php echo $vehicule['id']; ?>">Modifier</a>
                            <form action="flotte.php" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $vehicule['id']; ?>">
                                <button type="submit" name="supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?');">Supprimer</button>
                            </form>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Aucun véhicule disponible pour le moment.</p>
        <?php endif; ?>
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>
