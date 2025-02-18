<?php
require_once 'pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $motorisation = $_POST['motorisation'];
    $places = $_POST['places'];
    $gps = isset($_POST['gps']) ? 1 : 0;

    try {
        $stmt = $pdo->prepare('INSERT INTO vehicules (Marques, Modeles, Motorisation, Places, GPS) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$marque, $modele, $motorisation, $places, $gps]);
        $message = "Véhicule ajouté avec succès.";
    } catch (PDOException $e) {
        $message = 'Erreur : ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un véhicule</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>
    <section id="ajouter-vehicule">
        <?php if (isset($message)): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form action="ajouter_vehicule.php" method="post">
            <label for="marque">Marque:</label>
            <input type="text" id="marque" name="marque" required>
            
            <label for="modele">Modèle:</label>
            <input type="text" id="modele" name="modele" required>
            
            <label for="motorisation">Motorisation:</label>
            <input type="text" id="motorisation" name="motorisation" required>
            
            <label for="places">Places:</label>
            <input type="number" id="places" name="places" required>
            
            <label for="gps">GPS:</label>
            <input type="checkbox" id="gps" name="gps">
            
            <button type="submit">Ajouter</button>
        </form>
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>