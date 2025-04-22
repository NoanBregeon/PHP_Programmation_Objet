<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends BaseController {

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

    public function logout() {
        session_destroy();
        $this->redirect('index.php');
    }
}
