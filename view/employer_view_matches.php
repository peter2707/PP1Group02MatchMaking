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

    <div class="col-md-6 offset-md-3 mt-5 mb-5" style="min-height: 200px;">
        <?php
        if(count($jobmatches) < 1){
            echo "<h3>This post doesn't have any match yet.</h3>";
        }else{
            function createViewProfileButton($hiddenName, $hiddenValue, $buttonText, $actionPage){
                echo "<td>";
                echo "  <form action=$actionPage method=\"GET\">";
                echo "      <input type=\"hidden\" name=$hiddenName value=$hiddenValue>";
                echo "      <button type=\"submit\" class=\"btn btn-solid-sm\"><i class='fa fa-user' aria-hidden='true'></i> $buttonText</button>";
                echo "  </form>";
                echo "</td>";
            }
            function createDenyButton($matchID, $buttonText){
                echo "<td>";
                echo "  <form method=\"POST\">";
                echo "      <input type=\"hidden\" name='matchID' value=$matchID>";
                echo "      <button name=\"deny\" type=\"submit\" class=\"btn btn-danger-sm\" onclick=\"return confirm('Are you sure you want to deny this match ?')\" ><i class='fa fa-times' aria-hidden='true'></i> $buttonText</button>";
                echo "  </form>";
                echo "</td>";
            }
                echo "<table class='table table-striped'>";
                echo "  <thead style='height: 50px;' class='table-dark'>";
                echo "  <tr>";
                echo "      <th scope='col'>Job Seeker</th>";
                echo "      <th scope='col'>Salary</th>";
                echo "      <th scope='col'>Type</th>";
                echo "      <th scope='col' style='width: 20%;'>Match Percentage</th>";
                echo "      <th scope='col' style='width: 13%;'>Action</th>";
                echo "      <th scope='col' style='width: 14%;'></th>";
                echo "  </tr>";
                echo "  </thead>";
                echo "  <tbody>";
            foreach ($jobmatches as $match) {
                echo "  <tr>";
                echo "      <td scope='row'>$match->jobseeker</td>";
                echo "      <td scope='row'>$match->salary</td>";
                echo "      <td scope='row'>$match->type</td>";
                echo "      <td scope='row'>$match->percentage %</td>";
                createDenyButton($match->id, "Deny");
                createViewProfileButton('jobseeker', $match->jobseeker, 'Profile', 'user_view_other.php');
                echo "  </tr>";
            }
                echo "  </tbody>";
                echo "</table>";
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