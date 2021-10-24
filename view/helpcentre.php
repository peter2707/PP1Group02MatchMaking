<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Webpage Title -->
    <title>JobMatch | Help & Support</title>
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
                    <h1>Help & Support</h1>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header> <!-- end of ex-header -->
    <!-- end of header -->

    <!-- Help & Support -->
    <div class="ex-basic-1 pt-5 pb-5">
        <div class="container">
            <div class="col-md-9 offset-md-3">
                <h2 class="mt-5 mb-5">Frequently Asked Question (FAQ)</h2>
                <div class="mb-5">
                    <p><strong>1. </strong> How to create an account?</p>
                    <p><strong>Answer: </strong> Go to Login > Create an account > Fill in your details > Submit</p>
                </div>
                <div class="mb-5">
                    <p><strong>2. </strong> How to create an account?</p>
                    <p><strong>Answer: </strong> Go to Login > Create an account > Fill in your details > Submit</p>
                </div>
                <div class="mb-5">
                    <p><strong>3. </strong> How to create an account?</p>
                    <p><strong>Answer: </strong> Go to Login > Create an account > Fill in your details > Submit</p>
                </div>
                <div class="mb-5">
                    <p><strong>4. </strong> How to create an account?</p>
                    <p><strong>Answer: </strong> Go to Login > Create an account > Fill in your details > Submit</p>
                </div>
                <div class="mb-5">
                    <p><strong>5. </strong> How to create an account?</p>
                    <p><strong>Answer: </strong> Go to Login > Create an account > Fill in your details > Submit</p>
                </div>
                <div class="mb-5">
                    <p><strong>6. </strong> How to create an account?</p>
                    <p><strong>Answer: </strong> Go to Login > Create an account > Fill in your details > Submit</p>
                </div>
                <div class="mb-5">
                    <p><strong>7. </strong> How to create an account?</p>
                    <p><strong>Answer: </strong> Go to Login > Create an account > Fill in your details > Submit</p>
                </div>
                <div class="mb-5">
                    <p><strong>8. </strong> How to create an account?</p>
                    <p><strong>Answer: </strong> Go to Login > Create an account > Fill in your details > Submit</p>
                </div>
                <div class="mb-5">
                    <p><strong>9. </strong> How to create an account?</p>
                    <p><strong>Answer: </strong> Go to Login > Create an account > Fill in your details > Submit</p>
                </div>
                <div class="mb-5">
                    <p><strong>10. </strong> How to create an account?</p>
                    <p><strong>Answer: </strong> Go to Login > Create an account > Fill in your details > Submit</p>
                </div>
            </div> <!-- end of col -->
            <div class="col-md-9 offset-md-3">
                <h2 class="mt-5 mb-5">More Information</h2>
                <div class="mb-5">
                    <p><strong>1. </strong> How to create an account?</p>
                    <p><strong>Answer: </strong> Go to Login > Create an account > Fill in your details > Submit</p>
                </div>
                <div class="mb-5">
                    <p><strong>2. </strong> How to create an account?</p>
                    <p><strong>Answer: </strong> Go to Login > Create an account > Fill in your details > Submit</p>
                </div>
                <div class="mb-5">
                    <p><strong>3. </strong> How to create an account?</p>
                    <p><strong>Answer: </strong> Go to Login > Create an account > Fill in your details > Submit</p>
                </div>
                <div class="mb-5">
                    <p><strong>4. </strong> How to create an account?</p>
                    <p><strong>Answer: </strong> Go to Login > Create an account > Fill in your details > Submit</p>
                </div>
                <div class="mb-5">
                    <p><strong>5. </strong> How to create an account?</p>
                    <p><strong>Answer: </strong> Go to Login > Create an account > Fill in your details > Submit</p>
                </div>
            </div> <!-- end of col -->
            <div class="col-md-6 offset-md-3">
                <h2 class="mt-5 mb-5">Didn't find what you're looking for?</h2>
                <form method="POST">
                    <div class="form-group">
                        <input type="text" class="form-control-input" placeholder="Name" name="name" required>
                    </div>
                    <div class="form-group">
                        <select class="form-control-input" name="subject" required>
                            <option selected disabled value="">Select your enquiry...</option>
                            <option value="Account Issues">Account Issues</option>
                            <option value="Job Match">Job Match</option>
                            <option value="Job Search">Job Search</option>
                            <option value="Report Job/Employer">Report Job/Employer</option>
                            <option value="Report Bug">Report Bug</option>
                            <option value="Other">Other</option>
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
            </div> <!-- end of col -->
        </div> <!-- end of container -->
    </div> <!-- end of ex-basic-1 -->
    <!-- end of Help & Support -->


    <!-- footer start -->
    <?php
        require_once("component/footer.php");
    ?>
    <!-- end of footer -->


</body>
</html>