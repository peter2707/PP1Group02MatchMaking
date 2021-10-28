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
    require_once "../controller/admin_controller.php";
    $adminController = new AdminController();
    $username = $_POST['username'];
    $adminController->deleteAccount($username, "admin");
} else {
    $allJobMatches = array();
    $allJobMatches = $ac->getAllJobMatch();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | Admin List</title>
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
            <div class="row justify-content-md-center">
                <div class="col-xl-11 mb-2">
                    <h1>Job Matches</h1>
                </div>
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </header>
    <!-- end of header -->

    <div class="container mt-5">
        <div class="mb-5" style="min-height: 400px;">
            <?php
            if(count($allJobMatches) < 1){
                echo "<h3>No data available yet.</h3> <small>All job matches will be displayed here once available.</small>";
            }else{
                foreach ($allJobMatches as $match) {
                    $badge = "badge bg-primary";
                    if($match->type == "Full Time"){
                        $badge = "badge bg-success";
                    }elseif($match->type == "Part Time"){
                        $badge = "badge bg-primary";
                    }elseif($match->type == "Casual"){
                        $badge = "badge bg-warning";
                    }elseif($match->type == "Contract"){
                        $badge = "badge bg-danger";
                    }
                    echo <<< END
                        <div class="job-card">
                            <div class="card border-0 mb-5">
                                <div class="card-body">
                                    <div class="row d-flex align-items-center">
                                        <div class="col text-start">
                                            <small class="ms-1"><span class="$badge">$match->type</span></small>
                                            <h4 style="font-size: 30px; font-weight: lighter;" class="text-start">$match->position</h4>
                                            <p class="card-text"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp; $match->location &nbsp;&nbsp; <i style="font-size: 20px" class="bi bi-cash"></i>&nbsp; $match->salary</p>
                                            <small class="card-text text-success"><i class="fa fa-check" aria-hidden="true"></i>&nbsp; $match->percentage% Match</small>
                                            <br>
                                            <small class="card-text"><i class="fa fa-clock" aria-hidden="true"></i>&nbsp; $match->date</small>
                                        </div>
                                        <div class="col text-end">
                                            <form action="jobseeker_view_match.php" method="GET">
                                                <input type="hidden" name="id" value=$match->id>
                                                <button type="submit" class="btn btn-solid-lg">View</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    END;
                }
                unset($allJobMatches);
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