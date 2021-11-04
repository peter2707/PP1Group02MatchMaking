<?php
class LoginController{

	// Login function which compare username and password to user database
	public function login($username, $password){
		if (!isset($username) || empty($username)) {	// check if username is null or empty
			header("location: ../view/login.php?error=emptyusername");
			exit();
		}elseif (!isset($password) || empty($password)) { // check if password is null or empty
			header("location: ../view/login.php?error=emptypassword");
			exit();
		}else {
			// After validation, log user in
			require_once '../model/login_model.php';
			$loginModel = new LoginModel();
			$loginModel->login($username, $password);
		}
	}

	// Logout function
	public function logOut(){
		require_once '../model/login_model.php';
		$loginModel = new LoginModel();
		$loginModel->logOut();
	}

	// Reset password function
	public function resetPassword($type, $email){
		if(!isset($type) || !isset($email)){	// check if type or email is null
			header("location: ../view/forget_password.php?error=emptyinput");
		}else{
			// if the input is valid, call reset password function
			require_once '../model/db_connection.php';
			require_once '../model/login_model.php';
			$loginModel = new LoginModel();
			$loginModel->resetPassword($db, $type, $email);
		}
	}
	
}

?>