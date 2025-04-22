<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../models/Vehicule.php';

class VehiculeController extends BaseController {

    public function index() {
        if (!$this->isLoggedIn()) {
            $this->redirect('index.php?controller=auth&action=login');
        }

        $vehicules = Vehicule::getAll();
        $this->render('vehicule/index', ['vehicules' => $vehicules]);
    }

    public function flotte() {
        if (!$this->isLoggedIn()) {
            $this->redirect('index.php?controller=auth&action=login');
        }

        $vehicules = Vehicule::getAll();
        $this->render('flotte', ['vehicules' => $vehicules]);
    }

    public function create() {
        if (!$this->isAdmin()) {
            $this->redirect('index.php');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Vehicule::create($_POST);
            $this->redirect('index.php?controller=vehicule&action=index');
        }

        $this->render('vehicule/create');
    }

    public function delete($id) {
        if ($this->isAdmin()) {
            Vehicule::delete($id);
        }
        $this->redirect('index.php?controller=vehicule&action=index');
    }
}
