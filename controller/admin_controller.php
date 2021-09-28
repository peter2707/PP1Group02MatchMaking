<?php
class AdminController {
    public function register($firstName, $lastName, $username, $password, $confirmPassword, $dateOfBirth, $phone, $email, $type, $positionEmployer, $positionAdmin, $field){
        require_once '../model/utility.php';
        require_once '../model/db_connection.php';
        require_once '../model/admin_model.php';
        $adminModel = new AdminModel();

        if (emptyInputRegister($firstName, $lastName, $username, $password, $confirmPassword, $dateOfBirth, $phone, $email, $type) !== false) {
            header("location: ../view/addUser.php?error=emptyinput");
            exit();
        } elseif (invalidUsername($username) !== false) {                         // Proper username chosen
            header("location: ../view/addUser.php?error=invaliduid");
            exit();
        } elseif (invalidEmail($email) !== false) {                     // Proper email chosen
            header("location: ../view/addUser.php?error=invalidemail");
            exit();
        } elseif (passwordMatch($password, $confirmPassword) !== false) {               // Do the two passwords match?
            header("location: ../view/addUser.php?error=passwordsdontmatch");
            exit();
        } else {
            if($type == "employer"){
                if (!$positionEmployer){
                    header("location: ../view/addUser.php?error=positionnull");
                }elseif (usernameExists($db, $username, $email, "employer") !== false) {              // Is the username taken already
                    header("location: ../view/addUser.php?error=usernametaken");
                    exit();
                }else{
                    $adminModel->registerEmployer($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $positionEmployer);
                }
            }elseif($type == "admin"){
                if (!$positionAdmin){
                    header("location: ../view/addUser.php?error=positionnull");
                }elseif (usernameExists($db, $username, $email, "admin") !== false) {              // Is the username taken already
                    header("location: ../view/addUser.php?error=usernametaken");
                    exit();
                }else{
                    $adminModel->registerAdmin($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $positionAdmin);
                }
            }else{
                if (!$field){
                    header("location: ../view/addUser.php?error=fieldnull");
                }elseif (usernameExists($db, $username, $email, "jobseeker") !== false) {              // Is the username taken already
                    header("location: ../view/addUser.php?error=usernametaken");
                    exit();
                }else{
                    $adminModel->registerJobSeeker($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $field);
                }
          }
        }
      }
    
}
