<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../models/Motorisation.php';

class MotorisationController extends BaseController {

    public function index() {
        if (!$this->isLoggedIn()) {
            $this->redirect('login.php');
        }

        $motorisations = Motorisation::getAll();
        $this->render('motorisation/index', ['motorisations' => $motorisations]);
    }

    public function create() {
        if (!$this->isAdmin()) {
            $this->redirect('index.php');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Motorisation::create($_POST);
            $this->redirect('index.php?controller=motorisation&action=index');
        }

        $this->render('motorisation/create');
    }

    public function delete($id) {
        if ($this->isAdmin()) {
            Motorisation::delete($id);
        }
        $this->redirect('index.php?controller=motorisation&action=index');
    }
}
