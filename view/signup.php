<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | Sign Up</title>
    <?php
        include("component/header.php");
    ?>
</head>

<body class="text-center">

    <!-- Navigation Start  -->
    <?php
        include("component/navbar.php");
    ?>
    <!-- Navigation End  -->


    <!-- signup section start -->
    <header class="ex-header">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1 mb-3">
                    <h1>Create an Account</h1>
                    <p class="mt-5 mb-2 text-muted">Enter your details below:</p>
                </div>
                <div class="col-md-4 offset-md-4">
                <main class="form-register">
                    <form action="../includes/signup.inc.php" method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Firstname" name="firstName">
                            <label for="floatingInput">Firstname</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Lastname" name="lastName">
                            <label for="floatingInput">Lastname</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Username" name="username">
                            <label for="floatingInput">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Confirm Password" name="confirmPassword">
                            <label for="floatingPassword">Confirm Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="floatingInput" placeholder="Date of Birth" name="dateOfBirth">
                            <label for="floatingInput">Date of Birth</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="tel" class="form-control" id="floatingInput" placeholder="Phone" name="phone">
                            <label for="floatingInput">Phone</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" placeholder="Email" name="email">
                            <label for="floatingInput">Email</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="signup_type" id="inlineRadio1" value="jobseeker" checked>
                            <label class="form-check-label" for="inlineRadio1">Job Seeker</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="signup_type" id="inlineRadio2" value="employer">
                            <label class="form-check-label" for="inlineRadio2">Employer</label>
                        </div>
                        
                        <p style="color: red;">
                            <?php
                            // Error messages
                            if (isset($_GET["error"])) {
                                if ($_GET["error"] == "emptyinput") {
                                    echo "Fill in all fields!";
                                } else if ($_GET["error"] == "invaliduid") {
                                    echo "Choose a proper username!";
                                } else if ($_GET["error"] == "invalidemail") {
                                    echo "Choose a proper email!";
                                } else if ($_GET["error"] == "passwordsdontmatch") {
                                    echo "Passwords doesn't match!";
                                } else if ($_GET["error"] == "stmtfailed") {
                                    echo "Something went wrong!";
                                } else if ($_GET["error"] == "usernametaken") {
                                    echo "Username already taken!";
                                } else if ($_GET["error"] == "none") {
                                    echo "You have signed up!";
                                }
                            }
                            ?>
                        </p>

                        <button class="w-50 btn btn-lg btn-primary mb-5 mt-2" type="submit" name="register">Register</button>
                        <p class="mb-3">Already have an account? <a href="login.php">Log In Here</a></p>
                    </form>
                </main>
            </div>
                <!-- end of col -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </header>
    <!-- signup section End -->


    <!-- footer start -->
    <?php
        include("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>