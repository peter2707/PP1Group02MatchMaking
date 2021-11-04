<?php
require_once '../controller/matchmaking_controller.php';
require_once '../controller/session_controller.php';
require_once '../controller/user_controller.php';
// check if the session has not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$mmc = new MatchmakingController();
$sc = new SessionController();
$uc = new UserController();
if (isset($_POST['match'])) {
    $user = $uc->getUser($sc->getUserType(), $sc->getUserName());
    $userField = $user->field;
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    $location = $_POST['location'];
    $type = $_POST['type'];

    $mmc->findMatch($position, $salary, $location, $type, $userField, $sc->getUserName());
} else {
    $jobmatches = array();
    $jobmatches = $mmc->getAllMatches($sc->getUserName());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | Match</title>
    <?php
    require_once("component/header.php");
    ?>
</head>

<body class="text-center" style="background-color:#fcfafb">

    <!-- Navigation Start  -->
    <?php
    require_once("component/navbar.php");
    ?>
    <!-- Navigation End  -->

    <!-- Header -->
    <header class="ex-header">
        <div class="container">
            <?php
                if($sc->getUserType() == "jobseeker"){
                    echo <<< END
                    <div class="row">
                        <div class="col-8 text-start">
                            <h1>Your Matches</h1>
                        </div>
                        <div class="col-4 text-end">
                            <button id="findMatchBtn" style="width:100px;" class="btn form-control-submit-button btn-lg" type="submit" onclick="showFindMatchForm()"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </div>
                        <form method="POST" id="jobmatch">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-floating">
                                        <input disabled type="text" class="form-control" id="positionInput" placeholder="Position" name="position" required>
                                        <label for="positionInput">Position</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-floating">
                                        <select disabled class="form-select" aria-label=".form-select-lg example" id="salary-field" name="salary">
                                            <option selected>Choose...</option>
                                        </select>
                                        <label for="salary-field">Salary Range</label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-floating">
                                        <select disabled class="form-select" aria-label=".form-select-lg example" id="location-field" name="location">
                                            <option selected>Choose...</option>
                                        </select>
                                        <label for="location-field">Location</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-floating">
                                        <select disabled class="form-select" aria-label=".form-select-lg example" id="job-type-field" name="type">
                                            <option selected>Choose...</option>
                                        </select>
                                        <label for="job-type-field">Job Type</label>
                                    </div>
                                </div>
                                <div class="col-sm-2"><button disabled class="btn btn-success btn-success-lg w-100 fw-bolder" type="submit" id="matchBtn" name="match">Find</button></div>

                            </div>
                        </form>
                    </div> <!-- end of row -->
                    END;
                } else {
                    echo "<div class='col-xl-10 offset-xl-1'>
                            <h4>You don't have access to this page. Please <a href='login.php'>log in</a></h4>
                        </div>";
                }
            ?>
        </div> <!-- end of container -->
    </header> <!-- end of ex-header -->
    <!-- end of header -->



    <div class="col-md-6 offset-md-3 mt-5 mb-5" style="min-height: 400px;">
        <?php
        if (isset($_GET["warning"])) {
            echo "<div class='mb-5'><h5><span class='badge bg-secondary'>";
            if ($_GET["warning"] == "nomatch") {
                echo "There are no match found at the moment...";
            }
            echo "</span></h5><small class='text-secondary'>Try searching for a different position or change your career field to a similar one.</small></div>";
        } elseif (isset($_GET["error"])) {
            echo "<h5><span class='mb-5 badge bg-danger'>";
            if ($_GET["error"] == "emptyinput") {
                echo "Please complete all required columns!";
            } else if ($_GET["error"] == "positionnumeric") {
                echo "Position cannot be a number!";
            } else if ($_GET["error"] == "specialcharacter") {
                echo "Position cannot contain special character!";
            } elseif ($_GET["error"] == "failedfeedback") {
                echo "There was a problem trying to post the feedback.";
            }
            echo "</span></h5>";
        } elseif (isset($_GET["success"])) {
            echo "<h5><span class='mb-5 badge bg-success'>";
            if ($_GET["success"] == "matchfound") {
                echo "You have a new match! You can view it in the table below.";
            } elseif ($_GET["success"] == "denied") {
                echo "Match denied successfully";
            } elseif ($_GET["success"] == "addedfeedback") {
                echo "Feedback posted successfully";
            }
            echo "</span></h5>";
        }

        if($sc->getUserType() == "jobseeker"){
            if (count($jobmatches) < 1) {
                echo "<h3>You don't have any match yet.</h3> <small>To find match, click on the <i class='fa fa-search' aria-hidden='true'></i> button</small>";
            } else {
                foreach ($jobmatches as $match) {
                    $badge = "badge bg-primary";
                    if ($match->type == "Full Time") {
                        $badge = "badge bg-success";
                    } elseif ($match->type == "Part Time") {
                        $badge = "badge bg-primary";
                    } elseif ($match->type == "Casual") {
                        $badge = "badge bg-warning";
                    } elseif ($match->type == "Contract") {
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
                unset($jobmatches);
            }
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