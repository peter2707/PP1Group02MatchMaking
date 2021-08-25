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
		
		<!-- login section start -->
		<section class="login-wrapper">
			<div class="container">
				<div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2">
					<form method="post" action="index.php">
						<img class="img-responsive" alt="logo" src="img/logo.png">
						<input type="text" class="form-control input-lg" placeholder="User Name" name="username">
						<input type="password" class="form-control input-lg" placeholder="Password" name="password">
						<label><a href="">Forget Password?</a></label>
						<button type="submit" class="btn btn-primary">Login</button>
						<p>Have't Any Account <a href="register.php">Create An Account</a></p>
					</form>
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