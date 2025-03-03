<?php
require_once '../controllers/AuthController.php';
require_once '../models/Bdd.php';
session_start();

$authController = new AuthController();
$bdd = new Bdd();
$pdo = $bdd->getConnection();
$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($password === $confirm_password) {
        try {
            // Insérer l'utilisateur dans la base de données
            $stmt = $pdo->prepare('INSERT INTO utilisateurs (email, password) VALUES (?, ?)');
            $stmt->execute([$email, $password]);
            $message = "Inscription réussie. Vous pouvez maintenant vous connecter.";
        } catch (PDOException $e) {
            $message = 'Erreur : ' . $e->getMessage();
        }

        if ($authController->inscription($email, $password)) {
            header('Location: connexion.php');
            exit();
        } else {
            $erreur = "Erreur lors de l'inscription. Veuillez réessayer.";
        }
    } else {
        $erreur = "Les mots de passe ne correspondent pas.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
    <header>
        <h1>Inscription</h1>
        <?php
        // views/index.php
        require_once 'header.php';
        ?>
    </header>
    <section>
        <?php if (!empty($erreur)) : ?>
            <p class="message error"> <?= htmlspecialchars($erreur) ?> </p>
        <?php endif; ?>
        <?php if (isset($message)): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
            
            <label for="confirm_password">Confirmer le mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            
            <button type="submit">S'inscrire</button>
        </form>
    </section>
</body>
</html>