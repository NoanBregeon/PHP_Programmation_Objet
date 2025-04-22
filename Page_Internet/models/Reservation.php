<?php
require_once 'Bdd.php';

class Reservation {

    public static function getAll(): array {
        $conn = Bdd::getConnection();
        $stmt = $conn->query("SELECT * FROM reservations");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(array $data): bool {
        $conn = Bdd::getConnection();

        $stmt = $conn->prepare("
            INSERT INTO reservations (id_utilisateur, id_vehicule, date_debut, date_fin)
            VALUES (?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['id_utilisateur'],
            $data['id_vehicule'],
            $data['date_debut'],
            $data['date_fin']
        ]);
    }

    public static function findByUser(int $userId): array {
        $conn = Bdd::getConnection();

        $stmt = $conn->prepare("SELECT * FROM reservations WHERE id_utilisateur = ?");
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete(int $id): bool {
        $conn = Bdd::getConnection();
        $stmt = $conn->prepare("DELETE FROM reservations WHERE id = ?");
        return $stmt->execute([$id]);
    }
    public static function getByUserId(int $userId): array {
        $conn = Bdd::getConnection();
    
        $stmt = $conn->prepare("SELECT * FROM reservations WHERE id_utilisateur = ?");
        $stmt->execute([$userId]);
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
