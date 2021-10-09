<?php
require_once('../vendor/autoload.php');

use Sendinblue\Mailin;

include '../model/db_connection.php';
include '../model/login_model.php';

if (isset($_POST['send'])) {
    $email = "prummonkolsophearith@gmail.com";
    $result = mysqli_query($db, "SELECT email, password FROM jobseeker WHERE email='$email'");
    $row = mysqli_fetch_array($result);

    if ($row) {
        $email = md5($row['email']);
        $pass = md5($row['password']);

        $mailin = new Mailin('https://api.sendinblue.com/v2.0', 'Your access key');
        /** Prepare variables for easy use **/
        $to = array("to@example.net" => "to whom!");
        //mandatory
        $subject = "My subject";
        //mandatory
        $from = array("from@email.com", "from email!");
        //mandatory
        $html = "This is the <h1>HTML</h1>";
        //mandatory
        $text = "This is the text";
        $cc = array("cc@example.net" => "cc whom!");
        $bcc = array("bcc@example.net" => "bcc whom!");
        $replyto = array("replyto@email.com", "reply to!");
        $attachment = array();
        //provide the absolute url of the attachment/s
        $headers = array("Content-Type" => "text/html; charset=iso-8859-1", "X-Ewiufkdsjfhn" => "hello", "X-Custom" => "Custom");
        var_dump($mailin->send_email($to, $subject, $from, $html, $text, $cc, $bcc, $replyto, $attachment, $headers));
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | Reset Password</title>
    <?php
    require_once("component/header.php");
    ?>
</head>

<body class="text-center">

    <!-- Navigation Start  -->
    <?php
    require_once("component/navbar.php");
    ?>
    <!-- Navigation End  -->


    <!-- register section start -->
    <header class="ex-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3 mb-3">
                    <h2>Forgot Password?</h2>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <div class="panel-body mt-5">
                                <p>You can reset your password here.</p>
                                <form method="POST" autocomplete="off">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" placeholder="Email Address" name="email">
                                        <label for="floatingInput">Email Address</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="type" id="job-seeker" value="jobseeker" checked>
                                            <label class="form-check-label" for="job-seeker">Job Seeker</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="type" id="employer" value="employer">
                                            <label class="form-check-label" for="employer">Employer</label>
                                        </div>
                                    </div>
                                    <button class="w-50 btn-solid-lg mb-5 mt-2" type="submit" name="send">Send Recovery Link</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of col -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </header>
    <!-- register section End -->




    <!-- footer start -->
    <?php
    require_once("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>