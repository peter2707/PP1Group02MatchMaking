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
    $salary = $_POST['salary'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];
    $location = $_POST['location'];
    $type = $_POST['type'];
    $contact = $_POST['contact'];

    $mmc->postJob(ucfirst($position), $salary, $type, $description, $requirements, $location, $sc->getUserName(), $contact);
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
            <div class="row">
                <p style="color: red;">
                    <?php
                    // Error messages
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "emptyinput") {
                            echo "Please complete all required columns!";
                        }elseif($_GET["error"] == "notanumber"){
                            echo "Contact must be a number!";
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
                        }
                    }
                    ?>
                </p>
                <div class="col-8 text-start">
                    <h1>Your Posts</h1>
                </div>
                <div class="col-4 text-end">
                    <button id="newPostBtn" style="width:100px;" class="btn btn-primary btn-lg" type="submit" onclick="showNewPostForm()"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                </div>
                <div class="col-md-4 offset-md-4">
                    <form method="POST" id="newpost">
                        <div class="form-floating mb-3">
                            <input disabled type="text" class="form-control" id="positionInput" placeholder="Position" name="position" required>
                            <label for="positionInput">Position</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select disabled class="form-select mb-3" aria-label=".form-select-lg example" id="match-salary-field" name="salary">
                                <option disabled selected>Choose...</option>
                                <option value="25-30">$25-$30/hr</option>
                                <option value="30-35">$30-$35/hr</option>
                                <option value="35-40">$35-$40/hr</option>
                                <option value="40-45">$40-$45/hr</option>
                                <option value="45-50">$45-$50/hr</option>
                                <option value="50-55">$50-$55/hr</option>
                                <option value="55-60">$55-$60/hr</option>
                                <option value="60-more">$60/hr or more</option>
                            </select>
                            <label for="match-salary-field">Salary Range</label>
                        </div>
                        <div class="form-group mb-3">
                            <textarea disabled class="form-control" id="descriptionTextArea" placeholder="Description" name="description" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <textarea disabled class="form-control" id="requirementsTextArea" placeholder="Requirements" name="requirements" rows="3"></textarea>
                        </div>
                        <div class="form-floating mb-3">
                            <select disabled class="form-select mb-3" aria-label=".form-select-lg example" id="job-type-field" name="type">
                                <option disabled selected>Choose...</option>
                                <option value="fulltime">Full time</option>
                                <option value="partime">Part time</option>
                                <option value="casual">Casual</option>
                                <option value="contract">Contract</option>
                            </select>
                            <label for="job-type-field">Job Type</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select disabled class="form-select mb-3" aria-label=".form-select-lg example" id="match-location-field" name="location">
                                <option disabled selected>Choose...</option>
                                <option value="nsw">New South Wales</option>
                                <option value="qld">Queensland</option>
                                <option value="nt">Northern Territory</option>
                                <option value="wa">Western Australia</option>
                                <option value="sa">South Australia</option>
                                <option value="vic">Victoria</option>
                                <option value="act">Australian Capital Territory</option>
                                <option value="tas">Tasmania</option>
                            </select>
                            <label for="match-location-field">Location</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input disabled type="tel" class="form-control" id="contactInput" placeholder="Contact" name="contact" pattern="^(\+?\(61\)|\(\+?61\)|\+?61|\(0[1-9]\)|0[1-9])?( ?-?[0-9]){7,9}$" title="Must have phone number format and at least 7 characters long" required>
                            <label for="contactInput">Contact</label>
                        </div>
                        <button disabled class="btn btn-success btn-lg mt-1 w-100 fw-bolder" type="submit" id="postBtn" name="post">Post</button>
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
        if(count($jobposts) < 1){
            echo "<h3>You don't have any post yet.</h3> <small>To make a new post, click on the <i class='fa fa-paper-plane' aria-hidden='true'></i> button and fill in the job details</small>";
        }else{
            function createOpenButton($hiddenName, $hiddenValue, $buttonText, $actionPage){
                echo "<td>";
                echo "  <form action=$actionPage method=\"GET\">";
                echo "      <input type=\"hidden\" name=$hiddenName value=$hiddenValue>";
                echo "      <button type=\"submit\" class=\"btn btn-primary\">$buttonText</button>";
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
                createOpenButton('open', $post->id, 'Open', 'post.php');
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