<?php
require_once '../controller/login_controller.php';

if (isset($_POST['send'])) {
    $type = $_POST['type'];
    $email = $_POST['email'];
    $loginController = new LoginController();
    $loginController->resetPassword($type, $email);
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
                            <?php
                                // Error messages
                                if (isset($_GET["error"])) {
                                    echo "<h5><span class='mb-2 badge bg-danger'>";
                                    if ($_GET["error"] == "usernotfound") {
                                        echo "User not found!";
                                    }else if ($_GET["error"] == "sthwentwrong") {
                                        echo "There was a problem trying to generate the link.";
                                    }else if ($_GET["error"] == "emptyinput") {
                                        echo "Please fill in all field before continue!";
                                    }
                                    echo "</span></h5>";
                                }elseif (isset($_GET["success"])) {
                                    echo "<h5><span class='mb-2 badge bg-success'>";
                                    if ($_GET["success"] == "tokengenerated") {
                                        echo "A link has been sent to your email, please check your inbox or spam folder.";
                                    }
                                    echo "</span></h5>";
                                }
                            ?>
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