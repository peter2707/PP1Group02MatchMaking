<?php
require_once '../controller/matchmaking_controller.php';
require_once '../controller/session_controller.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$mmc = new MatchmakingController();
$sc = new SessionController();

if (isset($_POST['post'])) {
    $position = $_POST['position'];
    $field = $_POST['field'];
    $salary = $_POST['salary'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];
    $location = $_POST['location'];
    $type = $_POST['type'];
    $contact = $_POST['contact'];

    $mmc->postJob(ucfirst($position), $field, $salary, $type, $description, $requirements, $location, $sc->getUserName(), $contact);
}else{
    $jobposts = array();
    $jobposts = $mmc->getJobPostsByEmployer($sc->getUserName());
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | Post</title>
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
            <div class="row col-xl-10 offset-xl-1">
                <div class="col-8 text-start">
                    <h1>Your Posts</h1>
                </div>
                <div class="col-4 text-end">
                    <button id="newPostBtn" style="width:120px;" class="btn btn-solid-lg" type="submit" onclick="showNewPostForm()"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                </div>

                <div class="col-xl-10 offset-xl-1">
                    <form method="POST" id="newpost">
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input disabled type="text" class="form-control" id="positionInput" placeholder="Position" name="position" pattern='^[a-zA-Z, ]+$' title='Must contain only letters' required>
                                    <label for="positionInput">Position</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <select class="form-select mb-3" aria-label=".form-select-lg example" id="fieldOfExpertise-form" name="field" required>
                                        <option disabled selected value="">Choose...</option>
                                    </select>
                                    <label for="fieldOfExpertise-form">Job Field</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <select disabled class="form-select mb-3" aria-label=".form-select-lg example" id="salary-field" name="salary" required>
                                        <option disabled selected value="">Choose...</option>
                                    </select>
                                    <label for="salary-field">Salary Range</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <textarea class="form-control" id="descriptionTextArea" placeholder="Description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <textarea class="form-control" id="requirementsTextArea" placeholder="Requirements" name="requirements" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <select disabled class="form-select mb-3" aria-label=".form-select-lg example" id="job-type-field" name="type" required>
                                        <option disabled selected value="">Choose...</option>
                                    </select>
                                    <label for="job-type-field">Job Type</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <select disabled class="form-select mb-3" aria-label=".form-select-lg example" id="location-field" name="location" required>
                                        <option disabled selected value="">Choose...</option>
                                    </select>
                                    <label for="location-field">Location</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input disabled type="email" class="form-control" id="contactInput" placeholder="Contact" name="contact" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" title="Must contain email format E.g. johndoe@mail.com" required>
                                    <label for="contactInput">Contact Email</label>
                                </div>
                            </div>
                        </div>



                        <button disabled class="btn btn-success-lg mt-1 w-100 fw-bolder" type="submit" id="postBtn" name="post">Post</button>
                    </form>
                </div>
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header> <!-- end of ex-header -->
    <!-- end of header -->



    <div class="col-md-6 offset-md-3 mt-5 mb-5" style="min-height: 400px;">
        <?php
        // Error messages
        if (isset($_GET["error"])) {
            echo "<h5><span class='mb-5 badge bg-danger'>";
            if ($_GET["error"] == "emptyinput") {
                echo "Please complete all required columns!";
            } else if ($_GET["error"] == "fieldnotfound") {
                echo "You have to choose a field of expertise";
            } else if ($_GET["error"] == "positionnumeric") {
                echo "Position cannot be a number!";
            } else if ($_GET["error"] == "updatefailed") {
                echo "There was a problem while trying to update.";
            } else if ($_GET["error"] == "deletefailed") {
                echo "There was a problem while trying to delete.";
            } else if ($_GET["error"] == "errordeny") {
                echo "There was a problem while trying to deny the match.";
            } else if ($_GET["error"] == "samevalue") {
                echo "You didn't make any changes.";
            }
            echo "</span></h5>";
        } elseif (isset($_GET["success"])) {
            echo "<h5><span class='mb-5 badge bg-success'>";
            if ($_GET["success"] == "posted") {
                echo "You have posted a new job! You can view it in the table below.";
            } elseif ($_GET["success"] == "updated") {
                echo "Your post have been updated successfully.";
            } elseif ($_GET["success"] == "deleted") {
                echo "Your post have been deleted successfully.";
            } elseif ($_GET["success"] == "denied") {
                echo "Match denied successfully";
            }
            echo "</span></h5>";
        }
        
        if (count($jobposts) < 1) {
            echo "<h3>You don't have any post yet.</h3> <small>To make a new post, click on the <i class='fa fa-paper-plane' aria-hidden='true'></i> button and fill in the job details</small>";
        } else {
            foreach ($jobposts as $post) {
                $badge = "badge bg-primary";
                if ($post->type == "Full Time") {
                    $badge = "badge bg-success";
                } elseif ($post->type == "Part Time") {
                    $badge = "badge bg-primary";
                } elseif ($post->type == "Casual") {
                    $badge = "badge bg-warning";
                } elseif ($post->type == "Contract") {
                    $badge = "badge bg-danger";
                }
                echo <<< END
                    <div class="job-card">
                        <div class="card border-0 mb-5">
                            <div class="card-body">
                                <div class="row d-flex align-items-center">
                                    <div class="col text-start">
                                        <small class="ms-1"><span class="$badge">$post->type</span></small>
                                        <h4 style="font-size: 30px; font-weight: lighter;" class="text-start">$post->position</h4>
                                        <p class="card-text"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp; $post->location &nbsp;&nbsp; <i style="font-size: 20px" class="bi bi-cash"></i>&nbsp; $post->salary</p>
                                        <small class="card-text text-success"><i class="fa fa-users" aria-hidden="true"></i>&nbsp; Match: $post->matches time(s)</small>
                                        <br>
                                        <small class="card-text"><i class="fa fa-clock" aria-hidden="true"></i>&nbsp; $post->date</small>
                                    </div>
                                    <div class="col text-end">
                                        <form action="employer_view_post.php" method="GET">
                                            <input type="hidden" name="id" value=$post->id>
                                            <button type="submit" class="btn btn-solid-lg">View</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                END;
            }
            unset($jobposts);
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