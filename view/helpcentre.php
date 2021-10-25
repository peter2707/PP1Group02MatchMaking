<?php
if (isset($_POST['submitEmail'])) {
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    if(!isset($name)||!isset($subject)||!isset($message)){
        header("location: helpcentre.php?error=emptyinput");
    }else{
        header("location: mailto:jobmatchdemo@gmail.com?subject=Name:" . $name . ", Subject: " . $subject . "&body=" . $message);
    }
}
?>
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
            <?php
            // Error messages
            if (isset($_GET["error"])) {
                echo "<div class='text-center'><h5><span class='mt-5 mb-2 badge bg-danger'>";
                if ($_GET["error"] == "emptyinput") {
                    echo "Please complete all required columns!";
                }
                echo "</span></h5></div>";
            }
            ?>
            <div class="col-md-10 offset-md-1">
                <h2 class="mt-5 mb-5">Frequently Asked Questions (FAQ)</h2>
                <div class="mb-5">
                    <p><strong>1. </strong> How do I find a match?</p>
                    <p><strong>Answer: </strong> After you have created your account, you can start finding matches by go to 'Your Matches' tab, click on the search button.</p>
                </div>
                <div class="mb-5">
                    <p><strong>2. </strong> How do I know when I have new matches?</p>
                    <p><strong>Answer: </strong> When you have a new match, you will be able to see it on the 'Your Matches' tab and our system will also send you an email in case you missed it.</p>
                </div>
                <div class="mb-5">
                    <p><strong>3. </strong> After I found a match, what options do I have, what do I have to do?</p>
                    <p><strong>Answer: </strong> When you have a match, if you click on 'Accept', you will be able to see the contact details, you can contact the employer to set up the interview process by sending them an email.</p>
                </div>
                <div class="mb-5">
                    <p><strong>4. </strong> I want to update my account details or password, how do I do that?</p>
                    <p><strong>Answer: </strong> Go to Settings > Enter your updated details > Click 'Save Changes'</p>
                </div>
                <div class="mb-5">
                    <p><strong>5. </strong> I'd like to change my profile pictures, can I do that?</p>
                    <p><strong>Answer: </strong> Yes you can, to do that, Go to 'Profile' > Click 'Change Picture' > Choose an image from your device > Click 'Save Changes'</p>
                </div>
                <div class="mb-5">
                    <p><strong>6. </strong> How do I add more details to impress a potential employer?</p>
                    <p><strong>Answer: </strong> You can add more details about you such as your skills, education, career history, and social links from your profile page.</p>
                </div>
                <div class="mb-5">
                    <p><strong>7. </strong> I have encountered an employer who might be a scammer, what do I do?</p>
                    <p><strong>Answer: </strong> If you have noticed a job post or an employer that is suspicious, please report using the link on the job post immediately so our team can look into it as fast as possible.</p>
                </div>
                <div class="mb-5">
                    <p><strong>8. </strong> How can I reset my password?</p>
                    <p><strong>Answer: </strong> To reset your password, Go to login page, click on 'Forget Password' and type in your email, if you have an account with us, you will receive a link to reset the password.</p>
                </div>
                <div class="mb-5">
                    <p><strong>9. </strong> I'd like to delete my account, how to I do that?</p>
                    <p><strong>Answer: </strong> To completely delete your account from JobMatch, Go to 'Settings' and Click on 'Delete' button and confirm your deletion.</p>
                </div>
                <div class="mb-5">
                    <p><strong>10. </strong> How can I remove a job match from my account?</p>
                    <p><strong>Answer: </strong> You can remove a job match from your account by denying it, to deny a match, go to the job match and click on 'Deny' button.</p>
                </div>
            </div> <!-- end of col -->
            <div class="col-md-10 offset-md-1">
                <h2 class="mt-5 mb-5">More Information</h2>
                <div class="mb-5">
                    <p><strong>1. </strong> Will my review be anonymous?</p>
                    <p><strong>Answer: </strong> Yes, your review will be anonymous and no identifiable information will be provided by JobMatch, in your review.</p>
                </div>
                <div class="mb-5">
                    <p><strong>2. </strong> What details should I send to an employer?</p>
                    <p><strong>Answer: </strong> You can send any details related to the job that you are applying to, keep in mind that you should never send your credit card or bank details to any employer.</p>
                </div>
                <div class="mb-5">
                    <p><strong>3. </strong> Can I post anything else besides job hiring?</p>
                    <p><strong>Answer: </strong> JobMatch does not allow non-job postings. JobMatch does not allow jobs from parties not authorised to post on behalf of the employer. Each job that appears on JobMatch 
                    must be offered by an authorised representative of the company seeking to fill a position. Third parties recruiting on behalf of an employer must be clearly identified so as not to misrepresent this relationship to the JobSeeker.</p>
                </div>
                <div class="mb-5">
                    <p><strong>4. </strong> Is it safe to use JobMatch?</p>
                    <p><strong>Answer: </strong> JobMatch was built as a platform to match job seekers to potential employers, we try to ban any job post or employer that are suspicious to ensure safe experience for all job seeker.
                    but keep in mind that we do not responsible for anything that happens outside our website such as job interview as it is out of our reach.</p>
                </div>
                <div class="mb-5">
                    <p><strong>5. </strong> What kind of informations does JobMatch publishes?</p>
                    <p><strong>Answer: </strong> JobMatch ensures full privacy protection for both employer and jobseeker, which is why we do not publishes any of your information without your approval.</p>
                </div>
            </div> <!-- end of col -->
            <br><br>
            <div class="col-md-10 offset-md-1">
                <h2 class="mt-5 mb-5">Didn't find what you're looking for?</h2>
                <div class="row">
                    <div class="col-md-6 text-center">
                    <strong>Send us an email.</strong>
                    <p class="mb-4"> Fill in your details and message, we will get back to you as soon as possible.</p>
                    <img class="img-fluid" src="../images/feedback.png" alt="alternative">
                    </div>
                    <div class="col-md-6">
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
                    </div>
                </div>
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