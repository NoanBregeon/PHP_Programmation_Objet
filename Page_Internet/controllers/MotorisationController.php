<?php
require_once '../models/Motorisation.php';

class MotorisationController {
    private $motorisation;

    public function __construct() {
        $this->motorisation = new Motorisation();
    }

    public function getAllMotorisations() {
        return $this->motorisation->obtenirToutes();
    }

    public function ajouterMotorisation($nom) {
        return $this->motorisation->ajouter($nom);
    }

    public function modifierMotorisation($id, $nom) {
        return $this->motorisation->modifier($id, $nom);
    }

    public function supprimerMotorisation($id) {
        return $this->motorisation->supprimer($id);
    }
}
