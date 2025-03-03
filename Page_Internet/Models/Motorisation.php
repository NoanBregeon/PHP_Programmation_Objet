<?php

class Motorisation {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function ajouterMotorisation($motorisation) {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO motorisation (Motorisation) VALUES (?)');
            $stmt->execute([$motorisation]);
            return "Type de motorisation ajouté avec succès.";
        } catch (PDOException $e) {
            return 'Erreur : ' . $e->getMessage();
        }
    }

    public function getMotorisations() {
        try {
            $stmt = $this->pdo->query('SELECT id, Motorisation FROM motorisation');
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return 'Erreur : ' . $e->getMessage();
        }
    }
}