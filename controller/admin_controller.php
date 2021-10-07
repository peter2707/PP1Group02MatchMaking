<?php
class AdminController {
    public function register($firstName, $lastName, $username, $password, $confirmPassword, $dateOfBirth, $phone, $email, $type, $positionEmployer, $positionAdmin, $field){
        require_once '../model/utility.php';
        require_once '../model/db_connection.php';
        require_once '../model/admin_model.php';
        $adminModel = new AdminModel();

        if (emptyInputRegister($firstName, $lastName, $username, $password, $confirmPassword, $dateOfBirth, $phone, $email, $type) !== false) {
            header("location: ../view/admin_add_user.php?error=emptyinput");
            exit();
        } elseif (invalidUsername($username) !== false) {                         // Proper username chosen
            header("location: ../view/admin_add_user.php?error=invaliduid");
            exit();
        } elseif (invalidEmail($email) !== false) {                     // Proper email chosen
            header("location: ../view/admin_add_user.php?error=invalidemail");
            exit();
        } elseif (passwordMatch($password, $confirmPassword) !== false) {               // Do the two passwords match?
            header("location: ../view/admin_add_user.php?error=passwordsdontmatch");
            exit();
        } else {
            if($type == "employer"){
                if (!$positionEmployer){
                    header("location: ../view/admin_add_user.php?error=positionnull");
                }elseif (usernameExists($db, $username, $email, "employer") !== false) {              // Is the username taken already
                    header("location: ../view/admin_add_user.php?error=usernametaken");
                    exit();
                }else{
                    $adminModel->registerEmployer($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $positionEmployer);
                }
            }elseif($type == "admin"){
                if (!$positionAdmin){
                    header("location: ../view/admin_add_user.php?error=positionnull");
                }elseif (usernameExists($db, $username, $email, "admin") !== false) {              // Is the username taken already
                    header("location: ../view/admin_add_user.php?error=usernametaken");
                    exit();
                }else{
                    $adminModel->registerAdmin($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $positionAdmin);
                }
            }else{
                if (!$field){
                    header("location: ../view/admin_add_user.php?error=fieldnull");
                }elseif (usernameExists($db, $username, $email, "jobseeker") !== false) {              // Is the username taken already
                    header("location: ../view/admin_add_user.php?error=usernametaken");
                    exit();
                }else{
                    $adminModel->registerJobSeeker($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $field);
                }
            }
        }
    }

    public function deleteAccount($username, $usertype){
        require_once '../model/db_connection.php';
        require_once '../model/admin_model.php';
        $adminModel = new AdminModel();
        $adminModel->deleteAccount($db, $username, $usertype);
    }

    public function getAllJobSeeker(){
        require_once '../model/admin_model.php';
        include '../model/db_connection.php';
        $adminModel = new AdminModel();
        return $adminModel->getAllJobSeeker($db);
	}

	public function getAllEmployer(){
        require_once '../model/admin_model.php';
        include '../model/db_connection.php';
        $adminModel = new AdminModel();
        return $adminModel->getAllEmployer($db);
	}

    public function getAllAdmin(){
        require_once '../model/admin_model.php';
        include '../model/db_connection.php';
        $adminModel = new AdminModel();
        return $adminModel->getAllAdmin($db);
	}

	public function updateJobSeeker($firstName, $lastName, $username, $password, $dob, $phone, $email, $field, $id){
        require_once '../model/admin_model.php';
        include '../model/db_connection.php';
        $adminModel = new AdminModel();
        $adminModel->updateJobSeeker($db, $firstName, $lastName, $username, $password, $dob, $phone, $email, $field, $id);
	}

	public function updateEmployer($firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $id){
        require_once '../model/admin_model.php';
        include '../model/db_connection.php';
        $adminModel = new AdminModel();
        $adminModel->updateEmployer($db, $firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $id);
	}

    public function updateAdmin($firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $id){
        require_once '../model/admin_model.php';
        include '../model/db_connection.php';
        $adminModel = new AdminModel();
        $adminModel->updateAdmin($db, $firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $id);
	}

    public function generateReport($table){
        require_once '../model/admin_model.php';
        include '../model/db_connection.php';
        $adminModel = new AdminModel();
        $adminModel->generateReport($db, $table);
	}
    
}
