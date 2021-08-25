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
                    <form action="php/register.php" method="POST">
                        <input type="text" id="firstName" class="form-control input-lg" placeholder="Firstname" name="firstName"><br><br>
                        <input type="text" id="lastName" class="form-control input-lg" placeholder="Lastname" name="lastName"><br><br>
                        <input type="text" id="username" class="form-control input-lg" placeholder="Username" name="username"><br><br>
                        <input type="password" id="password" class="form-control input-lg" placeholder="Password" name="password"><br><br>
                        <input type="text" id="dateOfBirth" class="form-control input-lg" placeholder="Date Of Birth" name="dateOfBirth"><br><br>
                        <input type="text" id="phone" class="form-control input-lg" placeholder="Phone" name="phone"><br><br>
                        <input type="email" id="email" class="form-control input-lg" placeholder="Email" name="email"><br><br>
                        <input type="text" id="position" class="form-control input-lg" placeholder="Position" name="position"><br><br>

                        <button type="submit" class="btn btn-primary">Register</button>
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