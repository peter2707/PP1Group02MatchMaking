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

	<!-- login section start -->
	<section class="login-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="card">
						<form style="margin: 10px 50px 10px 50px;" method="POST" action="includes/login.inc.php">
							<img class="img-responsive" alt="logo" src="img/login.png">
							<p style="color: red;">
								<?php
								// Error messages
								if (isset($_GET["error"])) {
									if ($_GET["error"] == "emptyusername") {
										echo "Username cannot be empty!";
									} else if ($_GET["error"] == "emptypassword") {
										echo "Password cannot be empty!";
									} else if ($_GET["error"] == "failed") {
										echo "Something went wrong!";
									} else if ($_GET["error"] == "incorrect") {
										echo "Incorrect Password or Email!";
									}
								}
								?>
							</p>
							<p style="color: #4BB543;">
								<?php
								// Account created message
								if (isset($_GET["success"])) {
									if ($_GET["success"] == "created") {
										echo "Your account has been created.<br>Please log in to continue!";
									}
								}
								?>
							</p>
							<input type="text" class="form-control input-lg" placeholder="Username" name="username">
							<input type="password" class="form-control input-lg" placeholder="Password" name="password">
							<label><a href="">Forget Password?</a></label>
							<button type="submit" class="btn btn-primary">Login</button>
							<p>Not a user? <a href="signup.php">Create An Account</a></p>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- login section End -->

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