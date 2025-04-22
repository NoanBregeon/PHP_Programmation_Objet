<?php
class BaseController {

    /**
     * Affiche une vue avec les données passées.
     *
     * @param string $view Nom du fichier de la vue (ex: 'vehicule/index')
     * @param array $data Données à transmettre à la vue
     */
    protected function render(string $view, array $data = []) {
        extract($data);
        include __DIR__ . '/../views/' . $view . '.php';
    }

    /**
     * Redirige vers une URL.
     *
     * @param string $url URL de redirection
     */
    protected function redirect(string $url) {
        header("Location: $url");
        exit;
    }

    /**
     * Vérifie si l'utilisateur est connecté.
     *
     * @return bool
     */
    protected function isLoggedIn(): bool {
        return isset($_SESSION['user']);
    }

    /**
     * Vérifie si l'utilisateur est un administrateur.
     *
     * @return bool
     */
    protected function isAdmin(): bool {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }
}
