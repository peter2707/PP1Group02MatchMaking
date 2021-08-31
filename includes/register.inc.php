<?php

  if(isset($_POST['registerAdmin'])){
    if (isset($_POST['firstName']) || isset($_POST['lastName']) || isset($_POST['username']) || isset($_POST['password']) 
        || isset($_POST['dateOfBirth']) || isset($_POST['phone']) || isset($_POST['email']) || isset($_POST['position'])){
      $_SESSION['Error'] = "You left one or more of the required fields.";
    } else {
      registerAdmin($_POST['firstName'], $_POST['lastName'], $_POST['username'], $_POST['password'], $_POST['dateOfBirth'], $_POST['phone'], $_POST['email'], $_POST['position']);
    }
  }

  if(isset($_POST['registerEmployer'])){
    
    
  }

  if(isset($_POST['registerJobSeeker'])){
    
    
  }

  function registerAdmin($firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $position){
    require('db_connection.inc.php');
    $query = "INSERT INTO admin (firstName, lastName, username, password, dateOfBirth, phone, email, position) 
            VALUES ('$firstName', '$lastName', '$username', '$password', '$dateOfBirth', '$phone', '$email', '$position')";
    mysqli_query($db, $query);
  }

  function registerEmployer(){

  }

  function registerJobSeeker(){

  }

  

  

  
?>