<?php

	if (isset($_POST['username']) || isset($_POST['password'])) {
		if (!isset($_POST['username']) || empty($_POST['username'])) {
			echo "Name not supplied";
			return false;
		}
		if (!isset($_POST['password']) || empty($_POST['password'])) {
			echo "Password not supplied";
			return false;
		}

		require('db_connection.inc.php');
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
			echo "Couldn't check credentials";
			$db->close();
			exit;
		}
		
		$row = $result->fetch_row();
		
		if ($row[0] > 0) {
			$_SESSION['valid_user'] = $username;
			$db->close();
			return true;
		}
		else {
			echo "Username and Password Incorrect<br>";
			$db->close();
			return false;
		}		
	}	
	return false;
?>

