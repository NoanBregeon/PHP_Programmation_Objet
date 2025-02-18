<?php
require_once 'pdo.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['Pseudo'] !== 'Admin') {
    header('Location: connexion.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $motorisation = $_POST['motorisation'];
    $places = $_POST['places'];
    $gps = isset($_POST['gps']) ? 1 : 0;

    try {
        $stmt = $pdo->prepare('UPDATE vehicules SET Marques = ?, Modeles = ?, Motorisation = ?, Places = ?, GPS = ? WHERE id = ?');
        $stmt->execute([$marque, $modele, $motorisation, $places, $gps, $id]);
        $message = "Véhicule modifié avec succès.";
    } catch (PDOException $e) {
        $message = 'Erreur : ' . $e->getMessage();
    }
} else {
    $id = $_GET['id'];
    try {
        $stmt = $pdo->prepare('SELECT * FROM vehicules WHERE id = ?');
        $stmt->execute([$id]);
        $vehicule = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
}

// Récupérer les options de motorisation depuis la base de données
try {
    $stmt = $pdo->query('SELECT id, Motorisation FROM motorisation');
    $motorisations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un véhicule</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>
    <section id="modifier-vehicule">
        <?php if (isset($message)): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form action="modifier_vehicule.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($vehicule['id']); ?>">
            
            <label for="marque">Marque:</label>
            <input type="text" id="marque" name="marque" value="<?php echo htmlspecialchars($vehicule['Marques']); ?>" required>
            
            <label for="modele">Modèle:</label>
            <input type="text" id="modele" name="modele" value="<?php echo htmlspecialchars($vehicule['Modeles']); ?>" required>
            
            <label for="motorisation">Motorisation:</label>
            <select id="motorisation" name="motorisation" required>
                <?php foreach ($motorisations as $motorisation): ?>
                    <option value="<?php echo htmlspecialchars($motorisation['id']); ?>" <?php if ($motorisation['id'] == $vehicule['Motorisation']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($motorisation['Motorisation']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <label for="places">Places:</label>
            <input type="number" id="places" name="places" value="<?php echo htmlspecialchars($vehicule['Places']); ?>" required>
            
            <label for="gps">GPS:</label>
            <input type="checkbox" id="gps" name="gps" <?php if ($vehicule['GPS']) echo 'checked'; ?>>
            
            <button type="submit">Modifier</button>
        </form>
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>