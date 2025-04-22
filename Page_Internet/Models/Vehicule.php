<?php
require_once 'Bdd.php';

class Vehicule {

    public static function getAll(string $sort = ''): array {
        $conn = Bdd::getConnection();
    
        $allowed = [
            'marque' => 'marque ASC',
            'prix_asc' => 'prix_journalier ASC',
            'prix_desc' => 'prix_journalier DESC',
            'places' => 'nb_places DESC'
        ];
    
        $orderBy = $allowed[$sort] ?? 'marque, modele';
    
        $stmt = $conn->query("SELECT * FROM vehicules ORDER BY $orderBy");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public static function findById(int $id): ?array {
        $conn = Bdd::getConnection();
        $stmt = $conn->prepare("SELECT * FROM vehicules WHERE id = ?");
        $stmt->execute([$id]);
        $vehicule = $stmt->fetch(PDO::FETCH_ASSOC);
        return $vehicule ?: null;
    }

    public static function create(array $data): void {
        $conn = Bdd::getConnection();
        $stmt = $conn->prepare("INSERT INTO vehicules (nom, marque, modele, id_motorisation, prix_journalier, image, boite_auto, nb_places) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['nom'] ?? '',
            $data['marque'] ?? '',
            $data['modele'] ?? '',
            $data['id_motorisation'] ?? null,
            $data['prix_journalier'] ?? null,
            $data['image'] ?? '',
            $data['boite_auto'] ?? 0,
            $data['nb_places'] ?? 4
        ]);
    }

    public static function update(int $id, array $data): void {
        $conn = Bdd::getConnection();
        $stmt = $conn->prepare("UPDATE vehicules 
                                SET nom = ?, marque = ?, modele = ?, id_motorisation = ?, prix_journalier = ?, image = ?, boite_auto = ?, nb_places = ?
                                WHERE id = ?");
        $stmt->execute([
            $data['nom'] ?? '',
            $data['marque'] ?? '',
            $data['modele'] ?? '',
            $data['id_motorisation'] ?? null,
            $data['prix_journalier'] ?? null,
            $data['image'] ?? '',
            $data['boite_auto'] ?? 0,
            $data['nb_places'] ?? 4,
            $id
        ]);
    }

    public static function delete(int $id): void {
        $conn = Bdd::getConnection();
        $stmt = $conn->prepare("DELETE FROM vehicules WHERE id = ?");
        $stmt->execute([$id]);
    }
}
