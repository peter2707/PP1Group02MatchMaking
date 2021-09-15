<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Webpage Title -->
    <title>JobMatch | Home</title>
    <?php
        include("component/header.php");
    ?>

</head>

<body data-bs-spy="scroll" data-bs-target="#navbarExample">

    <!-- Navigation Start  -->
		<?php
			include("component/navbar.php");
		?>
	<!-- Navigation End  -->


    <!-- Header -->
    <header class="ex-header">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1">
                    <h1>Career Advice</h1>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header> <!-- end of ex-header -->
    <!-- end of header -->

  <!-- Contact -->
  <div id="contact" class="form-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="text-container">
                        <div class="section-title">CAREER ADVICE</div>
                        <h2>Get in touch for career advice</h2>
                        <p>Aliquam et enim vel sem pulvinar suscipit sit amet quis lorem. Sed risus ipsum, egestas sed odio in, pulvinar euismod ipsum. Sed ut enim non nunc fermentum dictum et sit amet erat. Maecenas</p>
                        <ul class="list-unstyled li-space-lg">
                            <li class="d-flex">
                                <i class="fas fa-square"></i>
                                <div class="flex-grow-1">Vel maximus nunc aliquam ut. Donec semper, magna a pulvinar</div>
                            </li>
                            <li class="d-flex">
                                <i class="fas fa-square"></i>
                                <div class="flex-grow-1">Suscipit sit amet quis lorem. Sed risus ipsum, egestas mare</div>
                            </li>
                            <li class="d-flex">
                                <i class="fas fa-square"></i>
                                <div class="flex-grow-1">Sem pulvinar suscipit sit amet quis lorem. Sed risus</div>
                            </li>
                        </ul>
                        <a class="btn-outline-reg" href="careeradvice.php">Details</a>
                    </div>
                    <!-- end of text-container -->
                </div>
                <!-- end of col -->
                <div class="col-lg-6">

                    <!-- Contact Form -->
                    <form>
                        <div class="form-group">
                            <input type="text" class="form-control-input" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control-input" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control-input" placeholder="Industry" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control-input" placeholder="Your product" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control-submit-button">Submit</button>
                        </div>
                    </form>
                    <!-- end of contact form -->

                </div>
                <!-- end of col -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </div>
    <!-- end of form-1 -->
    <!-- end of contact -->


    <!-- footer start -->
    <?php
        include("component/footer.php");
    ?>
    <!-- end of footer -->


</body>
</html>