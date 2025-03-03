<?php
// views/reservation.php
require_once '../controllers/ReservationController.php';
require_once '../controllers/VehiculeController.php';

$reservationController = new ReservationController();
$vehiculeController = new VehiculeController();
$vehicule = null;

if (isset($_GET['vehicule_id'])) {
    $vehicule = $vehiculeController->obtenirVehiculeParId($_GET['vehicule_id']);
}

if (!$vehicule) {
    die("Véhicule introuvable.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: connexion.php');
        exit();
    }
    
    $donnees = [
        'vehicule_id' => $_GET['vehicule_id'],
        'utilisateur_id' => $_SESSION['user_id'],
        'date_debut' => $_POST['date_debut'] ?? '',
        'date_fin' => $_POST['date_fin'] ?? ''
    ];
    
    if (!empty($donnees['date_debut']) && !empty($donnees['date_fin'])) {
        $reservationController->ajouterReservation($donnees['vehicule_id'], $donnees['utilisateur_id'], $donnees['date_debut'], $donnees['date_fin']);
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
    <title>Réserver un Véhicule</title>
    <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
    <header>
        <h1>Réserver un Véhicule</h1>
        <?php
        // views/index.php
        require_once 'header.php';
        ?>
    </header>
    <section>
        <h2><?= htmlspecialchars($vehicule['marque'] . ' ' . $vehicule['modele']) ?></h2>
        <p>Année : <?= htmlspecialchars($vehicule['annee']) ?></p>
        <p>Motorisation : <?= htmlspecialchars($vehicule['motorisation']) ?></p>
        
        <form method="POST">
            <label for="date_debut">Date de début :</label>
            <input type="date" id="date_debut" name="date_debut" required>
            
            <label for="date_fin">Date de fin :</label>
            <input type="date" id="date_fin" name="date_fin" required>
            
            <button type="submit">Réserver</button>
        </form>
    </section>
</body>
</html>