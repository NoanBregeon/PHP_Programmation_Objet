<?php
require_once '../controllers/VehiculeController.php';
require_once '../controllers/MotorisationController.php';

$controller = new VehiculeController();
$motorisationController = new MotorisationController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($controller->ajouterVehicule($_POST, $_FILES['image'])) {
        header("Location: flotte.php");
        exit();
    }
}

$motorisations = $motorisationController->getAllMotorisations();
?>
<head>
    <meta charset="UTF-8">
    <title>Ajout Vehicule - Location de véhicules</title>
    <link rel="stylesheet" href="..\public\styles.css">
</head>
<?php include '..\Layouts\header.php'; ?>
<h2>Ajouter un véhicule</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Nom :</label>
    <input type="text" name="nom" required><br>

    <label>Marque :</label>
    <input type="text" name="marque" required><br>

    <label>Modèle :</label>
    <input type="text" name="modele" required><br>

    <label>Motorisation :</label>
    <select name="id_motorisation" required>
        <?php foreach ($motorisations as $m) : ?>
            <option value="<?= $m['id'] ?>"><?= ($m['nom']) ?></option>
        <?php endforeach; ?>
    </select><br>

    <label>Prix journalier (€) :</label>
    <input type="number" name="prix_journalier" step="0.01" required><br>

    <label>Boîte automatique :</label>
    <input type="checkbox" name="boite_auto"><br>

    <label>Nombre de places :</label>
    <input type="number" name="nb_places" min="1" max="9" value="4"><br>

    <label>Image :</label>
    <input type="file" name="image" accept="image/*" required><br><br>

    <button type="submit">Ajouter</button>
</form>
<?php include '..\Layouts\footer.php'; ?>
