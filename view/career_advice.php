<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Webpage Title -->
    <title>JobMatch | Home</title>
    <?php
        require_once("component/header.php");
    ?>

</head>

<body data-bs-spy="scroll" data-bs-target="#navbarExample">

    <!-- Navigation Start  -->
		<?php
			require_once("component/navbar.php");
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
                       
                        <h2>How can we help?</h2>
                        <p>Please select the correct topic related to your enquiry and we will get back to you immediately.</p>
                       
                    </div>
                    <!-- end of text-container -->
                    <!-- <div class="image-container">
                            <img class="img-fluid" src="../images/careeradvice-1.png" alt="alternative">
                        </div> -->
                    <!-- end of image-container -->
                </div>
                <!-- end of col -->
                <div class="col-lg-6">

                    <!-- Contact Form -->
                    <form>
                        <div class="form-group">
                            <select class="form-control-input" required>
                                <option selected disabled hidded>Select your enquiry...</option>
                                <option value="careerAdvice">Career Advice</option>
                                <option value="CustomerService">Customer Service</option>
                                <option value="contactUs">Contact Us</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control-input" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control-input" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <select class="form-control-input" required>
                                <option selected disabled hidded>Topic</option>
                                <option value="employer">Employer</option>
                                <option value="jobSeeker">Job Seeker</option>
                                <option value="newUser">New User</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea rows="3" class="form-control-input" placeholder="Enter enquiry..." required></textarea>
                            
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
        require_once("component/footer.php");
    ?>
    <!-- end of footer -->


</body>
</html>