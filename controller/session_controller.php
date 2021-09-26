<?php
require_once __DIR__.'/../model/session_model.php';
class SessionController {
    
    public function checkSession() {
        $sessionModel = new SessionModel();
        return $sessionModel->sessionExists();
    }

    public function getUserType() {
        $sessionModel = new SessionModel();
        return $sessionModel->getUserType();
    }

    public function getUserName() {
        $sessionModel = new SessionModel();
        return $sessionModel->getUserName();
    }
}
?> 