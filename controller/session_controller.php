<?php
require_once '../model/session_model.php';
class SessionController {
    
    public function checkSession() {
        $sessionModel = new SessionModel();
        return $sessionModel->sessionExists();
    }

    public function setNewSession($username, $password, $type) {
        $sessionModel = new SessionModel();
        $sessionModel->setNewSession($username, $password, $type);
    }

    public function getUserType() {
        $sessionModel = new SessionModel();
        return $sessionModel->getUserType();
    }

    public function getUserName() {
        $sessionModel = new SessionModel();
        return $sessionModel->getUserName();
    }
    
    public function destroySession() {
        $sessionModel = new SessionModel();
        $sessionModel->destroySession();
    }
}
?> 