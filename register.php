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
                    <form action="includes/register.inc.php" method="POST">
						<img class="img-responsive" alt="logo" src="img/register.png">
                        <input type="text" id="firstName" class="form-control input-lg" placeholder="Firstname" name="firstName">
                        <input type="text" id="lastName" class="form-control input-lg" placeholder="Lastname" name="lastName">
                        <input type="text" id="username" class="form-control input-lg" placeholder="Username" name="username">
                        <input type="password" id="password" class="form-control input-lg" placeholder="Password" name="password">
                        <input type="text" id="dateOfBirth" class="form-control input-lg" placeholder="Date Of Birth" name="dateOfBirth">
                        <input type="tel" id="phone" class="form-control input-lg" placeholder="Phone" name="phone">
                        <input type="email" id="email" class="form-control input-lg" placeholder="Email" name="email">
                        <input type="text" id="position" class="form-control input-lg" placeholder="Position" name="position">
						<p style="color: red;">
							<?php 
								if(isset($_SESSION['Error'])){
									echo $_SESSION['Error'];
									unset($_SESSION['Error']);
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