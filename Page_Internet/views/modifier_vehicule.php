<?php
require_once '../controllers/VehiculeController.php';
require_once '../controllers/MotorisationController.php';

$controller = new VehiculeController();
$motorisationController = new MotorisationController();

if (!isset($_GET['id'])) {
    echo "ID du véhicule manquant.";
    exit();
}

$id = $_GET['id'];
$vehicule = $controller->getVehiculeById($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($controller->modifierVehicule($id, $_POST, $_FILES['image'])) {
        header("Location: flotte.php");
        exit();
    }
}

$motorisations = $motorisationController->getAllMotorisations();
?>
<head>
    <meta charset="UTF-8">
    <title>Modification véhicule - Location de véhicules</title>
    <link rel="stylesheet" href="..\public\styles.css">
</head>
<?php include '..\Layouts\header.php'; ?>
<h2>Modifier le véhicule</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Nom :</label>
    <input type="text" name="nom" value="<?= ($vehicule['nom']) ?>" required><br>

    <label>Marque :</label>
    <input type="text" name="marque" value="<?= ($vehicule['marque']) ?>" required><br>

    <label>Modèle :</label>
    <input type="text" name="modele" value="<?= ($vehicule['modele']) ?>" required><br>

    <label>Motorisation :</label>
    <select name="id_motorisation" required>
        <?php foreach ($motorisations as $m) : ?>
            <option value="<?= $m['id'] ?>" <?= $m['id'] == $vehicule['id_motorisation'] ? 'selected' : '' ?>>
                <?= ($m['nom']) ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <label>Prix journalier (€) :</label>
    <input type="number" name="prix_journalier" step="0.01" value="<?= $vehicule['prix_journalier'] ?>" required><br>

    <label>Boîte automatique :</label>
    <input type="checkbox" name="boite_auto" <?= $vehicule['boite_auto'] ? 'checked' : '' ?>><br>

    <label>Nombre de places :</label>
    <input type="number" name="nb_places" min="1" max="9" value="<?= $vehicule['nb_places'] ?>"><br>

    <label>Changer l'image :</label>
    <input type="file" name="image" accept="image/*"><br><br>

    <button type="submit">Modifier</button>
</form>
<?php include '..\Layouts\footer.php'; ?>
