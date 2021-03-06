<?php
	class LoginModel {

		public function login($username, $password) {
			require_once 'db_connection.php';
			require_once '../controller/session_controller.php';
			$sessionController = new SessionController();
			if (session_status() === PHP_SESSION_NONE) {
				session_start();
			}

			if($this->checkAdmin($db, $username, $password)) {
				$sessionController->setNewSession($username, $password, "admin");
				$db->close();
				if($sessionController->checkSession()) {
					header("Location: ../view/admin_index.php");
				}
			}elseif($this->checkEmployer($db, $username, $password)) {
				$sessionController->setNewSession($username, $password, "employer");
				$db->close();
				if($sessionController->checkSession()) {
					header("Location: ../view/index.php");
				}
			}elseif($this->checkJobSeeker($db, $username, $password)) {
				$sessionController->setNewSession($username, $password, "jobseeker");
				$db->close();
				if($sessionController->checkSession()) {
					header("Location: ../view/index.php");
				}
			}else {
				header("location: ../view/login.php?error=incorrect");
				exit();
				$db->close();
			}
		}

		public function logOut() {
			require_once '../controller/session_controller.php';
			$sessionController = new SessionController();
			$sessionController->destroySession();
			header('location: ../view/login.php?success=logout');
		}
	
		function checkAdmin($db, $username, $password) {
			$admin = false;
			$query = "SELECT count(*) FROM admin WHERE username=? AND password =?";  
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
	
		function checkEmployer($db, $username, $password) {
			$employer = false;
			$query = "SELECT count(*) FROM employer WHERE username=? AND password =?";
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
	
		function checkJobSeeker($db, $username, $password) {
			$jobseeker = false;
			$query = "SELECT count(*) FROM jobseeker WHERE username=? AND password =?"; 
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

		function is_localhost() {
			$whitelist = array( '127.0.0.1', '::1' );
			if ( in_array( $_SERVER['REMOTE_ADDR'], $whitelist ) ) {	// check if the server is in the array
				return true;	// this is a local environment
			}
		}

		public function forgetPassword($db, $type, $email){
			require_once('../vendor/autoload.php');
			$email = filter_var($email, FILTER_SANITIZE_EMAIL);			
			$query = "SELECT * FROM $type WHERE email = ?";
			$stmtEmp = $db->prepare($query);
			$stmtEmp->bind_param("s", $email);
			$stmtEmp->execute();
			$result = $stmtEmp->get_result();
			$stmtEmp->close();
			$row = $result->fetch_assoc();

			if ($row) {
				date_default_timezone_set('Australia/Melbourne');
				$expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
				$expDate = date("Y-m-d H:i:s", $expFormat);
				$token = md5($row['email'].$expDate);
				try{
					$this->checkPreviousToken($db, $email);
					$query = "INSERT INTO password_reset (email, token, expDate) VALUES ('$email', '$token', '$expDate')";
					mysqli_query($db, $query) or die(mysqli_error($db));
					$db->close();

					$link = "https://jobmatchdemo.herokuapp.com/view/reset_password.php";
					if($this->is_localhost()){
						$link = "http://localhost/jobmatch/view/reset_password.php";
					}
					$mail = new \SendGrid\Mail\Mail();
					$mail->setFrom("jobmatchdemo@gmail.com", "JobMatch");
					$mail->addTo($email, $row['firstName'].' '.$row['lastName'], 
					[
						'username' => $row['username'],
						'support' => 'https://jobmatchdemo.herokuapp.com/view/index.php#contact',
						'token' => $link . '?token=' . $token . '&email=' . $email . '&type=' . $type,
					]);
					$mail->setTemplateId("d-08d93e23cbf74354b1dc54986e61e303");
					$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/environment');
					$dotenv->load();
					$sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
					try {
						$sendgrid->send($mail);
						header("location: ../view/forget_password.php?success=tokengenerated");
					} catch (Exception $e) {
						echo 'Caught exception: ' . $e->getMessage() . "\n";
					}
				}catch(Exception $e){
					echo $e->getMessage();
				}
			}else{
				header("location: ../view/forget_password.php?error=usernotfound");
			}
		}

		public function checkPreviousToken($db, $email){
			$query = "SELECT count(*) FROM password_reset WHERE email = '$email'";		
			$stmt = $db->prepare($query);
			$stmt->execute();
			$result = $stmt->get_result();
			$stmt->close();
			if (!$result) {
				$db->close();
			}
			$row = $result->fetch_row();
			if ($row[0] > 0) {
				$this->deleteToken($db, $email);
			}
		}
		
		public function deleteToken($db, $email) {
			$query = "DELETE FROM password_reset WHERE email = ?";
			$stmt = $db->prepare($query);
			$stmt->bind_param("s", $email);
			$stmt->execute();
			$affectedRows = $stmt->affected_rows;
			$stmt->close();	
			if ($affectedRows == 1) {
				return true;
			} else {
				return false;
			}
		}

	}
?>