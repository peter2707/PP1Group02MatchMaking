<?php
class AdminController {
    // Register function for admin to create new user
    public function register($firstName, $lastName, $username, $password, $confirmPassword, $dateOfBirth, $phone, $email, $location, $type, $positionEmployer, $positionAdmin, $field){
        require_once '../model/utility.php';
        require_once '../model/db_connection.php';
        require_once '../model/admin_model.php';
        $adminModel = new AdminModel();

        // check input if empty
        if (emptyInputRegister($firstName, $lastName, $username, $password, $confirmPassword, $dateOfBirth, $phone, $email, $location, $type) !== false) {
            header("location: ../view/admin_add_user.php?error=emptyinput");
            exit();
        } elseif (invalidUsername($username) !== false) {                               // Proper username chosen
            header("location: ../view/admin_add_user.php?error=invalidusername");
            exit();
        } elseif (invalidEmail($email) !== false) {                                     // Proper email chosen
            header("location: ../view/admin_add_user.php?error=invalidemail");
            exit();
        } elseif (passwordMatch($password, $confirmPassword) !== false) {               // Do the two passwords match?
            header("location: ../view/admin_add_user.php?error=passwordsdontmatch");
            exit();
        } else {
            if($type == "employer"){
                if (!$positionEmployer){
                    header("location: ../view/admin_add_user.php?error=positionnotfound");
                }elseif (usernameExists($db, $username, $email, "employer") !== false) {              // Is the username taken already
                    header("location: ../view/admin_add_user.php?error=usernametaken");
                    exit();
                }else{
                    // On success validation, trigger register employer function
                    $adminModel->registerEmployer($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $positionEmployer, $location);
                }
            }elseif($type == "admin"){
                if (!$positionAdmin){
                    header("location: ../view/admin_add_user.php?error=positionnotfound");
                }elseif (usernameExists($db, $username, $email, "admin") !== false) {              // Is the username taken already
                    header("location: ../view/admin_add_user.php?error=usernametaken");
                    exit();
                }else{
                    $adminModel->registerAdmin($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $positionAdmin);
                }
            }else{
                if (!$field){
                    header("location: ../view/admin_add_user.php?error=fieldnotfound");
                }elseif (usernameExists($db, $username, $email, "jobseeker") !== false) {              // Is the username taken already
                    header("location: ../view/admin_add_user.php?error=usernametaken");
                    exit();
                }else{
                    // On success validation, trigger register job seeker function
                    $adminModel->registerJobSeeker($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $field, $location);
                }
            }
        }
    }

    // Delete function for admin to remove account by username
    public function deleteAccount($username, $usertype){
        require_once '../model/db_connection.php';
        require_once '../model/admin_model.php';
        $adminModel = new AdminModel();
        $adminModel->deleteAccount($db, $username, $usertype);
    }

    // retreive all job seeker accounts
    public function getAllJobSeeker(){
        require_once '../model/admin_model.php';
        include '../model/db_connection.php';
        $adminModel = new AdminModel();
        return $adminModel->getAllJobSeeker($db);
	}

    // retreive all employers account
	public function getAllEmployer(){
        require_once '../model/admin_model.php';
        include '../model/db_connection.php';
        $adminModel = new AdminModel();
        return $adminModel->getAllEmployer($db);
	}

    // retreive all admin accounts
    public function getAllAdmin(){
        require_once '../model/admin_model.php';
        include '../model/db_connection.php';
        $adminModel = new AdminModel();
        return $adminModel->getAllAdmin($db);
	}

    // update job seeker accounts
	public function updateJobSeeker($firstName, $lastName, $username, $password, $dob, $phone, $email, $field, $location, $id){
        require_once '../model/admin_model.php';
        include '../model/db_connection.php';
        $adminModel = new AdminModel();
        $adminModel->updateJobSeeker($db, $firstName, $lastName, $username, $password, $dob, $phone, $email, $field, $location, $id);
	}

    // update employer account
	public function updateEmployer($firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $location, $id){
        require_once '../model/admin_model.php';
        include '../model/db_connection.php';
        $adminModel = new AdminModel();
        $adminModel->updateEmployer($db, $firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $location, $id);
	}

    // update admin account
    public function updateAdmin($firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $id){
        require_once '../model/admin_model.php';
        include '../model/db_connection.php';
        $adminModel = new AdminModel();
        $adminModel->updateAdmin($db, $firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $id);
	}

    // generate report
    public function generateReport($table){
        require_once '../model/admin_model.php';
        include '../model/db_connection.php';
        $adminModel = new AdminModel();
        $adminModel->generateReport($db, $table);
	}
    
}
