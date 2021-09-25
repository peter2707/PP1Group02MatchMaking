<?php
	class LoginModel{

		public function login($username, $password){
			session_start();
			require_once 'db_connection.php';

			if($this->checkAdmin($db, $username, $password)){
				$_SESSION['valid_user'] = $username;
				$_SESSION['valid_pass'] = $password;
				$_SESSION['user_type'] = "admin";
				$db->close();
				if(isset($_SESSION['valid_user']) && $_SESSION['valid_pass']) {
					header("Location: ../view/adminIndex.php");
				}
			}elseif($this->checkEmployer($db, $username, $password)){
				$_SESSION['valid_user'] = $username;
				$_SESSION['valid_pass'] = $password;
				$_SESSION['user_type'] = "employer";
				$db->close();
				if(isset($_SESSION['valid_user']) && $_SESSION['valid_pass']) {
					header("Location: ../view/index.php");
				}
			}elseif($this->checkJobSeeker($db, $username, $password)){
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

		public function logOut(){
			session_start();
			unset($_SESSION["username"]);
			unset($_SESSION["password"]);
			session_destroy();
			header('Refresh: 1; URL = ../view/index.php?logout=success');
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
	}
?>