<?php
session_start();
require_once 'models\Bdd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'];
    $mdp = $_POST['mdp'];

    try {
        $stmt = $pdo->prepare('INSERT INTO comptes (Pseudo, MDP) VALUES (?, ?)');
        $stmt->execute([$pseudo, $mdp]);
        $message = "Compte créé avec succès. Vous pouvez maintenant vous connecter.";
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
    <title>Inscription</title>
    <link rel="stylesheet" href="styles.css?v=0">
</head>
<body>
<?php include 'header.php'; ?>
    <section id="inscription">
        <?php if (isset($message)): ?>
            <p><?php echo ($message); ?></p>
        <?php endif; ?>
        <form action="inscription.php" method="post">
            <label for="pseudo">Nom d'utilisateur:</label>
            <input type="text" id="pseudo" name="pseudo" required>
            
            <label for="mdp">Mot de passe:</label>
            <input type="password" id="mdp" name="mdp" required>
            
            <button type="submit">S'inscrire</button>
        </form>
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>