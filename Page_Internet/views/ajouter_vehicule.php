<?php
session_start();
require_once 'models/Bdd.php';
require_once 'models/Vehicule.php';
require_once 'models/Motorisation.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['Pseudo'] !== 'Admin') {
    header('Location: connexion.php');
    exit;
}

$vehiculeModel = new Vehicule($pdo);
$motorisationModel = new Motorisation($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $bva = isset($_POST['bva']) ? 1 : 0;
    $places = $_POST['places'];
    $motorisation = $_POST['motorisation'];
    $radio = isset($_POST['radio']) ? 1 : 0;
    $climatisation = isset($_POST['climatisation']) ? 1 : 0;
    $bluetooth = isset($_POST['bluetooth']) ? 1 : 0;
    $regulateur_vitesse = isset($_POST['regulateur_vitesse']) ? 1 : 0;
    $pack_electrique = isset($_POST['pack_electrique']) ? 1 : 0;
    $gps = isset($_POST['gps']) ? 1 : 0;
    $prix = $_POST['prix'];

    $message = $vehiculeModel->ajouterVehicule($type, $marque, $modele, $bva, $places, $motorisation, $radio, $climatisation, $bluetooth, $regulateur_vitesse, $pack_electrique, $gps, $prix);
}

$motorisations = $motorisationModel->getMotorisations();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un véhicule</title>
    <link rel="stylesheet" href="styles.css?v=0">
</head>
<body>
<?php include 'header.php'; ?>
    <section id="ajouter-vehicule">
        <?php if (isset($message)): ?>
            <p><?php echo ($message); ?></p>
        <?php endif; ?>
        <form action="ajouter_vehicule.php" method="post">
            <label for="type">Type:</label>
            <select id="type" name="type" required>
                <option value="Utilitaire">Utilitaire</option>
                <option value="Tourisme">Tourisme</option>
            </select>
            <label for="marque">Marque:</label>
            <input type="text" id="marque" name="marque" required>
            <label for="modele">Modèle:</label>
            <input type="text" id="modele" name="modele" required>
            <label for="places">Places:</label>
            <input type="number" id="places" name="places" required>
            <label for="motorisation">Motorisation:</label>
            <select id="motorisation" name="motorisation" required>
                <?php foreach ($motorisations as $motorisation): ?>
                    <option value="<?php echo ($motorisation['id']); ?>">
                        <?php echo ($motorisation['Motorisation']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="bva">Boîte de vitesses automatique (BVA):</label>
            <input type="checkbox" id="bva" name="bva">
            <label for="radio">Radio:</label>
            <input type="checkbox" id="radio" name="radio">
            <label for="climatisation">Climatisation:</label>
            <input type="checkbox" id="climatisation" name="climatisation">
            <label for="bluetooth">Bluetooth:</label>
            <input type="checkbox" id="bluetooth" name="bluetooth">
            <label for="regulateur_vitesse">Régulateur de vitesse:</label>
            <input type="checkbox" id="regulateur_vitesse" name="regulateur_vitesse">
            <label for="pack_electrique">Pack Électrique:</label>
            <input type="checkbox" id="pack_electrique" name="pack_electrique">
            <label for="gps">GPS:</label>
            <input type="checkbox" id="gps" name="gps">
            <label for='prix'>Prix Journalié</label>
            <input type="number" id="prix" name="prix" required>
            <button type="submit">Ajouter</button>
        </form>
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>