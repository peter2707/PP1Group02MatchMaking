<?php
	session_start(); 
	
	if (isset($_POST['username']) || isset($_POST['password'])) {
		if (!isset($_POST['username']) || empty($_POST['username'])) {
			header("location: ../login.php?error=emptyusername");
        	exit();
		}
		if (!isset($_POST['password']) || empty($_POST['password'])) {
			header("location: ../login.php?error=emptypassword");
        	exit();
		}

		require_once 'db_connection.inc.php';
		$username = $_POST['username'];
		$password = $_POST['password'];

		
		$query = "SELECT count(*) 
				FROM admin
				WHERE username=? AND password =?";
				  
		$stmt = $db->prepare($query);
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		
		$result = $stmt->get_result();
		$stmt->close();

		if (!$result) {
			header("location: ../login.php?error=failed");
        	exit();
			$db->close();
			exit();
		}
		
		$row = $result->fetch_row();
		
		if ($row[0] > 0) {
			$_SESSION['valid_user'] = $username;
			$_SESSION['valid_pass'] = $password;
			$db->close();
			if(isset($_SESSION['valid_user']) && $_SESSION['valid_pass']) {
				header("Location: ../index.php");
			}
			
		}
		else {
			header("location: ../login.php?error=incorrect");
        	exit();
			$db->close();
		}
	}	
	return false;
?>

