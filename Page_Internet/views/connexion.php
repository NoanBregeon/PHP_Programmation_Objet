<?php
require_once '../models/Bdd.php';
session_start();

$bdd = new Bdd();
$pdo = $bdd->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $pseudo = $_POST['pseudo'];
   $mdp = $_POST['mdp']
   
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css?v=0">
</head>
<body>
<?php include 'header.php'; ?>
    <section id="connexion">
        <?php if (isset($message)): ?>
            <p><?php echo ($message); ?></p>
        <?php endif; ?>
        <form action="connexion.php" method="post">
            <label for="pseudo">Nom d'utilisateur:</label>
            <input type="text" id="pseudo" name="pseudo" required>
            
            <label for="mdp">Mot de passe:</label>
            <input type="password" id="mdp" name="mdp" required>
            
            <button type="submit">Se connecter</button>
        </form>
        <p>Pas encore de compte ? <a href="inscription.php">Inscrivez-vous ici</a></p>
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>