<?php
require_once '../controller/matchmaking_controller.php';
require_once '../controller/session_controller.php';
// check if the session has not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// call controllers
$sc = new SessionController();
$mmc = new MatchmakingController();

$id = $_GET['id'];
if (isset($_POST['submit'])) {
    $rating = $_POST['rating'];
    $feedback = $_POST['feedback'];
    $mmc->addFeedback($rating, $feedback, $id);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | Feedback</title>
    <?php
    require_once("component/header.php");
    ?>

</head>

<body data-bs-spy="scroll" data-bs-target="#navbarExample">

    <!-- Navigation Start  -->
    <?php
    require_once("component/navbar.php");
    ?>
    <!-- Navigation End  -->


    <!-- Header -->
    <header class="ex-header">
        <div class="container mb-5">
            <div class="row">
                <div class="col-xl-10 offset-xl-1 text-center">
                    <h1>Feedback</h1>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header> <!-- end of ex-header -->
    <!-- end of header -->

    <!-- Feedback -->
    <div class="container mt-5 mb-5">
        <div class="row text-center">
        <?php
        // Error messages
        if (isset($_GET["error"])) {
            echo "<h5><span class='mb-2 badge bg-danger'>";
            if ($_GET["error"] == "emptyinput") {
                echo "Please complete all required columns!";
            }
            echo "</span></h5>";
        }

        if($sc->getUserType() == "jobseeker"){
            echo <<< END
                <div class="col-lg-6">
                    <div class="text-container">
                        <h2 class="mb-5">How did we do?</h2>
                        <p>We want to hear what you love and what you think we can do better.<br>Provide feedback by filling out a few details in the form and submit it.</p>
                        <small>If you are experiencing an issue with the website, please contact the <a href="https://jobmatchdemo.herokuapp.com/view/index.php#contact">support team</a> so we can help you sort it out as soon as possible.</small>
                    </div>
                    <div class="col-md-7 offset-md-2 image-container">
                        <img class="img-fluid" src="../images/feedback.png" alt="alternative">
                    </div>
                </div>
                <div class="col-lg-6 mt-5">
                    <form method="POST">
                        <div class="form-group">
                            <input type="text" class="form-control-input" disabled value='Match ID: $id'>
                        </div>
                        <div class="form-group">
                            <select class="form-select form-control-input" name="rating" aria-label="Default select example" required>
                                <option selected disabled value="">Matching Experience...</option>
                                <option value="5">⭐⭐⭐⭐⭐</option>
                                <option value="4">⭐⭐⭐⭐</option>
                                <option value="3">⭐⭐⭐</option>
                                <option value="2">⭐⭐</option>
                                <option value="1">⭐</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control-input" name="feedback" id="feedback" rows="5" placeholder="Feedback..." required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="submit" class="form-control-submit-button">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- end of col -->
            END;
        } else {
            echo "<div class='col-xl-10 offset-xl-1' style='height: 300px;'>
                    <h4>You don't have access to this page. Please <a href='login.php'>log in</a></h4>
                </div>";
        }
        ?>
        </div>
        <!-- end of row -->
    </div>
    <!-- end of Feedback -->


    <!-- footer start -->
    <?php
    require_once("component/footer.php");
    ?>
    <!-- end of footer -->


</body>

</html>