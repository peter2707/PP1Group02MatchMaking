<?php
	$dbAddress = 'localhost';
	$dbUser = 'root';
	$dbPass = '';
	$dbName = 'jobmatch';

	$db = new mysqli($dbAddress, $dbUser, $dbPass, $dbName);
	if ($db->connect_error) {
		echo "Could not connect to the database.  Please try again later.";
		exit;
	}
?>