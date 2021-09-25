<?php
class AdminModel{

  public function register($firstName, $lastName, $username, $password, $confirmPassword, $dateOfBirth, $phone, $email, $type, $position, $rating, $exp, $skill){
    require_once 'utility.php';
    require_once 'db_connection.php';
    if (emptyInputSignup($firstName, $lastName, $username, $password, $confirmPassword, $dateOfBirth, $phone, $email, $type) !== false) {
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
        if (usernameExists($db, $username, $email, "employer") !== false) {              // Is the username taken already
          header("location: ../view/addUser.php?error=usernametaken");
          exit();
        }else{
          registerEmployer($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $rating);
        }
      }elseif($type == "admin"){
        if (usernameExists($db, $username, $email, "admin") !== false) {              // Is the username taken already
          header("location: ../view/addUser.php?error=usernametaken");
          exit();
        }else{
          registerAdmin($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $position);
        }
      }else{
        if (usernameExists($db, $username, $email, "jobseeker") !== false) {              // Is the username taken already
          header("location: ../view/addUser.php?error=usernametaken");
          exit();
        }else{
          registerJobSeeker($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $exp, $skill);
        }
      }
    }
  }
  

  function registerEmployer($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $rating){
    $query = "INSERT INTO employer (firstName, lastName, username, password, dateOfBirth, phone, email, rating) 
            VALUES ('$firstName', '$lastName', '$username', '$password', '$dateOfBirth', '$phone', '$email', '$rating')";
    mysqli_query($db, $query);
    $db->close();
    header("location: ../view/adminIndex.php?success=created");
  }

  function registerJobSeeker($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $exp, $skill){
    $query = "INSERT INTO jobseeker (firstName, lastName, username, password, dateOfBirth, phone, email, experience, skill) 
            VALUES ('$firstName', '$lastName', '$username', '$password', '$dateOfBirth', '$phone', '$email', '$exp', '$skill')";
    mysqli_query($db, $query);
    $db->close();
    header("location: ../view/adminIndex.php?success=created");
  }

  function registerAdmin($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $position){
    $query = "INSERT INTO employer (firstName, lastName, username, password, dateOfBirth, phone, email, position) 
            VALUES ('$firstName', '$lastName', '$username', '$password', '$dateOfBirth', '$phone', '$email', '$position')";
    mysqli_query($db, $query);
    $db->close();
    header("location: ../view/adminIndex.php?success=created");
  }
}
  
?>