<?php
class UserController {
    public function getUserData($userType) {
        require_once '../model/user_model.php';
        require_once '../model/db_connection.php';
        $userModel = new UserModel();
        return $userModel->getUser($db, $userType);
    }

    public function updateJobSeeker($firstName, $lastName, $password, $dob, $phone, $email, $field, $location, $username) {
        require_once '../model/user_model.php';
        require_once '../model/db_connection.php';
        $userModel = new UserModel();
        $userModel->updateJobSeeker($db, $firstName, $lastName, $password, $dob, $phone, $email, $field, $location, $username);
    }

    public function updateEmployer($firstName, $lastName, $password, $dob, $phone, $email, $position, $location, $username) {
        require_once '../model/user_model.php';
        require_once '../model/db_connection.php';
        $userModel = new UserModel();
        $userModel->updateEmployer($db, $firstName, $lastName, $password, $dob, $phone, $email, $position, $location, $username);
    }

    public function deleteAccount($username, $type){
        require_once '../model/db_connection.php';
        require_once '../model/user_model.php';
        $userModel = new UserModel();
        $userModel->deleteAccount($db, $username, $type);
    }

    public function changeProfilePicture($file, $username, $userType){
        include '../model/db_connection.php';
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
        include '../model/db_connection.php';
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

    public function getSkills($username){
        require_once '../model/user_model.php';
        include '../model/db_connection.php';
        $userModel = new UserModel();
        return $userModel->getSkills($db, $username);
    }

    public function addSkill($username, $skill, $experience){
        include '../model/db_connection.php';
        require_once '../model/user_model.php';
        $userModel = new UserModel();
        $userModel->addSkill($db, $username, $skill, $experience);
    }

    public function deleteSkill($id){
        include '../model/db_connection.php';
        require_once '../model/user_model.php';
        $userModel = new UserModel();
        $userModel->deleteSkill($db, $id);
    }

    public function getEducations($username){
        require_once '../model/user_model.php';
        include '../model/db_connection.php';
        $userModel = new UserModel();
        return $userModel->getEducations($db, $username);
    }

    public function addEducation($username, $institution, $degree, $graduation){
        include '../model/db_connection.php';
        require_once '../model/user_model.php';
        $userModel = new UserModel();
        $userModel->addEducation($db, $username, $institution, $degree, $graduation);
    }

    public function deleteEducation($id){
        include '../model/db_connection.php';
        require_once '../model/user_model.php';
        $userModel = new UserModel();
        $userModel->deleteEducation($db, $id);
    }

    public function getCareers($username){
        require_once '../model/user_model.php';
        include '../model/db_connection.php';
        $userModel = new UserModel();
        return $userModel->getCareers($db, $username);
    }

    public function addCareer($username, $position, $company, $experience){
        include '../model/db_connection.php';
        require_once '../model/user_model.php';
        $userModel = new UserModel();
        $userModel->addCareer($db, $username, $position, $company, $experience);
    }

    public function deleteCareer($id){
        include '../model/db_connection.php';
        require_once '../model/user_model.php';
        $userModel = new UserModel();
        $userModel->deleteCareer($db, $id);
    }

    public function resetPassword($type, $password, $confirmPassword, $email, $token) {
        require_once '../model/utility.php';
        if(!isset($type) || !isset($password) || !isset($confirmPassword) || !isset($email) || !isset($token)){
            header("location: ../view/reset_password.php?error=emptyinput");
            exit();
        }elseif (passwordMatch($password, $confirmPassword) !== false) {               // Do the two passwords match?
            header("location: ../view/reset_password.php?error=passwordsdontmatch");
            exit();
        }else{
            require_once '../model/user_model.php';
            include '../model/db_connection.php';
            $userModel = new UserModel();
            return $userModel->resetPassword($db, $type, $password, $email, $token);
        }
    }
}
?> 