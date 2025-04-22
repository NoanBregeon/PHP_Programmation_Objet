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
    
        $sort = $_GET['sort'] ?? ''; // 👈 tri récupéré depuis l'URL
        $vehicules = Vehicule::getAll($sort); // 👈 trié dynamiquement
    
        $this->render('vehicules/index', ['vehicules' => $vehicules]);
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
    public function modifierVehicule($id, $data, $file = null){
        if (!$this->isAdmin()) {
            $_SESSION['error'] = "Action non autorisée.";
            $this->redirect('index.php?controller=vehicule&action=flotte');
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Vehicule::update($id, $_POST);
            $_SESSION['success'] = "Véhicule modifié avec succès.";
            $this->redirect('index.php?controller=vehicule&action=flotte');
        } else {
            $vehicule = Vehicule::findById($id);
            $this->render('vehicules/edit', ['vehicule' => $vehicule]);
        }
    }
    
    
    public function delete($id) {
        if ($this->isAdmin()) {
            Vehicule::delete($id);
            $_SESSION['success'] = "Véhicule supprimé avec succès.";
        } else {
            $_SESSION['error'] = "Action non autorisée.";
        }
    
        $this->redirect('index.php?controller=vehicule&action=flotte');
    }
        
}
