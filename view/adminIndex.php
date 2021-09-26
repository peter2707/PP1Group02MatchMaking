<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | Admin</title>
    <?php
        include("component/header.php");
    ?>
</head>

<body data-bs-spy="scroll" data-bs-target="#navbarExample" class="text-center">

    <!-- Navigation Start  -->
    <?php
        include("component/navbar.php");
    ?>
    <!-- Navigation End  -->

    <!-- Header -->
    <header id="ex-header" class="ex-header">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1 mb-3">
                    <h1>Admin Home</h1>
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
                            }
                        }
                        ?>
                    </p>
                    <p class="mt-5 mb-2" style="color: #4BB543;">
                        <?php
                        // Account created message
                        if (isset($_GET["success"])) {
                            if ($_GET["success"] == "created") {
                                echo "Account has been successfully created.";
                            }
                        }
                        ?>
                    </p>
                </div>

                <div class="col-md-4 offset-md-4">
                    <a style="text-decoration : none" href="allJobSeeker.php" class="mb-4 w-100 btn btn-primary">Display all Job Seeker</a>
                    <a style="text-decoration : none" href="allEmp.php" class="mb-4 w-100 btn btn-primary">Display all Employer</a>
                    <a style="text-decoration : none" href="addUser.php" class="mb-4 w-100 btn btn-primary">Add new user</a>
                </div>
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </header>
    <!-- end of header -->



    <!-- footer start -->
    <?php
        include("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>