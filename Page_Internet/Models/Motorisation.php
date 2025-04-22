<?php
require_once 'Bdd.php';

class Motorisation {
    private $conn;

    public function __construct() {
        $this->conn = Bdd::getConnection();
    }

    /**
     * Ajoute une nouvelle motorisation.
     */
    public function ajouter($nom) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO motorisation (nom) VALUES (?)");
            return $stmt->execute([$nom]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout de la motorisation : " . $e->getMessage());
        }
    }

    /**
     * Modifie une motorisation existante.
     */
    public function modifier($id, $nom) {
        try {
            $stmt = $this->conn->prepare("UPDATE motorisation SET nom = ? WHERE id = ?");
            return $stmt->execute([$nom, $id]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la modification de la motorisation : " . $e->getMessage());
        }
    }

    /**
     * Supprime une motorisation.
     */
    public function supprimer($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM motorisation WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression de la motorisation : " . $e->getMessage());
        }
    }

    /**
     * Récupère toutes les motorisations.
     */
    public function obtenirToutes() {
        try {
            $stmt = $this->conn->query("SELECT * FROM motorisation");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des motorisations : " . $e->getMessage());
        }
    }
}
?>