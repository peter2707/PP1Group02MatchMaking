<?php
	$dbAddress = 'localhost';
	$dbUser = 'root';
	$dbPass = '';
	$dbName = 'heroku_4846e6f92797d07';

	$db = new mysqli($dbAddress, $dbUser, $dbPass, $dbName);
	if ($db->connect_error) {
		echo "Could not connect to the database.  Please try again later.";
		exit;
	}
?>

<?php
//Get Heroku ClearDB connection information
$cleardb_url = parse_url(getenv("us-cdbr-east-04.cleardb.com"));
$cleardb_server = $cleardb_url["us-cdbr-east-04.cleardb.com"];
$cleardb_username = $cleardb_url["b562d2d71ed125"];
$cleardb_password = $cleardb_url["5e707588"];
$cleardb_db = substr($cleardb_url["us-cdbr-east-04.cleardb.com"],1);
$active_group = 'default';
$query_builder = TRUE;
// Connect to DB
$db = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);
?>