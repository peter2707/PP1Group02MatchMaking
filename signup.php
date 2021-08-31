<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>JobMatch | Home</title>
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
		
		<!-- Sign Up section start -->
		<section class="login-wrapper">
			<div class="container">
				<div class="col-md-4 col-md-offset-4">
                    <form action="includes/signup.inc.php" method="POST">
						<img class="img-responsive" alt="logo" src="img/register.png">
                        <input type="text" id="firstName" class="form-control input-lg" placeholder="Firstname" name="firstName">
                        <input type="text" id="lastName" class="form-control input-lg" placeholder="Lastname" name="lastName">
                        <input type="text" id="username" class="form-control input-lg" placeholder="Username" name="username">
                        <input type="password" id="password" class="form-control input-lg" placeholder="Password" name="password">
						<input type="password" id="confirmPassword" class="form-control input-lg" placeholder="Confirm Password" name="confirmPassword">
						<div class="form-control input-lg">
							<div class="col-md-5" style="margin-left:-15px; margin-top:3px;">
								<label for="date">Date of Birth: </label>
							</div>
							<div class="col-md-3">
								<input type="date" style="border-width: 0px; margin-top:2px;" id="dateOfBirth" name="dateOfBirth">
							</div>
						</div>
                        <input type="tel" id="phone" class="form-control input-lg" placeholder="Phone" name="phone">
                        <input type="email" id="email" class="form-control input-lg" placeholder="Email" name="email">
                        <input type="text" id="position" class="form-control input-lg" placeholder="Position" name="position">
						<p style="color: red;">
							<?php 
								// Error messages
								if (isset($_GET["error"])) {
									if ($_GET["error"] == "emptyinput") {
										echo "Fill in all fields!";
									}else if ($_GET["error"] == "invaliduid") {
										echo "Choose a proper username!";
									}else if ($_GET["error"] == "invalidemail") {
										echo "Choose a proper email!";
									}else if ($_GET["error"] == "passwordsdontmatch") {
										echo "Passwords doesn't match!";
									}else if ($_GET["error"] == "stmtfailed") {
										echo "Something went wrong!";
									}else if ($_GET["error"] == "usernametaken") {
										echo "Username already taken!";
									}else if ($_GET["error"] == "none") {
										echo "You have signed up!";
									}
								}
							?>
						</p>
                        <button type="submit" class="btn btn-primary" name="registerAdmin">Register</button>
						<p>Already got an account? <a href="login.php">Login Here</a></p>
                   </form>
				</div>
			</div>
		</section>
		<!-- Sign Up section End -->
		
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