<?php
// controllers/VehiculeController.php
require_once '../models/Bdd.php';
require_once '../models/Vehicule.php';

class VehiculeController {
    private $bdd;
    private $vehicule;

    public function __construct() {
        $this->bdd = new Bdd();
        $this->vehicule = new Vehicule($this->bdd->getConnection());
    }

    public function ajouterVehicule($donnees) {
        return $this->vehicule->ajouter($donnees);
    }

    public function modifierVehicule($id, $donnees) {
        if (!$this->vehicule->obtenirParId($id)) {
            return "Erreur : Véhicule introuvable.";
        }
        return $this->vehicule->modifier($id, $donnees);
    }

    public function supprimerVehicule($id) {
        if (!$this->vehicule->obtenirParId($id)) {
            return "Erreur : Véhicule introuvable.";
        }
        return $this->vehicule->supprimer($id);
    }

    public function obtenirVehicules() {
        return $this->vehicule->obtenirTous();
    }

    public function obtenirVehiculeParId($id) {
        return $this->vehicule->obtenirParId($id);
    }
}
?>
