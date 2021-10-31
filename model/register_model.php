<?php
class RegisterModel {
	public function registerEmployer($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $position, $location) {
		$success = false;
		try {
			$query = "INSERT INTO employer (firstName, lastName, username, password, dateOfBirth, phone, email, position, location) 
            VALUES ('$firstName', '$lastName', '$username', '$password', '$dateOfBirth', '$phone', '$email', '$position', '$location')";
			mysqli_query($db, $query) or die(mysqli_error($db));
			$db->close();
			$success = true;
		} catch (Exception $e) {
			$e->getMessage();
		}
		return $success;
	}

	public function registerJobSeeker($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $field, $location) {
		$success = false;
		try {
			$query = "INSERT INTO jobseeker (firstName, lastName, username, password, dateOfBirth, phone, email, field, location) 
            VALUES ('$firstName', '$lastName', '$username', '$password', '$dateOfBirth', '$phone', '$email', '$field', '$location')";
			mysqli_query($db, $query) or die(mysqli_error($db));
			$db->close();
			$success = true;
		} catch (Exception $e) {
			$e->getMessage();
		}
		return $success;
	}
}
