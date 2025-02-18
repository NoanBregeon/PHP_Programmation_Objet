<?php
require_once 'pdo.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['Pseudo'] !== 'Admin') {
    header('Location: connexion.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    $image = '';

    // Gestion du téléchargement de l'image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imageSize = $_FILES['image']['size'];
        $imageType = $_FILES['image']['type'];
        $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
        $newImageName = md5(time() . $imageName) . '.' . $imageExtension;
        $uploadDir = 'uploads/';
        $destPath = $uploadDir . $newImageName;

        if (move_uploaded_file($imageTmpPath, $destPath)) {
            // Uploader l'image sur GitHub
            $githubToken = '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';
            $githubRepo = 'NoanBregeon/PHP_Programmation_Objet';
            $githubPath = 'Page_Internet/Images/' . $newImageName; 

            $imageData = base64_encode(file_get_contents($destPath));
            $data = json_encode([
                'message' => 'Ajouter une nouvelle image',
                'content' => $imageData
            ]);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.github.com/repos/$githubRepo/contents/$githubPath");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: token ' . $githubToken,
                'User-Agent: PHP'
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 201) {
                $responseData = json_decode($response, true);
                $image = $responseData['content']['download_url'];
            } else {
                $message = 'Erreur lors du téléchargement de l\'image sur GitHub.';
            }
        } else {
            $message = 'Erreur lors du téléchargement de l\'image.';
        }
    }

    try {
        $stmt = $pdo->prepare('INSERT INTO vehicules (Type, Marques, Modeles, BVA, Places, Motorisation, Radio, Climatisation, Bluetooth, Regulateur_vitesse, Pack_Electrique, GPS, Image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$type, $marque, $modele, $bva, $places, $motorisation, $radio, $climatisation, $bluetooth, $regulateur_vitesse, $pack_electrique, $gps, $image]);
        $message = "Véhicule ajouté avec succès.";
    } catch (PDOException $e) {
        $message = 'Erreur : ' . $e->getMessage();
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
    <title>Ajouter un véhicule</title>
    <link rel="stylesheet" href="styles.css?v=0">
</head>
<body>
<?php include 'header.php'; ?>
    <section id="ajouter-vehicule">
        <?php if (isset($message)): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form action="ajouter_vehicule.php" method="post" enctype="multipart/form-data">
            <label for="type">Type:</label>
            <select id="type" name="type" required>
                <option value="Utilitaire">Utilitaire</option>
                <option value="Tourisme">Tourisme</option>
            </select>
            
            <label for="marque">Marque:</label>
            <input type="text" id="marque" name="marque" required>
            
            <label for="modele">Modèle:</label>
            <input type="text" id="modele" name="modele" required>
            
            <label for="bva">Boîte de vitesses automatique (BVA):</label>
            <input type="checkbox" id="bva" name="bva">
            
            <label for="places">Places:</label>
            <input type="number" id="places" name="places" required>
            
            <label for="motorisation">Motorisation:</label>
            <select id="motorisation" name="motorisation" required>
                <?php foreach ($motorisations as $motorisation): ?>
                    <option value="<?php echo htmlspecialchars($motorisation['id']); ?>">
                        <?php echo htmlspecialchars($motorisation['Motorisation']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <label for="radio">Radio:</label>
            <input type="checkbox" id="radio" name="radio">
            
            <label for="climatisation">Climatisation:</label>
            <input type="checkbox" id="climatisation" name="climatisation">
            
            <label for="bluetooth">Bluetooth:</label>
            <input type="checkbox" id="bluetooth" name="bluetooth">
            
            <label for="regulateur_vitesse">Régulateur de vitesse:</label>
            <input type="checkbox" id="regulateur_vitesse" name="regulateur_vitesse">
            
            <label for="pack_electrique">Pack Électrique:</label>
            <input type="checkbox" id="pack_electrique" name="pack_electrique">
            
            <label for="gps">GPS:</label>
            <input type="checkbox" id="gps" name="gps">
            
            <label for="image">Image:</label>
            <input type="file" id="image" name="image">
            
            <button type="submit">Ajouter</button>
        </form>
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>