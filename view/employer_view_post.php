<?php
require_once '../controller/matchmaking_controller.php';
require_once '../controller/admin_controller.php';
require_once '../controller/session_controller.php';
// check if the session has not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// call controllers

$mmc = new MatchmakingController();
$sc = new SessionController();
$ac = new AdminController();

$id = $_GET['id'];

$jobpost = $mmc->getJobPostByID($id);
$userType = $sc->getUserType();

if (isset($_POST['update'])) {
    $position = $_POST['position'];
    $field = $_POST['field'];
    $salary = $_POST['salary'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];
    $location = $_POST['location'];
    $type = $_POST['type'];
    $contact = $_POST['contact'];
    if (
        $position == $jobpost->position && $field == $jobpost->field && $salary == $jobpost->salary
        && $description == $jobpost->description && $requirements == $jobpost->requirements
        && $location == $jobpost->location && $location == $jobpost->location
        && $type == $jobpost->type && $contact == $jobpost->contact
    ) {
        header("location: ../view/employer_post.php?error=samevalue");
    } else {
        if($sc->getUserType() == "admin"){
            $ac->updatePost($position, $field, $salary, $type, $description, $requirements, $location, $contact, $id);
        }else{
            $mmc->updatePost($position, $field, $salary, $type, $description, $requirements, $location, $contact, $id);
        }
    }
} elseif (isset($_POST['delete'])) {
    if($sc->getUserType() == "admin"){
        $ac->deletePost($id);
    }else{
        $mmc->deletePost($id, $sc->getUserType());
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | <?php echo "$jobpost->position"; ?></title>
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
                    <?php
                    if ($userType == "admin") {
                        echo "<p class='card-text'><b>ID:</b> $jobpost->id &nbsp;&nbsp;&nbsp; <b>Employer:</b> $jobpost->employer</p><h1>$jobpost->position</h1>";
                    }elseif($userType == "employer"){
                        echo "<h1>$jobpost->position</h1>";
                    }
                    ?>
                </div>
                <?php
                    if ($userType == "admin" || $userType == "employer") {
                        echo <<< END
                            <div class="row">
                                <div class="col text-start">
                                    <h6 class="text-muted"><i class='fa fa-certificate' aria-hidden='true'></i>&nbsp; $jobpost->field</h6>
                                    <p class="text-muted"><i class='fa fa-briefcase' aria-hidden='true'></i>&nbsp; $jobpost->type</p>
                                </div>
                                <div class="col text-end mt-4">
                                    <small><i class='fa fa-clock' aria-hidden='true'></i>&nbsp; $jobpost->date</small>
                                </div>
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col text-start"><small>Match: $jobpost->matches times</small></div>
                                <div class="col text-end">
                                    <form action='employer_view_matches.php' method='GET'>
                                        <input type='hidden' name='id' value='$id'>
                                        <button type='submit' class='btn btn-solid-lg'>Matches</button>
                                    </form>
                                </div>
                            </div>
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
        <!-- end of container -->
    </header>
    <!-- end of header -->

    <!-- Basic -->
    <div class="ex-basic-1 pt-4 mb-5">
        <div class="container">
            <div class="row">
                <?php
                    if($userType == "admin" || $userType == "employer"){
                        $description = htmlspecialchars_decode($jobpost->description);
                        $requirements = htmlspecialchars_decode($jobpost->requirements);
                        echo <<< END
                            <div class="col-xl-10 offset-xl-1 text-start">
                                <form method="POST">
                                    <div class="row">
                                        <div class="col">
                                            <h3 class="mb-3">Position</h3>
                                            <hr>
                                        </div>
                                        <div class="col">
                                            <h3 class="mb-3">Field</h3>
                                            <hr>
                                        </div>
                                        <div class="col">
                                            <h3 class="mb-3">Salary</h3>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type='text' class='form-control' id='positionInput' placeholder='Position' name=' position' pattern='^[a-zA-Z, ]+$' title='Must contain only letters' value='$jobpost->position' required>
                                                <label for="positionInput">Position</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <select class="form-select mb-3" aria-label=".form-select-lg example" id="fieldOfExpertise-form" name="field" required>
                                                    <option readonly selected value='$jobpost->field'>$jobpost->field</option>
                                                </select>
                                                <label for="fieldOfExpertise-form">Job Field</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <select class="form-select mb-3" aria-label=".form-select-lg example" id="salary-field" name="salary" required>
                                                    <option readonly selected value='$jobpost->salary'>$jobpost->salary</option>
                                                </select>
                                                <label for="salary-field">Salary Range</label>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="form-group mb-3">
                                        <h3 class="mb-3">Job Description</h3>
                                        <hr>
                                        <textarea class="form-control" id="descriptionTextArea" placeholder="Description" name="description" rows="3" required>
                                            $description
                                        </textarea>
                                    </div><br>
                                    <div class="form-group mb-3">
                                        <h3 class="mb-3">Job Requirements</h3>
                                        <hr>
                                        <textarea class="form-control" id="requirementsTextArea" placeholder="Requirements" name="requirements" rows="3" required>
                                            $requirements
                                        </textarea>
                                    </div><br>
                                    <div class="row">
                                        <div class="col">
                                            <h3 class="mb-3">Type</h3>
                                            <hr>
                                        </div>
                                        <div class="col">
                                            <h3 class="mb-3">Location</h3>
                                            <hr>
                                        </div>
                                        <div class="col">
                                            <h3 class="mb-3">Email</h3>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <select class="form-select mb-3" aria-label=".form-select-lg example" id="job-type-field" name="type" required>
                                                    <option readonly selected value='$jobpost->type'>$jobpost->type</option>
                                                </select>
                                                <label for="job-type-field">Job Type</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <select class="form-select mb-3" aria-label=".form-select-lg example" id="location-field" name="location" required>
                                                    <option readonly selected value='$jobpost->location'>$jobpost->location</option>
                                                </select>
                                                <label for="location-field">Location</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type='email' value='$jobpost->contact' class='form-control' id='contactInput' placeholder='Contact' name='contact' pattern='[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}' title='Must contain email format E.g. johndoe@mail.com' required>
                                                <label for="contactInput">Contact Email</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-end">
                                            <button class="btn btn-danger-sm mt-1 w-50 fw-bolder" type="submit" name="delete" onclick="javascript:return confirm('Are you sure you want to delete your post?');"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                        </div>
                                        <div class="col text-start">
                                            <button class="btn btn-success-sm mt-1 w-50 fw-bolder" type="submit" name="update"><i class="fa fa-check" aria-hidden="true"></i> Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        END;
                    }
                ?>
                <!-- end of col -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </div>
    <!-- end of ex-basic-1 -->
    <!-- end of basic -->


    <!-- footer start -->
    <?php
    require_once("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>