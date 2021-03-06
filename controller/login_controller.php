<?php
class LoginController{

	public function login($username, $password){
		if (!isset($username) || empty($username)) {
			header("location: ../view/login.php?error=emptyusername");
			exit();
		}elseif (!isset($password) || empty($password)) {
			header("location: ../view/login.php?error=emptypassword");
			exit();
		}else {
			require_once '../model/login_model.php';
			$loginModel = new LoginModel();
			$loginModel->login($username, $password);
		}
	}

	public function logOut(){
		require_once '../model/login_model.php';
		$loginModel = new LoginModel();
		$loginModel->logOut();
	}

	public function forgetPassword($type, $email){
		if(!isset($type) || !isset($email)){
			header("location: ../view/forget_password.php?error=emptyinput");
		}else{
			require_once '../model/db_connection.php';
			require_once '../model/login_model.php';
			$loginModel = new LoginModel();
			$loginModel->forgetPassword($db, $type, $email);
		}
	}
	
}

?>