<?php
// views/modifier_vehicule.php
require_once '../controllers/VehiculeController.php';
require_once '../controllers/MotorisationController.php';

$vehiculeController = new VehiculeController();
$motorisationController = new MotorisationController();
$motorisations = $motorisationController->obtenirMotorisations();

$vehicule = null;
if (isset($_GET['id'])) {
    $vehicule = $vehiculeController->obtenirVehiculeParId($_GET['id']);
}

if (!$vehicule) {
    die("Véhicule introuvable.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $donnees = [
        'marque' => $_POST['marque'] ?? '',
        'modele' => $_POST['modele'] ?? '',
        'annee' => $_POST['annee'] ?? '',
        'motorisation_id' => $_POST['motorisation_id'] ?? ''
    ];
    
    if (!empty($donnees['marque']) && !empty($donnees['modele']) && !empty($donnees['annee']) && !empty($donnees['motorisation_id'])) {
        $vehiculeController->modifierVehicule($_GET['id'], $donnees);
        header('Location: flotte.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Véhicule</title>
    <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
    <header>
        <h1>Modifier un Véhicule</h1>
        <?php
        // views/index.php
        require_once 'header.php';
        ?>
    </header>
    <section>
        <form method="POST">
            <label for="marque">Marque :</label>
            <input type="text" id="marque" name="marque" value="<?= htmlspecialchars($vehicule['marque']) ?>" required>
            
            <label for="modele">Modèle :</label>
            <input type="text" id="modele" name="modele" value="<?= htmlspecialchars($vehicule['modele']) ?>" required>
            
            <label for="annee">Année :</label>
            <input type="number" id="annee" name="annee" value="<?= htmlspecialchars($vehicule['annee']) ?>" required>
            
            <label for="motorisation_id">Motorisation :</label>
            <select id="motorisation_id" name="motorisation_id" required>
                <option value="">Sélectionner</option>
                <?php foreach ($motorisations as $motorisation): ?>
                    <option value="<?= $motorisation['id'] ?>" <?= ($vehicule['motorisation_id'] == $motorisation['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($motorisation['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <button type="submit">Modifier</button>
        </form>
    </section>
</body>
</html>
