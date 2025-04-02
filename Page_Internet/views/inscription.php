<?php
require_once '..\controllers\AuthController.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$auth = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($auth->register($_POST['nom'], $_POST['email'], $_POST['password'])) {
        header("Location: connexion.php");
        exit();
    }
}
?>
<head>
    <meta charset="UTF-8">
    <title>Accueil - Location de véhicules</title>
    <link rel="stylesheet" href="..\public\styles.css">
</head>
<?php include '..\Layouts\header.php'; ?>
<h2>Inscription</h2>

<form method="POST">
    <label>Nom :</label>
    <input type="text" name="nom" required><br>

    <label>Email :</label>
    <input type="email" name="email" required><br>

    <label>Mot de passe :</label>
    <input type="password" name="password" required><br><br>

    <button type="submit">S'inscrire</button>
</form>

<?php if (isset($_SESSION['error'])): ?>
    <p style="color:red"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>
<?php if (isset($_SESSION['success'])): ?>
    <p style="color:green"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
<?php endif; ?>
<?php include '..\Layouts\footer.php'; ?>
