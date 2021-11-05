<?php
require_once '../controller/admin_controller.php';
require_once '../controller/session_controller.php';
// call controllers
$sc = new SessionController();
$ac = new AdminController();

// check if the session has not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['delete'])) {
    $username = $_POST['username'];
    $ac->deleteAccount($username, "jobseeker");
} else {
    $allJobSeekers = array();
    $allJobSeekers = $ac->getAllJobSeeker();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | JobSeeker List</title>
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
            <h1>JobSeekers</h1>
        </div>
        <!-- end of container -->
    </header>
    <!-- end of header -->

    <div class="container mt-5">
        <div class="mb-5" style="min-height: 400px;">
            <?php
            if($sc->getUserType() == "admin"){
                if (count($allJobSeekers) < 1) {
                    echo "<h3>No result found yet.</h3> <small><b>To add a user</b>, click on the Add New User button</small>";
                } else {
                    foreach ($allJobSeekers as $jobSeeker) {
                        $userImage = $jobSeeker->image;
                        if ($jobSeeker->image == NULL) {
                            $defaultImage = file_get_contents("../images/user.png");
                            $userImage = base64_encode($defaultImage);
                        }
                        echo <<< END
                            <div class="job-card">
                                <div class="card border-0 mb-5">
                                    <div class="card-body">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-1 text-center" id="content-desktop"><img src="data:image/png;base64, $userImage" alt='User' class='rounded-circle' width='50' height='50'></div>
                                            <div class="col text-start">
                                                <small class="ms-1"><span class="badge bg-secondary">ID: $jobSeeker->id</span></small>
                                                <h4 style="font-size: 30px; font-weight: lighter;" class="text-start">$jobSeeker->firstName $jobSeeker->lastName</h4>
                                                <p class="card-text"><i class="fa fa-certificate" aria-hidden="true"></i>&nbsp; $jobSeeker->field</p>
                                            </div>
                                            <div class="col row text-end">
                                                <div class="col text-end">
                                                    <form action="admin_edit_user.php" method="GET">
                                                        <input type="hidden" name="jobseeker" value=$jobSeeker->username>
                                                        <button type="submit" class="btn btn-solid-sm"><i class="fa fa-wrench" aria-hidden="true"></i></button>
                                                    </form>
                                                </div>
                                                <div class="col text-start">
                                                    <form method="POST">
                                                        <input type="hidden" name="username" value=$jobSeeker->username>
                                                        <button name="delete" type="submit" class="btn btn-danger-sm" onclick="return confirm('Are you sure you want to delete $jobSeeker->username ?')" ><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        END;
                    }
                    unset($allJobSeekers);
                }
            } else {
                echo "<div class='col-xl-10 offset-xl-1' style='height: 300px;'>
                            <h4>You don't have access to this page. Please <a href='login.php'>log in</a></h4>
                        </div>";
            }
            ?>

        </div>
    </div>

    <!-- footer start -->
    <?php
    require_once("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>