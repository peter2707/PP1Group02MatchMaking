<?php
$id = $_GET['id'];
require_once '../controller/session_controller.php';
require_once '../controller/matchmaking_controller.php';
// check if the session has not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// call controllers
$mmc = new MatchmakingController();
$sc = new SessionController();
$jobmatch = $mmc->getJobMatchByID($id);

if (isset($_POST['deny'])) {
    $mmc->denyMatch($id, $sc->getUserType());
}

function createUserLinkButton($hiddenName, $hiddenValue, $buttonText, $actionPage, $rating) {
    echo "<form action=$actionPage method=\"GET\">";
    echo "<input type=\"hidden\" name=$hiddenName value=$hiddenValue>";
    echo "<button type='submit' class='btn btn-secondary-sm'>$buttonText &nbsp;|&nbsp; $rating <i class='fa fa-star' style='color:#FFD700' aria-hidden='true'></i></button>";
    echo "</form>";
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

<body data-bs-spy="scroll" data-bs-target="#navbarExample" class="text-center  d-flex flex-column">

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
                    <h1><?php echo "$jobmatch->position"; ?></h1>
                </div>
                <div class="row">
                    <div class="col mb-5 text-start">
                        <h6 class="text-muted"><?php echo "$jobmatch->field"; ?></h6>
                    </div>
                    <div class="col row text-end">
                        <p class="text-muted">
                            <?php
                                createUserLinkButton('employer', $jobmatch->employer, $jobmatch->employer, 'user_view_other.php', $jobmatch->rating);
                            ?>
                        </p>
                    </div>
                </div>
                <div class="text-start">
                    <button class="btn btn-solid-lg" style="float:left" data-bs-toggle="modal" data-bs-target="#acceptModal">Accept</button>
                    <form method="POST" style="float:left; margin-left:20px;">
                        <button class="btn btn-danger-lg" onclick="return confirm('Are you sure you want to deny this match ?')" name="deny" type="submit">Deny</button>
                    </form>

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
                                        <a href='mailto:$jobmatch->contact?subject=Subject...&body=Message...'>
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
                    <div class="row">
                        <div class="col text-start">
                            <button class="btn btn-secondary-sm"><i class="fa fa-info-circle" aria-hidden="true"></i> Report</button>
                        </div>
                        <div class="col text-end">
                            <button class="btn btn-secondary-sm"><i class="fa fa-comments" aria-hidden="true"></i> Feedback</button>
                        </div>
                    </div>
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