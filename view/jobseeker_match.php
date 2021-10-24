<?php
require_once '../controller/matchmaking_controller.php';
require_once '../controller/session_controller.php';
require_once '../controller/user_controller.php';
// check if the session has not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_POST['match'])) {
    $mmc = new MatchmakingController();
    $sc = new SessionController();
    $uc = new UserController();

    $user = $uc->getUser($sc->getUserType(), $sc->getUserName());
    $userField = $user->field;
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    $location = $_POST['location'];
    $type = $_POST['type'];

    $mmc->findMatch($position, $salary, $location, $type, $userField, $sc->getUserName());
}else{
    // call controllers
    $sc = new SessionController();
    $mmc = new MatchmakingController();
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

<body class="text-center">

    <!-- Navigation Start  -->
    <?php
    require_once("component/navbar.php");
    ?>
    <!-- Navigation End  -->

    <!-- Header -->
    <header class="ex-header">
        <div class="container">
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
        </div> <!-- end of container -->
    </header> <!-- end of ex-header -->
    <!-- end of header -->



    <div class="col-md-6 offset-md-3 mt-5 mb-5" style="min-height: 200px;">
        <?php
        if (isset($_GET["warning"])) {
            echo "<h5><span class='mb-5 badge bg-secondary'>";
            if($_GET["warning"] == "nomatch"){
                echo "There are no match found at the moment...<br>Try searching for a different position or change your career field to a similar one.";
            }
            echo "</span></h5>";
        }elseif (isset($_GET["error"])) {
            echo "<h5><span class='mb-5 badge bg-danger'>";
            if ($_GET["error"] == "emptyinput") {
                echo "Please complete all required columns!";
            }else if ($_GET["error"] == "positionnumeric") {
                echo "Position cannot be a number!";
            }elseif($_GET["error"] == "errorfeedback"){
                echo "There was a problem trying to post the feedback.";
            }
            echo "</span></h5>";
        }elseif (isset($_GET["success"])) {
            echo "<h5><span class='mb-5 badge bg-success'>";
            if ($_GET["success"] == "matchfound") {
                echo "You have a new match! You can view it in the table below.";
            }elseif ($_GET["success"] == "successdeny") {
                echo "Match denied successfully";
            }elseif ($_GET["success"] == "donefeedback") {
                echo "Feedback posted successfully";
            }
            echo "</span></h5>";
        }

        if(count($jobmatches) < 1){
            echo "<h3>You don't have any match yet.</h3> <small>To find match, click on the <i class='fa fa-search' aria-hidden='true'></i> button</small>";
        }else{
            function createOpenButton($hiddenName, $hiddenValue, $buttonText, $actionPage){
                echo "<td>";
                echo "  <form action=$actionPage method=\"GET\">";
                echo "      <input type=\"hidden\" name=$hiddenName value=$hiddenValue>";
                echo "      <button type=\"submit\" class=\"btn btn-solid-sm\">$buttonText</button>";
                echo "  </form>";
                echo "</td>";
            }
                echo "<table class='table table-striped'>";
                echo "            <thead style='height: 50px;' class='table-dark'>";
                echo "                <tr>";
                echo "                    <th scope='col'>Position</th>";
                echo "                    <th scope='col'>Salary</th>";
                echo "                    <th scope='col'>Since</th>";
                echo "                    <th scope='col'>Location</th>";
                echo "                    <th scope='col'>Match Percentage</th>";
                echo "                    <th scope='col'>Action</th>";
                echo "                </tr>";
                echo "            </thead>";
                echo "            <tbody>";
            foreach ($jobmatches as $match) {
                echo "                <tr>";
                echo "                    <td scope='row'>$match->position</td>";
                echo "                    <td scope='row'>$match->salary</td>";
                echo "                    <td scope='row'>$match->date</td>";
                echo "                    <td scope='row'>$match->location</td>";
                echo "                    <td scope='row'>$match->percentage %</td>";
                createOpenButton('id', $match->id, 'View', 'jobseeker_view_match.php');
                echo "                </tr>";
            }
                echo "            </tbody>";
                echo "            </table>";
                unset($jobmatches);
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