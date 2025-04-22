<?php
require_once '../models/Bdd.php';

abstract class BaseController {
    protected $conn;

    public function __construct() {
        $this->conn = Bdd::getConnection();
    }

    /**
     * Gère les erreurs en les stockant dans la session.
     */
    protected function setError($message) {
        $_SESSION['error'] = $message;
    }

    /**
     * Gère les messages de succès en les stockant dans la session.
     */
    protected function setSuccess($message) {
        $_SESSION['success'] = $message;
    }

    /**
     * Redirige vers une page donnée.
     */
    protected function redirect($url) {
        header("Location: $url");
        exit();
    }
}
?>