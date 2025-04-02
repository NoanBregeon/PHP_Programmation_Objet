<?php
require_once 'controllers/ReservationController.php';
require_once 'controllers/VehiculeController.php';

session_start();

if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = "Vous devez être connecté pour réserver un véhicule.";
    header("Location: connexion.php");
    exit();
}

if (!isset($_GET['id_vehicule'])) {
    echo "Aucun véhicule sélectionné.";
    exit();
}

$id_vehicule = $_GET['id_vehicule'];

$vehiculeController = new VehiculeController();
$vehicule = $vehiculeController->getVehiculeById($id_vehicule);

$reservationController = new ReservationController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $donnees = [
        'id_vehicule' => $id_vehicule,
        'date_debut' => $_POST['date_debut'],
        'date_fin' => $_POST['date_fin']
    ];

    if ($reservationController->reserver($donnees)) {
        $_SESSION['success'] = "Réservation enregistrée avec succès !";
        header("Location: flotte.php");
        exit();
    }
}
?>

<h2>Réserver le véhicule : <?= ($vehicule['nom']) ?> (<?= ($vehicule['marque']) ?> <?= ($vehicule['modele']) ?>)</h2>

<form method="POST">
    <label>Date de début :</label>
    <input type="date" name="date_debut" required><br>

    <label>Date de fin :</label>
    <input type="date" name="date_fin" required><br><br>

    <button type="submit">Confirmer la réservation</button>
</form>

<?php if (isset($_SESSION['error'])): ?>
    <p style="color:red"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>
