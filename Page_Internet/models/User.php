<?php
require_once 'Bdd.php';

class User {

    public static function findByEmail($email) {
        $conn = Bdd::getConnection();
        $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($nom, $email, $password) {
        $conn = Bdd::getConnection();

        // Vérifie si l'utilisateur existe déjà
        $stmt = $conn->prepare("SELECT id FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return "Cet email est déjà utilisé.";
        }

        // Insère le nouvel utilisateur
        $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, email, password, role) VALUES (?, ?, ?, 'utilisateur')");
        if ($stmt->execute([$nom, $email, $password])) {
            return true;
        } else {
            return "Erreur lors de l'inscription.";
        }
    }
}
