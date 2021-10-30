<?php
class RegisterController {

	public function register($firstName, $lastName, $username, $password, $confirmPassword, $dateOfBirth, $phone, $email, $location, $type, $field, $position) {
		require_once '../model/register_model.php';
		require_once '../model/utility.php';
		require_once '../model/db_connection.php';
		$registerModel = new RegisterModel();

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
		} else {
			if ($type == "employer") {
				if (!$position) {
					header("location: ../view/register.php?error=positionnotfound");
				} elseif (usernameExists($db, $username, $email, "employer") !== false) {              // Is the username taken already
					header("location: ../view/register.php?error=usernametaken");
					exit();
				} else {
					if ($registerModel->registerEmployer($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $position, $location)) {
						header("location: ../view/login.php?success=created");
					} else {
						header("location: ../view/login.php?error=failed");
					}
				}
			} else {
				if (!$field) {
					header("location: ../view/register.php?error=fieldnotfound");
				} elseif (usernameExists($db, $username, $email, "jobseeker") !== false) {              // Is the username taken already
					header("location: ../view/register.php?error=usernametaken");
					exit();
				} else {
					if ($registerModel->registerJobSeeker($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $field, $location)) {
						header("location: ../view/login.php?success=created");
					} else {
						header("location: ../view/login.php?error=failed");
					}
				}
			}
		}
	}
}
