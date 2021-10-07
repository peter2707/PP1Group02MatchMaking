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
        
        if($userModel->deleteAccount($db, $username, $type)){
            session_start();
			unset($_SESSION["username"]);
			unset($_SESSION["password"]);
			session_destroy();
			$script = "<script>window.location = '../view/login.php?success=accountdeleted';</script>";
			echo $script;
        } else {
            $script = "<script>window.location = '../view/login.php?error=errordelete';</script>";
			echo $script;
        }
    }

    public function changeProfilePicture($file, $username, $userType){
        require_once '../model/db_connection.php';
        require_once '../model/user_model.php';
        $userModel = new UserModel();
        $userModel->changeProfilePicture($db, $file, $username, $userType);
    }

    public function getUserByName($usertype, $username) {
        require_once '../model/user_model.php';
        include '../model/db_connection.php';
        $userModel = new UserModel();
        return $userModel->getUserByName($db, $usertype, $username);
    }

    public function editSocialLink($username, $linkedin, $github, $twitter, $instagram, $facebook){
        require_once '../model/db_connection.php';
        require_once '../model/user_model.php';
        $userModel = new UserModel();
        $userModel->editSocialLink($db, $username, $linkedin, $github, $twitter, $instagram, $facebook);
    }

    public function getSocialLink($username) {
        require_once '../model/user_model.php';
        include '../model/db_connection.php';
        $userModel = new UserModel();
        return $userModel->getSocialLink($db, $username);
    }
}
?> 