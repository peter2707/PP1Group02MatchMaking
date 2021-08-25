<html>
	<head>
		<title>Home Page</title>
		<meta charset="UTF-8" />
	</head>

	<body>
		<?php
			session_start();

			$validLogin = require('login.php');
			if ($validLogin) {
				$username = $_SESSION['valid_user'];
				echo "<h1>Right</h1>";
			} else {
				if (isset($_SESSION['valid_user'])) {
					echo "Could not log you in.<br>";
				}
				echo "<h1>Wrong</h1>";
		
			}
			
		?>
		
		
	</body>


</html>