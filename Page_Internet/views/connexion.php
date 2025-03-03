<?php
require_once '../models/Bdd.php';
session_start();

$bdd = new Bdd();
$pdo = $bdd->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'];
    $mdp = $_POST['mdp'];
        // Récupérer l'utilisateur via son pseudo
        $sql = "SELECT * FROM utilisateurs WHERE email = '".$pseudo."'";
        $stmt = $pdo->query($sql);
        $user = $stmt->fetchAll();

        // Vérifier si l'utilisateur existe et que le mot de passe est correct
        if ($user !== false && password_verify($mdp, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_pseudo'] = $user['email'];
            header('Location: index.php');
            exit;
        } else {
            $message = "Nom d'utilisateur ou mot de passe incorrect.";
        }
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
            <p><?php echo htmlspecialchars($message); ?></p>
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
