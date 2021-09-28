<?php
class LoginController{

	public function login($username, $password){
		require_once '../model/login_model.php';
		$loginModel = new LoginModel();
		if (!isset($username) || empty($username)) {
			header("location: ../view/login.php?error=emptyusername");
			exit();
		}elseif (!isset($password) || empty($password)) {
			header("location: ../view/login.php?error=emptypassword");
			exit();
		}else {
			$loginModel->login($username, $password);
		}
	}

	public function logOut(){
		require_once '../model/login_model.php';
		$loginModel = new LoginModel();

		$loginModel->logOut();
	}
	
}

?>