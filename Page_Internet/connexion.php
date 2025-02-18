<?php
require_once 'pdo.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'];
    $mdp = $_POST['mdp'];

    try {
        $stmt = $pdo->prepare('SELECT * FROM comptes WHERE Pseudo = ? AND MDP = ?');
        $stmt->execute([$pseudo, $mdp]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['user'] = $user;
            header('Location: index.php');
            exit;
        } else {
            $message = "Nom d'utilisateur ou mot de passe incorrect.";
        }
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
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>