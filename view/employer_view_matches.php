<?php
$id = $_GET['id'];
require_once '../controller/matchmaking_controller.php';
require_once '../controller/session_controller.php';
// check if the session has not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// call controllers
$sc = new SessionController();
$mmc = new MatchmakingController();
$jobmatches = array();
$jobmatches = $mmc->getJobMatchByPostID($id, $sc->getUserName());

if (isset($_POST['deny'])) {
    $matchID = $_POST['matchID'];
    $mmc->denyMatch($matchID, $sc->getUserType());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | Matches</title>
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
            <div class="col-xl-10 offset-xl-1">
                <div class="text-start">
                    <h1>All Matches</h1>
                </div>
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </header>
    <!-- end of header -->

    <div class="col-md-6 offset-md-3 mt-5 mb-5" style="min-height: 400px;">
        <?php
        if ($sc->getUserType() == "employer") {
            if (count($jobmatches) < 1) {
                echo "<h3>This post doesn't have any match yet.</h3>";
            } else {
                foreach ($jobmatches as $match) {
                    echo <<< END
                        <div class="job-card">
                            <div class="card border-0 mb-5">
                                <div class="card-body">
                                    <div class="row d-flex align-items-center">
                                        <div class="col text-start">
                                            <h4 style="font-size: 30px; font-weight: lighter;" class="text-start">$match->jobseeker</h4>
                                            <p class="card-text text-success"><i class="fa fa-check" aria-hidden="true"></i>&nbsp; $match->percentage% Match</p>
                                            <br>
                                            <small class="card-text"><i class="fa fa-clock" aria-hidden="true"></i>&nbsp; $match->date</small>
                                        </div>
                                        <div class="col row text-end">
                                            <div class="col text-end">
                                                <form method="POST">
                                                    <input type="hidden" name="matchID" value=$match->id>
                                                    <button name="deny" type="submit" class="btn btn-danger-sm" onclick="return confirm('Are you sure you want to deny this match ?')" ><i class='fa fa-times' aria-hidden='true'></i> Deny</button>
                                                </form>
                                            </div>
                                            <div class="col text-start">
                                                <form action="user_view_other.php" method="GET">
                                                    <input type="hidden" name="jobseeker" value=$match->jobseeker>
                                                    <button type="submit" class="btn btn-solid-sm"><i class='fa fa-user' aria-hidden='true'></i> Profile</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    END;
                }
                unset($jobmatches);
            }
        } else {
            echo "<div class='col-xl-10 offset-xl-1' style='height: 300px;'>
                    <h4>You don't have access to this page. Please <a href='login.php'>log in</a></h4>
                </div>";
        }
        ?>

    </div>


    <!-- footer start -->
    <?php
    require_once("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>