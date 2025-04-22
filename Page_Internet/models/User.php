<?php
require_once 'Bdd.php';

class User {

    /**
     * Récupère un utilisateur par email (utilisé pour le login).
     *
     * @param string $email
     * @return array|null
     */
    public static function findByEmail(string $email): ?array {
        $conn = Bdd::getConnection();
        $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    /**
     * Crée un nouvel utilisateur avec mot de passe sécurisé.
     *
     * @param string $nom
     * @param string $email
     * @param string $password
     * @return true|string True si réussite, sinon message d'erreur
     */
    public static function create(string $nom, string $email, string $password) {
        $conn = Bdd::getConnection();

        // Vérifie si l'email est déjà utilisé
        $stmt = $conn->prepare("SELECT id FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return "Cet email est déjà utilisé.";
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, email, password, role) VALUES (?, ?, ?, 'utilisateur')");
        $success = $stmt->execute([$nom, $email, $hashedPassword]);

        return $success ? true : "Erreur lors de l'inscription.";
    }

    /**
     * Vérifie un mot de passe pour un utilisateur.
     *
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public static function verifyPassword(string $password, string $hash): bool {
        return password_verify($password, $hash);
    }
}
