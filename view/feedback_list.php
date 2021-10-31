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
                foreach ($allFeedbacks as $feedback) {
                    $rating = str_repeat("⭐", $feedback->rating);
                    echo <<< END
                        <div class="job-card">
                            <div class="card border-0 mb-5">
                                <div class="card-body">
                                    <div class="row d-flex align-items-center">
                                        <div class="col text-start">
                                            <p class="ms-1"><span class="badge bg-secondary">ID: &nbsp;$feedback->id</span></p>
                                            <h4 style="font-size: 30px; font-weight: lighter;" class="text-start">$rating</h4>
                                            <p class="card-text"><i class="fa fa-comment" aria-hidden="true"></i>&nbsp; $feedback->comment</p>
                                            <small class="card-text text-success"><i class="fa fa-user" aria-hidden="true"></i>&nbsp; $feedback->username</small>
                                            <br>
                                            <small class="card-text"><i class="fa fa-clock" aria-hidden="true"></i>&nbsp; $feedback->date</small>
                                            <br><br>
                                        </div>
                                        <div class="col-2 text-end">
                                            <form method="POST">
                                                <input type="hidden" name="feedbackID" value=$feedback->id>
                                                <button name="deleteFeedback" type="submit" class="btn btn-danger-sm" onclick="return confirm('Are you sure you want to delete this feedback?')"><i class='fa fa-trash' aria-hidden='true'></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    END;
                }
                unset($allFeedbacks);
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
                foreach ($allReports as $report) {
                    echo <<< END
                        <div class="job-card">
                            <div class="card border-0 mb-5">
                                <div class="card-body">
                                    <div class="row d-flex align-items-center">
                                        <div class="col text-start">
                                            <p class="ms-1"><span class="badge bg-secondary">ID: &nbsp;$report->id</span></p>
                                            <h4 style="font-size: 30px; font-weight: lighter;" class="text-start">$report->reason</h4>
                                            <p class="card-text"><i class="fa fa-comment" aria-hidden="true"></i>&nbsp; $report->comment</p>
                                            <small class="card-text text-success"><i class="fa fa-user" aria-hidden="true"></i>&nbsp; $report->username</small>
                                            <br>
                                            <small class="card-text"><i class="fa fa-clock" aria-hidden="true"></i>&nbsp; $report->date</small>
                                            <br><br>
                                        </div>
                                        <div class="col-2 text-end">
                                            <form method="POST">
                                                <input type="hidden" name="reportID" value=$report->id>
                                                <button name="deleteReport" type="submit" class="btn btn-danger-sm" onclick="return confirm('Are you sure you want to delete this report?')"><i class='fa fa-trash' aria-hidden='true'></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    END;
                }
                unset($allReports);
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