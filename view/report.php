<?php
$id = $_GET['id'];
require_once '../controller/matchmaking_controller.php';
require_once '../controller/session_controller.php';
$mmc = new MatchmakingController();
$sc = new SessionController();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_POST['submit'])) {
    $username = $sc->getUserName();
    $type = $sc->getUserType();
    $reason = $_POST['reason'];
    $comment = $_POST['comment'];
    $mmc->reportMatch($username, $type, $id, $reason, $comment);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Webpage Title -->
    <title>JobMatch | Report</title>
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
                <div class="col-xl-10">
                    <h1>Report a Match <i class="fa fa-info-circle" aria-hidden="true"></i></h1>
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
        }elseif (isset($_GET["success"])) {
            echo "<h5><span class='mb-2 badge bg-success'>";
            if ($_GET["success"] == "reported") {
                echo "Your report has been submitted, our team will review it soon.";
            }
            echo "</span></h5>";
        }
        ?>
            <div class="col-lg-6">
                <div class="text-container">
                    <h2 class="mb-5">Looking Suspicious?</h2>
                    <p>You can report a match if you think it is suspicious or something is wrong with the post.<br><br>To submit a report, please fill in the details and click submit.</p>
                    <small>If you are experiencing an issue with the website, please contact the <a href="https://jobmatchdemo.herokuapp.com/view/index.php#contact">support team</a> so we can help you sort it out as soon as possible.</small>
                </div>
            </div>
            <div class="col-lg-6 mt-5">
                <form method="POST">
                    <div class="form-group">
                        <input type="text" class="form-control-input" disabled value='<?php echo "Match ID: $id" ?>'>
                    </div>
                    <div class="form-group">
                        <select class="form-select form-control-input" name="reason" aria-label="Default select example" required>
                            <option selected disabled value="">Reason for reporting...</option>
                            <option value="Fraudulent">Fraudulent</option>
                            <option value="Poorly Classified">Poorly Classified</option>
                            <option value="Misleading">Misleading</option>
                            <option value="Offensive">Offensive</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control-input" name="comment" rows="5" placeholder="Comment..." required></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" class="form-control-submit-button">Submit</button>
                    </div>
                </form>
            </div>
            <!-- end of col -->
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