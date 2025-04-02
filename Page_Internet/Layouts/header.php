<?php
require_once __DIR__ . '/../config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header>
    <h1>🚗 Location de véhicules</h1>
    <div class="nav-wrapper">
    <nav>
        <ul class="main-nav">
            <li><a href="<?= BASE_URL ?>/index.php">Accueil</a></li>
            <li><a href="<?= BASE_URL ?>/views/flotte.php">Nos véhicules</a></li>

            <?php if (isset($_SESSION['user'])): ?>
                <li><a href="<?= BASE_URL ?>/views/mes_reservations.php">Mes réservations</a></li>
                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                    <li><a href="<?= BASE_URL ?>/views/admin_dashboard.php">Administration</a></li>
                <?php endif; ?>
                <li><a href="<?= BASE_URL ?>/views/logout.php">Déconnexion</a></li>
            <?php else: ?>
                <li><a href="<?= BASE_URL ?>/views/connexion.php">Connexion</a></li>
                <li><a href="<?= BASE_URL ?>/views/inscription.php">Inscription</a></li>
            <?php endif; ?>
        </ul>
        <button id="theme-toggle" class="theme-switch">🌙</button>
    </nav>
</div>

</header>
<hr>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const toggle = document.getElementById("theme-toggle");
    const body = document.body;

    const currentTheme = localStorage.getItem("theme");
    if (currentTheme === "light") {
        body.classList.add("light-mode");
        body.classList.remove("dark-mode");
        toggle.textContent = "🌞";
    } else {
        body.classList.add("dark-mode");
        body.classList.remove("light-mode");
        toggle.textContent = "🌙";
    }

    toggle.addEventListener("click", () => {
        body.classList.toggle("light-mode");
        body.classList.toggle("dark-mode");

        const newTheme = body.classList.contains("light-mode") ? "light" : "dark";
        localStorage.setItem("theme", newTheme);
        toggle.textContent = newTheme === "light" ? "🌞" : "🌙";
    });
});
</script>