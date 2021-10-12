<?php
if (isset($_POST['reset'])) {
    require_once '../controller/user_controller.php';
    $userController = new UserController();

    $token = $_GET['token'];
    $email = $_GET['email'];
    $type = $_GET['type'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $userController->resetPassword($type, $password, $confirmPassword, $email, $token);
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
                    <h2>Reset Password</h2>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <div class="panel-body mt-5">
                                <?php
                                    // Error messages
                                    if (isset($_GET["error"])) {
                                        echo "<h5><span class='mb-2 badge bg-danger'>";
                                        if ($_GET["error"] == "passwordsdontmatch") {
                                            echo "Passwords does not match";
                                        }else if ($_GET["error"] == "sthwentwrong") {
                                            echo "There was a problem trying to reset the password.";
                                        }else if ($_GET["error"] == "emptyinput") {
                                            echo "Please fill in all field before continue!";
                                        }else if ($_GET["error"] == "notfound") {
                                            echo "Invalid token or email.";
                                        }else if ($_GET["error"] == "expired") {
                                            echo "This link has already expired.";
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
                                <p>Enter your new password here.</p>
                                <form method="POST" autocomplete="off">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="floatingPassword" placeholder="New Password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,20}" title="Must contain at least one number and one uppercase and lowercase letter, and 5 to 20 characters" required>
                                    <label for="floatingPassword">New Password</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="floatingPassword" placeholder="Confirm Password" name="confirmPassword" required>
                                    <label for="floatingPassword">Confirm Password</label>
                                </div>
                                    <button class="w-50 btn-solid-lg mb-5 mt-2" type="submit" name="reset">Reset Password</button>
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