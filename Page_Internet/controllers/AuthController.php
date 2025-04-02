<?php
require_once '..\models\Bdd.php';
session_start();

class AuthController {

    public function login($email, $password) {
        global $conn;

        if (empty($email) || empty($password)) {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
            return false;
        }

        $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'nom' => $user['nom'],
                'email' => $user['email'],
                'role' => $user['role'] ?? 'utilisateur'
            ];

            return true;
        } else {
            $_SESSION['error'] = "Email ou mot de passe incorrect.";
            return false;
        }
    }

    public function register($nom, $email, $mot_de_passe) {
        global $conn;

        if (empty($nom) || empty($email) || empty($mot_de_passe)) {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
            return false;
        }

        // Vérifie si l'utilisateur existe déjà
        $stmt = $conn->prepare("SELECT id FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $_SESSION['error'] = "Cet email est déjà utilisé.";
            return false;
        }

        // Hash du mot de passe
        $hashedPassword = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        // Insertion de l'utilisateur avec le rôle par défaut "utilisateur"
        $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, role) VALUES (?, ?, ?, 'utilisateur')");
        if ($stmt->execute([$nom, $email, $hashedPassword])) {
            $_SESSION['success'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
            return true;
        } else {
            $_SESSION['error'] = "Erreur lors de l'inscription.";
            return false;
        }
    }

    public function logout() {
        session_destroy();
        header('Location: ../views/login.php');
        exit();
    }
}
