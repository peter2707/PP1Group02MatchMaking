<?php
// check if the session has not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// require files
require_once '../controller/session_controller.php';
require_once '../controller/user_controller.php';
require_once '../controller/matchmaking_controller.php';

// call controllers
$sessionController = new SessionController();
$userController = new UserController();
$matchmakingController = new MatchmakingController();

// get current user session
$validSession = $sessionController->checkSession();
$userType = $sessionController->getUserType();
$username = $sessionController->getUserName();

if (isset($_POST['done'])) {
    $linkedin = $_POST['linkedin'];
    $github = $_POST['github'];
    $twitter = $_POST['twitter'];
    $instagram = $_POST['instagram'];
    $facebook = $_POST['facebook'];
    $userController->editSocialLink($sessionController->getUserName(), $linkedin, $github, $twitter, $instagram, $facebook);
} elseif (isset($_POST['changeImage'])) {
    $input = $_FILES["image"]["tmp_name"];
    if (file_exists($input)) {
        $file = file_get_contents($input);
        $base64 = base64_encode($file);
        $userController->changeProfilePicture($base64, $sessionController->getUserName(), $sessionController->getUserType());
    } else {
        header("location: ../view/user_profile.php?error=imagenotfound");
    }
} elseif (isset($_POST['addResume'])) {
    $filename = $_FILES['resume']['name'];
    $file = $_FILES['resume']['tmp_name'];
    $destination = '../images/pdf/' . $sessionController->getUserName() . '.pdf';
    if (move_uploaded_file($file, $destination)) {
        $userController->addResume($destination, $sessionController->getUserName());
    } else {
        header("location: ../view/user_profile.php?error=filenotfound");
    }
} elseif (isset($_POST['removeResume'])) {
    $resumeName = $_POST['resumeName'];
    $filepath = $_POST['filepath'];
    $userController->removeResume($resumeName, $filepath);
} elseif (isset($_POST['downloadResume'])) {
    $filepath = $_POST['filepath'];
    $filename = $_POST['filename'];
    $userController->downloadResume($filepath, $filename);
} elseif (isset($_POST['addSkill'])) {
    $skill = $_POST['skill'];
    $skillExp = $_POST['skillExp'];
    $userController->addSkill($sessionController->getUserName(), $skill, $skillExp);
} elseif (isset($_POST['deleteSkill'])) {
    $skillId = $_POST['deleteSkill'];
    $userController->deleteSkill($skillId, $sessionController->getUserName());
} elseif (isset($_POST['addEducation'])) {
    $institution = $_POST['institution'];
    $degree = $_POST['degree'];
    $graduation = $_POST['graduation'];
    $userController->addEducation($sessionController->getUserName(), $institution, $degree, $graduation);
} elseif (isset($_POST['deleteEducation'])) {
    $educationId = $_POST['deleteEducation'];
    $userController->deleteEducation($educationId, $sessionController->getUserName());
} elseif (isset($_POST['addCareer'])) {
    $position = $_POST['position'];
    $company = $_POST['company'];
    $experience = $_POST['experience'];
    $userController->addCareer($sessionController->getUserName(), $position, $company, $experience);
} elseif (isset($_POST['deleteCareer'])) {
    $careerId = $_POST['deleteCareer'];
    $userController->deleteCareer($careerId, $sessionController->getUserName());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | User</title>
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

    <?php
    if ($validSession) {
        $user = $userController->getUser($userType, $username);
        $social = $userController->getSocialLink($user->username);

        $userImage = $user->image;
        if ($user->image == NULL) {
            $defaultImage = file_get_contents("../images/user.png");
            $userImage = base64_encode($defaultImage);
        }
        if ($userType == "jobseeker") {
            $skills = array();
            $educations = array();
            $careers = array();

            $resume = $userController->getResume($user->username);
            $skills = $userController->getSkills($user->username);
            $educations = $userController->getEducations($user->username);
            $careers = $userController->getCareers($user->username);

            echo <<<END
                <!-- User Profile section start -->
                <header class="ex-header">
                    <div class="container">
            END;
            if (isset($_GET["error"])) {
                echo "<h5><span class='mb-2 badge bg-danger'>";
                if ($_GET["error"] == "failed") {
                    echo "Something went wrong. Please try again!";
                } else if ($_GET["error"] == "imagenotfound") {
                    echo "Please select an image.";
                }
                echo "</span></h5>";
            } elseif (isset($_GET["success"])) {
                echo "<h5><span class='mt-5 mb-2 badge bg-success'>";
                if ($_GET["success"] == "accountupdated") {
                    echo "Your account has been successfully Updated.";
                }
                echo "</span></h5>";
            }
            echo <<<END
                    <div class="main-body">
                        <div class="row gutters-sm">
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <img src="data:image/png;base64, $userImage" alt="User" class="rounded-circle" width="150" height="150">
                                            <div class="mt-3">
                                                <h4>$user->firstName $user->lastName</h4>
                                                <p class="text-secondary">$user->field </p>
                                                <button class="btn btn-solid-sm" data-bs-toggle="modal" data-bs-target="#profileModal">Change Picture</button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="profileModalLabel">Change profile picture</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form method="POST" enctype="multipart/form-data">
                                                                <div class="modal-body">
                                                                    <small id="message">Choose an image</small>
                                                                    <input type="file" class="form-control" id="image" name="image"/>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn-secondary-sm" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" name="changeImage" class="btn btn-solid-sm">Save changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-3">
                                    <ul class="list-group list-group-flush">
                                    <form method="POST">
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="row">
                                                <div class="col-5 text-start mt-2">
                                                    <h6 class="mb-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-linkedin icon-inline text-primary">
                                                        <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                                                        <rect x="2" y="9" width="4" height="12"></rect>
                                                        <circle cx="4" cy="4" r="2"></circle>
                                                    </svg>&nbsp; LinkedIn</h6>
                                                </div>
                                                <div class="col-7">
                                                    <input disabled type="text" id ="linkedinLink" name="linkedin" class="form-control" style="text-align:right;" value="$social->linkedin" required/>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="row">
                                                <div class="col-5 text-start mt-2">
                                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github mr-2 icon-inline">
                                                            <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                                                        </svg>&nbsp; Github</h6>
                                                </div>
                                                <div class="col-7">
                                                    <input disabled type="text" id ="githubLink" name="github" class="form-control" style="text-align:right;" value="$social->github" required/>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="row">
                                                <div class="col-5 text-start mt-2">
                                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter mr-2 icon-inline text-info">
                                                            <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                                                        </svg>&nbsp; Twitter</h6>
                                                </div>
                                                <div class="col-7">
                                                    <input disabled type="text" id ="twitterLink" name="twitter" class="form-control" style="text-align:right;" value="$social->twitter" required/>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="row">
                                                <div class="col-5 text-start mt-2">
                                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram mr-2 icon-inline text-danger">
                                                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                                        </svg>&nbsp; Instagram</h6>
                                                </div>
                                                <div class="col-7">
                                                    <input disabled type="text" id ="instagramLink" name="instagram" class="form-control" style="text-align:right;" value="$social->instagram" required/>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="row">
                                                <div class="col-5 text-start mt-2">
                                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook mr-2 icon-inline text-primary">
                                                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                                        </svg>&nbsp; Facebook</h6>
                                                </div>
                                                <div class="col-7">
                                                    <input disabled type="text" id ="facebookLink" name="facebook" class="form-control" style="text-align:right;" value="$social->facebook" required/>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col text-start">
                                                    <button type="submit" id="doneInputLink" class="btn btn-solid-sm w-100" name="done" style='display:none;'>Done</button>
                                                </div>
                                                <div class="col text-end">
                                                    <button type="button" id="editInputLink" class="btn-secondary-sm w-100" onclick="edit()"><i class='fas fa-edit'></i> Edit</button>
                                                    <button type="button" id="cancelInputLink" class="btn-secondary-sm w-100" style='display:none;' onclick="cancel()">Cancel</button>
                                                </div>
                                            </div>
                                        </li>
                                    </form>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row text-start ms-2 mx-2">
                                            <h2>Resume</h2>
            END;
            if ($resume) {
                $resumeName = $resume;
                while (str_contains($resumeName, "/")) {
                    $resumeName = substr($resumeName, strpos($resumeName, "/") + 1);
                }
                echo <<< END
                    <div class="col text-start mt-3 ms-3">
                        <form method="POST">
                            <input type="hidden" name="filepath" value="$resume">
                            <input type="hidden" name="filename" value="$resumeName">
                            <input type="hidden" name="resumeName" value="$user->username">
                            <button type="submit" name="downloadResume" onclick="javascript:return confirm('Download Resume?');" class="btn btn-secondary">$resumeName</button>
                            <button type="submit" name="removeResume" onclick="javascript:return confirm('Remove Resume?');" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                END;
            } else {
                echo <<< END
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row mt-3">
                            <div class="col text-start mt-1">
                                <input type="file" class="form-control" name="resume" accept=".pdf" required/>
                            </div>
                            <div class="col">
                                <button type="submit" name="addResume" class="btn btn-solid-sm mt-2">Submit</button>
                            </div>
                        </div>
                    </form>
                END;
            }
                echo <<<END
                </div>
                <hr>
                <div class="row text-start ms-2 mx-2 mb-5">
                    <div class="row mb-3 mt-3">
                        <div class="col text-start">
                            <h2>Skill</h2>
                        </div>
                        <div class="col text-end">
                            <button class="btn btn-solid-sm" data-bs-toggle="modal" data-bs-target="#skillModal"><i class="fa fa-plus" aria-hidden="true"></i></button>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="skillModal" tabindex="-1" aria-labelledby="skillModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="skillModalLabel">Add Skill</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="POST">
                                    <div class="modal-body">
                                        <div class="col-8 mb-2 offset-2"><input type="text" class="form-control" name="skill" placeholder="Skill" required/></div>
                                        <div class="col-8 mb-2 offset-2">
                                            <select class="form-select" aria-label=".form-select-lg example" id="skill-year-field" name="skillExp" required>
                                                <option selected disabled value="">Experience</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn-secondary-sm" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" name="addSkill" class="btn-success-sm mt-1">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                END;
            if (count($skills) < 1) {
                echo "<small class='text-center'><b>To add a skill</b>, click on the <i class='fa fa-plus' aria-hidden='true'></i> button</small>";
            } else {
                foreach ($skills as $skill) {
                    echo <<<END
                        <div class="col-4 text-center mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 style="font-weight: lighter;">$skill->skill</h5>
                                    <small><i class="fa fa-clock" aria-hidden="true"></i> $skill->experience</small>
                                    <form method="POST">
                                        <input type="hidden" name="deleteSkill" value="$skill->id">
                                        <button type="submit" onclick="javascript:return confirm('Remove Skill?');" class="btn btn-danger btn-sm mt-3"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    END;
                }
            }
            echo <<<END
                </div>
                <hr>
                <div class="row text-start ms-2 mx-2 mb-5">
                    <div class="row mb-3 mt-3">
                        <div class="col text-start">
                            <h2>Education</h2>
                        </div>
                        <div class="col text-end">
                            <button class="btn btn-solid-sm" data-bs-toggle="modal" data-bs-target="#educationModal"><i class="fa fa-plus" aria-hidden="true"></i></button>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="educationModal" tabindex="-1" aria-labelledby="educationModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="educationModalLabel">Add Education</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="POST">
                                    <div class="modal-body">
                                        <div class="col-8 mb-2 offset-2"><input type="text" class="form-control" name="institution" placeholder="Institution" required/></div>
                                        <div class="col-8 mb-2 offset-2"><input type="text" class="form-control" name="degree" placeholder="Degree" required/></div>
                                        <div class="col-8 mb-2 offset-2"><input id="calendar" class="form-control" name="graduation" required/></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn-secondary-sm" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" name="addEducation" class="btn-success-sm mt-1">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            END;
            if (count($educations) < 1) {
                echo "<small class='text-center'><b>To add an education</b>, click on the <i class='fa fa-plus' aria-hidden='true'></i> button</small>";
            } else {
                foreach ($educations as $education) {
                    echo <<<END
                        <div class="col-4 text-center mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 style="font-weight: lighter;">$education->degree</h5>
                                    <small><i class="fa fa-graduation-cap" aria-hidden="true"></i> $education->graduation</small>
                                    <p class="testimonial-text"><i class="fa fa-building" aria-hidden="true"></i> $education->institution</p>
                                    <form method="POST">
                                        <input type="hidden" name="deleteEducation" value="$education->id">
                                        <button type="submit" onclick="javascript:return confirm('Remove Education?');" class="btn btn-danger btn-sm mt-1"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    END;
                }
            }
            echo <<<END
                </div>
                <hr>
                <div class="row text-start ms-2 mx-2 mb-5">
                    <div class="row mb-3 mt-3">
                        <div class="col text-start">
                            <h2>Career History</h2>
                        </div>
                        <div class="col text-end">
                            <button class="btn btn-solid-sm" data-bs-toggle="modal" data-bs-target="#careerModal"><i class="fa fa-plus" aria-hidden="true"></i></button>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="careerModal" tabindex="-1" aria-labelledby="careerModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="careerModalLabel">Add Career</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="POST">
                                    <div class="modal-body">
                                        <div class="col-8 mb-2 offset-2"><input type="text" class="form-control" name="position" placeholder="Position" required/></div>
                                        <div class="col-8 mb-2 offset-2"><input type="text" class="form-control" name="company" placeholder="Company" required/></div>
                                        <div class="col-8 mb-2 offset-2">
                                            <select class="form-select" aria-label=".form-select-lg example" id="career-year-field" name="experience" required>
                                                <option selected disabled value="">Experience</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn-secondary-sm" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" name="addCareer" class="btn-success-sm mt-1">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            END;

            if (count($careers) < 1) {
                echo "<small class='text-center'><b>To add a career</b>, click on the <i class='fa fa-plus' aria-hidden='true'></i> button</small>";
            } else {
                foreach ($careers as $career) {
                    echo <<<END
                        <div class="col-4 text-center mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 style="font-weight: lighter;">$career->position</h5>
                                    <small><i class="fa fa-clock" aria-hidden="true"></i> $career->experience</small>
                                    <p class="testimonial-text"><i class="fa fa-building" aria-hidden="true"></i> $career->company</p>
                                    <form method="POST">
                                        <input type="hidden" name="deleteCareer" value="$career->id">
                                        <button type="submit" onclick="javascript:return confirm('Remove Career?');" class="btn btn-danger btn-sm mt-1"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    END;
                }
            }

        echo <<<END

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of container -->
            </header>
            <!-- User Profile section End -->

        END;
        } elseif ($userType == "employer") {
            $feedbacks = array();
            $feedbacks = $userController->getAllFeedback($user->username);
            $totalPosts = $matchmakingController->countJobPosts($sessionController->getUserName());
            $rating = number_format((float)$user->rating, 1, '.', '');
            $map = $userController->getMap($user->location);

            echo <<<END
                <!-- User Profile section start -->
                <header class="ex-header">
                    <div class="container">
            END;

            if (isset($_GET["error"])) {
                echo "<h5><span class='mb-2 badge bg-danger'>";
                if ($_GET["error"] == "failed") {
                    echo "Something went wrong. Please try again!";
                } else if ($_GET["error"] == "imagenotfound") {
                    echo "Please select an image.";
                }
                echo "</span></h5>";
            } elseif (isset($_GET["success"])) {
                echo "<h5><span class='mt-5 mb-2 badge bg-success'>";
                if ($_GET["success"] == "accountupdated") {
                    echo "Your account has been successfully Updated.";
                }
                echo "</span></h5>";
            }

            echo <<<END
                    <div class="main-body">
                        <div class="row gutters-sm">
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <img src="data:image/png;base64, $userImage" alt="Admin" class="rounded-circle" width="150" height="150">

                                            <div class="mt-3">
                                                <h4>$user->firstName $user->lastName</h4>
                                                <p class="text-secondary">$user->position</p>
                                                <button class="btn btn-solid-sm" data-bs-toggle="modal" data-bs-target="#profileModal">Change Picture</button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="profileModalLabel">Change profile picture</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form method="POST" enctype="multipart/form-data">
                                                                <div class="modal-body">
                                                                    <small id="message">Choose an image</small>
                                                                    <input type="file" class="form-control" id="image" name="image"/>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn-secondary-sm" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" name="changeImage" class="btn btn-solid-sm">Save changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-3">
                                    <ul class="list-group list-group-flush">
                                    <form method="POST">
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="row">
                                                <div class="col-5 text-start mt-2">
                                                    <h6 class="mb-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-linkedin icon-inline text-primary">
                                                        <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                                                        <rect x="2" y="9" width="4" height="12"></rect>
                                                        <circle cx="4" cy="4" r="2"></circle>
                                                    </svg>&nbsp; LinkedIn</h6>
                                                </div>
                                                <div class="col-7">
                                                    <input disabled type="text" id ="linkedinLink" name="linkedin" class="form-control" style="text-align:right;" value="$social->linkedin" required/>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="row">
                                                <div class="col-5 text-start mt-2">
                                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github mr-2 icon-inline">
                                                            <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                                                        </svg>&nbsp; Github</h6>
                                                </div>
                                                <div class="col-7">
                                                    <input disabled type="text" id ="githubLink" name="github" class="form-control" style="text-align:right;" value="$social->github" required/>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="row">
                                                <div class="col-5 text-start mt-2">
                                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter mr-2 icon-inline text-info">
                                                            <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                                                        </svg>&nbsp; Twitter</h6>
                                                </div>
                                                <div class="col-7">
                                                    <input disabled type="text" id ="twitterLink" name="twitter" class="form-control" style="text-align:right;" value="$social->twitter" required/>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="row">
                                                <div class="col-5 text-start mt-2">
                                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram mr-2 icon-inline text-danger">
                                                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                                        </svg>&nbsp; Instagram</h6>
                                                </div>
                                                <div class="col-7">
                                                    <input disabled type="text" id ="instagramLink" name="instagram" class="form-control" style="text-align:right;" value="$social->instagram" required/>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="row">
                                                <div class="col-5 text-start mt-2">
                                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook mr-2 icon-inline text-primary">
                                                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                                        </svg>&nbsp; Facebook</h6>
                                                </div>
                                                <div class="col-7">
                                                    <input disabled type="text" id ="facebookLink" name="facebook" class="form-control" style="text-align:right;" value="$social->facebook" required/>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col text-start">
                                                    <button type="submit" id="doneInputLink" name="done" class="btn btn-solid-sm w-100" style='display:none;'>Done</button>
                                                </div>
                                                <div class="col text-end">
                                                    <button type="button" id="editInputLink" class="btn-secondary-sm w-100" onclick="edit()"><i class='fas fa-edit'></i> Edit</button>
                                                    <button type="button" id="cancelInputLink" class="btn-secondary-sm w-100" style='display:none;' onclick="cancel()">Cancel</button>
                                                </div>
                                            </div>
                                        </li>
                                    </form>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="text-start ms-2 mx-2">
                                            <h2 class="mb-5">Overview</h2>
                                            <div class="row ms-2 mx-2">
                                                <div class="col text-center">
                                                    <h5 class="text-secondary" style="font-weight: lighter;">Total Posts:&nbsp; $totalPosts</h5>
                                                </div>
                                                <div class="col text-center">
                                                    <h5 class="text-secondary" style="font-weight: lighter;">Position:&nbsp; $user->position</h5>
                                                </div>
                                                <div class="col text-center">
                                                    <h5 class="text-secondary" style="font-weight: lighter;">Rating:&nbsp; $rating <i class="fa fa-star mb-1" style="color:gold" aria-hidden="true"></i></h5>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <div class="text-start ms-2 mx-2">
                                            <h2 class="mb-5">Contact</h2>
                                            <div class="row ms-2 mx-2">
                                                <div class="col text-center">
                                                    <h5 class="text-secondary" style="font-weight: lighter;"><b><i class="fa fa-envelope" aria-hidden="true"></i></b>&nbsp; $user->email</h5>
                                                </div>
                                                <div class="col text-center">
                                                    <h5 class="text-secondary" style="font-weight: lighter;"><b><i class="fa fa-phone" aria-hidden="true"></i></b>&nbsp; $user->phone</h5>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <div class="text-start ms-2 mx-2">
                                            <h2 class="mb-5">Reviews</h2>
                                            <div class="row text-center">
            END;

            if (count($feedbacks) < 1) {
                echo "<h6 class='mt-5'>No result found yet.</h6> <small>All feedback made by user will be appeared here.</small>";
            } else {
                $feedback = array_slice($feedbacks, -4);
                for ($i = 0; $i < count($feedback); $i++) {
                    $rating = str_repeat("???", $feedback[$i]->rating);
                    $comment = $feedback[$i]->comment;
                    $jobseeker = $feedback[$i]->jobseeker;
                    $date = $feedback[$i]->date;
                    echo <<< END
                        <!-- Card -->
                        <div class="col-3 text-center">
                            <div class="card">
                                <div class="card-body">
                                    <h5 style="font-weight: lighter;">$jobseeker</h5>
                                    <small>$rating</small>
                                    <p class="testimonial-text">$comment</p>
                                    <small style="line-height: 0.5;" class="text-secondary">$date</small>
                                </div>
                            </div>
                        </div>
                        <!-- end of card -->
                    END;
                }
            }

            echo <<< END
                                                </div>
                                            <hr>
                                        </div>
                                        <div class="text-start ms-2 mx-2">
                                            <h2 class="mb-5">Location</h2>
                                            <div class="row ms-2 mx-2">
                                                <div class="col">
                                                    <h5 class="mb-4 ms-5"><i class="fa fa-map-pin" style="color:red" aria-hidden="true"></i> $user->location</h5>
                                                    $map
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of container -->
            </header>
            <!-- User Profile section End -->
                            
            END;
        }
    } else {
        echo "<header class='ex-header'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-xl-10 offset-xl-1' style='height: 300px;'>
                            <h4>You don't have access to this page. Please <a href='login.php'>log in</a></h4>
                        </div>
                    </div>
                </div>
            </header>";
    }

    ?>


    <!-- footer start -->
    <?php
    require_once("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>