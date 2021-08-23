<?php
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $dateOfBirth = $_POST['dateOfBirth'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $position = $_POST['position'];

  $db = mysqli_connect("localhost", "root", "", "jobmatch");
  if(!$db){
    die("Connection failed");
  }
  $query = "INSERT INTO admin (firstName, lastName, username, password, dateOfBirth, phone, email, position) 
            VALUES ('$firstName', '$lastName', '$username', '$password', '$dateOfBirth', '$phone', '$email', '$position')";
  mysqli_query($db, $query);
?>

