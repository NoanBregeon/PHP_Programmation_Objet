<?php
require_once 'Models\Bdd.php';
session_start();

// Supprimer un véhicule si l'ID est fourni et que l'utilisateur est admin
if (isset($_POST['supprimer']) && isset($_POST['id']) && $_SESSION['user']['Pseudo'] === 'Admin') {
    $id = $_POST['id'];

    try {
        $stmt = $pdo->prepare('DELETE FROM vehicules WHERE id = ?');
        $stmt->execute([$id]);
        $message = "Véhicule supprimé avec succès.";
    } catch (PDOException $e) {
        $message = 'Erreur : ' . $e->getMessage();
    }
}

// Récupérer les données des véhicules depuis la base de données
try {
    $stmt = $pdo->query('SELECT id, Marques AS marque, Modeles AS modele, Motorisation AS motorisation, Places AS places, GPS AS gps, prix AS prix FROM vehicules');
    $vehicules = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos véhicules</title>
    <link rel="stylesheet" href="styles.css?v=0">
</head>
<body>    
    <?php include 'header.php'; ?>
    <section id="vehicules">
        <?php if (isset($message)): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <?php if (!empty($vehicules)): ?>
            <ul>
                <?php foreach ($vehicules as $vehicule): ?>
                    <li>
                        <h2><?php echo htmlspecialchars($vehicule['marque']); ?></h2>
                        <p>Modèle: <?php echo htmlspecialchars($vehicule['modele']); ?></p>
                        <p>Motorisation: <?php echo htmlspecialchars($vehicule['motorisation']); ?></p>
                        <p>Places: <?php echo htmlspecialchars($vehicule['places']); ?></p>
                        <p>Prix Journalié: <?php echo htmlspecialchars($vehicule['prix']); ?></p>
                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['Pseudo'] === 'Admin'): ?>
                            <a href="modifier_vehicule.php?id=<?php echo $vehicule['id']; ?>">Modifier</a>
                            <form action="vehicules.php" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $vehicule['id']; ?>">
                                <button type="submit" name="supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?');">Supprimer</button>
                            </form>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Aucun véhicule disponible pour le moment.</p>
        <?php endif; ?>
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>
