<?php

// Check for empty input register
function emptyInputRegister($firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $location, $type) {
	$result = false;
	if (empty(trim($firstName, " ")) || empty(trim($lastName, " ")) || empty(trim($username, " ")) || empty(trim($password, " ")) || empty(trim($dateOfBirth, " ")) 
		|| empty(trim($phone, " ")) || empty(trim($email, " ")) || empty(trim($location, " ")) || empty(trim($type, " "))) {
		$result = true;
	}
	return $result;
}

// Check invalid username
function invalidUsername($username) {
	$result = false;
	if (!preg_match('/^[a-z\d_]{5,20}$/i', $username)) {
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
function usernameExists($db, $username, $email, $table) {
	$query = "SELECT count(*) FROM $table WHERE username=? OR email =?";
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

// Check if the input is in the future
function compareDate($date){
	$currentDate = date("Y-m-d");

	if($currentDate > $date){
		return false;
	} else {
		return true;
	}

}


?>