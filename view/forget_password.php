<?php
require_once('../vendor/autoload.php');
require_once '../model/db_connection.php';
require_once '../model/login_model.php';

if (isset($_POST['send'])) {
    $type = $_POST['type'];
    $email = $_POST['email'];
    $query = "SELECT * FROM $type WHERE email = ?";
    $stmtEmp = $db->prepare($query);
    $stmtEmp->bind_param("s", $email);

    $stmtEmp->execute();
    $result = $stmtEmp->get_result();
    $stmtEmp->close();
    $row = $result->fetch_assoc();
    $db->close();

    if ($row) {
        // $email = md5($row['email']);
        // $pass = md5($row['password']);

        $mail = new \SendGrid\Mail\Mail();
        $mail->setFrom("jobmatchdemo@gmail.com", "JobMatch");
        $mail->setSubject("Reset Password");
        $mail->addTo($email, $row['username']);
        $mail->addContent("text/plain", "and easy to do anywhere, even with PHP");
        $mail->addContent(
            "text/html",
            "<strong>and easy to do anywhere, even with PHP</strong>"
        );
        // $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        $sendgrid = new \SendGrid('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');
        try {
            $response = $sendgrid->send($mail);
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
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