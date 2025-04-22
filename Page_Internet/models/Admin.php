<?php
require_once 'Bdd.php';

class Admin {

    /**
     * Récupère tous les utilisateurs.
     *
     * @return array
     */
    public static function getAllUsers(): array {
        $conn = Bdd::getConnection();
        $stmt = $conn->query("SELECT * FROM utilisateurs ORDER BY nom ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Supprime un utilisateur par son ID.
     *
     * @param int $id
     * @return void
     */
    public static function deleteUser(int $id): void {
        $conn = Bdd::getConnection();
        $stmt = $conn->prepare("DELETE FROM utilisateurs WHERE id = ?");
        $stmt->execute([$id]);
    }
}
