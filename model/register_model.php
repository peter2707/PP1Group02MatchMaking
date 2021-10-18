<?php
class RegisterModel {

  public function registerEmployer($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $position, $location){
    try{
      $query = "INSERT INTO employer (firstName, lastName, username, password, dateOfBirth, phone, email, position, location) 
            VALUES ('$firstName', '$lastName', '$username', '$password', '$dateOfBirth', '$phone', '$email', '$position', '$location')";
      mysqli_query($db, $query) or die(mysqli_error($db));
      $db->close();
      header("location: ../view/login.php?success=created");
    }catch(Exception $e){
      $e->getMessage();
      header("location: ../view/login.php?error=failed");
    }
  }

  public function registerJobSeeker($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $field, $location) {
    try{
      $query = "INSERT INTO jobseeker (firstName, lastName, username, password, dateOfBirth, phone, email, field, location) 
            VALUES ('$firstName', '$lastName', '$username', '$password', '$dateOfBirth', '$phone', '$email', '$field', '$location')";
      mysqli_query($db, $query) or die(mysqli_error($db));
      $db->close();
      header("location: ../view/login.php?success=created");
    }catch(Exception $e){
      $e->getMessage();
      header("location: ../view/login.php?error=failed");
    }
  }
}
?>