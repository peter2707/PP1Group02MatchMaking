<?php
class RegisterController
{
  // function to register a user
  public function register($firstName, $lastName, $username, $password, $confirmPassword, $dateOfBirth, $phone, $email, $location, $type, $field, $position)
  {
    require_once '../model/register_model.php';
    require_once '../model/utility.php';
    require_once '../model/db_connection.php';
    $registerModel = new RegisterModel();

    // check if the input is empty
    if (emptyInputRegister($firstName, $lastName, $username, $password, $confirmPassword, $dateOfBirth, $phone, $email, $location, $type) !== false) {
      header("location: ../view/register.php?error=emptyinput");
      exit();
    } elseif (invalidUsername($username) !== false) {                               // Proper username chosen
      header("location: ../view/register.php?error=invalidusername");
      exit();
    } elseif (invalidEmail($email) !== false) {                                     // Proper email chosen
      header("location: ../view/register.php?error=invalidemail");
      exit();
    } elseif (passwordMatch($password, $confirmPassword) !== false) {               // Do the two passwords match?
      header("location: ../view/register.php?error=passwordsdontmatch");
      exit();
    } elseif (compareDate($dateOfBirth)) {
      header("location: ../view/register.php?error=date");
      exit();
    } elseif (preg_match('/^\S.*\s.*\S$/', $firstName) || preg_match('/^\S.*\s.*\S$/', $lastName)) {
      header("location: ../view/register.php?error=name");
      exit();
    } else {
      if ($type == "employer") {  // check user type
        if (!$position) {  // check if position is trpe
          header("location: ../view/register.php?error=positionnotfound");
        } elseif (usernameExists($db, $username, $email, "employer") !== false) {              // Is the username taken already
          header("location: ../view/register.php?error=usernametaken");
          exit();
        } else {
          // call register employer function to register model
          $registerModel->registerEmployer($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $position, $location);
        }
      } else {
        if (!$field) {     // check if field is true
          header("location: ../view/register.php?error=fieldnotfound");
        } elseif (usernameExists($db, $username, $email, "jobseeker") !== false) {              // Is the username taken already
          header("location: ../view/register.php?error=usernametaken");
          exit();
        } else {
          // call register job seeker function to register model
          $registerModel->registerJobSeeker($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $field, $location);
        }
      }
    }
  }
}
