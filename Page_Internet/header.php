<header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="vehicules.php">Véhicules</a></li>
            <li><a href="reservation.php">Réservations</a></li>
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['Pseudo'] === 'Admin'): ?>
                <li><a href="ajouter_vehicule.php">Ajout Véhicule</a></li>
                <li><a href="ajouter_motorisation.php">Ajout Motorisation</a></li>
            <?php endif; ?>
            <li><a href="contact.php">Contact</a></li>
            <?php if (isset($_SESSION['user'])): ?>
                <li><a href="deconnexion.php">Déconnexion</a></li>
            <?php else: ?>
                <li><a href="connexion.php">Connexion</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>