<?php
// controllers/MotorisationController.php
require_once '../models/Bdd.php';
require_once '../models/Motorisation.php';

class MotorisationController {
    private $bdd;
    private $motorisation;

    public function __construct() {
        $this->bdd = new Bdd();
        $this->motorisation = new Motorisation($this->bdd->getConnection());
    }

    public function ajouterMotorisation($nom) {
        if ($this->motorisation->existe($nom)) {
            return "Erreur : Cette motorisation existe déjà.";
        }
        return $this->motorisation->ajouter(['nom' => $nom]);
    }

    public function modifierMotorisation($id, $nom) {
        if (!$this->motorisation->obtenirParId($id)) {
            return "Erreur : Motorisation introuvable.";
        }
        return $this->motorisation->modifier($id, ['nom' => $nom]);
    }

    public function supprimerMotorisation($id) {
        if (!$this->motorisation->obtenirParId($id)) {
            return "Erreur : Motorisation introuvable.";
        }
        return $this->motorisation->supprimer($id);
    }

    public function obtenirMotorisations() {
        return $this->motorisation->obtenirToutes();
    }
}
?>
