<?php
class AdminModel {
	
	public function registerEmployer($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $position) {
		$query = "INSERT INTO employer (firstName, lastName, username, password, dateOfBirth, phone, email, position) 
				VALUES ('$firstName', '$lastName', '$username', '$password', '$dateOfBirth', '$phone', '$email', '$position')";
		mysqli_query($db, $query) or die(mysqli_error($db));
		$db->close();
		header("location: ../view/admin_index.php?success=created");
	}

	public function registerJobSeeker($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $field) {
		$query = "INSERT INTO jobseeker (firstName, lastName, username, password, dateOfBirth, phone, email, field) 
				VALUES ('$firstName', '$lastName', '$username', '$password', '$dateOfBirth', '$phone', '$email', '$field')";
		mysqli_query($db, $query) or die(mysqli_error($db));
		$db->close();
		header("location: ../view/admin_index.php?success=created");
	}

	public function registerAdmin($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $position) {
		$query = "INSERT INTO admin (firstName, lastName, username, password, dateOfBirth, phone, email, position) 
				VALUES ('$firstName', '$lastName', '$username', '$password', '$dateOfBirth', '$phone', '$email', '$position')";
		mysqli_query($db, $query) or die(mysqli_error($db));
		$db->close();
		header("location: ../view/admin_index.php?success=created");
	}

	public function getAllJobSeeker($db) {
		require_once '../model/user_object.php';
		$allJobSeekers = array();
		$query = "SELECT * FROM jobseeker ORDER BY id";
		$result = $db->query($query);
		$numResults = $result->num_rows;
		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$allJobSeekers[$i] = new JobSeeker($row['id'], $row['firstName'], $row['lastName'], $row['username'], $row['password'], $row['dateOfBirth'], $row['phone'], $row['email'], $row['field'], $row['Image']);
		}
		$result->free();
		$db->close();
		return $allJobSeekers;
	}

	public function getAllEmployer($db) {
		require_once '../model/user_object.php';
		$allEmployers = array();
		$query = "SELECT * FROM employer ORDER BY id";
		$result = $db->query($query);
		$numResults = $result->num_rows;
		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$allEmployers[$i] = new Employer($row['id'], $row['firstName'], $row['lastName'], $row['username'], $row['password'], $row['dateOfBirth'], $row['phone'], $row['email'], $row['position'], $row['rating'], $row['image']);
		}
		$result->free();
		$db->close();
		return $allEmployers;
	}

	public function getAllAdmin($db) {
		require_once '../model/user_object.php';
		$allAdmins = array();
		$query = "SELECT * FROM admin ORDER BY id";
		$result = $db->query($query);
		$numResults = $result->num_rows;
		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$allAdmins[$i] = new Admin($row['id'], $row['firstName'], $row['lastName'], $row['username'], $row['password'], $row['dateOfBirth'], $row['phone'], $row['email'], $row['position'], $row['image']);
		}
		$result->free();
		$db->close();
		return $allAdmins;
	}

	public function updateAdmin($db, $firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $id) {
		$query = "UPDATE admin SET firstName=?, lastName=?, username=?, password=?, dateOfBirth=?, phone=?, email=?, position=? WHERE id=?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("ssssisss", $firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $id);
		$stmt->execute();

		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		if ($affectedRows == 1) {
			header("location: ../view/admin_index.php?success=successupdate");
		} else {
			header("location: ../view/admin_index.php?error=errorupdate");
		}
	}

	public function deleteAccount($db, $username, $type) {
		$query = "DELETE FROM $type WHERE username = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("s", $username);
		$stmt->execute();

		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		if ($affectedRows == 1) {
			header("location: ../view/admin_index.php?success=successdelete");
		} else {
			header("location: ../view/admin_index.php?error=errordelete");
		}
	}

}
  
?>