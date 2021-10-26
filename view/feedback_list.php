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

if (isset($_POST['deleteFeedback'])) {
    require_once "../controller/admin_controller.php";
    $adminController = new AdminController();
    $id = $_POST['feedbackID'];
    $adminController->deleteFeedback($id);
}elseif (isset($_POST['deleteReport'])) {
    require_once "../controller/admin_controller.php";
    $adminController = new AdminController();
    $id = $_POST['reportID'];
    $adminController->deleteReport($id);
} else {
    $allFeedbacks = array();
    $allFeedbacks = $ac->getAllFeedback();

    $allReports = array();
    $allReports = $ac->getAllReport();
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
                    <h1>All Feedbacks</h1>
                </div>
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </header>
    <!-- end of header -->

    <div class="container mt-5">
        <h3><i class="fa fa-comment" aria-hidden="true"></i> Feedbacks</h3>
        <div class="mb-5 mt-4" style="min-height: 300px;">
            <?php
            if (count($allFeedbacks) < 1) {
                echo "<h6 class='mt-5'>No result found yet.</h6> <small>All feedback made by user will be appeared here.</small>";
            } else {
                echo "<table class='table'>";
                echo "      <thead>";
                echo "        <tr>";
                echo "            <th scope='col'>ID</th>";
                echo "            <th scope='col'>User</th>";
                echo "            <th scope='col'>Rating</th>";
                echo "            <th scope='col'>Comment</th>";
                echo "            <th scope='col'>Date</th>";
                echo "            <th scope='col'>Action</th>";
                echo "        </tr>";
                echo "      </thead>";
                echo "      <tbody>";
                foreach ($allFeedbacks as $feedback) {
                    echo "        <tr>";
                    echo "          <td scope=\"row\">$feedback->id</td>";
                    echo "          <td scope=\"row\">$feedback->username</td>";
                    echo "          <td scope=\"row\">$feedback->rating</td>";
                    echo "          <td scope=\"row\">$feedback->comment</td>";
                    echo "          <td scope=\"row\">$feedback->date</td>";
                    createDeleteFeedbackButton("feedbackID", $feedback->id, "<i class='fa fa-trash' aria-hidden='true'></i>");
                    echo "        </tr>";
                }
                echo "      </tbody>";
                echo "</table>";
                unset($allFeedbacks);
            }
            function createDeleteFeedbackButton($hiddenName, $id, $buttonText)
            {
                echo "<td>";
                echo "<form method=\"POST\">";
                echo "<input type=\"hidden\" name=$hiddenName value=$id>";
                echo "<button name=\"deleteFeedback\" type=\"submit\" class=\"btn btn-danger btn-sm\" onclick=\"return confirm('Are you sure you want to delete this feedback?')\" >$buttonText</button>";
                echo "</form>";
                echo "</td>";
            }
            ?>
        </div>
    </div>
    <div class="container mt-5">
        <h3><i class="fa fa-info-circle" aria-hidden="true"></i> Reports</h3>
        <div class="mb-5 mt-4" style="min-height: 300px;">
            <?php
            if (count($allReports) < 1) {
                echo "<h6 class='mt-5'>No result found yet.</h6> <small>All report made by user will be appeared here.</small>";
            } else {
                echo "<table class='table'>";
                echo "      <thead>";
                echo "        <tr>";
                echo "            <th scope='col'>ID</th>";
                echo "            <th scope='col'>User</th>";
                echo "            <th scope='col'>Type</th>";
                echo "            <th scope='col'>MatchID</th>";
                echo "            <th scope='col'>Reason</th>";
                echo "            <th scope='col'>Comment</th>";
                echo "            <th scope='col'>Date</th>";
                echo "            <th scope='col'>Action</th>";
                echo "        </tr>";
                echo "      </thead>";
                echo "      <tbody>";
                foreach ($allReports as $report) {
                    echo "        <tr>";
                    echo "          <td scope=\"row\">$report->id</td>";
                    echo "          <td scope=\"row\">$report->username</td>";
                    echo "          <td scope=\"row\">$report->type</td>";
                    echo "          <td scope=\"row\">$report->matchID</td>";
                    echo "          <td scope=\"row\">$report->reason</td>";
                    echo "          <td scope=\"row\">$report->comment</td>";
                    echo "          <td scope=\"row\">$report->date</td>";
                    createDeleteReportButton("reportID", $report->id, "<i class='fa fa-trash' aria-hidden='true'></i>");
                    echo "        </tr>";
                }
                echo "      </tbody>";
                echo "</table>";
                unset($allReports);
            }
            function createDeleteReportButton($hiddenName, $id, $buttonText)
            {
                echo "<td>";
                echo "<form method=\"POST\">";
                echo "<input type=\"hidden\" name=$hiddenName value=$id>";
                echo "<button name=\"deleteReport\" type=\"submit\" class=\"btn btn-danger btn-sm\" onclick=\"return confirm('Are you sure you want to delete this report?')\" >$buttonText</button>";
                echo "</form>";
                echo "</td>";
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