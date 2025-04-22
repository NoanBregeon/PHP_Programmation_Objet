<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends BaseController {

    /**
     * Affiche le formulaire de connexion ou traite le login.
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = User::findByEmail($email);

            if ($user && $password === $user['password']) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'nom' => $user['nom'],
                    'email' => $user['email'],
                    'role' => $user['role'] ?? 'utilisateur'
                ];
                $this->redirect('index.php');
            } else {
                $_SESSION['error'] = "Identifiants incorrects.";
                $this->render('auth/login');
            }
        } else {
            $this->render('auth/login');
        }
    }

    /**
     * Affiche le formulaire d'inscription ou traite l'inscription.
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $result = User::create($nom, $email, $password);
            if ($result === true) {
                $_SESSION['success'] = "Inscription réussie.";
                $this->redirect('index.php?controller=auth&action=login');
            } else {
                $_SESSION['error'] = $result;
                $this->render('auth/register');
            }
        } else {
            $this->render('auth/register');
        }
    }

    /**
     * Déconnecte l'utilisateur et redirige vers la page d'accueil.
     */
    public function logout() {
        session_destroy();
        $this->redirect('index.php');
    }
}
