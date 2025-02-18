<?php
require_once 'Models/Bdd.php';
require_once 'Models/Vehicule.php';
require_once 'Models/Motorisation.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['Pseudo'] !== 'Admin') {
    header('Location: connexion.php');
    exit;
}

$vehiculeModel = new Vehicule($pdo);
$motorisationModel = new Motorisation($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
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

    $message = $vehiculeModel->modifierVehicule($id, $type, $marque, $modele, $bva, $places, $motorisation, $radio, $climatisation, $bluetooth, $regulateur_vitesse, $pack_electrique, $gps, $prix);
    header('Location: flotte.php');
    exit;
} else {
    $id = $_GET['id'];
    $vehicule = $vehiculeModel->getVehiculeById($id);
    if (!$vehicule) {
        echo 'Erreur : Véhicule non trouvé';
        exit;
    }
}

$motorisations = $motorisationModel->getMotorisations();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un véhicule</title>
    <link rel="stylesheet" href="styles.css?v=0">
</head>
<body>
<?php include 'header.php'; ?>
    <section id="modifier-vehicule">
        <?php if (isset($message)): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form action="modifier_vehicule.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($vehicule['id'] ?? ''); ?>">
            
            <label for="type">Type:</label>
            <select id="type" name="type" required>
                <option value="Utilitaire" <?php if (($vehicule['Type'] ?? '') == 'Utilitaire') echo 'selected'; ?>>Utilitaire</option>
                <option value="Tourisme" <?php if (($vehicule['Type'] ?? '') == 'Tourisme') echo 'selected'; ?>>Tourisme</option>
            </select>
            
            <label for="marque">Marque:</label>
            <input type="text" id="marque" name="marque" value="<?php echo htmlspecialchars($vehicule['Marques'] ?? ''); ?>" required>
            
            <label for="modele">Modèle:</label>
            <input type="text" id="modele" name="modele" value="<?php echo htmlspecialchars($vehicule['Modeles'] ?? ''); ?>" required>
            
            <label for="bva">Boîte de vitesses automatique (BVA):</label>
            <input type="checkbox" id="bva" name="bva" <?php if (($vehicule['BVA'] ?? 0) == 1) echo 'checked'; ?>>
            
            <label for="places">Places:</label>
            <input type="number" id="places" name="places" value="<?php echo htmlspecialchars($vehicule['Places'] ?? ''); ?>" required>
            
            <label for="motorisation">Motorisation:</label>
            <select id="motorisation" name="motorisation" required>
                <?php foreach ($motorisations as $motorisation): ?>
                    <option value="<?php echo htmlspecialchars($motorisation['id']); ?>" <?php if ($motorisation['id'] == ($vehicule['Motorisation'] ?? '')) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($motorisation['Motorisation']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <label for="radio">Radio:</label>
            <input type="checkbox" id="radio" name="radio" <?php if (($vehicule['Radio'] ?? 0) == 1) echo 'checked'; ?>>
            
            <label for="climatisation">Climatisation:</label>
            <input type="checkbox" id="climatisation" name="climatisation" <?php if (($vehicule['Climatisation'] ?? 0) == 1) echo 'checked'; ?>>
            
            <label for="bluetooth">Bluetooth:</label>
            <input type="checkbox" id="bluetooth" name="bluetooth" <?php if (($vehicule['Bluetooth'] ?? 0) == 1) echo 'checked'; ?>>
            
            <label for="regulateur_vitesse">Régulateur de vitesse:</label>
            <input type="checkbox" id="regulateur_vitesse" name="regulateur_vitesse" <?php if (($vehicule['Regulateur_vitesse'] ?? 0) == 1) echo 'checked'; ?>>
            
            <label for="pack_electrique">Pack Électrique:</label>
            <input type="checkbox" id="pack_electrique" name="pack_electrique" <?php if (($vehicule['Pack_Electrique'] ?? 0) == 1) echo 'checked'; ?>>
            
            <label for="gps">GPS:</label>
            <input type="checkbox" id="gps" name="gps" <?php if (($vehicule['GPS'] ?? 0) == 1) echo 'checked'; ?>>

            <label for="prix">Prix Journalié:</label>
            <input type="number" id="prix" name="prix" value="<?php echo htmlspecialchars($vehicule['prix'] ?? ''); ?>" required>

            <button type="submit">Modifier</button>
        </form>
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>