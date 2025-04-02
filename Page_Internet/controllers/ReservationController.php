<?php
require_once '../config/db.php';
session_start();

class ReservationController {

    public function reserver($donnees) {
        global $conn;

        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Vous devez être connecté pour réserver.";
            return false;
        }

        $id_utilisateur = $_SESSION['user']['id'];
        $id_vehicule = $donnees['id_vehicule'];
        $date_debut = $donnees['date_debut'];
        $date_fin = $donnees['date_fin'];

        if (empty($date_debut) || empty($date_fin)) {
            $_SESSION['error'] = "Veuillez sélectionner une date de début et de fin.";
            return false;
        }

        // Vérifier chevauchement de réservation
        $stmt = $conn->prepare("SELECT COUNT(*) FROM reservations 
            WHERE id_vehicule = ?
            AND (
                (date_debut <= ? AND date_fin >= ?) OR
                (date_debut <= ? AND date_fin >= ?) OR
                (date_debut >= ? AND date_fin <= ?)
            )");

        $stmt->execute([
            $id_vehicule,
            $date_debut, $date_debut,
            $date_fin, $date_fin,
            $date_debut, $date_fin
        ]);

        $count = $stmt->fetchColumn();
        if ($count > 0) {
            $_SESSION['error'] = "Ce véhicule est déjà réservé sur cette période.";
            return false;
        }

        // Insertion
        $stmt = $conn->prepare("INSERT INTO reservations (id_utilisateur, id_vehicule, date_debut, date_fin)
                                VALUES (?, ?, ?, ?)");
        return $stmt->execute([$id_utilisateur, $id_vehicule, $date_debut, $date_fin]);
    }

    public function getReservationsByUser($id_utilisateur) {
        global $conn;
        $stmt = $conn->prepare("SELECT r.*, v.nom AS nom_vehicule 
                                FROM reservations r 
                                JOIN vehicules v ON r.id_vehicule = v.id
                                WHERE r.id_utilisateur = ?
                                ORDER BY r.date_debut DESC");
        $stmt->execute([$id_utilisateur]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllReservations() {
        global $conn;

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['error'] = "Accès refusé.";
            return [];
        }

        $stmt = $conn->query("SELECT r.*, v.nom AS nom_vehicule, u.nom AS nom_utilisateur 
                              FROM reservations r
                              JOIN vehicules v ON r.id_vehicule = v.id
                              JOIN utilisateurs u ON r.id_utilisateur = u.id
                              ORDER BY r.date_debut DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
