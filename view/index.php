<?php
require_once '../controller/admin_controller.php';
require_once '../controller/session_controller.php';
// call controllers
$sc = new SessionController();
$ac = new AdminController();

// check if the session has not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$allFeedbacks = array();
$allFeedbacks = $ac->getAllFeedback();
?>
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
    <header id="header" class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-5">
                    <div class="text-container">
                        <h1 class="h1-large">Get your job faster and easier</h1>
                        <p class="p-large">Let us help you land an opportunity of a lifetime.</p>
                        <a class="btn-solid-lg" href="register.php">Join today</a>
                    </div>
                    <!-- end of text-container -->
                </div>
                <!-- end of col -->
                <div class="col-lg-6 col-xl-7">
                    <div class="image-container" style="margin-top: -50px;">
                        <img class="img-fluid" src="../images/header-image.png" alt="alternative">
                    </div>
                    <!-- end of image-container -->
                </div>
                <!-- end of col -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </header>
    <!-- end of header -->


    <!-- Services -->
    <div id="getstarted" class="cards-1 bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>How To Start?</h2>
                </div>
                <!-- end of col -->
            </div>
            <!-- end of row -->
            <div class="row">
                <div class="col-lg-12">

                    <!-- Card -->
                    <div class="card">
                        <div class="card-icon">
                            <span class="fas fa-file-alt"></span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Create your account</h5>
                             <p>Enter your details, choose your side between an Employer or Job Seeker!</p> <!-- Employer? List a job post with your business values! Job Seeker? Personalize your profile with a fieldset!</p> -->
                            <a class="read-more no-line" href="register.php">Learn more <span class="fas fa-long-arrow-alt-right"></span></a>
                        </div>
                    </div>
                    <!-- end of card -->

                    <!-- Card -->
                    <div class="card">
                        <div class="card-icon red">
                            <span class="far fa-lightbulb"></span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Get matches</h5>
                            <p>We will pair you up with your corresponding Employer/Job Seeker. Keep an eye out on your email!</p>
                            <a class="read-more no-line" href="aboutus.php">Learn more <span class="fas fa-long-arrow-alt-right"></span></a>
                        </div>
                    </div>
                    <!-- end of card -->

                    <!-- Card -->
                    <div class="card">
                        <div class="card-icon green">
                            <span class="far fa-comments"></span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Make contact</h5>
                            <p>Choose to continue with the next employment steps by contacting one another!</p>
                            <a class="read-more no-line" href="aboutus.php">Learn more <span class="fas fa-long-arrow-alt-right"></span></a>
                        </div>
                    </div>
                    <!-- end of card -->

                </div>
                <!-- end of col -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </div>
    <!-- end of cards-1 -->
    <!-- end of services -->


    <!-- Details 1 -->
    <div id="details" class="basic-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-7">
                    <div class="image-container">
                        <img class="img-fluid" src="../images/details-1.png" alt="alternative">
                    </div>
                    <!-- end of image-container -->
                </div>
                <!-- end of col -->
                <div class="col-lg-6 col-xl-5">
                    <div class="text-container">
                        <div class="section-title">JOB SEEKER</div>
                        <h2>Finding jobs have never been easier</h2>
                        <p>Looking for a job?. Customise your profile; add your fields, experience, qualifications, availability, career objective. With thousands of jobs currently available and more being added everyday, JobMatch can help you find the right job.</p>
                        <!-- <a class="btn-solid-reg" href="#contact">Get Advices</a> -->
                    </div>
                    <!-- end of text-container -->
                </div>
                <!-- end of col -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </div>
    <!-- end of basic-1 -->
    <!-- end of details 1 -->


    <!-- Details 2 -->
    <div class="basic-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-5">
                    <div class="text-container">
                        <div class="section-title">EMPLOYER</div>
                        <h2>Advertise a job at no cost!</h2>
                        <p>Looking for candidates? It's quick & simple to post jobs on JobMatch. Start today. Reach 200M+ Job Seekers. Evaluate Candidates. Post a job in minutes. No.1 Job-Matching Site. Find Quality Candidates. Schedule Interviews.</p>
                        <!-- <a class="btn-solid-reg" href="#contact">Get Advices</a> -->
                    </div>
                    <!-- end of text-container -->
                </div>
                <!-- end of col -->
                <div class="col-lg-6 col-xl-7">
                    <div class="image-container">
                        <img class="img-fluid" src="../images/details-2.png" alt="alternative">
                    </div>
                    <!-- end of image-container -->
                </div>
                <!-- end of col -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </div>
    <!-- end of basic-2 -->
    <!-- end of details 2 -->

    <!-- Details 3 -->
    <div id=aboutUs class="basic-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-7">
                    <div class="image-container">
                        <img class="img-fluid" src="../images/details-3.png" alt="alternative">
                    </div>
                    <!-- end of image-container -->
                </div>
                <!-- end of col -->
                <div class="col-lg-6 col-xl-5">
                    <div class="text-container">
                        <div class="section-title">ABOUT US</div>
                        <h2>Whatever you're looking for, you can find it on JobMatch!</h2>
                        <p>JobMatch is the latest product developed by students from RMIT University studying the course COSC2408 Programming Project 1. We're helping people to get back to work & employers find the right staff. Find jobs & career related information or recruit the ideal candidate!</p>
                        <a class="btn-solid-reg" href="aboutus.php">About Us</a>
                    </div>
                    <!-- end of text-container -->
                </div>
                <!-- end of col -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </div>
    <!-- end of basic-2 -->
    <!-- end of details 2 -->


    <!-- Testimonials -->
    <div class="cards-2 bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="h2-heading">Customer satisfactions</h2>
                </div>
                <!-- end of col -->
            </div>
            <!-- end of row -->
            <div class="row">
                <div class="col-lg-12">

                    <?php
                    if (count($allFeedbacks) < 1) {
                        echo "<h6 class='mt-5'>No result found yet.</h6> <small>All feedback made by user will be appeared here.</small>";
                    } else {
                        $feedback = array_slice($allFeedbacks, -6);
                        for ($i = 0; $i < count($feedback); $i++) {
                            $rating = str_repeat("???", $feedback[$i]->rating);
                            $comment = $feedback[$i]->comment;
                            $jobseeker = $feedback[$i]->jobseeker;
                            $date = $feedback[$i]->date;
                            echo <<< END
                                <!-- Card -->
                                <div class="card">
                                    <img class="quotes" src="../images/quotes.svg" alt="alternative">
                                    <div class="card-body">
                                        <small>$rating</small>
                                        <p class="testimonial-text">$comment</p>
                                        <div class="testimonial-author">$jobseeker</div>
                                        <div class="occupation">$date</div>
                                    </div>
                            END;
                            if($i == 0 || $i == 3){
                                echo "<div class='gradient-floor red-to-blue'></div>";
                            }elseif($i == 1 || $i == 4){
                                echo "<div class='gradient-floor blue-to-purple'></div>";
                            }elseif($i == 2 || $i == 5){
                                echo "<div class='gradient-floor purple-to-green'></div>";
                            }
                            echo <<< END
                                </div>
                                <!-- end of card -->
                            END;
                        }
                    }
                    ?>

                </div>
                <!-- end of col -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </div>
    <!-- end of cards-2 -->
    <!-- end of testimonials -->


    <!-- Customers -->
    <div class="slider-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h4>Trusted by over <span class="blue">5000</span> customers worldwide</h4>
                    <hr class="section-divider">

                    <!-- Image Slider -->
                    <div class="slider-container">
                        <div class="swiper-container image-slider">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img class="img-fluid" src="../images/customer-logo-1.png" alt="alternative">
                                </div>
                                <div class="swiper-slide">
                                    <img class="img-fluid" src="../images/customer-logo-2.png" alt="alternative">
                                </div>
                                <div class="swiper-slide">
                                    <img class="img-fluid" src="../images/customer-logo-3.png" alt="alternative">
                                </div>
                                <div class="swiper-slide">
                                    <img class="img-fluid" src="../images/customer-logo-4.png" alt="alternative">
                                </div>
                                <div class="swiper-slide">
                                    <img class="img-fluid" src="../images/customer-logo-5.png" alt="alternative">
                                </div>
                                <div class="swiper-slide">
                                    <img class="img-fluid" src="../images/customer-logo-6.png" alt="alternative">
                                </div>
                            </div>
                            <!-- end of swiper-wrapper -->
                        </div>
                        <!-- end of swiper container -->
                    </div>
                    <!-- end of slider-container -->
                    <!-- end of image slider -->

                </div>
                <!-- end of col -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </div>
    <!-- end of slider-1 -->
    <!-- end of customers -->


    <!-- Invitation -->
    <div class="basic-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-container">
                        <h2>Find the right job for you</h2>
                        <p class="p-large">We understand that the workplace may seem challenging. So, let us help!</p>
                        <a class="btn-solid-lg" href="#contact">Get free quote</a>
                    </div>
                    <!-- end of text-container -->
                </div>
                <!-- end of col -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </div>
    <!-- end of basic-3 -->
    <!-- end of invitation -->


    <!-- Contact -->
    <div id="contact" class="form-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="text-container">
                        <div class="section-title">HELP & SUPPORT</div>
                        <h2>Got a question? Just ask us!</h2>
                        <p>Whether you require support or have an issue with your experience, let us know!</p>
                        <ul class="list-unstyled li-space-lg">
                            <li class="d-flex">
                                <i class="fas fa-square"></i>
                                <div class="flex-grow-1">Fill in your contact details including your full name & email.</div>
                            </li>
                            <li class="d-flex">
                                <i class="fas fa-square"></i>
                                <div class="flex-grow-1">Enter a title for your message & type away!</div>
                            </li>
                            <li class="d-flex">
                                <i class="fas fa-square"></i>
                                <div class="flex-grow-1">Submit your enquiry & we'll make sure to get back to you within 1-3 business days.</div>
                            </li>
                        </ul>
                        <a class="btn-solid-lg" href="helpcentre.php">Help Centre</a>
                    </div>
                    <!-- end of text-container -->
                </div>
                <!-- end of col -->
                <div class="col-lg-6 mt-5">
                    <form method="POST">
                        <div class="form-group">
                            <input type="text" class="form-control-input" placeholder="Name" name="name" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control-input" placeholder="Subject" name="subject" required>
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
                </div>
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->

        <!-- START Bootstrap-Cookie-Alert -->
        <div class="alert text-center cookiealert" role="alert">
            <b>Do you like cookies?</b> &#x1F36A; We use cookies to ensure you get the best experience on our website. <a href="https://cookiesandyou.com/" target="_blank">Learn more</a>
            <button type="button" class="btn btn-primary btn-sm acceptcookies btn-solid-sm">I agree</button>
        </div>
        <!-- END Bootstrap-Cookie-Alert -->
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