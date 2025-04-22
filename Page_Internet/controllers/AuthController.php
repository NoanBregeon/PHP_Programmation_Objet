<?php
require_once '../models/Bdd.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class AuthController {
    private $conn;

    public function __construct() {
        $this->conn = Bdd::getConnection();
    }

    /**
     * Authentifie un utilisateur.
     */
    public function login($email, $password) {
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
            return false;
        }

        try {
            $stmt = $this->conn->prepare("SELECT * FROM utilisateurs WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && $password === $user['password']) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'nom' => $user['nom'],
                    'email' => $user['email'],
                    'role' => $user['role'] ?? 'utilisateur'
                ];
                return true;
            } else {
                $_SESSION['error'] = "Identifiants incorrects.";
                return false;
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Erreur lors de la connexion : " . $e->getMessage();
            return false;
        }
    }

    /**
     * Inscrit un nouvel utilisateur.
     */
    public function register($nom, $email, $password) {
        if (empty($nom) || empty($email) || empty($password)) {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
            return false;
        }

        try {
            // Vérifie si l'utilisateur existe déjà
            $stmt = $this->conn->prepare("SELECT id FROM utilisateurs WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $_SESSION['error'] = "Cet email est déjà utilisé.";
                return false;
            }

            // Insère un nouvel utilisateur
            $stmt = $this->conn->prepare("INSERT INTO utilisateurs (nom, email, password, role) VALUES (?, ?, ?, 'utilisateur')");
            if ($stmt->execute([$nom, $email, $password])) {
                $_SESSION['success'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
                return true;
            } else {
                $_SESSION['error'] = "Erreur lors de l'inscription.";
                return false;
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Erreur lors de l'inscription : " . $e->getMessage();
            return false;
        }
    }

    /**
     * Déconnecte l'utilisateur.
     */
    public function logout() {
        session_destroy();
        header('Location: ../views/connexion.php');
        exit();
    }
}
?>