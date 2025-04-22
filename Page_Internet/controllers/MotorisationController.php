<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../models/Motorisation.php';

class MotorisationController extends BaseController {

    /**
     * Affiche toutes les motorisations (admin uniquement).
     */
    public function index() {
        if (!$this->isAdmin()) {
            $this->redirect('index.php');
        }

        $motorisations = Motorisation::getAll();
        $this->render('motorisation/index', ['motorisations' => $motorisations]);
    }

    /**
     * Crée une nouvelle motorisation.
     */
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

    /**
     * Supprime une motorisation.
     *
     * @param int $id
     */
    public function delete($id) {
        if ($this->isAdmin()) {
            Motorisation::delete($id);
        }

        $this->redirect('index.php?controller=motorisation&action=index');
    }
}
