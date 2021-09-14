
<?php
	// $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
	// $cleardb_server = $cleardb_url["host"];
	// $cleardb_username = $cleardb_url["user"];
	// $cleardb_password = $cleardb_url["pass"];
	// $cleardb_db = substr($cleardb_url["path"],1);
	// $active_group = 'default';
	// $query_builder = TRUE;

	// $db = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);
	// if ($db->connect_error) {
	// 	echo "Could not connect to the database.  Please try again later.";
	// 	exit;
	// }
?>


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