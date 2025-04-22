<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../models/Vehicule.php';

class VehiculeController extends BaseController {

    /**
     * Page d'accueil réservée aux admins pour la gestion des véhicules.
     */
    public function index() {
        if (!$this->isLoggedIn()) {
            $this->redirect('index.php?controller=auth&action=login');
        }

        $vehicules = Vehicule::getAll();
        $this->render('vehicule/index', ['vehicules' => $vehicules]);
    }

    /**
     * Affiche la flotte de véhicules disponible pour tous les utilisateurs connectés.
     */
    public function flotte() {
        if (!$this->isLoggedIn()) {
            $this->redirect('index.php?controller=auth&action=login');
        }

        $vehicules = Vehicule::getAll();
        $this->render('flotte', ['vehicules' => $vehicules]);
    }

    /**
     * Formulaire d'ajout d'un véhicule + traitement du POST.
     */
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

    /**
     * Supprime un véhicule.
     *
     * @param int $id
     */
    public function delete($id) {
        if ($this->isAdmin()) {
            Vehicule::delete($id);
        }
        $this->redirect('index.php?controller=vehicule&action=index');
    }

    /**
     * Formulaire de modification d’un véhicule + traitement du POST.
     *
     * @param int $id
     */
    public function update($id) {
        if (!$this->isAdmin()) {
            $this->redirect('index.php');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Vehicule::update($id, $_POST);
            $this->redirect('index.php?controller=vehicule&action=index');
        }

        $vehicule = Vehicule::findById($id);
        $this->render('vehicule/edit', ['vehicule' => $vehicule]);
    }
}
