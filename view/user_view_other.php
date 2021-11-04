<?php
require_once '../controller/user_controller.php';
require_once '../controller/session_controller.php';
require_once '../controller/matchmaking_controller.php';

// check if the session has not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// call controllers
$uc = new UserController();
$sc = new SessionController();
$mc = new MatchmakingController();

if(isset($_GET['jobseeker'])){
    $usertype = "jobseeker";
    $username = $_GET['jobseeker'];
}elseif(isset($_GET['employer'])){
    $usertype = "employer";
    $username = $_GET['employer'];
}
if (isset($_POST['downloadResume'])) {
    $filepath = $_POST['filepath'];
    $filename = $_POST['filename'];
    $uc->downloadResume($filepath, $filename);
}
$validSession = $sc->checkSession();
$viewUser = $uc->getUser($usertype, $username);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | <?php echo "$viewUser->username"; ?></title>
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

    <!-- User Profile section start -->
    <?php
    if ($validSession) {
        $social = $uc->getSocialLink($viewUser->username);
        $map = $uc->getMap($viewUser->location);

        $userImage = $viewUser->image;
        if ($viewUser->image == NULL) {
            $defaultImage = file_get_contents("../images/user.png");
            $userImage = base64_encode($defaultImage);
        }
        if ($usertype == "jobseeker") {
            $skills = array();
            $educations = array();
            $careers = array();

            $resume = $uc->getResume($viewUser->username);
            $skills = $uc->getSkills($viewUser->username);
            $educations = $uc->getEducations($viewUser->username);
            $careers = $uc->getCareers($viewUser->username);
            echo <<<END
            <header class="ex-header">
                <div class="container">
                    <div class="main-body">
                        <div class="row gutters-sm">
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <img src="data:image/png;base64, $userImage" alt="User" class="rounded-circle" width="150" height="150">
                                            <div class="mt-3">
                                                <h4>$viewUser->firstName $viewUser->lastName</h4>
                                                <p class="text-secondary">$viewUser->field </p>
                                                <div class="row ms-2 mx-2">
                                                    <div class="col text-center">
                                                        <a style="text-decoration: none;" href="mailto:$viewUser->email"><b><i class="fa fa-envelope" aria-hidden="true"></i></b></a>
                                                    </div>
                                                    <div class="col text-center">
                                                        <a style="text-decoration: none;" href="tel:$viewUser->phone"><b><i class="fa fa-phone" aria-hidden="true"></i></b></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-3">
                                    <ul class="list-group list-group-flush">
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
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row text-start ms-2 mx-2 mb-5">
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
                        <button type="submit" name="downloadResume" onclick="javascript:return confirm('Download Resume?');" class="btn btn-secondary">Download</button>
                    </form>
                </div>
            END;
        } else {
            echo "<small class='text-center'>This user has not added a resume yet.</small>";
        }
            echo <<<END
            </div>
            <hr>
            <div class="row text-start ms-2 mx-2 mb-5">
                <div class="row mb-3 mt-3">
                    <div class="col text-start">
                        <h2>Skill</h2>
                    </div>
                </div>
            END;
        if (count($skills) < 1) {
            echo "<small class='text-center'>This user has not added a skill yet.</small>";
        } else {
            foreach ($skills as $skill) {
                echo <<<END
                    <div class="col-4 text-center mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 style="font-weight: lighter;">$skill->skill</h5>
                                <small><i class="fa fa-clock" aria-hidden="true"></i> $skill->experience</small>
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
                </div>
        END;
        if (count($educations) < 1) {
            echo "<small class='text-center'>This user has not added an education yet.</small>";
        } else {
            foreach ($educations as $education) {
                echo <<<END
                    <div class="col-4 text-center mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 style="font-weight: lighter;">$education->degree</h5>
                                <small><i class="fa fa-graduation-cap" aria-hidden="true"></i> $education->graduation</small>
                                <p class="testimonial-text"><i class="fa fa-building" aria-hidden="true"></i> $education->institution</p>
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
                </div>
        END;

        if (count($careers) < 1) {
            echo "<small class='text-center'>This user has not added a career yet.</small>";
        } else {
            foreach ($careers as $career) {
                echo <<<END
                    <div class="col-4 text-center mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 style="font-weight: lighter;">$career->position</h5>
                                <small><i class="fa fa-clock" aria-hidden="true"></i> $career->experience</small>
                                <p class="testimonial-text"><i class="fa fa-building" aria-hidden="true"></i> $career->company</p>
                            </div>
                        </div>
                    </div>
                END;
            }
        }
                echo <<<END
                                                </div>
                                                <hr>
                                                <div class="row text-start ms-2 mx-2">
                                                    <h2 class="mb-5">Location</h2>
                                                    <div class="row ms-2 mx-2">
                                                        <div class="col">
                                                            <h5 class="text-secondary ms-2 mb-3" style="font-weight: lighter;">From: $viewUser->location <i class="fa fa-map-pin" style="color:red" aria-hidden="true"></i></h5>
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
                    </div>
                    <!-- end of container -->
                </header>
                END;

        } elseif ($usertype == "employer") {
            $feedbacks = array();
            $feedbacks = $uc->getAllFeedback($viewUser->username);
            $totalPosts = $mc->countJobPosts($viewUser->username);
            $rating = number_format((float)$viewUser->rating, 1, '.', '');

            echo <<<END
                <!-- User Profile section start -->
                <header class="ex-header">
                    <div class="container">
                        <div class="main-body">
                            <div class="row gutters-sm">
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-column align-items-center text-center">
                                                <img src="data:image/png;base64, $userImage" alt="Admin" class="rounded-circle" width="150" height="150">

                                                <div class="mt-3">
                                                    <h4>$viewUser->firstName $viewUser->lastName</h4>
                                                    <p class="text-secondary">$viewUser->position</p>
                                                    <div class="row">
                                                        <div class="col text-center">
                                                            <a style="text-decoration: none;" href="mailto:$viewUser->email"><b><i class="fa fa-envelope" aria-hidden="true"></i></b></a>
                                                        </div>
                                                        <div class="col text-center">
                                                            <a style="text-decoration: none;" href="tel:$viewUser->phone"><b><i class="fa fa-phone" aria-hidden="true"></i></b></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mt-3">
                                        <ul class="list-group list-group-flush">
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
                                                        <h5 class="text-secondary" style="font-weight: lighter;">Position:&nbsp; $viewUser->position</h5>
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
                                                        <a style="text-decoration: none;" href="mailto:$viewUser->email"><h5 class="text-secondary" style="font-weight: lighter;"><b><i class="fa fa-envelope" aria-hidden="true"></i></b>&nbsp; $viewUser->email</h5></a>
                                                    </div>
                                                    <div class="col text-center">
                                                        <a style="text-decoration: none;" href="tel:$viewUser->phone"><h5 class="text-secondary" style="font-weight: lighter;"><b><i class="fa fa-phone" aria-hidden="true"></i></b>&nbsp; $viewUser->phone</h5></a>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="text-start ms-2 mx-2">
                                                <h2 class="mb-5">Reviews</h2>
                                                <div class="row">
                END;

            if (count($feedbacks) < 1) {
                echo "<h6 class='mt-5'>No result found yet.</h6> <small>All feedback made by user will be appeared here.</small>";
            } else {
                $feedback = array_slice($feedbacks, -4);
                for ($i = 0; $i < count($feedback); $i++) {
                    $rating = str_repeat("⭐", $feedback[$i]->rating);
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
                                                        <h5 class="text-secondary ms-2 mb-3" style="font-weight: lighter;">From: $viewUser->location <i class="fa fa-map-pin" style="color:red" aria-hidden="true"></i></h5>
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
                    <div class='col-xl-10 offset-xl-1' style='height: 300px;'>
                        <h4>You don't have access to this page. Please <a href='login.php'>log in</a></h4>
                    </div>
                </div>
            </header>";
    }

    ?>
    <!-- User Profile section End -->


    <!-- footer start -->
    <?php
    require_once("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>