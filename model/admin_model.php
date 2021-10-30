<?php
class AdminModel {

	public function registerAdmin($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $position) {
		$query = "INSERT INTO admin (firstName, lastName, username, password, dateOfBirth, phone, email, position) 
				VALUES ('$firstName', '$lastName', '$username', '$password', '$dateOfBirth', '$phone', '$email', '$position')";
		mysqli_query($db, $query) or die(mysqli_error($db));
		$db->close();
		return true;
	}

	public function updateAdmin($db, $firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $id) {
		$success = false;
		$query = "UPDATE admin SET firstName=?, lastName=?, username=?, password=?, dateOfBirth=?, phone=?, email=?, position=? WHERE id=?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("ssssssssi", $firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $id);
		$stmt->execute();

		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		if ($affectedRows == 1) {
			$success = true;
		} 
		return $success;
	}

	public function getAllJobSeeker($db) {
		require_once '../model/user_object.php';
		$allJobSeekers = array();
		$query = "SELECT * FROM jobseeker ORDER BY id";
		$result = $db->query($query);
		$numResults = $result->num_rows;
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
		$query = "SELECT * FROM employer ORDER BY id";
		$result = $db->query($query);
		$numResults = $result->num_rows;
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
		$query = "SELECT * FROM admin ORDER BY id";
		$result = $db->query($query);
		$numResults = $result->num_rows;
		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$allAdmins[$i] = new Admin($row['id'], $row['firstName'], $row['lastName'], $row['username'], $row['password'], $row['dateOfBirth'], $row['phone'], $row['email'], $row['position']);
		}
		$result->free();
		$db->close();
		return $allAdmins;
	}

	public function getAllJobMatch($db) {
		require_once '../model/job_object.php';
		require_once '../model/matchmaking_model.php';
		$mm = new MatchmakingModel();
		$alljobMatches = array();
		$query = "SELECT *, jobpost.id as jid, jobmatch.id as mid FROM jobmatch 
				  INNER JOIN jobpost ON jobpost.id = jobmatch.jobPostID";
		$result = $db->query($query);
		$numResults = $result->num_rows;
		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$rating = $mm->getEmployerRating($db, $row['employer']);
			$date = $mm->getDate($db, 'jobmatch', $row['mid']);
			$timeElapsed = $mm->getTimeElapsed($date);
			$alljobMatches[$i] = new JobMatch($row['mid'], $row['employer'], $row['jobSeeker'], $row['contact'], $row['position'], $row['field'], $row['salary'], $row['type'], $row['description'], $row['requirements'], $row['location'], $row['percentage'], $rating, $row['feedback'], $timeElapsed);
		}
		$result->free();
		$db->close();
		return $alljobMatches;
	}

	public function getAllJobPost($db){
		require_once '../model/job_object.php';
		require_once '../model/matchmaking_model.php';
		$mm = new MatchmakingModel();
		$jobposts = array();
		$query = "SELECT * FROM jobpost ORDER BY id";
		$result = $db->query($query) or die(mysqli_error($db));
		$numResults = $result->num_rows;
		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$totalMatches = $mm->countJobMatches($db, $row['id']);
			$timeElapsed = $mm->getTimeElapsed($row['date']);
			$jobposts[$i] = new JobPost($row['id'], $row['position'], $row['field'], $row['salary'], $row['type'], $row['description'], $row['requirements'], $row['location'], $row['employer'], $row['contact'], $totalMatches, $timeElapsed);
		}

		$result->free();
		return $jobposts;
	}

	public function getAllFeedback($db) {
		require_once '../model/job_object.php';
		require_once '../model/matchmaking_model.php';
		$mm = new MatchmakingModel();
		$allFeedbacks = array();
		$query = "SELECT * FROM jobmatch ORDER BY id";
		$result = $db->query($query);
		$numResults = $result->num_rows;
		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			if($row['rating'] != NULL || $row['rating'] > 1){
				$timeElapsed = $mm->getTimeElapsed($row['date']);
				$allFeedbacks[$i] = new Feedback($row['id'], $row['jobSeeker'], intval($row['rating']), $row['feedback'], $timeElapsed);
			}
		}
		$result->free();
		$db->close();
		return $allFeedbacks;
	}

	public function getAllReport($db) {
		require_once '../model/job_object.php';
		require_once '../model/matchmaking_model.php';
		$mm = new MatchmakingModel();
		$allReports = array();
		$query = "SELECT * FROM report ORDER BY id";
		$result = $db->query($query);
		$numResults = $result->num_rows;
		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$timeElapsed = $mm->getTimeElapsed($row['date']);
			$allReports[$i] = new Report($row['id'], $row['username'], $row['type'], $row['matchID'], $row['reason'], $row['comment'], $timeElapsed);
		}
		$result->free();
		$db->close();
		return $allReports;
	}

	public function deleteFeedback($db, $id) {
		$success = false;
		$query = "UPDATE jobmatch SET feedback = NULL, rating = NULL WHERE id = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $id);
		$stmt->execute();

		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		if ($affectedRows == 1) {
			$success = true;	
		} 
		$db->close();
		return $success;
	}

	public function deleteReport($db, $id) {
		$query = "DELETE FROM report WHERE id = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $id);
		$stmt->execute();

		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		if ($affectedRows == 1) {
			header("location: ../view/admin_index.php?success=deleted");
		} else {
			header("location: ../view/admin_index.php?error=deletefailed");
		}
		$db->close();
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
			}elseif($table == "jobpost"){
				$fields = array('ID', 'POSITION', 'FIELD', 'SALARY', 'TYPE', 'DESCRIPTION', 'REQUIREMENTS', 'LOCATION', 'EMPLOYER', 'CONTACT', 'DATE');
			}elseif($table == "jobmatch"){
				$fields = array('ID', 'EMPLOYER', 'JOBSEEKER', 'POSTID', 'PERCENTAGE', 'RATING', 'FEEDBACK', 'DATE');
			}elseif($table == "report"){
				$fields = array('ID', 'USERNAME', 'TYPE', 'MATCHID', 'REASON', 'COMMENT', 'DATE');
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
				}elseif($table == "jobpost"){
					$lineData = array($row['id'], $row['position'], $row['field'], $row['salary'], $row['type'], $row['description'], $row['requirements'], $row['location'], $row['contact'], $row['date']); 
				}elseif($table == "jobmatch"){
					$lineData = array($row['id'], $row['employer'], $row['jobSeeker'], $row['jobPostID'], $row['percentage'], $row['rating'], $row['feedback'], $row['date']); 
				}elseif($table == "report"){
					$lineData = array($row['id'], $row['username'], $row['type'], $row['matchID'], $row['reason'], $row['comment'], $row['date']); 
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
