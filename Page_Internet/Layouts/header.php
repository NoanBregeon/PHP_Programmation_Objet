<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header>
    <h1>🚗 Location de véhicules</h1>
    <div class="nav-wrapper">
        <nav>
            <ul class="main-nav">
                <li><a href="index.php">Accueil</a></li>
                <li><a href="index.php?controller=vehicule&action=flotte">Nos véhicules</a></li>

                <?php if (isset($_SESSION['user'])): ?>
                    <li><a href="index.php?controller=reservation&action=mes">Mes réservations</a></li>

                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                        <li><a href="index.php?controller=admin&action=dashboard">Administration</a></li>
                    <?php endif; ?>

                    <li><a href="index.php?controller=auth&action=logout">Déconnexion</a></li>
                <?php else: ?>
                    <li><a href="index.php?controller=auth&action=login">Connexion</a></li>
                    <li><a href="index.php?controller=auth&action=register">Inscription</a></li>
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
        toggle.textContent = "🌞";
    } else {
        body.classList.add("dark-mode");
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
