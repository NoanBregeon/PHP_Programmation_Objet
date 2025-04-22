<?php
require_once '../models/Motorisation.php';

class MotorisationController {
    private $motorisation;

    public function __construct() {
        $this->motorisation = new Motorisation();
    }

    /**
     * Récupère toutes les motorisations.
     */
    public function getAllMotorisations() {
        try {
            return $this->motorisation->obtenirToutes();
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            return [];
        }
    }

    /**
     * Ajoute une nouvelle motorisation.
     */
    public function ajouterMotorisation($nom) {
        try {
            return $this->motorisation->ajouter($nom);
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            return false;
        }
    }

    /**
     * Modifie une motorisation existante.
     */
    public function modifierMotorisation($id, $nom) {
        try {
            return $this->motorisation->modifier($id, $nom);
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            return false;
        }
    }

    /**
     * Supprime une motorisation.
     */
    public function supprimerMotorisation($id) {
        try {
            return $this->motorisation->supprimer($id);
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            return false;
        }
    }
}
?>
