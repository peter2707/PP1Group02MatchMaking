<?php
class SessionModel {
	public function sessionExists() {
		$exist = false;
		if (isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['type'])) {
			$exist = true;
		}
		return $exist;
	}

	public function setNewSession($username, $password, $type) {
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
		$_SESSION['type'] = $type;
	}

	public function getUserName() {
		return $_SESSION['username'] ?? "";
	}

	public function getUserType() {
		return $_SESSION['type'] ?? "";
	}

	public function destroySession() {
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		unset($_SESSION["username"]);
		unset($_SESSION["password"]);
		unset($_SESSION["type"]);
		session_destroy();
	}
}
