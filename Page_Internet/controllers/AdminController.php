<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../models/Admin.php';

class AdminController extends BaseController {

    public function dashboard() {
        if (!$this->isAdmin()) {
            $this->redirect('index.php');
        }

        $this->render('admin/dashboard');
    }

    public function manageUsers() {
        if (!$this->isAdmin()) {
            $this->redirect('index.php');
        }

        $users = Admin::getAllUsers(); // méthode fictive à adapter selon ton modèle
        $this->render('admin/users', ['users' => $users]);
    }

    public function deleteUser($id) {
        if ($this->isAdmin()) {
            Admin::deleteUser($id); // méthode fictive à adapter
        }
        $this->redirect('index.php?controller=admin&action=manageUsers');
    }
}
