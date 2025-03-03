<?php

class Vehicule {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function ajouterVehicule($marque, $modele, $bva, $places, $motorisation_id, $radio, $climatisation, $bluetooth, $regulateur_vitesse, $pack_electrique, $gps, $prix) {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO vehicules (marque, modele, bva, places, motorisation_id, radio, climatisation, bluetooth, regulateur_vitesse, pack_electrique, gps, prix) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$marque, $modele, $bva, $places, $motorisation_id, $radio, $climatisation, $bluetooth, $regulateur_vitesse, $pack_electrique, $gps, $prix]);
            return "Véhicule ajouté avec succès.";
        } catch (PDOException $e) {
            return 'Erreur : ' . $e->getMessage();
        }
    }

    public function modifierVehicule($id, $marque, $modele, $bva, $places, $motorisation_id, $radio, $climatisation, $bluetooth, $regulateur_vitesse, $pack_electrique, $gps, $prix) {
        try {
            $stmt = $this->pdo->prepare('UPDATE vehicules SET marque = ?, modele = ?, bva = ?, places = ?, motorisation_id = ?, radio = ?, climatisation = ?, bluetooth = ?, regulateur_vitesse = ?, pack_electrique = ?, gps = ?, prix = ? WHERE id = ?');
            $stmt->execute([$marque, $modele, $bva, $places, $motorisation_id, $radio, $climatisation, $bluetooth, $regulateur_vitesse, $pack_electrique, $gps, $prix, $id]);
            return "Véhicule modifié avec succès.";
        } catch (PDOException $e) {
            return 'Erreur : ' . $e->getMessage();
        }
    }

    public function supprimerVehicule($id) {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM vehicules WHERE id = ?');
            $stmt->execute([$id]);
            return "Véhicule supprimé avec succès.";
        } catch (PDOException $e) {
            return 'Erreur : ' . $e->getMessage();
        }
    }

    public function obtenirParId($id) {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM vehicules WHERE id = ?');
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return null;
        }
    }
    public function obtenirTous() {
        $stmt = $this->pdo->query("SELECT * FROM vehicules");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>
