<?php
class UserModel {

	public function getUser($db, $userType) {
		include '../model/user_object.php';
		$sessionController = new SessionController();
		$username = $sessionController->getUserName();

		$query = "SELECT * FROM $userType WHERE username = ?";
		$stmtEmp = $db->prepare($query);
		$stmtEmp->bind_param("s", $username);

		$stmtEmp->execute();
		$result = $stmtEmp->get_result();
		$stmtEmp->close();
		$row = $result->fetch_assoc();
		$db->close();

		if($userType == "jobseeker"){
			$jobseeker = new JobSeeker($row['id'], $row['firstName'], $row['lastName'], $row['username'], $row['password'], $row['dateOfBirth'], $row['phone'], $row['email'], $row['field'], $row['Image']);
			return $jobseeker;
		}elseif($userType == "employer"){
			$employer = new Employer($row['id'], $row['firstName'], $row['lastName'], $row['username'], $row['password'], $row['dateOfBirth'], $row['phone'], $row['email'], $row['position'], $row['rating'], $row['image']);
			return $employer;
		}elseif($userType == "admin"){
			$admin = new Admin($row['id'], $row['firstName'], $row['lastName'], $row['username'], $row['password'], $row['dateOfBirth'], $row['phone'], $row['email'], $row['position'], $row['image']);
			return $admin;
		}
	}

	public function getUserByName($db, $usertype, $username) {
		include '../model/user_object.php';
		$query = "SELECT * FROM $usertype WHERE username = ?";
		$stmtEmp = $db->prepare($query);
		$stmtEmp->bind_param("s", $username);

		$stmtEmp->execute();
		$result = $stmtEmp->get_result();
		$stmtEmp->close();
		$row = $result->fetch_assoc();
		$db->close();

		if($usertype == "jobseeker"){
			$jobseeker = new JobSeeker($row['id'], $row['firstName'], $row['lastName'], $row['username'], $row['password'], $row['dateOfBirth'], $row['phone'], $row['email'], $row['field'], $row['Image']);
			return $jobseeker;
		}elseif($usertype == "employer"){
			$employer = new Employer($row['id'], $row['firstName'], $row['lastName'], $row['username'], $row['password'], $row['dateOfBirth'], $row['phone'], $row['email'], $row['position'], $row['rating'], $row['image']);
			return $employer;
		}elseif($usertype == "admin"){
			$admin = new Admin($row['id'], $row['firstName'], $row['lastName'], $row['username'], $row['password'], $row['dateOfBirth'], $row['phone'], $row['email'], $row['position'], $row['image']);
			return $admin;
		}
	}

	public function updateJobSeeker($db, $firstName, $lastName, $password, $dob, $phone, $email, $field, $username) {
		$query = "UPDATE jobseeker SET firstName=?, lastName=?, password=?, dateOfBirth=?, phone=?, email=?, field=? WHERE username = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("ssssisss", $firstName, $lastName, $password, $dob, $phone, $email, $field, $username);
		$stmt->execute();

		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		if ($affectedRows == 1) {
			$script = "<script>window.location = '../view/user_profile.php?success=successupdate';</script>";
			echo $script;
		} else {
			$script = "<script>window.location = '../view/user_profile.php?error=errorupdate';</script>";
			echo $script;
		}
	}

	public function updateEmployer($db, $firstName, $lastName, $password, $dob, $phone, $email, $position, $username) {
		$query = "UPDATE employer SET firstName=?, lastName=?, password=?, dateOfBirth=?, phone=?, email=?, position=? WHERE username = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("ssssisss", $firstName, $lastName, $password, $dob, $phone, $email, $position, $username);
		$stmt->execute();

		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		if ($affectedRows == 1) {
			$script = "<script>window.location = '../view/user_profile.php?success=successupdate';</script>";
			echo $script;
		} else {
			$script = "<script>window.location = '../view/user_profile.php?error=errorupdate';</script>";
			echo $script;
		}
	}

	public function deleteAccount($db, $username, $type) {
		$query = "DELETE FROM $type WHERE username = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("s", $username);
		$stmt->execute();

		$affectedRows = $stmt->affected_rows;
		$stmt->close();

		if ($affectedRows == 1) {
			return true;
		} else {
			return false;
		}
	}

	public function changeProfilePicture($db, $file, $username, $userType){
		$query = "UPDATE $userType SET image=? WHERE username = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("ss", $file, $username);
		$stmt->execute();

		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		if ($affectedRows == 1) {
			$script = "<script>window.location = '../view/user_profile.php?success=successupdate';</script>";
			echo $script;
		} else {
			$script = "<script>window.location = '../view/user_profile.php?error=errorupdate';</script>";
			echo $script;
		}
	}

	public function getSocialLink($db, $username){
		include '../model/job_object.php';
		$query = "SELECT * FROM social WHERE username = '$username'";
		$stmtEmp = $db->prepare($query);
		$stmtEmp->execute();
		$result = $stmtEmp->get_result();
		$row = $result->fetch_assoc();
		if(mysqli_num_rows($result)==0){
			$social = new Social('Not added', 'Not added', 'Not added', 'Not added', 'Not added', 'Not added');
		}else{
			$social = new Social($row['username'], $row['linkedin'], $row['github'], $row['twitter'], $row['instagram'], $row['facebook']);
		}
		$stmtEmp->close();
		$row = $result->fetch_assoc();
		$db->close();

		
		return $social;
	}
	
	public function addSocialLink($db, $username, $linkedin, $github, $twitter, $instagram, $facebook){
		$query = "INSERT INTO social (username, linkedin, github, twitter, instagram, facebook) 
            VALUES ('$username', '$linkedin', '$github', '$twitter', '$instagram', '$facebook')";
		mysqli_query($db, $query) or die(mysqli_error($db));
		$db->close();
		$script = "<script>window.location = '../view/user_profile.php?success=successupdate';</script>";
		echo $script;
	}

	public function editSocialLink($db, $username, $linkedin, $github, $twitter, $instagram, $facebook){
		$queryCheck = "SELECT count(*) FROM social WHERE username=?";
		$stmt = $db->prepare($queryCheck);
		$stmt->bind_param("s", $username);
		$stmt->execute();
		
		$result = $stmt->get_result();
		$stmt->close();

		if (!$result) {
			echo "Couldn't check at the moment";
			exit;
		}
		$row = $result->fetch_row();
		if ($row[0] > 0) {
			$query = "UPDATE social SET linkedin=?, github=?, twitter=?, instagram=?, facebook=? WHERE username = ?";
			$stmt = $db->prepare($query);
			$stmt->bind_param("ssssss", $linkedin, $github, $twitter, $instagram, $facebook, $username);
			$stmt->execute();

			$affectedRows = $stmt->affected_rows;
			$stmt->close();
			$db->close();

			if ($affectedRows == 1) {
				$script = "<script>window.location = '../view/user_profile.php?success=successupdate';</script>";
				echo $script;
			} else {
				$script = "<script>window.location = '../view/user_profile.php?error=errorupdate';</script>";
				echo $script;
			}
		}else {
			$this->addSocialLink($db, $username, $linkedin, $github, $twitter, $instagram, $facebook);
		}
	}

}
