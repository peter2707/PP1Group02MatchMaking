<?php
$id = $_GET['id'];
require_once '../controller/matchmaking_controller.php';
// check if the session has not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// call controllers
$mmc = new MatchmakingController();
$jobmatch = $mmc->getJobMatchByID($id);

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
                    <h1><?php echo "$jobmatch->position"; ?></h1>
                </div>
                <div class="row">
                    <div class="col mb-5 text-start">
                        <h6 class="text-muted"><?php echo "$jobmatch->field"; ?></h6>
                    </div>
                    <div class="col row text-end">
                        <p class="text-muted"><?php echo "$jobmatch->employer &nbsp;&nbsp; $jobmatch->rating <i class='fa fa-star' style='color:#FFD700' aria-hidden='true'></i>"; ?> </p>
                    </div>
                </div>
                <div class="text-start">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#acceptModal">Accept</button>
                    <button class="btn btn-secondary">Deny</button>

                    <!-- Modal -->
                    <div class="modal fade" id="acceptModal" tabindex="-1" aria-labelledby="acceptModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="acceptModalLabel">Accept Match</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="text-start">
                                            <h6>Employer: <?php echo "$jobmatch->employer "; ?></h6>
                                            <p>Contact: <?php echo "$jobmatch->contact "; ?></p>
                                        </div>
                                        <hr>
                                        <small id="message">You can also send a message to your employer here</small>
                                        <div class="">
                                            <form action="mailto:contact@yourdomain.com" method="POST" enctype="multipart/form-data" name="EmailForm">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="nameInput" placeholder="Full Name" name="name" required>
                                                    <label for="nameInput">Full Name</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="email" class="form-control" id="emailInput" placeholder="Email" name="email" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" title="Must contain email format E.g. johndoe@mail.com" required>
                                                    <label for="emailInput">Your Email Address</label>
                                                </div>
                                                <textarea class="form-control" id="emailTextArea" placeholder="Message..." name="body" rows="5" required></textarea>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" name="accept" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
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
                    <p><?php echo htmlspecialchars_decode("$jobmatch->requirement") ?></p>
                    <br><br>
                    <h3 class="mb-3">Play it safe</h3>
                    <hr>
                    <p>It’s important to protect yourself throughout the job hunting and interview process.
                        Don't ever provide your bank or credit card details when applying for jobs.
                        <b>JobMatch</b> will never ask for your private details such as bank, etc.
                    </p>
                    <h6>Looking Suspicious?</h6>
                    <p>If you found a job that is suspicious, please report it to <b>JobMatch</b> so that we can review it.</p>
                    <button class="btn btn-secondary"><i class="fa fa-info-circle" aria-hidden="true"></i> Report</button>
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