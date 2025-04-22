<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../models/Admin.php';

class AdminController extends BaseController {

    /**
     * Affiche le tableau de bord admin.
     */
    public function dashboard() {
        if (!$this->isAdmin()) {
            $this->redirect('index.php');
        }

        $this->render('admin/dashboard');
    }

    /**
     * Liste tous les utilisateurs (ou tous les clients).
     */
    public function users() {
        if (!$this->isAdmin()) {
            $this->redirect('index.php');
        }

        $users = Admin::getAllUsers(); // À définir dans le modèle Admin.php
        $this->render('admin/users', ['users' => $users]);
    }

    /**
     * Supprime un utilisateur.
     */
    public function deleteUser($id) {
        if (!$this->isAdmin()) {
            $this->redirect('index.php');
        }

        Admin::deleteUser($id);
        $this->redirect('index.php?controller=admin&action=users');
    }
}
