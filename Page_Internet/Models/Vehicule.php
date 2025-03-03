<?php

class Vehicule extends Bdd{
    // private $pdo;

    public function __construct() {
        // $this->pdo = $pdo;
    }

    public function ajouterVehicule($type, $marque, $modele, $bva, $places, $motorisation, $radio, $climatisation, $bluetooth, $regulateur_vitesse, $pack_electrique, $gps, $prix) {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO vehicules (Type, Marques, Modeles, BVA, Places, Motorisation, Radio, Climatisation, Bluetooth, Regulateur_vitesse, Pack_Electrique, GPS, prix) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$type, $marque, $modele, $bva, $places, $motorisation, $radio, $climatisation, $bluetooth, $regulateur_vitesse, $pack_electrique, $gps, $prix]);
            return "Véhicule ajouté avec succès.";
        } catch (PDOException $e) {
            return 'Erreur : ' . $e->getMessage();
        }
    }

    public function modifierVehicule($id, $type, $marque, $modele, $bva, $places, $motorisation, $radio, $climatisation, $bluetooth, $regulateur_vitesse, $pack_electrique, $gps, $prix) {
        try {
            $stmt = $this->pdo->prepare('UPDATE vehicules SET Type = ?, Marques = ?, Modeles = ?, BVA = ?, Places = ?, Motorisation = ?, Radio = ?, Climatisation = ?, Bluetooth = ?, Regulateur_vitesse = ?, Pack_Electrique = ?, GPS = ?, prix = ? WHERE id = ?');
            $stmt->execute([$type, $marque, $modele, $bva, $places, $motorisation, $radio, $climatisation, $bluetooth, $regulateur_vitesse, $pack_electrique, $gps, $prix, $id]);
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

    public function getVehicules() {
        try {
            $stmt = $this->pdo->query('SELECT id, Marques AS marque, Modeles AS modele, Motorisation AS motorisation, Places AS places, GPS AS gps, prix AS prix FROM vehicules');
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return 'Erreur : ' . $e->getMessage();
        }
    }

    public function getVehiculeById($id) {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM vehicules WHERE id = ?');
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return 'Erreur : ' . $e->getMessage();
        }
    }
}