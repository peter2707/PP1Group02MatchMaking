<?php
class RegisterModel{

  public function registerEmployer($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email){
    $query = "INSERT INTO employer (firstName, lastName, username, password, dateOfBirth, phone, email) 
            VALUES ('$firstName', '$lastName', '$username', '$password', '$dateOfBirth', '$phone', '$email')";
    mysqli_query($db, $query);
    $db->close();
    header("location: ../view/login.php?success=created");
  }

  public function registerJobSeeker($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email){
    $query = "INSERT INTO jobseeker (firstName, lastName, username, password, dateOfBirth, phone, email) 
            VALUES ('$firstName', '$lastName', '$username', '$password', '$dateOfBirth', '$phone', '$email')";
    mysqli_query($db, $query);
    $db->close();
    header("location: ../view/login.php?success=created");
  }
}
?>