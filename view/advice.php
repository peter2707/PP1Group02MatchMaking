<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Webpage Title -->
    <title>JobMatch | Advice</title>
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
        <div class="container mb-5">
            <div class="row">
                <div class="col-xl-10 offset-xl-1 text-center">
                    <h1>Career & Hiring Advice</h1>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header> <!-- end of ex-header -->
    <!-- end of header -->

  <!-- Contact -->
        <div class="container mt-5 mb-5">
            <div class="row">
                <div class="col-lg-6">
                    <div class="text-container">
                        <h2>How can we help?</h2>
                        <p>Please select the correct topic related to your enquiry and we will get back to you immediately.</p>
                    </div>
                    <!-- end of text-container -->
                    <div class="image-container">
                        <img class="img-fluid" src="../images/careeradvice-2.png" alt="alternative">
                    </div>
                    <!-- end of image-container -->
                </div>
                <!-- end of col -->
                <div class="col-lg-6 mt-5">
                    <!-- Contact Form -->
                    <form method="POST">
                        <div class="form-group">
                            <input type="text" class="form-control-input" placeholder="Name" name="name" required>
                        </div>
                        <div class="form-group">
                            <select class="form-control-input" name="subject" required>
                                <option selected disabled value="">Select your enquiry...</option>
                                <option value="Career Advice">Career Advice</option>
                                <option value="Hiring Advice">Hiring Advice</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control-input" rows="4" placeholder="Message" name="message" required></textarea>
                        </div>
                        <div class="form-group">
                            <button class='form-control-submit-button' type="submit" name="submitEmail">Submit</button>
                        </div>
                    </form>
                    <?php
                    if (isset($_POST['submitEmail'])) {
                        $name = $_POST['name'];
                        $subject = $_POST['subject'];
                        $message = $_POST['message'];
                        $script = "<script>window.location = 'mailto:jobmatchdemo@gmail.com?subject=Name: $name, Subject: $subject&body=$message'</script>";
			            echo $script;
                    }
                    ?>
                    <!-- end of contact form -->
                </div>
                <!-- end of col -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->

    <!-- end of advice -->


    <!-- footer start -->
    <?php
        require_once("component/footer.php");
    ?>
    <!-- end of footer -->


</body>
</html>