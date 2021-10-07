<?php
if (isset($_POST['post'])) {
    require_once '../controller/matchmaking_controller.php';
    require_once '../controller/session_controller.php';
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $mmc = new MatchmakingController();
    $sc = new SessionController();

    $position = $_POST['position'];
    $field = $_POST['field'];
    $salary = $_POST['salary'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];
    $location = $_POST['location'];
    $type = $_POST['type'];
    $contact = $_POST['contact'];

    $mmc->postJob(ucfirst($position), $field, $salary, $type, $description, $requirements, $location, $sc->getUserName(), $contact);
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
                <p style="color: red;">
                    <?php
                    // Error messages
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "emptyinput") {
                            echo "Please complete all required columns!";
                        }else if ($_GET["error"] == "fieldnull") {
                            echo "You have to choose a field of expertise";
                        }else if ($_GET["error"] == "positionnumeric") {
                            echo "Position cannot be a number!";
                        }else if ($_GET["error"] == "errorupdate") {
                            echo "There was a problem while trying to update.";
                        }else if ($_GET["error"] == "errordelete") {
                            echo "There was a problem while trying to delete.";
                        }else if ($_GET["error"] == "samevalue") {
                            echo "You didn't make any changes.";
                        }
                    }
                    ?>
                </p>
                <p style="color: #4BB543;">
                    <?php
                    // Account created message
                    if (isset($_GET["success"])) {
                        if ($_GET["success"] == "posted") {
                            echo "You have posted a new job! You can view it in the table below.";
                        }elseif ($_GET["success"] == "successupdate") {
                            echo "Your post have been updated successfully.";
                        }elseif ($_GET["success"] == "successdelete") {
                            echo "Your post have been deleted successfully.";
                        }elseif ($_GET["success"] == "successdeny") {
                            echo "Match denied successfully";
                        }
                    }
                    ?>
                </p>
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
                                    <input disabled type="text" class="form-control" id="positionInput" placeholder="Position" name="position" required>
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
                                    <select disabled class="form-select mb-3" aria-label=".form-select-lg example" id="match-salary-field" name="salary" required>
                                        <option disabled selected value="">Choose...</option>
                                        <option value="$25-$30/hr">$25-$30/hr</option>
                                        <option value="$30-$35/hr">$30-$35/hr</option>
                                        <option value="$35-$40/hr">$35-$40/hr</option>
                                        <option value="$40-$45/hr">$40-$45/hr</option>
                                        <option value="$45-$50/hr">$45-$50/hr</option>
                                        <option value="$50-$55/hr">$50-$55/hr</option>
                                        <option value="$55-$60/hr">$55-$60/hr</option>
                                        <option value="$60/hr or more">$60/hr or more</option>
                                    </select>
                                    <label for="match-salary-field">Salary Range</label>
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
                                        <option value="Full Time">Full Time</option>
                                        <option value="Part Time">Part Time</option>
                                        <option value="Casual">Casual</option>
                                        <option value="Contract">Contract</option>
                                    </select>
                                    <label for="job-type-field">Job Type</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <select disabled class="form-select mb-3" aria-label=".form-select-lg example" id="match-location-field" name="location" required>
                                        <option disabled selected value="">Choose...</option>
                                        <option value="New South Wales">New South Wales</option>
                                        <option value="Queensland">Queensland</option>
                                        <option value="Northern Territory">Northern Territory</option>
                                        <option value="Western Australia">Western Australia</option>
                                        <option value="South Australia">South Australia</option>
                                        <option value="Victoria">Victoria</option>
                                        <option value="Australian Capital Territory">Australian Capital Territory</option>
                                        <option value="Tasmania">Tasmania</option>
                                    </select>
                                    <label for="match-location-field">Location</label>
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



    <div class="col-md-6 offset-md-3 mt-5 mb-5" style="min-height: 200px;">
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
        $jobposts = array();
        $jobposts = $mmc->getJobPosts($sc->getUserName());
        if (count($jobposts) < 1) {
            echo "<h3>You don't have any post yet.</h3> <small>To make a new post, click on the <i class='fa fa-paper-plane' aria-hidden='true'></i> button and fill in the job details</small>";
        } else {
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
            echo "                    <th scope='col'>Type</th>";
            echo "                    <th scope='col'>Location</th>";
            echo "                    <th scope='col'>Matches</th>";
            echo "                    <th scope='col'></th>";
            echo "                </tr>";
            echo "            </thead>";
            echo "            <tbody>";
            foreach ($jobposts as $post) {
                echo "                <tr>";
                echo "                    <td scope='row'>$post->position</td>";
                echo "                    <td scope='row'>$post->salary</td>";
                echo "                    <td scope='row'>$post->type</td>";
                echo "                    <td scope='row'>$post->location</td>";
                echo "                    <td scope='row'>$post->matches times</td>";
                createOpenButton('id', $post->id, 'Open', 'employer_view_post.php');
                echo "                </tr>";
            }
            echo "            </tbody>";
            echo "            </table>";
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