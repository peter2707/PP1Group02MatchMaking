<?php
	class SessionModel {
		public function sessionExists() {
			$exist = false;
			if (isset($_SESSION['valid_user']) && isset($_SESSION['valid_pass']) && isset($_SESSION['user_type'])) {
				$exist = true;
			}
			return $exist;
		}

		public function getUserName() {
			return $_SESSION['valid_user'] ?? "";
		}

		public function getUserType(){
			return $_SESSION['user_type'] ?? "";
		}

	}
?>