<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- SEO Meta Tags -->
    <meta name="description" content="Your description">
    <meta name="author" content="Your name">

    <!-- OG Meta Tags to improve the way the post looks when you share the page on Facebook, Twitter, LinkedIn -->
    <meta property="og:site_name" content="" /> <!-- website name -->
    <meta property="og:site" content="" /> <!-- website link -->
    <meta property="og:title" content="" /> <!-- title shown in the actual shared post -->
    <meta property="og:description" content="" /> <!-- description shown in the actual shared post -->
    <meta property="og:image" content="" /> <!-- image link, make sure it's jpg -->
    <meta property="og:url" content="" /> <!-- where do you want your post to link to -->
    <meta name="twitter:card" content="summary_large_image"> <!-- to have large image post format in Twitter -->

    <!-- Webpage Title -->
    <title>JobMatch | Sign Up</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/fontawesome-all.min.css" rel="stylesheet">
    <link href="css/swiper.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    <!-- Favicon  -->
    <link rel="icon" href="images/favicon.png">
</head>

<body class="text-center">

    <!-- Navigation Start  -->
    <?php
    include("navbar.php");
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
                    <form action="includes/signup.inc.php" method="POST">
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
                                    echo "Fill in all required fields!";
                                } else if ($_GET["error"] == "invaliduid") {
                                    echo "Enter a valid username!";
                                } else if ($_GET["error"] == "invalidemail") {
                                    echo "Enter a valid email!";
                                } else if ($_GET["error"] == "passwordsdontmatch") {
                                    echo "Passwords do not match. Please try again!";
                                } else if ($_GET["error"] == "stmtfailed") {
                                    echo "Something went wrong. Please try again!";
                                } else if ($_GET["error"] == "usernametaken") {
                                    echo "Username is already taken!";
                                } else if ($_GET["error"] == "none") {
                                    echo "You have successfully registered!";
                                }
                            }
                            ?>
                        </p>

                        <button class="w-50 btn btn-lg btn-primary mb-5 mt-2" type="submit" name="register">Register</button>
                        <p class="mb-3">Already have an account? <a href="login.php">Login Here</a></p>
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
    include("footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>