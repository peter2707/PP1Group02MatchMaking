<?php
$id = $_GET['id'];
require_once '../controller/session_controller.php';
require_once '../controller/matchmaking_controller.php';
require_once '../controller/admin_controller.php';
// check if the session has not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// call controllers
$mmc = new MatchmakingController();
$ac = new AdminController();
$sc = new SessionController();
$jobmatch = $mmc->getJobMatchByID($id);
$userType = $sc->getUserType();

if (isset($_POST['deny'])) {
    if ($sc->getUserType() == "admin") {
        $ac->denyMatch($id);
    } else {
        $mmc->denyMatch($id, $sc->getUserType());
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | <?php echo "$jobmatch->position"; ?></title>
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
                    <?php
                    if ($userType == "admin") {
                        echo "<p class='card-text'><b>ID:</b> $jobmatch->id &nbsp;&nbsp;&nbsp; <b>Employer:</b> $jobmatch->employer &nbsp;&nbsp;&nbsp; <b>JobSeeker:</b> $jobmatch->jobseeker</p>";
                    }
                    ?>
                    <h1><?php echo "$jobmatch->position"; ?></h1>
                </div>
                <div class="row d-flex align-items-center">
                    <div class="col text-start">
                        <h5 class="text-muted"><?php echo "<i class='fa fa-certificate' aria-hidden='true'></i>&nbsp; $jobmatch->field"; ?></h5>
                        <br>
                        <small style="font-size:medium"><?php echo "<i class='fa fa-briefcase' aria-hidden='true'></i>&nbsp; $jobmatch->type"; ?></small><br>
                        <small style="font-size:medium"><?php echo "<i class='bi bi-cash' aria-hidden='true'></i>&nbsp; $jobmatch->salary"; ?></small><br>
                        <small style="font-size:medium"><?php echo "<i class='fa fa-map-marker' aria-hidden='true'></i>&nbsp; $jobmatch->location"; ?></small>
                    </div>
                    <div class="col text-end"><small><?php echo "<i class='fa fa-clock' aria-hidden='true'></i>&nbsp; $jobmatch->date"; ?></small></div>
                </div>
                <hr>
                <div class="text-start">
                    <?php
                    $rating = number_format((float)$jobmatch->rating, 1, '.', '');
                    if ($userType == "admin") {
                        echo <<< END
                            <div class="row">
                                <div class="col-md-2">
                                    <form method="POST">
                                        <button class="btn btn-danger-lg" onclick="return confirm('Are you sure you want to deny this match ?')" name="deny" type="submit">Delete</button>
                                    </form>
                                </div>
                                <div class="col text-end">
                                    <form action="user_view_other.php" method="GET">
                                        <input type="hidden" name="employer" value="$jobmatch->employer">
                                        <button type='submit' class='btn btn-secondary-sm'>$jobmatch->employer &nbsp;|&nbsp; $rating <i class='fa fa-star' style='color:#FFD700' aria-hidden='true'></i></button>
                                    </form>
                                </div>
                            </div>
                        END;
                    } else {
                        echo <<< END
                            <div class="row">
                                <div class="col-md-2">
                                    <button class="btn btn-solid-lg" data-bs-toggle="modal" data-bs-target="#acceptModal">Accept</button>
                                </div>
                                <div class="col-md-2">
                                    <form method="POST">
                                        <button class="btn btn-danger-lg" onclick="return confirm('Are you sure you want to deny this match ?')" name="deny" type="submit">Deny</button>
                                    </form>
                                </div>
                                <div class="col text-end">
                                    <form action="user_view_other.php" method="GET">
                                        <input type="hidden" name="employer" value="$jobmatch->employer">
                                        <button type='submit' class='btn btn-secondary-sm'>$jobmatch->employer &nbsp;|&nbsp; $rating <i class='fa fa-star' style='color:#FFD700' aria-hidden='true'></i></button>
                                    </form>
                                </div>
                            </div>
                        END;
                    }
                    ?>

                    <!-- Modal -->
                    <div class="modal fade" id="acceptModal" tabindex="-1" aria-labelledby="acceptModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="acceptModalLabel">Accept Match</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-start">
                                        <h6><?php echo "$jobmatch->position"; ?></h6>
                                        <small><?php echo "$jobmatch->employer"; ?></small>
                                        <p>Contact: <?php echo "$jobmatch->contact"; ?></p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary-sm" data-bs-dismiss="modal">Cancel</button>
                                    <?php echo "
                                        <a href='mailto:$jobmatch->contact?subject=Accept Match ($jobmatch->position)&body=Message...'>
                                            <button class='btn btn-solid-sm'>Send Email</button>
                                        </a>
                                    "; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </header>
    <!-- end of header -->

    <!-- Basic -->
    <div class="ex-basic-1 pt-4 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1 text-start">
                    <h3 class="mb-3">Job Description</h3>
                    <hr>
                    <p><?php echo htmlspecialchars_decode("$jobmatch->description") ?></p>
                    <br><br>
                    <h3 class="mb-3">Job Requirements</h3>
                    <hr>
                    <p><?php echo htmlspecialchars_decode("$jobmatch->requirements") ?></p>
                    <br><br>
                    <h3 class="mb-3">Play it safe</h3>
                    <hr>
                    <p>It’s important to protect yourself throughout the job hunting and interview process.
                        Don't ever provide your bank or credit card details when applying for jobs.
                        <b>JobMatch</b> will never ask for your private details such as bank, etc.
                    </p>
                    <h6>Looking Suspicious?</h6>
                    <p>If you found a job that is suspicious, please report it to <b>JobMatch</b> so that we can review it.</p>
                    <?php
                    if ($userType == "employer" || $userType == "jobseeker") {
                        echo <<< END
                            <div class="row">
                                <div class="col text-start">
                                    <form action="report.php" method="GET">
                                        <input type="hidden" name="id" value=$id>
                                        <button type="submit" class="btn btn-secondary-sm"><i class="fa fa-info-circle" aria-hidden="true"></i> Report</button>
                                    </form>
                                </div>
                                <div class="col text-end">
                                    <form action="feedback.php" method="GET">
                                        <input type="hidden" name="id" value=$id>
                                        <button type="submit" class="btn btn-secondary-sm"><i class="fa fa-comments" aria-hidden="true"></i> Feedback</button>
                                    </form>
                                </div>
                            </div>
                        END;
                    }
                    ?>

                </div>
                <!-- end of col -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </div>
    <!-- end of ex-basic-1 -->
    <!-- end of basic -->


    <!-- footer start -->
    <?php
    require_once("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>