<?php
require_once 'BaseController.php';

class VehiculeController extends BaseController {
    /**
     * Supprime un véhicule par son ID.
     */
    public function supprimerVehiculeParId($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM vehicules WHERE id = ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            $this->setError("Erreur lors de la suppression du véhicule : " . $e->getMessage());
            return false;
        }
    }
}
?>