<?php
class UserModel {

	public function getUser($db, $userType, $username) {
		include '../model/user_object.php';

		// query to select user
		$query = "SELECT * FROM $userType WHERE username = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("s", $username);

		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$stmt->close();
		$db->close();

		// check if the result returns anything
		if(mysqli_num_rows($result)==0){
			echo "<h3>User not Found.</h3> <small>This user might have been deleted or has invalid details.</small>";
			exit();
		}else{
			// check user type
			// on successful validation, return user object
			if($userType == "jobseeker"){
				$jobseeker = new JobSeeker($row['id'], $row['firstName'], $row['lastName'], $row['username'], $row['password'], $row['dateOfBirth'], $row['phone'], $row['email'], $row['field'], $row['location'], $row['image']);
				return $jobseeker;
			}elseif($userType == "employer"){
				$employer = new Employer($row['id'], $row['firstName'], $row['lastName'], $row['username'], $row['password'], $row['dateOfBirth'], $row['phone'], $row['email'], $row['position'], $row['location'], $row['rating'], $row['image']);
				return $employer;
			}elseif($userType == "admin"){
				$admin = new Admin($row['id'], $row['firstName'], $row['lastName'], $row['username'], $row['password'], $row['dateOfBirth'], $row['phone'], $row['email'], $row['position']);
				return $admin;
			}
		}
	}

