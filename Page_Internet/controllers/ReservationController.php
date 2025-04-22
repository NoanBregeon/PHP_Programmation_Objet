<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../models/Reservation.php';

class ReservationController extends BaseController {

    public function index() {
        if (!$this->isLoggedIn()) {
            $this->redirect('login.php');
        }

        $reservations = Reservation::getAll();
        $this->render('reservation/index', ['reservations' => $reservations]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Reservation::create($_POST);
            $this->redirect('index.php?controller=reservation&action=index');
        }

        $this->render('reservation/create');
    }

    public function delete($id) {
        if ($this->isAdmin()) {
            Reservation::delete($id);
        }
        $this->redirect('index.php?controller=reservation&action=index');
    }
}
