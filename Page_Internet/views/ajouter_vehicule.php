<?php
require_once '../controllers/VehiculeController.php';
require_once '../controllers/MotorisationController.php';
// views/ajouter_vehicule.php
require_once '../controllers/VehiculeController.php';
require_once '../controllers/MotorisationController.php';

$vehiculeController = new VehiculeController();
$motorisationController = new MotorisationController();
$motorisations = $motorisationController->obtenirMotorisations();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $donnees = [
        'marque' => $_POST['marque'] ?? '',
        'modele' => $_POST['modele'] ?? '',
        'annee' => $_POST['annee'] ?? '',
        'motorisation' => $_POST['motorisation'] ?? '' // Adaptation à la base
    ];
    
    if (!empty($donnees['marque']) && !empty($donnees['modele']) && !empty($donnees['annee']) && !empty($donnees['motorisation'])) {
        $vehiculeController->ajouterVehicule($donnees);
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
    <title>Ajouter un Véhicule</title>
    <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
    <header>
        <h1>Ajouter un Véhicule</h1>
        <?php require_once 'header.php'; ?>
    </header>
    <section>
        <form method="POST">
            <label for="marque">Marque :</label>
            <input type="text" id="marque" name="marque" required>
            
            <label for="modele">Modèle :</label>
            <input type="text" id="modele" name="modele" required>
            
            <label for="annee">Année :</label>
            <input type="number" id="annee" name="annee" required>
            
            <label for="motorisation">Motorisation :</label>
            <select id="motorisation" name="motorisation" required>
                <option value="">Sélectionner</option>
                <?php foreach ($motorisations as $motorisation): ?>
                    <option value="<?= $motorisation['id'] ?>"><?= htmlspecialchars($motorisation['nom']) ?></option>
                <?php endforeach; ?>
            </select>
            
            <button type="submit">Ajouter</button>
        </form>
    </section>
</body>
</html>
