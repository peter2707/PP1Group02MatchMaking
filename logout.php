<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Jober Desk | Responsive Job Portal Template</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		
        <!-- All Plugin Css --> 
		<link rel="stylesheet" href="css/plugins.css">
		
		<!-- Style & Common Css --> 
		<link rel="stylesheet" href="css/common.css">
        <link rel="stylesheet" href="css/main.css">

    </head>
	
    <body>
	
		<!-- Navigation Start  -->
		<?php
			include("navbar.php");
		?>
		<!-- Navigation End  -->
		
        <?php	
			$validSession = require('php/check_session.php');
			
			if ($validSession) {
				$oldUser = $_SESSION['valid_user'];
				unset($_SESSION['valid_user']);
				session_destroy();		
			}
			
			if (!empty($oldUser)) {
				echo '<h1 class="text-center">Logged Out</h1>';

			}
			else {
				echo '<h5 class="text-center">You were not logged in, and so have not been logged out</h5>';
			}				
		?>
			
		<!-- footer start -->
		<?php
			include("footer.php");
		?>
		
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/owl.carousel.min.js"></script>
		<script src="js/bootsnav.js"></script>
		<script src="js/main.js"></script>
    </body>
</html>
