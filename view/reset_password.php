<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
include '../model/db_connection.php';

if(isset($_POST['submit_email']) && $_POST['email']){
    $result = mysqli_query($conn,"SELECT * FROM users WHERE email='" . $emailId . "'");
    $row= mysqli_fetch_array($result);
 
  if($row){
    $email=md5($row['email']);
    $pass=md5($row['password']);

    $link="<a href='www.samplewebsite.com/reset.php?key=".$email."&reset=".$pass."'>Click To Reset password</a>";
    require_once('phpmail/PHPMailerAutoload.php');
    $mail = new PHPMailer();
    $mail->CharSet =  "utf-8";
    $mail->IsSMTP();
    // enable SMTP authentication
    $mail->SMTPAuth = true;                  
    // GMAIL username
    $mail->Username = "your_email_id@gmail.com";
    // GMAIL password
    $mail->Password = "your_gmail_password";
    $mail->SMTPSecure = "ssl";  
    // sets GMAIL as the SMTP server
    $mail->Host = "smtp.gmail.com";
    // set the SMTP port for the GMAIL server
    $mail->Port = "465";
    $mail->From='your_gmail_id@gmail.com';
    $mail->FromName='your_name';
    $mail->AddAddress('reciever_email_id', 'reciever_name');
    $mail->Subject  =  'Reset Password';
    $mail->IsHTML(true);
    $mail->Body    = 'Click On This Link to Reset Password '.$pass.'';
    if($mail->Send())
    {
      echo "Check Your Email and Click on the link sent to your email";
    }
    else
    {
      echo "Mail Error - >".$mail->ErrorInfo;
    }
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