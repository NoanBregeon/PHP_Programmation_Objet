<?php
session_start();
require_once 'Models/Bdd.php';
require_once 'Models/Motorisation.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['Pseudo'] !== 'Admin') {
    header('Location: connexion.php');
    exit;
}

$motorisationModel = new Motorisation($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $motorisation = $_POST['motorisation'];
    $message = $motorisationModel->ajouterMotorisation($motorisation);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un type de motorisation</title>
    <link rel="stylesheet" href="styles.css?v=0">
</head>
<body>
<?php include 'header.php'; ?>
    <section id="ajouter-motorisation">
        <?php if (isset($message)): ?>
            <p><?php echo ($message); ?></p>
        <?php endif; ?>
        <form action="ajouter_motorisation.php" method="post">
            <label for="motorisation">Type de motorisation:</label>
            <input type="text" id="motorisation" name="motorisation" required>
            <button type="submit">Ajouter</button>
        </form>
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>