<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../models/Reservation.php';

class ReservationController extends BaseController {

    /**
     * Liste toutes les réservations (accessible aux admins).
     */
    public function index() {
        if (!$this->isAdmin()) {
            $this->redirect('index.php');
        }

        $reservations = Reservation::getAll();
        $this->render('reservation/index', ['reservations' => $reservations]);
    }

    /**
     * Affiche les réservations de l'utilisateur connecté.
     */
    public function mes() {
        if (!$this->isLoggedIn()) {
            $this->redirect('index.php?controller=auth&action=login');
        }
    
        $userId = $_SESSION['user']['id'];
        $reservations = Reservation::getByUserId($userId);
    
        $today = date('Y-m-d');
        $active = [];
        $expired = [];
    
        foreach ($reservations as $r) {
            if ($r['date_fin'] < $today) {
                $expired[] = $r;
            } else {
                $active[] = $r;
            }
        }
    
        // ✅ Maintenant les variables existent bien ici
        $this->render('reservation/mes', [
            'active' => $active,
            'expired' => $expired
        ]);
    }
    

    /**
     * Crée une nouvelle réservation.
     */
    public function create() {
        if (!$this->isLoggedIn()) {
            $this->redirect('index.php?controller=auth&action=login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Reservation::create($_POST);
            $this->redirect('index.php?controller=reservation&action=mes');
        }

        $this->render('reservation/create');
    }

    /**
     * Supprime une réservation.
     */
    public function delete($id) {
        if (!$this->isLoggedIn()) {
            $this->redirect('index.php');
        }

        Reservation::delete($id);
        $redirect = $this->isAdmin() ? 'index' : 'mes';
        $this->redirect("index.php?controller=reservation&action=$redirect");
    }
}
