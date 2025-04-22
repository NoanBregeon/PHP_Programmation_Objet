<?php include 'layouts/header.php'; ?>

<main>
    <h2>Bienvenue sur notre site de location de véhicules 🚗</h2>

    <?php if (isset($_SESSION['user'])): ?>
        <p class="success">Bonjour <strong><?= htmlspecialchars($_SESSION['user']['nom']) ?></strong> !</p>
        <div class="actions">
            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <p><a href="index.php?controller=admin&action=dashboard" class="button">🎛️ Tableau de bord admin</a></p>
            <?php endif; ?>
            <p><a href="index.php?controller=vehicule&action=flotte" class="button">🔍 Voir les véhicules disponibles</a></p>
            <p><a href="index.php?controller=reservation&action=mes" class="button">📅 Mes réservations</a></p>
            <p><a href="index.php?controller=auth&action=logout" class="button">🚪 Se déconnecter</a></p>
        </div>
    <?php else: ?>
        <p class="info">Veuillez vous connecter ou créer un compte pour accéder aux services :</p>
        <p>
            <a href="index.php?controller=auth&action=login" class="button">🔑 Connexion</a>
            <a href="index.php?controller=auth&action=register" class="button">📝 Inscription</a>
        </p>
    <?php endif; ?>
</main>

<?php include 'layouts/footer.php'; ?>
