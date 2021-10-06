<?php
require_once "../controller/admin_controller.php";
$adminController = new AdminController();
if (isset($_POST["exportJobSeeker"])) {
    $adminController->generateReport("jobseeker");
}elseif (isset($_POST["exportEmployer"])) {
    $adminController->generateReport("employer");
}elseif (isset($_POST["exportAdmin"])) {
    $adminController->generateReport("admin");
}
?>
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
                                echo "There was a problem while trying to delete.";
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
                            } elseif ($_GET["success"] == "successdelete") {
                                echo "Account has been successfully deleted.";
                            }
                        }
                        ?>
                    </p>
                </div>

                <div class="row col-md-6 offset-md-3">
                    <div class="col">
                        <a style="text-decoration : none" href="admin_add_user.php" class="mb-4 w-100 btn btn-success-lg"><i class="fa fa-user-plus" aria-hidden="true"></i> &nbsp;Add User</a>
                    </div>
                    <div class="col">
                        <button  data-bs-toggle="modal" data-bs-target="#generateReportModal" class="mb-4 w-100 btn btn-solid-lg"><i class="fa fa-file" aria-hidden="true"></i> &nbsp;Generate Report</button>

                        <!-- Modal -->
                        <div class="modal fade" id="generateReportModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="profileModalLabel">Generate Report</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="mb-3"><small id="message">Choose a table to generate to CSV File</small></div>
                                            <form method="POST">
                                                <button type="submit" name="exportJobSeeker" class="btn btn-solid-sm">JobSeeker</button>
                                                <button type="submit" name="exportEmployer" class="btn btn-solid-sm">Employer</button>
                                                <button type="submit" name="exportAdmin" class="btn btn-solid-sm">Admin</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary-sm" data-bs-dismiss="modal">Done</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col">
                        <a style="text-decoration : none" href="jobseeker_list.php" class="mb-4 w-100 btn btn-secondary-lg"><i class="fa fa-list" aria-hidden="true"></i> &nbsp;JobSeeker List</a>
                    </div>
                    <div class="col">
                        <a style="text-decoration : none" href="employer_list.php" class="mb-4 w-100 btn btn-secondary-lg"><i class="fa fa-list" aria-hidden="true"></i> &nbsp;Employer List</a>
                    </div>
                    <div class="col">
                        <a style="text-decoration : none" href="admin_list.php" class="mb-4 w-100 btn btn-secondary-lg"><i class="fa fa-list" aria-hidden="true"></i> &nbsp;Admin List</a>
                    </div>
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