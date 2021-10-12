<?php
	class LoginModel {

		public function login($username, $password) {
			session_start();
			require_once 'db_connection.php';

			if($this->checkAdmin($db, $username, $password)) {
				$_SESSION['valid_user'] = $username;
				$_SESSION['valid_pass'] = $password;
				$_SESSION['user_type'] = "admin";
				$db->close();
				if(isset($_SESSION['valid_user']) && $_SESSION['valid_pass']) {
					header("Location: ../view/admin_index.php");
				}
			}elseif($this->checkEmployer($db, $username, $password)) {
				$_SESSION['valid_user'] = $username;
				$_SESSION['valid_pass'] = $password;
				$_SESSION['user_type'] = "employer";
				$db->close();
				if(isset($_SESSION['valid_user']) && $_SESSION['valid_pass']) {
					header("Location: ../view/index.php");
				}
			}elseif($this->checkJobSeeker($db, $username, $password)) {
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

		public function logOut() {
			session_start();
			unset($_SESSION["username"]);
			unset($_SESSION["password"]);
			session_destroy();
			header('location: ../view/login.php?success=logout');
		}
	
		function checkAdmin($db, $username, $password) {
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
	
		function checkEmployer($db, $username, $password) {
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
	
		function checkJobSeeker($db, $username, $password) {
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

		public function resetPassword($db, $type, $email){
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
				$expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
				$expDate = date("Y-m-d H:i:s", $expFormat);
				$token = md5($row['email'].$expDate);
				try{
					$this->checkPreviousToken($db, $email);
					$query = "INSERT INTO password_reset (email, token, expDate) VALUES ('$email', '$token', '$expDate')";
					mysqli_query($db, $query) or die(mysqli_error($db));
					$db->close();

					$mail = new \SendGrid\Mail\Mail();
					$mail->setFrom("jobmatchdemo@gmail.com", "JobMatch");
					$mail->addTo($email, $row['firstName'].' '.$row['lastName'], 
					[
						'username' => $row['username'],
						'support' => 'https://jobmatchdemo.herokuapp.com/view/index.php#contact',
						'token' => 'https://jobmatchdemo.herokuapp.com/view/reset_password.php?token='. $token.'&email='.$email.'&type='.$type,
					]);
					$mail->setTemplateId("d-08d93e23cbf74354b1dc54986e61e303");
					// $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
					$sendgrid = new \SendGrid('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');
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