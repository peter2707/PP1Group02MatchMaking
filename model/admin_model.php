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


	public function deleteJobSeeker($db, $username) {
		$query = "DELETE FROM jobseeker WHERE username = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("s", $username);
		$stmt->execute();

		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		if ($affectedRows == 1) {
			header("location: ../view/admin_index.php?success=deletedSeeker");
		} else {
			header("location: ../view/admin_index.php?error=errordelete");
		}
	}

	public function deleteEmployer($db, $username) {
		$query = "DELETE FROM employer WHERE username = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("s", $username);
		$stmt->execute();

		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		if ($affectedRows == 1) {
			header("location: ../view/admin_index.php?success=deletedEmployer");
		} else {
			header("location: ../view/admin_index.php?error=errordelete");
		}
	}

	public function getAllJobSeeker($db) {
		$query = "SELECT * FROM jobseeker ORDER BY id";
		$result = $db->query($query);
		$numResults = $result->num_rows;
	}

	public function getAllEmployer($db) {
		$query = "SELECT * FROM employer ORDER BY id";
		$result = $db->query($query);
		$numResults = $result->num_rows;
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

}
  
?>