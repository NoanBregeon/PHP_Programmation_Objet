<?php
require_once '..\models\Bdd.php';
session_start();

class VehiculeController {

    public function getAllVehicules() {
        global $conn;
        $stmt = $conn->query("SELECT v.*, m.nom as motorisation 
                              FROM vehicules v 
                              JOIN motorisation m ON v.id_motorisation = m.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVehiculeById($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM vehicules WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function ajouterVehicule($donnees, $fichierImage) {
        global $conn;

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['error'] = "Accès refusé.";
            return false;
        }

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

        $stmt = $conn->prepare("INSERT INTO vehicules (nom, marque, modele, id_motorisation, prix_journalier, image, boite_auto, nb_places) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$nom, $marque, $modele, $id_motorisation, $prix_journalier, $imagePath, $boite_auto, $nb_places]);
    }

    public function modifierVehicule($id, $donnees, $fichierImage) {
        global $conn;

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['error'] = "Accès refusé.";
            return false;
        }

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
            $stmt = $conn->prepare("UPDATE vehicules SET nom = ?, marque = ?, modele = ?, id_motorisation = ?, prix_journalier = ?, boite_auto = ?, nb_places = ?, image = ? WHERE id = ?");
            return $stmt->execute([$nom, $marque, $modele, $id_motorisation, $prix_journalier, $boite_auto, $nb_places, $imagePath, $id]);
        } else {
            $stmt = $conn->prepare("UPDATE vehicules SET nom = ?, marque = ?, modele = ?, id_motorisation = ?, prix_journalier = ?, boite_auto = ?, nb_places = ? WHERE id = ?");
            return $stmt->execute([$nom, $marque, $modele, $id_motorisation, $prix_journalier, $boite_auto, $nb_places, $id]);
        }
    }

    public function supprimerVehicule($id) {
        global $conn;

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['error'] = "Accès refusé.";
            return false;
        }

        $stmt = $conn->prepare("DELETE FROM vehicules WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
