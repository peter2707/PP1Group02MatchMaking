<?php
	if (isset($_SESSION['valid_user']) && isset($_SESSION['valid_pass']) && isset($_SESSION['user_type'])) {
		return true;
	}
	else {
		return false;
	}
?>