<?php
class AdminController {
    public function register($firstName, $lastName, $username, $password, $confirmPassword, $dateOfBirth, $phone, $email, $type, $positionEmployer, $positionAdmin, $field){
        require_once '../model/utility.php';
        require_once '../model/db_connection.php';
        require_once '../model/admin_model.php';
        $adminModel = new AdminModel();

        if (emptyInputRegister($firstName, $lastName, $username, $password, $confirmPassword, $dateOfBirth, $phone, $email, $type) !== false) {
            header("location: ../view/add_user.php?error=emptyinput");
            exit();
        } elseif (invalidUsername($username) !== false) {                         // Proper username chosen
            header("location: ../view/add_user.php?error=invaliduid");
            exit();
        } elseif (invalidEmail($email) !== false) {                     // Proper email chosen
            header("location: ../view/add_user.php?error=invalidemail");
            exit();
        } elseif (passwordMatch($password, $confirmPassword) !== false) {               // Do the two passwords match?
            header("location: ../view/add_user.php?error=passwordsdontmatch");
            exit();
        } else {
            if($type == "employer"){
                if (!$positionEmployer){
                    header("location: ../view/add_user.php?error=positionnull");
                }elseif (usernameExists($db, $username, $email, "employer") !== false) {              // Is the username taken already
                    header("location: ../view/add_user.php?error=usernametaken");
                    exit();
                }else{
                    $adminModel->registerEmployer($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $positionEmployer);
                }
            }elseif($type == "admin"){
                if (!$positionAdmin){
                    header("location: ../view/add_user.php?error=positionnull");
                }elseif (usernameExists($db, $username, $email, "admin") !== false) {              // Is the username taken already
                    header("location: ../view/add_user.php?error=usernametaken");
                    exit();
                }else{
                    $adminModel->registerAdmin($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $positionAdmin);
                }
            }else{
                if (!$field){
                    header("location: ../view/add_user.php?error=fieldnull");
                }elseif (usernameExists($db, $username, $email, "jobseeker") !== false) {              // Is the username taken already
                    header("location: ../view/add_user.php?error=usernametaken");
                    exit();
                }else{
                    $adminModel->registerJobSeeker($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $field);
                }
            }
        }
    }

    public function deleteJobSeeker($username){
        require_once '../model/db_connection.php';
        require_once '../model/admin_model.php';
        $adminModel = new AdminModel();
        $adminModel->deleteJobSeeker($db, $username);
    }

    public function deleteEmployer($username){
        require_once '../model/db_connection.php';
        require_once '../model/admin_model.php';
        $adminModel = new AdminModel();
        $adminModel->deleteEmployer($db, $username);
    }

    public function getAllJobSeeker(){

		//return array of object
	}

	public function getAllEmployer(){

		//return array of object
	}

	public function editJobSeeker($username){

	}

	public function editEmployer($username){

	}
    
}
