<?php
require_once 'Bdd.php';

class Vehicule {
    private $conn;

    public function __construct() {
        $this->conn = Bdd::getConnection();
    }

    /**
     * Ajoute un nouveau véhicule.
     */
    public function ajouterVehicule($marque, $modele, $bva, $places, $motorisation_id, $radio, $climatisation, $bluetooth, $regulateur_vitesse, $pack_electrique, $gps, $prix) {
        try {
            $stmt = $this->conn->prepare('INSERT INTO vehicules (marque, modele, bva, places, motorisation_id, radio, climatisation, bluetooth, regulateur_vitesse, pack_electrique, gps, prix) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$marque, $modele, $bva, $places, $motorisation_id, $radio, $climatisation, $bluetooth, $regulateur_vitesse, $pack_electrique, $gps, $prix]);
            return "Véhicule ajouté avec succès.";
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout du véhicule : " . $e->getMessage());
        }
    }

    /**
     * Modifie un véhicule existant.
     */
    public function modifierVehicule($id, $marque, $modele, $bva, $places, $motorisation_id, $radio, $climatisation, $bluetooth, $regulateur_vitesse, $pack_electrique, $gps, $prix) {
        try {
            $stmt = $this->conn->prepare('UPDATE vehicules SET marque = ?, modele = ?, bva = ?, places = ?, motorisation_id = ?, radio = ?, climatisation = ?, bluetooth = ?, regulateur_vitesse = ?, pack_electrique = ?, gps = ?, prix = ? WHERE id = ?');
            $stmt->execute([$marque, $modele, $bva, $places, $motorisation_id, $radio, $climatisation, $bluetooth, $regulateur_vitesse, $pack_electrique, $gps, $prix, $id]);
            return "Véhicule modifié avec succès.";
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la modification du véhicule : " . $e->getMessage());
        }
    }

    /**
     * Supprime un véhicule.
     */
    public function supprimerVehicule($id) {
        try {
            $stmt = $this->conn->prepare('DELETE FROM vehicules WHERE id = ?');
            $stmt->execute([$id]);
            return "Véhicule supprimé avec succès.";
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression du véhicule : " . $e->getMessage());
        }
    }

    /**
     * Récupère un véhicule par son ID.
     */
    public function obtenirParId($id) {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM vehicules WHERE id = ?');
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération du véhicule : " . $e->getMessage());
        }
    }

    /**
     * Récupère tous les véhicules.
     */
    public function obtenirTous() {
        try {
            $stmt = $this->conn->query("SELECT * FROM vehicules");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des véhicules : " . $e->getMessage());
        }
    }
}
?>
