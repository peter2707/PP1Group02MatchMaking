<?php
if (isset($_POST['login'])) {
    require_once '../controller/login_controller.php';
    $loginController = new LoginController();

    $username = $_POST['username'];
    $password = $_POST['password'];
    $loginController->login($username, $password);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | Login</title>
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


    <!-- login section start -->
    <header class="ex-header">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1 mb-3">
                    <h1>Login</h1>
                    <p class="mt-5 mb-2" style="color: red;">
                        <?php
                        // Error messages
                        if (isset($_GET["error"])) {
                            if ($_GET["error"] == "emptyusername") {
                                echo "You must enter a valid username!";
                            } else if ($_GET["error"] == "emptypassword") {
                                echo "You must enter a valid password!";
                            } else if ($_GET["error"] == "failed") {
                                echo "Something went wrong. Please try again!";
                            } else if ($_GET["error"] == "incorrect") {
                                echo "Incorrect password or email. Please try again!";
                            } else if ($_GET["error"] == "errordelete") {
                                echo "There was a problem while deleting your account. Please try again!";
                            }
                        }
                        ?>
                    </p>
                    <p class="mt-5 mb-2" style="color: #4BB543;">
                        <?php
                        // Account created message
                        if (isset($_GET["success"])) {
                            if ($_GET["success"] == "created") {
                                echo "Your account has been successfully created.<br>Please log in to continue!";
                            } elseif ($_GET["success"] == "accountdeleted") {
                                echo "Your account has been deleted. Thank you for using our service :)";
                            } elseif ($_GET["success"] == "logout") {
                                echo "Successfully logged out.";
                            }
                        }
                        ?>
                    </p>
                </div>
                <div class="col-md-4 offset-md-4">
                    <main class="form-signin">
                        <form method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Username" name="username">
                                <label for="floatingInput">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                                <label for="floatingPassword">Password</label>
                            </div>

                            <div class="checkbox mb-3">
                                <label>
                                    <input type="checkbox" value="remember-me"> Remember me
                                </label>
                            </div>
                            <button class="w-50 btn btn-lg btn-primary mb-5 mt-2" type="submit" name="login">Log In</button>
                            <p class="mb-3">New user?</br><a href="register.php">Create an account</a></p>
                        </form>
                    </main>
                </div>
                <!-- end of col -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </header>
    <!-- login section End -->


    <!-- footer start -->
    <?php
        require_once("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>