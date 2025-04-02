<?php
require_once __DIR__ . '..\..\config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header>
    <h1>Location de véhicules</h1>
    <nav>
        <ul>
            <a href="<?= BASE_URL ?>/index.php">Accueil</a> |
            <a href="<?= BASE_URL ?>/views/flotte.php">Nos véhicules</a> |

            <?php if (isset($_SESSION['user'])): ?>
                <a href="<?= BASE_URL ?>/views/mes_reservations.php">Mes réservations</a> |

                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                    <a href="<?= BASE_URL ?>/views/admin_dashboard.php">Administration</a> |
                <?php endif; ?>

                <a href="<?= BASE_URL ?>/views/logout.php">Déconnexion</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/views/connexion.php">Connexion</a> |
                <a href="<?= BASE_URL ?>/views/inscription.php">Inscription</a>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<hr>
