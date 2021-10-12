<?php
class UserModel {

	public function getUser($db, $userType) {
		include '../model/user_object.php';
		$sessionController = new SessionController();
		$username = $sessionController->getUserName();

		$query = "SELECT * FROM $userType WHERE username = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("s", $username);

		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
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
		$stmt = $db->prepare($query);
		$stmt->bind_param("s", $username);

		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		$row = $result->fetch_assoc();
		$db->close();
		if(mysqli_num_rows($result)==0){
			echo "<h3>User not Found.</h3> <small>This user might have been deleted or has invalid details.</small>";
			exit();
		}else{
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
		$db->close();

		if ($affectedRows == 1) {
			session_start();
			unset($_SESSION["username"]);
			unset($_SESSION["password"]);
			session_destroy();
			$script = "<script>window.location = '../view/login.php?success=accountdeleted';</script>";
			echo $script;
		} else {
			$script = "<script>window.location = '../view/login.php?error=errordelete';</script>";
			echo $script;
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
		$stmt = $db->prepare($query);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		if(mysqli_num_rows($result)==0){
			$social = new Social('Not added', 'Not added', 'Not added', 'Not added', 'Not added', 'Not added');
		}else{
			$social = new Social($row['username'], $row['linkedin'], $row['github'], $row['twitter'], $row['instagram'], $row['facebook']);
		}
		$stmt->close();
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

	public function checkToken($db, $email, $token) {
		$success = false;
		$query = "SELECT * FROM password_reset WHERE email=? AND token =?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("ss", $email, $token);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		if (mysqli_num_rows($result)==0) {
			header("location: ../view/reset_password.php?error=notfound");
			exit();
		}else{
			$nowFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d"), date("Y"));
			$now = date("Y-m-d H:i:s", $nowFormat);
			$exp = $row['expDate'];
			if($exp >= $now){
				$success = true;
			}else{
				header("location: ../view/reset_password.php?error=expired");
			}
		}
		$stmt->close();
		return $success;
	}

	public function resetPassword($db, $type, $password, $email, $token){
		if($this->checkToken($db, $email, $token)){
			$query = "UPDATE $type SET password=? WHERE email = ?";
			$stmt = $db->prepare($query);
			$stmt->bind_param("ss", $password, $email);
			$stmt->execute();
			$affectedRows = $stmt->affected_rows;
			$stmt->close();
			$db->close();
			if ($affectedRows == 1) {
				header("location: ../view/login.php?success=reset");
			} else {
				header("location: ../view/reset_password.php?error=sthwentwrong");
			}
		}
	}

}
