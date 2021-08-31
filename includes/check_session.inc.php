<?php
	if (isset($_SESSION['valid_user']) && $_SESSION['valid_pass']) {
		return true;
	}
	else {
		return false;
	}	
?>