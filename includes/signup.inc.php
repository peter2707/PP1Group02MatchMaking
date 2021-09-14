<?php

  if(isset($_POST['register'])){
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $type = $_POST['signup_type'];
    require_once 'functions.inc.php';
    require_once 'db_connection.inc.php';
    if (emptyInputSignup($firstName, $lastName, $username, $password, $confirmPassword, $dateOfBirth, $phone, $email, $type) !== false) {
        header("location: ../view/signup.php?error=emptyinput");
        exit();
    } elseif (invalidUsername($username) !== false) {                         // Proper username chosen
        header("location: ../view/signup.php?error=invaliduid");
        exit();
    } elseif (invalidEmail($email) !== false) {                     // Proper email chosen
        header("location: ../view/signup.php?error=invalidemail");
        exit();
    } elseif (passwordMatch($password, $confirmPassword) !== false) {               // Do the two passwords match?
        header("location: ../view/signup.php?error=passwordsdontmatch");
        exit();
    } else {
        if($type == "employer"){
          if (usernameExists($db, $username, $email, "employer") !== false) {              // Is the username taken already
            header("location: ../view/signup.php?error=usernametaken");
            exit();
          }else{
            registerEmployer($db, $_POST['firstName'], $_POST['lastName'], $_POST['username'], $_POST['password'], $_POST['dateOfBirth'], $_POST['phone'], $_POST['email']);
          }
        }else{
          if (usernameExists($db, $username, $email, "jobseeker") !== false) {              // Is the username taken already
            header("location: ../view/signup.php?error=usernametaken");
            exit();
          }else{
            registerJobSeeker($db, $_POST['firstName'], $_POST['lastName'], $_POST['username'], $_POST['password'], $_POST['dateOfBirth'], $_POST['phone'], $_POST['email']);
          }
        }
    }
  }

  function registerEmployer($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email){
    $query = "INSERT INTO employer (firstName, lastName, username, password, dateOfBirth, phone, email) 
            VALUES ('$firstName', '$lastName', '$username', '$password', '$dateOfBirth', '$phone', '$email')";
    mysqli_query($db, $query);
    $db->close();
    header("location: ../view/login.php?success=created");
  }

  function registerJobSeeker($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email){
    $query = "INSERT INTO jobseeker (firstName, lastName, username, password, dateOfBirth, phone, email) 
            VALUES ('$firstName', '$lastName', '$username', '$password', '$dateOfBirth', '$phone', '$email')";
    mysqli_query($db, $query);
    $db->close();
    header("location: ../view/login.php?success=created");
  }
  
?>