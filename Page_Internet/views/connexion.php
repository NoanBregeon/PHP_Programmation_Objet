<?php
require_once '../controllers/AuthController.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$auth = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($auth->login($_POST['email'], $_POST['password'])) {
        header("Location: ../index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page de connexion - Location de véhicules</title>
    <link rel="stylesheet" href="..\public\styles.css">
</head>
<body>
<?php include '..\Layouts\header.php'; ?>
<h2>Connexion</h2>

<form method="POST">
    <label>Email :</label>
    <input type="text" name="email" placeholder="Email ou identifiant" required><br>

    <label>Mot de passe :</label>
    <input type="password" name="password" required><br><br>

    <button type="submit">Se connecter</button>
</form>

<?php if (isset($_SESSION['error'])): ?>
    <p style="color:red"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
<?php endif; ?>
<?php include '..\Layouts\footer.php'; ?>
</body>
</html>

