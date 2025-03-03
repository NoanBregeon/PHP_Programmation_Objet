<?php
require_once '../models/Bdd.php';

class AuthController {
    private $bdd;

    public function __construct() {
        $this->bdd = new Bdd();
    }

    public function connexion($email, $password) {
        $pdo = $this->bdd->getConnection();
        
        // Vérifier si l'utilisateur existe
        $stmt = $pdo->prepare("SELECT id, email, password FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            return "Erreur : Aucun utilisateur trouvé avec cet email.";
        }

        // Vérifier le mot de passe haché
        if (!password_verify($password, $user['password'])) {
            return "Erreur : Mot de passe incorrect.";
        }

        // Démarrer la session et enregistrer les informations de l'utilisateur
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        
        return true;
    }

    public function inscription($email, $password) {
        $pdo = $this->bdd->getConnection();
        
        // Vérifier si l'email existe déjà
        $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return "Erreur : Cet email est déjà utilisé.";
        }
        
        // Hasher le mot de passe et insérer l'utilisateur
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (email, password) VALUES (?, ?)");
        return $stmt->execute([$email, $hash]);
    }

    public function estConnecte() {
        session_start();
        return isset($_SESSION['user_id']);
    }

    public function deconnexion() {
        session_start();
        session_destroy();
        header('Location: ../views/connexion.php');
        exit();
    }
}
?>
