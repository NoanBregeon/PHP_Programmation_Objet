<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends BaseController {

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = User::authenticate($email, $password); // méthode à définir dans User

            if ($user) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['is_admin'] = $user->is_admin ?? false;
                $this->redirect('index.php');
            } else {
                $this->render('auth/login', ['error' => 'Identifiants incorrects.']);
            }
        } else {
            $this->render('auth/login');
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('login.php');
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            User::create($email, $password); // méthode à adapter
            $this->redirect('login.php');
        }

        $this->render('auth/register');
    }
}
