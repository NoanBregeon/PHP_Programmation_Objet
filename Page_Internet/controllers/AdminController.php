<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Vérification des droits admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    $_SESSION['error'] = "Accès réservé aux administrateurs.";
    header("Location: index.php");
    exit();
}
?>