<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
define('BASE_PATH', __DIR__);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Location de véhicules</title>
    <link rel="stylesheet" href="public\styles.css">
</head>
<body>

<?php include 'Layouts\header.php'; ?>

<main>
    <h2>Bienvenue sur notre site de location de véhicules 🚗</h2>

    <?php if (isset($_SESSION['user'])): ?>
        <p class="success">Bonjour <strong><?= ($_SESSION['user']['nom']) ?></strong> !</p>

        <div class="actions">
            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <p><a href="views/admin_dashboard.php" class="button">🎛️ Tableau de bord admin</a></p>
            <?php endif; ?>

            <p><a href="views/flotte.php" class="button">🔍 Voir les véhicules disponibles</a></p>
            <p><a href="views/mes_reservations.php" class="button">📅 Mes réservations</a></p>
            <p><a href="views/logout.php" class="button">🚪 Se déconnecter</a></p>
        </div>

    <?php else: ?>
        <p class="info">Veuillez vous connecter ou créer un compte pour accéder aux services :</p>
        <p><a href="connexion.php" class="button">🔑 Connexion</a> 
        <a href="inscription.php" class="button">📝 Inscription</a></p>
    <?php endif; ?>
</main>

<?php include 'Layouts\footer.php'; ?>

</body>
</html>
