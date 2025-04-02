<?php
// models/Motorisation.php
require_once 'Bdd.php';

class Motorisation {
    private $conn;

    public function __construct() {
        $this->conn = Bdd::getConnection();
    }

    public function ajouter($nom) {
        $stmt = $this->conn->prepare("INSERT INTO motorisation (nom) VALUES (?)");
        return $stmt->execute([$nom]);
    }

    public function modifier($id, $nom) {
        $stmt = $this->conn->prepare("UPDATE motorisation SET nom = ? WHERE id = ?");
        return $stmt->execute([$nom, $id]);
    }

    public function supprimer($id) {
        $stmt = $this->conn->prepare("DELETE FROM motorisation WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function obtenirToutes() {
        $stmt = $this->conn->query("SELECT * FROM motorisation");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
