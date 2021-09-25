<?php
class RegisterController {

    public function register($firstName, $lastName, $username, $password, $confirmPassword, $dateOfBirth, $phone, $email, $type, $rating, $exp, $skill){
        include '../model/register_model.php';
        include '../model/utility.php';
        require_once '../model/db_connection.php';
		$registerModel = new RegisterModel();

        if (emptyInputRegister($firstName, $lastName, $username, $password, $confirmPassword, $dateOfBirth, $phone, $email, $type) !== false) {
            header("location: ../view/register.php?error=emptyinput");
            exit();
        } elseif (invalidUsername($username) !== false) {                         // Proper username chosen
            header("location: ../view/register.php?error=invaliduid");
            exit();
        } elseif (invalidEmail($email) !== false) {                     // Proper email chosen
            header("location: ../view/register.php?error=invalidemail");
            exit();
        } elseif (passwordMatch($password, $confirmPassword) !== false) {               // Do the two passwords match?
            header("location: ../view/register.php?error=passwordsdontmatch");
            exit();
        } else {
            if($type == "employer"){
              if (usernameExists($db, $username, $email, "employer") !== false) {              // Is the username taken already
                header("location: ../view/register.php?error=usernametaken");
                exit();
              }else{
                $registerModel->registerEmployer($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email);
              }
            }else{
              if (usernameExists($db, $username, $email, "jobseeker") !== false) {              // Is the username taken already
                header("location: ../view/register.php?error=usernametaken");
                exit();
              }else{
                $registerModel->registerJobSeeker($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email);
              }
            }
        }
    }
}
?>