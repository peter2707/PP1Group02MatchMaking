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
			$jobseeker = new JobSeeker($row['firstName'], $row['lastName'], $row['username'], $row['password'], $row['dateOfBirth'], $row['phone'], $row['email'], $row['field'], $row['Image']);
			return $jobseeker;
		}elseif($userType == "employer"){
			$employer = new Employer($row['firstName'], $row['lastName'], $row['username'], $row['password'], $row['dateOfBirth'], $row['phone'], $row['email'], $row['position'], $row['rating'], $row['image']);
			return $employer;
		}elseif($userType == "admin"){
			$admin = new Admin($row['firstName'], $row['lastName'], $row['username'], $row['password'], $row['dateOfBirth'], $row['phone'], $row['email'], $row['position'], $row['image']);
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

}
