<?php
// models/Motorisation.php
require_once 'Bdd.php';

class Motorisation {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function ajouter($donnees) {
        $stmt = $this->conn->prepare("INSERT INTO motorisations (nom) VALUES (?)");
        return $stmt->execute([$donnees['nom']]);
    }

    public function modifier($id, $donnees) {
        $stmt = $this->conn->prepare("UPDATE motorisations SET nom = ? WHERE id = ?");
        return $stmt->execute([$donnees['nom'], $id]);
    }

    public function supprimer($id) {
        $stmt = $this->conn->prepare("DELETE FROM motorisations WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function obtenirToutes() {
        $stmt = $this->pdo->query("SELECT v.*, m.nom AS motorisation_nom FROM vehicules v JOIN motorisation m ON v.motorisation_id = m.id");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>