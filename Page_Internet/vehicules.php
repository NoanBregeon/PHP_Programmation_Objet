<?php
require_once 'pdo.php';

// Récupérer les données des véhicules depuis la base de données
try {
    $stmt = $pdo->query('SELECT Marques AS marque, Modeles AS modele, Motorisation AS motorisation, Places AS places, GPS AS gps FROM vehicules');
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
        <?php if (!empty($vehicules)): ?>
            <ul>
                <?php foreach ($vehicules as $vehicule): ?>
                    <li>
                        <h2><?php echo htmlspecialchars($vehicule['marque']); ?></h2>
                        <p>Modèle: <?php echo htmlspecialchars($vehicule['modele']); ?></p>
                        <p>Motorisation: <?php echo htmlspecialchars($vehicule['motorisation']); ?></p>
                        <p>Places: <?php echo htmlspecialchars($vehicule['places']); ?></p>
                        <p>GPS: <?php echo $vehicule['gps'] ? 'Oui' : 'Non'; ?></p>
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
