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

if (isset($_POST["exportJobSeeker"])) {
    $ac->generateReport("jobseeker");
} elseif (isset($_POST["exportEmployer"])) {
    $ac->generateReport("employer");
} elseif (isset($_POST["exportAdmin"])) {
    $ac->generateReport("admin");
} elseif (isset($_POST["exportJobPost"])) {
    $ac->generateReport("jobpost");
} elseif (isset($_POST["exportJobMatch"])) {
    $ac->generateReport("jobmatch");
} elseif (isset($_POST["exportReport"])) {
    $ac->generateReport("report");
} else {
    $allAdmins = array();
    $allAdmins = $ac->getAllAdmin();

    $allJobSeekers = array();
    $allJobSeekers = $ac->getAllJobSeeker();

    $allEmployers = array();
    $allEmployers = $ac->getAllEmployer();

    $allJobMatches = array();
    $allJobMatches = $ac->getAllJobMatch();

    $allJobPosts = array();
    $allJobPosts = $ac->getAllJobPost();

    $allReports = array();
    $allReports = $ac->getAllReport();

    $allFeedbacks = array();
    $allFeedbacks = $ac->getAllFeedback();

    $good = 0;
    $bad = 0;
    foreach ($allFeedbacks as $feedback) {
        if ($feedback->rating > 2) {
            $good++;
        } else {
            $bad++;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | Admin</title>
    <?php
    require_once("component/header.php");
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
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
            <div class="row">
                <div class="col-xl-10 offset-xl-1 mb-5">
                    <h1>Admin Home</h1>
                    <?php
                    // Error messages
                    if (isset($_GET["error"])) {
                        echo "<h5><span class='mb-2 mt-5 badge bg-danger'>";
                        if ($_GET["error"] == "emptyusername") {
                            echo "You must enter a valid username!";
                        } else if ($_GET["error"] == "emptypassword") {
                            echo "You must enter a valid password!";
                        } else if ($_GET["error"] == "failed") {
                            echo "Something went wrong. Please try again!";
                        } else if ($_GET["error"] == "deletefailed") {
                            echo "There was a problem while trying to delete.";
                        } else if ($_GET["error"] == "updatefailed") {
                            echo "There was a problem while trying to update.";
                        } else if ($_GET["error"] == "dbnull") {
                            echo "There are no data to generate.";
                        } else if ($_GET["error"] == "fieldnotfound") {
                            echo "You have to choose a field of expertise";
                        } else if ($_GET["error"] == "positionnotfound") {
                            echo "You have to enter a position";
                        }
                        echo "</span></h5>";
                    } elseif (isset($_GET["success"])) {
                        echo "<h5><span class='mb-2 mt-5 badge bg-success'>";
                        if ($_GET["success"] == "created") {
                            echo "Account has been successfully created.";
                        } elseif ($_GET["success"] == "deleted") {
                            echo "Successfully deleted.";
                        } elseif ($_GET["success"] == "updated") {
                            echo "Successfully updated.";
                        }
                        echo "</span></h5>";
                    }
                    ?>
                </div>

                <div class="row col-md-6 offset-md-3 mb-5">
                    <div class="col">
                        <a style="text-decoration : none" href="admin_add_user.php" class="mb-4 w-100 btn btn-success-lg"><i class="fa fa-user-plus" aria-hidden="true"></i> &nbsp;Add User</a>
                    </div>
                    <div class="col">
                        <button data-bs-toggle="modal" data-bs-target="#generateReportModal" class="mb-4 w-100 btn btn-solid-lg"><i class="fa fa-file" aria-hidden="true"></i> &nbsp;Generate Report</button>

                        <!-- Modal -->
                        <div class="modal fade" id="generateReportModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="profileModalLabel">Generate Report</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="mb-3"><small id="message">Choose a table to generate to CSV File</small></div>
                                            <form method="POST">
                                                <div class="row">
                                                    <div class="col"><button type="submit" name="exportJobSeeker" class="btn btn-success-sm">JobSeeker</button></div>
                                                    <div class="col"><button type="submit" name="exportEmployer" class="btn btn-success-sm">Employer</button></div>
                                                    <div class="col"><button type="submit" name="exportAdmin" class="btn btn-success-sm">Admin</button></div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col"><button type="submit" name="exportJobPost" class="btn btn-solid-sm">JobPost</button></div>
                                                    <div class="col"><button type="submit" name="exportJobMatch" class="btn btn-solid-sm">JobMatch</button></div>
                                                    <div class="col"><button type="submit" name="exportReport" class="btn btn-solid-sm">Report</button></div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary-sm" data-bs-dismiss="modal">Done</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col">
                        <div class="card">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-8 text-start">
                                        <h4 class="text-primary ms-4 mt-2"><?php echo count($allJobSeekers); ?></h4>
                                        <h6 class="text-muted m-b-0 ms-4">JobSeekers</h6>
                                    </div>
                                    <div class="col-4 text-end">
                                        <i class="fa fa-user fa-2x mx-4 mt-4" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-8 text-start">
                                        <h4 class="text-warning ms-4 mt-2"><?php echo count($allEmployers); ?></h4>
                                        <h6 class="text-muted m-b-0 ms-4">Employers</h6>
                                    </div>
                                    <div class="col-4 text-end">
                                        <i class="fa fa-address-card fa-2x mx-4 mt-4" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-8 text-start">
                                        <h4 style="color:#8E44AD" class="ms-4 mt-2"><?php echo count($allJobPosts); ?></h4>
                                        <h6 class="text-muted m-b-0 ms-4">JobPosts</h6>
                                    </div>
                                    <div class="col-4 text-end">
                                        <i class="fa fa-paper-plane fa-2x mx-4 mt-4" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-8 text-start">
                                        <h4 class="text-success ms-4 mt-2"><?php echo count($allJobMatches); ?></h4>
                                        <h6 class="text-muted m-b-0 ms-4">JobMatches</h6>
                                    </div>
                                    <div class="col-4 text-end">
                                        <i class="fa fa-lightbulb fa-2x mx-4 mt-4" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of row -->
            <div class="main-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-title mt-3">
                                <h5>Total Number of Users</h5>
                            </div>
                            <div class="card-body">
                                <?php
                                if (
                                    count($allJobSeekers) < 1 &&
                                    count($allEmployers) < 1 &&
                                    count($allJobPosts) < 1 &&
                                    count($allJobMatches) < 1 &&
                                    count($allReports) < 1
                                ) {
                                    echo "<small>There are no info to display yet.</small>";
                                } else {
                                    echo "<canvas id='barChart'></canvas>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-title mt-3">
                                <h5>Comparison</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php
                                    if (
                                        count($allJobSeekers) < 1 &&
                                        count($allEmployers) < 1 &&
                                        count($allJobPosts) < 1 &&
                                        count($allJobMatches) < 1 &&
                                        count($allReports) < 1
                                    ) {
                                        echo "<small>There are no info to display yet.</small>";
                                    } else {
                                        echo "<div class='col'><canvas id='userPieChart'></canvas></div>
                                            <div class='col'><canvas id='jobPieChart'></canvas></div>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-title mt-3">
                                <h5>Feedbacks</h5>
                            </div>
                            <div class="card-body">
                                <?php
                                if ($good < 1 && $bad < 1) {
                                    echo "<small>There are no info to display yet.</small>";
                                } else {
                                    echo "<canvas id='doughnutChart'></canvas>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <ul class='list-group list-group-flush'>
                                <h5 class="text-center mt-3 mb-3">Team Members</h5>
                                <?php
                                if (count($allAdmins) < 1) {
                                    echo "<small>No result found yet.</small>";
                                } else {
                                    foreach ($allAdmins as $admin) {
                                        echo <<< END
                                        <li class="list-group-item flex-wrap">
                                            <div class="row">
                                                <div class="col-md-2 text-center"><img src='../images/user.png' alt='User' class='rounded-circle' width='25' height='25'></div>
                                                <div class="col-md-6 text-start">$admin->firstName $admin->lastName</div>
                                                <div class="col-md-4 text-end text-muted">$admin->position</div>
                                            </div>   
                                        </li>
                                        END;
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- end of container -->
    </header>
    <!-- end of header -->

    <script>
        new Chart(document.getElementById("barChart"), {
            type: 'bar',
            data: {
                labels: ["JobSeekers", "Employers", "JobPosts", "JobMatches", "Reports"],
                datasets: [{
                    label: "Total(Number)",
                    backgroundColor: ["#3e95cd", "#ffc04d", "#8e5ea2", "#3cba9f", "#c45850"],
                    data: [<?php echo count($allJobSeekers); ?>,
                        <?php echo count($allEmployers); ?>,
                        <?php echo count($allJobPosts); ?>,
                        <?php echo count($allJobMatches); ?>,
                        <?php echo count($allReports); ?>
                    ]
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            userCallback(label, index, labels) {
                                if (Math.floor(label) === label) { // only show if whole number
                                    return label;
                                }
                            },
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    </script>

    <script>
        new Chart(document.getElementById("doughnutChart"), {
            type: 'doughnut',
            data: {
                labels: ["Equal or more than 3 stars", "Less than 3 stars"],
                datasets: [{
                    backgroundColor: ["#3cba9f", "#c45850"],
                    data: [<?php echo $good; ?>, <?php echo $bad; ?>]
                }]
            },
            options: {
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                                return previousValue + currentValue;
                            });
                            var currentValue = dataset.data[tooltipItem.index];
                            var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                            return percentage + "%";
                        }
                    }
                }
            }
        });
    </script>

    <script>
        new Chart(document.getElementById("userPieChart"), {
            type: 'pie',
            data: {
                labels: ["JobSeeker", "Employer"],
                datasets: [{
                    backgroundColor: ["#3e95cd", "#ffc04d"],
                    data: [<?php echo count($allJobSeekers); ?>,
                        <?php echo count($allEmployers); ?>
                    ]
                }]
            },
            options: {
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                                return previousValue + currentValue;
                            });
                            var currentValue = dataset.data[tooltipItem.index];
                            var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                            return percentage + "%";
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById("jobPieChart"), {
            type: 'pie',
            data: {
                labels: ["JobMatch", "JobPost"],
                datasets: [{
                    backgroundColor: ["#8e5ea2", "#3cba9f"],
                    data: [<?php echo count($allJobMatches); ?>,
                        <?php echo count($allJobPosts); ?>
                    ]
                }]
            },
            options: {
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                                return previousValue + currentValue;
                            });
                            var currentValue = dataset.data[tooltipItem.index];
                            var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                            return percentage + "%";
                        }
                    }
                }
            }
        });
    </script>

    <!-- footer start -->
    <?php
    require_once("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>