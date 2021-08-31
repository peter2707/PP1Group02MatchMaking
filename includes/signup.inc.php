<?php

  if(isset($_POST['registerAdmin'])){
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    require_once 'functions.inc.php';
    require_once 'db_connection.inc.php';
    if (emptyInputSignup($firstName, $lastName, $username, $password, $confirmPassword, $dateOfBirth, $phone, $email, $position) !== false) {
        header("location: ../signup.php?error=emptyinput");
        exit();
    } elseif (invalidUsername($username) !== false) {                         // Proper username chosen
        header("location: ../signup.php?error=invaliduid");
        exit();
    } elseif (invalidEmail($email) !== false) {                     // Proper email chosen
        header("location: ../signup.php?error=invalidemail");
        exit();
    } elseif (passwordMatch($password, $confirmPassword) !== false) {               // Do the two passwords match?
        header("location: ../signup.php?error=passwordsdontmatch");
        exit();
    } elseif (usernameExists($db, $username, $email) !== false) {              // Is the username taken already
        header("location: ../signup.php?error=usernametaken");
        exit();
    } else {
        registerAdmin($db, $_POST['firstName'], $_POST['lastName'], $_POST['username'], $_POST['password'], $_POST['dateOfBirth'], $_POST['phone'], $_POST['email'], $_POST['position']);
    }
  }

  if(isset($_POST['registerEmployer'])){
    
    
  }

  if(isset($_POST['registerJobSeeker'])){
    
    
  }

  function registerAdmin($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $position){
    $query = "INSERT INTO admin (firstName, lastName, username, password, dateOfBirth, phone, email, position) 
            VALUES ('$firstName', '$lastName', '$username', '$password', '$dateOfBirth', '$phone', '$email', '$position')";
    mysqli_query($db, $query);
    $db->close();
    header("location: ../login.php?success=created");
  }

  function registerEmployer(){

  }

  function registerJobSeeker(){

  }

  

  

  
?>