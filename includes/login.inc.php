<?php
	session_start(); 
	
	if (isset($_POST['username']) || isset($_POST['password'])) {
		if (!isset($_POST['username']) || empty($_POST['username'])) {
			header("location: ../view/login.php?error=emptyusername");
        	exit();
		}
		if (!isset($_POST['password']) || empty($_POST['password'])) {
			header("location: ../view/login.php?error=emptypassword");
        	exit();
		}

		require_once 'db_connection.inc.php';
		$username = $_POST['username'];
		$password = $_POST['password'];

		if(checkAdmin($db, $username, $password)){
			$_SESSION['valid_user'] = $username;
			$_SESSION['valid_pass'] = $password;
			$_SESSION['user_type'] = "admin";
			$db->close();
			if(isset($_SESSION['valid_user']) && $_SESSION['valid_pass']) {
				header("Location: ../view/adminIndex.php");
			}
		}elseif(checkEmployer($db, $username, $password)){
			$_SESSION['valid_user'] = $username;
			$_SESSION['valid_pass'] = $password;
			$_SESSION['user_type'] = "employer";
			$db->close();
			if(isset($_SESSION['valid_user']) && $_SESSION['valid_pass']) {
				header("Location: ../view/index.php");
			}
		}elseif(checkJobSeeker($db, $username, $password)){
			$_SESSION['valid_user'] = $username;
			$_SESSION['valid_pass'] = $password;
			$_SESSION['user_type'] = "jobseeker";
			$db->close();
			if(isset($_SESSION['valid_user']) && $_SESSION['valid_pass']) {
				header("Location: ../view/index.php");
			}
		}else {
			header("location: ../view/login.php?error=incorrect");
        	exit();
			$db->close();
		}
		
	}

	function checkAdmin($db, $username, $password){
		$admin = false;
		$query = "SELECT count(*) 
				FROM admin
				WHERE username=? AND password =?";
				  
		$stmt = $db->prepare($query);
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		
		$result = $stmt->get_result();
		$stmt->close();

		if (!$result) {
			header("location: ../view/login.php?error=failed");
			$db->close();
			exit();
		}
		
		$row = $result->fetch_row();
		
		if ($row[0] > 0) {
			$admin = true;
		}
		return $admin;
	}

	function checkEmployer($db, $username, $password){
		$employer = false;
		$query = "SELECT count(*) 
				FROM employer
				WHERE username=? AND password =?";
				  
		$stmt = $db->prepare($query);
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		
		$result = $stmt->get_result();
		$stmt->close();

		if (!$result) {
			header("location: ../view/login.php?error=failed");
			$db->close();
			exit();
		}
		
		$row = $result->fetch_row();
		
		if ($row[0] > 0) {
			$employer = true;
		}
		return $employer;
	}

	function checkJobSeeker($db, $username, $password){
		$jobseeker = false;
		$query = "SELECT count(*) 
				FROM jobseeker
				WHERE username=? AND password =?";
				  
		$stmt = $db->prepare($query);
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		
		$result = $stmt->get_result();
		$stmt->close();

		if (!$result) {
			header("location: ../view/login.php?error=failed");
			$db->close();
			exit();
		}
		
		$row = $result->fetch_row();
		
		if ($row[0] > 0) {
			$jobseeker = true;
		}
		return $jobseeker;
	}

?>

