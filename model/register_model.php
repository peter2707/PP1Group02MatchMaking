<?php
class RegisterModel {

  public function registerEmployer($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $position){
    $query = "INSERT INTO employer (firstName, lastName, username, password, dateOfBirth, phone, email, position) 
            VALUES ('$firstName', '$lastName', '$username', '$password', '$dateOfBirth', '$phone', '$email', '$position')";
    mysqli_query($db, $query) or die(mysqli_error($db));

  }

  public function registerJobSeeker($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $field) {
    $query = "INSERT INTO jobseeker (firstName, lastName, username, password, dateOfBirth, phone, email, field) 
            VALUES ('$firstName', '$lastName', '$username', '$password', '$dateOfBirth', '$phone', '$email', '$field')";
    mysqli_query($db, $query) or die(mysqli_error($db));
  }
}
?>