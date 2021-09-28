<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | Admin</title>
    <?php
        require_once("component/header.php");
    ?>
</head>

<body data-bs-spy="scroll" data-bs-target="#navbarExample" class="text-center">

    <!-- Navigation Start  -->
    <?php
        require_once("component/navbar.php");
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
                            } else if ($_GET["error"] == "errordelete") {
                                echo "There was a problem while trying to delete :(";
                            }
                        }
                        ?>
                    </p>
                    <p class="mt-5 mb-2" style="color: #4BB543;">
                        <?php
                        // Success message
                        if (isset($_GET["success"])) {
                            if ($_GET["success"] == "created") {
                                echo "Account has been successfully created.";
                            }elseif ($_GET["success"] == "deletedEmployer") {
                                echo "Employer has been successfully deleted.";
                            }elseif ($_GET["success"] == "deletedSeeker") {
                                echo "Job Seeker has been successfully deleted.";
                            }
                        }
                        ?>
                    </p>
                </div>

                <div class="col-md-4 offset-md-4">
                    <a style="text-decoration : none" href="jobseeker_list.php" class="mb-4 w-100 btn btn-primary">Display all Job Seeker</a>
                    <a style="text-decoration : none" href="employer_list.php" class="mb-4 w-100 btn btn-primary">Display all Employer</a>
                    <a style="text-decoration : none" href="add_user.php" class="mb-4 w-100 btn btn-primary">Add new user</a>
                </div>
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </header>
    <!-- end of header -->



    <!-- footer start -->
    <?php
        require_once("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>