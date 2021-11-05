<?php
class AdminModel {
	public function registerEmployer($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $position, $location) {
		// query to add new employer to employer table
		$query = "INSERT INTO employer (firstName, lastName, username, password, dateOfBirth, phone, email, position, location) 
				VALUES ('$firstName', '$lastName', '$username', '$password', '$dateOfBirth', '$phone', '$email', '$position', '$location')";
		mysqli_query($db, $query) or die(mysqli_error($db));
		$db->close();
		header("location: ../view/admin_index.php?success=created");
	}

	public function registerJobSeeker($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $field, $location) {
		// query to add new job seeker to job seeker table
		$query = "INSERT INTO jobseeker (firstName, lastName, username, password, dateOfBirth, phone, email, field, location) 
				VALUES ('$firstName', '$lastName', '$username', '$password', '$dateOfBirth', '$phone', '$email', '$field', '$location')";
		mysqli_query($db, $query) or die(mysqli_error($db));
		$db->close();
		header("location: ../view/admin_index.php?success=created");
	}

	public function registerAdmin($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $position) {
		// query to add new admin to admin table
		$query = "INSERT INTO admin (firstName, lastName, username, password, dateOfBirth, phone, email, position) 
				VALUES ('$firstName', '$lastName', '$username', '$password', '$dateOfBirth', '$phone', '$email', '$position')";
		mysqli_query($db, $query) or die(mysqli_error($db));
		$db->close();
		header("location: ../view/admin_index.php?success=created");
	}

