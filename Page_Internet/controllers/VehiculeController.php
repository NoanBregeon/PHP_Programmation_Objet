<?php
require_once '../models/Bdd.php';
session_start();

class VehiculeController {
    private $conn;

    public function __construct() {
        $this->conn = Bdd::getConnection();
    }

    /**
     * Récupère tous les véhicules.
     */
    public function getAllVehicules() {
        try {
            $stmt = $this->conn->query("SELECT v.*, m.nom as motorisation 
                                        FROM vehicules v 
                                        JOIN motorisation m ON v.id_motorisation = m.id");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION['error'] = "Erreur lors de la récupération des véhicules : " . $e->getMessage();
            return [];
        }
    }

    /**
     * Récupère un véhicule par son ID.
     */
    public function getVehiculeById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM vehicules WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION['error'] = "Erreur lors de la récupération du véhicule : " . $e->getMessage();
            return null;
        }
    }

    /**
     * Ajoute un nouveau véhicule.
     */
    public function ajouterVehicule($donnees, $fichierImage) {
        try {
            $nom = $donnees['nom'];
            $marque = $donnees['marque'];
            $modele = $donnees['modele'];
            $id_motorisation = $donnees['id_motorisation'];
            $prix_journalier = $donnees['prix_journalier'];
            $boite_auto = isset($donnees['boite_auto']) ? 1 : 0;
            $nb_places = isset($donnees['nb_places']) ? intval($donnees['nb_places']) : 4;
            $imagePath = null;

            if ($fichierImage['error'] === 0) {
                $allowedTypes = ['image/jpeg', 'image/png'];
                if (!in_array($fichierImage['type'], $allowedTypes)) {
                    $_SESSION['error'] = "Format d'image non autorisé.";
                    return false;
                }

                $imagePath = '../public/images/' . uniqid() . '_' . basename($fichierImage['name']);
                move_uploaded_file($fichierImage['tmp_name'], $imagePath);
            }

            $stmt = $this->conn->prepare("INSERT INTO vehicules (nom, marque, modele, id_motorisation, prix_journalier, image, boite_auto, nb_places) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            return $stmt->execute([$nom, $marque, $modele, $id_motorisation, $prix_journalier, $imagePath, $boite_auto, $nb_places]);
        } catch (PDOException $e) {
            $_SESSION['error'] = "Erreur lors de l'ajout du véhicule : " . $e->getMessage();
            return false;
        }
    }

    /**
     * Modifie un véhicule existant.
     */
    public function modifierVehicule($id, $donnees, $fichierImage) {
        try {
            $nom = $donnees['nom'];
            $marque = $donnees['marque'];
            $modele = $donnees['modele'];
            $id_motorisation = $donnees['id_motorisation'];
            $prix_journalier = $donnees['prix_journalier'];
            $boite_auto = isset($donnees['boite_auto']) ? 1 : 0;
            $nb_places = isset($donnees['nb_places']) ? intval($donnees['nb_places']) : 4;

            $imagePath = null;
            if ($fichierImage && $fichierImage['error'] === 0) {
                $allowedTypes = ['image/jpeg', 'image/png'];
                if (!in_array($fichierImage['type'], $allowedTypes)) {
                    $_SESSION['error'] = "Format d'image non autorisé.";
                    return false;
                }
                $imagePath = '../public/images/' . uniqid() . '_' . basename($fichierImage['name']);
                move_uploaded_file($fichierImage['tmp_name'], $imagePath);
            }

            if ($imagePath) {
                $stmt = $this->conn->prepare("UPDATE vehicules SET nom = ?, marque = ?, modele = ?, id_motorisation = ?, prix_journalier = ?, boite_auto = ?, nb_places = ?, image = ? WHERE id = ?");
                return $stmt->execute([$nom, $marque, $modele, $id_motorisation, $prix_journalier, $boite_auto, $nb_places, $imagePath, $id]);
            } else {
                $stmt = $this->conn->prepare("UPDATE vehicules SET nom = ?, marque = ?, modele = ?, id_motorisation = ?, prix_journalier = ?, boite_auto = ?, nb_places = ? WHERE id = ?");
                return $stmt->execute([$nom, $marque, $modele, $id_motorisation, $prix_journalier, $boite_auto, $nb_places, $id]);
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Erreur lors de la modification du véhicule : " . $e->getMessage();
            return false;
        }
    }

    /**
     * Supprime un véhicule.
     */
    public function supprimerVehicule($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM vehicules WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            $_SESSION['error'] = "Erreur lors de la suppression du véhicule : " . $e->getMessage();
            return false;
        }
    }

    /**
     * Supprime un véhicule par son ID.
     */
    public function supprimerVehiculeParId($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM vehicules WHERE id = ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            $_SESSION['error'] = "Erreur lors de la suppression du véhicule : " . $e->getMessage();
            return false;
        }
    }
}
?>