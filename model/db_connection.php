<?php
	//------------Config for Heroku only, will not work for local environment------------

	$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
	$cleardb_server = $cleardb_url["host"];
	$cleardb_username = $cleardb_url["user"];
	$cleardb_password = $cleardb_url["pass"];
	$cleardb_db = substr($cleardb_url["path"],1);
	$active_group = 'default';
	$query_builder = TRUE;

	$db = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);
	if ($db->connect_error) {
		echo "Could not connect to the database.  Please try again later.";
		exit;
	}
?>


<?php
	//------------Use below part when running on local environment------------

	// try {
	// 	$dbAddress = 'localhost';
	// 	$dbUser = 'root';
	// 	$dbPass = '';
	// 	$dbName = 'jobmatch';
	// 	$db = mysqli_connect($dbAddress, $dbUser, $dbPass, $dbName);
    
	// 	// Check connection
	// 	if (mysqli_connect_errno()) {
	// 		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	// 		exit();
	// 	}
	// }catch(Exception $e) {
	// 	echo $e->getMessage();
	// }
?>