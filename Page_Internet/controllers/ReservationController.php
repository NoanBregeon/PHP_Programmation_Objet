<?php
// controllers/ReservationController.php
require_once '../models/Bdd.php';

class ReservationController {
    private $bdd;

    public function __construct() {
        $this->bdd = new Bdd();
    }

    public function ajouterReservation($vehicule_id, $email, $date_debut, $date_fin) {
        $pdo = $this->bdd->getConnection();
        $stmt = $pdo->prepare("INSERT INTO reservations (vehicule_id, utilisateur_id, date_debut, date_fin) VALUES (?, (SELECT id FROM utilisateurs WHERE email = ?), ?, ?)");
        return $stmt->execute([$vehicule_id, $email, $date_debut, $date_fin]);
    }

    public function obtenirReservationsUtilisateur($email) {
        $pdo = $this->bdd->getConnection();
        
        // Récupérer l'ID de l'utilisateur
        $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if (!$user) {
            return []; // Retourner une liste vide si aucun utilisateur trouvé
        }
        
        $stmt = $pdo->prepare("SELECT * FROM reservations WHERE utilisateur_id = ?");
        $stmt->execute([$user['id']]);
        return $stmt->fetchAll();
    }

    public function annulerReservation($id) {
        $pdo = $this->bdd->getConnection();
        $stmt = $pdo->prepare("DELETE FROM reservations WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>