	public function getAllJobSeeker($db) {
		require_once '../model/user_object.php';
		$allJobSeekers = array();

		// query all job seekers order by id
		$query = "SELECT * FROM jobseeker ORDER BY id";
		$result = $db->query($query);
		$numResults = $result->num_rows;

		// Loop to add all result into job seeker object
		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$allJobSeekers[$i] = new JobSeeker($row['id'], $row['firstName'], $row['lastName'], $row['username'], $row['password'], $row['dateOfBirth'], $row['phone'], $row['email'], $row['field'],$row['location'], $row['image']);
		}
		$result->free();
		$db->close();
		return $allJobSeekers;
	}

	public function getAllEmployer($db) {
		require_once '../model/user_object.php';
		$allEmployers = array();

		// query all employer order by id
		$query = "SELECT * FROM employer ORDER BY id";
		$result = $db->query($query);
		$numResults = $result->num_rows;

		// Loop to add all result into employer object
		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$allEmployers[$i] = new Employer($row['id'], $row['firstName'], $row['lastName'], $row['username'], $row['password'], $row['dateOfBirth'], $row['phone'], $row['email'], $row['position'], $row['location'],$row['rating'], $row['image']);
		}
		$result->free();
		$db->close();
		return $allEmployers;
	}

	public function getAllAdmin($db) {
		require_once '../model/user_object.php';
		$allAdmins = array();
		
		// query all admin order by id
		$query = "SELECT * FROM admin ORDER BY id";
		$result = $db->query($query);
		$numResults = $result->num_rows;

		// Loop to add all result into admin object
		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$allAdmins[$i] = new Admin($row['id'], $row['firstName'], $row['lastName'], $row['username'], $row['password'], $row['dateOfBirth'], $row['phone'], $row['email'], $row['position']);
		}
		$result->free();
		$db->close();
		return $allAdmins;
	}

	public function updateAdmin($db, $firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $id) {
		// query to update an admin account
		$query = "UPDATE admin SET firstName=?, lastName=?, username=?, password=?, dateOfBirth=?, phone=?, email=?, position=? WHERE id=?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("ssssssssi", $firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $id);
		$stmt->execute();

		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		// on successful update, display successful message
		// on fail, display error message
		if ($affectedRows == 1) {
			header("location: ../view/admin_index.php?success=updated");
		} else {
			header("location: ../view/admin_index.php?error=failed");
		}
	}

	public function updateJobSeeker($db, $firstName, $lastName, $username, $password, $dob, $phone, $email, $field, $location, $id) {
		// query to update a job seeker account
		$query = "UPDATE jobseeker SET firstName=?, lastName=?, username=?, password=?, dateOfBirth=?, phone=?, email=?, field=?, location=? WHERE id=?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("sssssssssi", $firstName, $lastName, $username, $password, $dob, $phone, $email, $field, $location, $id);
		$stmt->execute();

		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		// on successful update, display successful message
		// on fail, display error message
		if ($affectedRows == 1) {
			header("location: ../view/admin_index.php?success=updated");
		} else {
			header("location: ../view/admin_index.php?error=failed");
		}
	}

	public function updateEmployer($db, $firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $location, $id) {
		// query to update an employer account
		$query = "UPDATE employer SET firstName=?, lastName=?, username=?, password=?, dateOfBirth=?, phone=?, email=?, position=?, location=? WHERE id=?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("sssssssssi", $firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $location, $id);
		$stmt->execute();

		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		// on successful update, display successful message
		// on fail, display error message
		if ($affectedRows == 1) {
			header("location: ../view/admin_index.php?success=updated");
		} else {
			header("location: ../view/admin_index.php?error=failed");
		}
	}

	public function deleteAccount($db, $username, $type) {
		require_once '../model/user_model.php';
		$um = new UserModel();

		// query delete account from account table using username as which one to delete, and type as which type of user
		$query = "DELETE FROM $type WHERE username = ?";

		$stmt = $db->prepare($query);
		$stmt->bind_param("s", $username);
		$stmt->execute();

		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		// on successful update, delete that user career, all education, skills, and social media links
		// on fail, display error message
		if ($affectedRows == 1) {
			$um->deleteAllCareers($db, $username);
			$um->deleteAllEducations($db, $username);
			$um->deleteAllSkills($db, $username);
			$um->deleteAllSocials($db, $username);
			header("location: ../view/admin_index.php?success=deleted");
		} else {
			header("location: ../view/admin_index.php?error=deletefailed");
		}
	}

	public function generateReport($db, $table){
		// Fetch records from database 
		$query = $db->query("SELECT * FROM $table ORDER BY id ASC"); 
		
		if($query->num_rows > 0){
			$delimiter = ","; 
			$filename = $table . "_list_" . date('Y-m-d') . ".csv"; 
			
			// Create a file pointer 
			$f = fopen('php://memory', 'w'); 
			
			// Set column headers
			if($table == "jobseeker"){
				$fields = array('ID', 'FIRSTNAME', 'LASTNAME', 'USERNAME', 'DATEOFBIRTH', 'PHONE', 'EMAIL', 'FIELD', 'LOCATION');
			}elseif($table == "employer"){
				$fields = array('ID', 'FIRSTNAME', 'LASTNAME', 'USERNAME', 'DATEOFBIRTH', 'PHONE', 'EMAIL', 'POSITION', 'LOCATION', 'RATING');
			}elseif($table == "admin"){
				$fields = array('ID', 'FIRSTNAME', 'LASTNAME', 'USERNAME', 'DATEOFBIRTH', 'PHONE', 'EMAIL', 'POSITION');
			}
			fputcsv($f, $fields, $delimiter);
			
			// Output each row of the data, format line as csv and write to file pointer 
			while($row = $query->fetch_assoc()){
				if($table == "jobseeker"){
					$lineData = array($row['id'], $row['firstName'], $row['lastName'], $row['username'], $row['dateOfBirth'], $row['phone'], $row['email'], $row['field'], $row['location']); 
				}elseif($table == "employer"){
					$lineData = array($row['id'], $row['firstName'], $row['lastName'], $row['username'], $row['dateOfBirth'], $row['phone'], $row['email'], $row['position'], $row['location'], $row['rating']); 
				}elseif($table == "admin"){
					$lineData = array($row['id'], $row['firstName'], $row['lastName'], $row['username'], $row['dateOfBirth'], $row['phone'], $row['email'], $row['position']); 
				}
				fputcsv($f, $lineData, $delimiter); 
			} 
			
			// Move back to beginning of file 
			fseek($f, 0);
			
			// Set headers to download file rather than displayed
			header('Content-Type: text/csv');
			header('Content-Disposition: attachment; filename="' . $filename . '";');
			
			//output all remaining data on a file pointer

			fpassthru($f);
		}else{
			header("location: ../view/admin_index.php?error=dbnull");
		}
		exit;
	}

}