	public function getSkills($db, $username) {
		require_once '../model/job_object.php';
		$skills = array();

		// query to select all skill from a username
		$query = "SELECT * FROM skill WHERE username='$username'";
		$result = $db->query($query) or die(mysqli_error($db));
		$numResults = $result->num_rows;

		// check if the skills existed and add to skill object
		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$skills[$i] = new Skill($row['id'], $row['username'], $row['skill'], $row['experience']);
		}
		$result->free();
		return $skills;
	}

	public function addSkill($db, $username, $skill, $experience){
		// query to insert into skill table
		$query = "INSERT INTO skill (username, skill, experience) 
            VALUES ('$username', '$skill', '$experience')";
		mysqli_query($db, $query) or die(mysqli_error($db));
		$db->close();
		header("location: ../view/user_profile.php?success=accountupdated");
	}

	public function deleteSkill($db, $id, $username) {
		// query to delete skill based on its id and username
		$query = "DELETE FROM skill WHERE id = ? AND username = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("is", $id, $username);
		$stmt->execute();
		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		// check if the delete is completed
		if ($affectedRows == 1) {
			header("location: ../view/user_profile.php?success=accountupdated");
		} else {
			header("location: ../view/user_profile.php?error=failed");
		}
	}

	public function deleteAllSkills($db, $username) {
		// query to delete all skills from a username
		$query = "DELETE FROM skill WHERE username = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $username);
		$stmt->execute();
		$stmt->close();
	}

	public function getEducations($db, $username) {
		require_once '../model/job_object.php';
		$educations = array();

		// query to select all education from a username
		$query = "SELECT * FROM education WHERE username='$username'";
		$result = $db->query($query) or die(mysqli_error($db));
		$numResults = $result->num_rows;

		// loop to add all existed education from a username into education object
		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$educations[$i] = new Education($row['id'], $row['username'], $row['institution'], $row['degree'], $row['graduation']);
		}
		$result->free();
		return $educations;
	}

	public function addEducation($db, $username, $institution, $degree, $graduation){
		// query to add new education
		$query = "INSERT INTO education (username, institution, degree, graduation) 
            VALUES ('$username', '$institution', '$degree', '$graduation')";
		mysqli_query($db, $query) or die(mysqli_error($db));
		$db->close();
		header("location: ../view/user_profile.php?success=accountupdated");
	}

	public function deleteEducation($db, $id, $username) {
		// query to delete education 
		$query = "DELETE FROM education WHERE id = ? AND username = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("is", $id, $username);
		$stmt->execute();
		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		// check if delete is successful
		if ($affectedRows == 1) {
			header("location: ../view/user_profile.php?success=accountupdated");
		} else {
			header("location: ../view/user_profile.php?error=failed");
		}
	}

	public function deleteAllEducations($db, $username) {
		// query to delete from education table
		$query = "DELETE FROM education WHERE username = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $username);
		$stmt->execute();
		$stmt->close();
	}

	public function getCareers($db, $username) {
		require_once '../model/job_object.php';
		$careers = array();

		// query to select all from career table
		$query = "SELECT * FROM career WHERE username='$username'";

		$result = $db->query($query) or die(mysqli_error($db));
		$numResults = $result->num_rows;

		// loop to add all existed career from a username to career object
		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$careers[$i] = new Career($row['id'], $row['username'], $row['position'], $row['company'], $row['experience']);
		}
		$result->free();
		return $careers;
	}

	public function addCareer($db, $username, $position, $company, $experience){
		// query to add new career into career table
		$query = "INSERT INTO career (username, position, company, experience) 
            VALUES ('$username', '$position', '$company', '$experience')";
		mysqli_query($db, $query) or die(mysqli_error($db));
		$db->close();
		header("location: ../view/user_profile.php?success=accountupdated");
	}

	public function deleteCareer($db, $id, $username) {
		// query to delete career
		$query = "DELETE FROM career WHERE id = ? AND username = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("is", $id, $username);
		$stmt->execute();
		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		// check if delete has gone through
		if ($affectedRows == 1) {
			header("location: ../view/user_profile.php?success=accountupdated");
		} else {
			header("location: ../view/user_profile.php?error=failed");
		}
	}

	public function deleteAllCareers($db, $username) {
		// query to delete all career from a user
		$query = "DELETE FROM career WHERE username = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $username);
		$stmt->execute();
		$stmt->close();
	}
	
	public function getSocialLink($db, $username){
		include '../model/job_object.php';

		// query to select all from social table
		$query = "SELECT * FROM social WHERE username = '$username'";
		$stmt = $db->prepare($query);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		// check if the query returns data,
		// then add to social object.
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
		// query to insert into social table
		$query = "INSERT INTO social (username, linkedin, github, twitter, instagram, facebook) 
            VALUES ('$username', '$linkedin', '$github', '$twitter', '$instagram', '$facebook')";
		mysqli_query($db, $query) or die(mysqli_error($db));
		$db->close();
		header("location: ../view/user_profile.php?success=accountupdated");
	}

	public function editSocialLink($db, $username, $linkedin, $github, $twitter, $instagram, $facebook){
		// query to count add social links related to a user
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

		// check if social link is available
		if ($row[0] > 0) {
			// query to update social media link
			$query = "UPDATE social SET linkedin=?, github=?, twitter=?, instagram=?, facebook=? WHERE username = ?";
			$stmt = $db->prepare($query);
			$stmt->bind_param("ssssss", $linkedin, $github, $twitter, $instagram, $facebook, $username);
			$stmt->execute();

			$affectedRows = $stmt->affected_rows;
			$stmt->close();
			$db->close();

			// check if the update is successful
			if ($affectedRows == 1) {
				header("location: ../view/user_profile.php?success=accountupdated");
			} else {
				header("location: ../view/user_profile.php?error=failed");
			}
		}else {
			$this->addSocialLink($db, $username, $linkedin, $github, $twitter, $instagram, $facebook);
		}
	}

	public function deleteAllSocials($db, $username) {
		// query to delete all social media 
		$query = "DELETE FROM social WHERE username = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $username);
		$stmt->execute();
		$stmt->close();
	}

	public function updateJobSeeker($db, $firstName, $lastName, $password, $dob, $phone, $email, $field, $location, $username) {
		// query to update a job seeker account
		$query = "UPDATE jobseeker SET firstName=?, lastName=?, password=?, dateOfBirth=?, phone=?, email=?, field=?, location=? WHERE username = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("ssssissss", $firstName, $lastName, $password, $dob, $phone, $email, $field, $location, $username);
		$stmt->execute();

		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		// check if the update account is completed
		if ($affectedRows == 1) {
			header("location: ../view/user_settings.php?success=accountupdated");
		} else {
			header("location: ../view/user_settings.php?error=failed");
		}
	}

	public function updateEmployer($db, $firstName, $lastName, $password, $dob, $phone, $email, $position, $location, $username) {
		// query to update an employer account
		$query = "UPDATE employer SET firstName=?, lastName=?, password=?, dateOfBirth=?, phone=?, email=?, position=?, location=? WHERE username = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("ssssissss", $firstName, $lastName, $password, $dob, $phone, $email, $position, $location, $username);
		$stmt->execute();

		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		// check if the update account is completed
		if ($affectedRows == 1) {
			header("location: ../view/user_settings.php?success=accountupdated");
		} else {
			header("location: ../view/user_settings.php?error=failed");
		}
	}

	public function deleteAccount($db, $username, $type) {
		require_once '../model/session_model.php';
		$sm = new SessionModel();

		// query to delete an account
		$query = "DELETE FROM $type WHERE username = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$affectedRows = $stmt->affected_rows;
		$stmt->close();

		// check if the delete is completed
		// if it does, delete the user career, educations, social, and skills
		if ($affectedRows == 1) {
			$this->deleteAllCareers($db, $username);
			$this->deleteAllEducations($db, $username);
			$this->deleteAllSkills($db, $username);
			$this->deleteAllSocials($db, $username);
			if($sm->getUserName() == $username){
				session_start();
				unset($_SESSION["username"]);
				unset($_SESSION["password"]);
				session_destroy();
			}
			header("location: ../view/login.php?success=accountdeleted");
		} else {
			header("location: ../view/user_settings.php?error=deletefailed");
		}
		$db->close();
	}

	public function changeProfilePicture($db, $file, $username, $userType){
		// query to update a user profile picture
		$query = "UPDATE $userType SET image=? WHERE username = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("ss", $file, $username);
		$stmt->execute();

		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		// check if the update has gone through
		if ($affectedRows == 1) {
			header("location: ../view/user_profile.php?success=accountupdated");
		} else {
			header("location: ../view/user_profile.php?error=failed");
		}
	}

	public function checkToken($db, $email, $token) {
		$success = false;

		// query to select all from password_reset
		$query = "SELECT * FROM password_reset WHERE email=? AND token =?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("ss", $email, $token);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		// check if query return data
		if (mysqli_num_rows($result)==0) {
			header("location: ../view/reset_password.php?error=notfound");
			exit();
		}else{
			// create time format
			$nowFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d"), date("Y"));

			// create current time and date
			$now = date("Y-m-d H:i:s", $nowFormat);

			// retrieve expired date column and set it to a varible
			$exp = $row['expDate'];

			// check if the expired token is ahead of current time
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
		// check token
		if($this->checkToken($db, $email, $token)){
			// query to update password
			$query = "UPDATE $type SET password=? WHERE email = ?";
			$stmt = $db->prepare($query);
			$stmt->bind_param("ss", $password, $email);
			$stmt->execute();
			$affectedRows = $stmt->affected_rows;
			$stmt->close();
			$db->close();

			// check if the update is success
			if ($affectedRows == 1) {
				header("location: ../view/login.php?success=reset");
			} else {
				header("location: ../view/reset_password.php?error=resetfailed");
			}
		}
	}

}
