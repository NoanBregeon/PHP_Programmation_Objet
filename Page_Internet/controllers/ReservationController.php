<?php
require_once 'BaseController.php';

class ReservationController extends BaseController {
    /**
     * Réserve un véhicule pour un utilisateur.
     */
    public function reserver($id_utilisateur, $id_vehicule, $date_debut, $date_fin) {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM reservations WHERE id_vehicule = ? AND (
                (date_debut <= ? AND date_fin >= ?) OR
                (date_debut <= ? AND date_fin >= ?) OR
                (? <= date_debut AND ? >= date_fin))");
            $stmt->execute([$id_vehicule, $date_debut, $date_debut, $date_fin, $date_fin, $date_debut, $date_fin]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $this->setError("Ce véhicule est déjà réservé pour cette période.");
                return false;
            }

            $stmt = $this->conn->prepare("INSERT INTO reservations (id_utilisateur, id_vehicule, date_debut, date_fin) VALUES (?, ?, ?, ?)");
            return $stmt->execute([$id_utilisateur, $id_vehicule, $date_debut, $date_fin]);
        } catch (PDOException $e) {
            $this->setError("Erreur lors de la réservation : " . $e->getMessage());
            return false;
        }
    }

    /**
     * Supprime une réservation par son ID et l'utilisateur associé.
     */
    public function supprimerReservationParId($id, $id_utilisateur) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM reservations WHERE id = ? AND id_utilisateur = ?");
            $stmt->execute([$id, $id_utilisateur]);
            return true;
        } catch (PDOException $e) {
            $this->setError("Erreur lors de la suppression de la réservation : " . $e->getMessage());
            return false;
        }
    }
}
?>