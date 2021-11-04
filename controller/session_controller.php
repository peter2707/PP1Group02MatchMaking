<?php
require_once '../model/session_model.php';
class SessionController {
    // function to check session
    public function checkSession() {
        $sessionModel = new SessionModel();
        return $sessionModel->sessionExists();
    }
    
    // get user type
    public function getUserType() {
        $sessionModel = new SessionModel();
        return $sessionModel->getUserType();
    }

    // get username
    public function getUserName() {
        $sessionModel = new SessionModel();
        return $sessionModel->getUserName();
    }
}
?> 