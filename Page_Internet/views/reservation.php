<?php
require_once('../controllers/ReservationController.php');
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../connexion.php');
    exit();
}

$reservationController = new ReservationController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_utilisateur = $_SESSION['user']['id'];
    $id_vehicule = $_GET['id_vehicule'] ?? null;
    $date_debut = $_POST['date_debut'] ?? null;
    $date_fin = $_POST['date_fin'] ?? null;

    if ($id_vehicule && $date_debut && $date_fin) {
        if ($reservationController->reserver($id_utilisateur, $id_vehicule, $date_debut, $date_fin)) {
            $_SESSION['success'] = "Réservation effectuée avec succès.";
            header("Location: mes_reservations.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Tous les champs sont requis.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réserver un véhicule</title>
    <link rel="stylesheet" href="..\public\styles.css">
</head>
<body>
<?php include '..\Layouts\header.php'; ?>

<h2>Réserver ce véhicule</h2>

<?php if (isset($_SESSION['error'])): ?>
    <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<form method="post">
    <label>Date de début :</label>
    <input type="date" name="date_debut" required><br><br>

    <label>Date de fin :</label>
    <input type="date" name="date_fin" required><br><br>

    <button type="submit">Réserver</button>
</form>

<?php include '..\Layouts\footer.php'; ?>
</body>
</html>