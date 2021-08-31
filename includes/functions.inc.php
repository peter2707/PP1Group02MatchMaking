<?php

// Check for empty input signup
function emptyInputSignup($firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $position) {
	$result = false;
	if (empty($firstName) || empty($lastName) || empty($username) || empty($password) || empty($dateOfBirth) || empty($phone) || empty($email) || empty($position)) {
		$result = true;
	}
	return $result;
}

// Check invalid username
function invalidUsername($username) {
	$result = false;
	if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
		$result = true;
	}
	return $result;
}

// Check invalid email
function invalidEmail($email) {
	$result = false;
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$result = true;
	}
	return $result;
}

// Check if passwords matches
function passwordMatch($password, $confirmPassword) {
	$result = false;
	if ($password !== $confirmPassword) {
		$result = true;
	}
	return $result;
}

// Check if username is in database, if so then return data
function usernameExists($db, $username, $email) {
		$username = $_POST['username'];
		$email = $_POST['email'];

		$query = "SELECT count(*) FROM admin WHERE username=? OR email =?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("ss", $username, $email);
		$stmt->execute();
		
		$result = $stmt->get_result();
		$stmt->close();

		if (!$result) {
			echo "Couldn't check credentials";
			exit;
		}
		$row = $result->fetch_row();
		if ($row[0] > 0) {
			return true;
		}else {
			return false;
		}
  }

?>