<?php
class UserController {
    public function getUserData($userType) {
        require_once '../model/user_model.php';
        require_once '../model/db_connection.php';
        $userModel = new UserModel();
        return $userModel->getUser($db, $userType);
    }

    public function updateJobSeeker($firstName, $lastName, $password, $dob, $phone, $email, $field, $username) {
        require_once '../model/user_model.php';
        require_once '../model/db_connection.php';
        $userModel = new UserModel();
        $userModel->updateJobSeeker($db, $firstName, $lastName, $password, $dob, $phone, $email, $field, $username);
    }

    public function updateEmployer($firstName, $lastName, $password, $dob, $phone, $email, $position, $username) {
        require_once '../model/user_model.php';
        require_once '../model/db_connection.php';
        $userModel = new UserModel();
        $userModel->updateEmployer($db, $firstName, $lastName, $password, $dob, $phone, $email, $position, $username);
    }

    public function deleteAccount($username, $type){
        require_once '../model/db_connection.php';
        require_once '../model/user_model.php';
        $userModel = new UserModel();
        $userModel->deleteAccount($db, $username, $type);
    }

    public function changeProfilePicture($file, $username, $userType){
        require_once '../model/db_connection.php';
        require_once '../model/user_model.php';
        $userModel = new UserModel();
        $userModel->changeProfilePicture($db, $file, $username, $userType);
    }
}
?> 