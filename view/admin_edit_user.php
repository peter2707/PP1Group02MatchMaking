<?php
require_once '../controller/user_controller.php';
require_once '../controller/admin_controller.php';
// check if the session has not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// call controllers
$uc = new UserController();
$ac = new AdminController();

if (isset($_GET['jobseeker'])) {
    $usertype = "jobseeker";
    $username = $_GET['jobseeker'];
} elseif (isset($_GET['employer'])) {
    $usertype = "employer";
    $username = $_GET['employer'];
} elseif (isset($_GET['admin'])) {
    $usertype = "admin";
    $username = $_GET['admin'];
}

$user = $uc->getUserByName($usertype, $username);
$social = $uc->getSocialLink($user->username);
$userImage = $user->image;

if (isset($_POST['update'])) {
    if ($usertype == "jobseeker") {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $dob = $_POST['dob'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $field = $_POST['field'];
        $password = $_POST['password'];

        $ac->updateJobSeeker($firstName, $lastName, $username, $password, $dob, $phone, $email, $field, $user->id);
    } elseif ($usertype == "employer") {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $dob = $_POST['dob'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $position = $_POST['position'];
        $password = $_POST['password'];

        $ac->updateEmployer($firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $user->id);
    } elseif ($usertype == "admin") {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $dob = $_POST['dob'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $position = $_POST['position'];
        $password = $_POST['password'];

        $ac->updateAdmin($firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $user->id);
    }
} elseif (isset($_POST['cancel'])){
    header("location: ../view/admin_index.php");
} elseif (isset($_POST['done'])) {
    $linkedin = $_POST['linkedin'];
    $github = $_POST['github'];
    $twitter = $_POST['twitter'];
    $instagram = $_POST['instagram'];
    $facebook = $_POST['facebook'];
    $uc->editSocialLink($username, $linkedin, $github, $twitter, $instagram, $facebook);
} elseif (isset($_POST['delete'])) {
    $uc->deleteAccount($username, $usertype);
} elseif (isset($_POST['changeImage'])) {
    $input = $_FILES["image"]["tmp_name"];
    if (file_exists($input)) {
        $file = file_get_contents($input);
        $base64 = base64_encode($file);
        $uc->changeProfilePicture($base64, $username, $usertype);
    } else {
        $script = "<script>window.location = '../view/user_profile.php?error=imagenotfound';</script>";
        echo $script;
    }
} elseif ($user->image == NULL) {
    $defaultImage = file_get_contents("../images/user.png");
    $userImage = base64_encode($defaultImage);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | Edit</title>
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

    <?php
    if ($usertype == "jobseeker") {
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
                                                            <input type="file" class="form-control" id="image" name="image" />
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary-sm" data-bs-dismiss="modal">Cancel</button>
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
                                                    </svg>&nbsp; LinkedIn
                                                </h6>
                                            </div>
                                            <div class="col-7">
                                                <input disabled type="text" id="linkedinLink" name="linkedin" class="form-control" style="text-align:right;" value="$social->linkedin" required />
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
                                                <input disabled type="text" id="githubLink" name="github" class="form-control" style="text-align:right;" value="$social->github" required />
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
                                                <input disabled type="text" id="twitterLink" name="twitter" class="form-control" style="text-align:right;" value="$social->twitter" required />
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
                                                <input disabled type="text" id="instagramLink" name="instagram" class="form-control" style="text-align:right;" value="$social->instagram" required />
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
                                                <input disabled type="text" id="facebookLink" name="facebook" class="form-control" style="text-align:right;" value="$social->facebook" required />
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col text-start">
                                                <button type="submit" id="doneInputLink" class="btn btn-solid-sm w-100" name="done" style='display:none;'>Done</button>
                                            </div>
                                            <div class="col text-end">
                                                <button type="button" id="editInputLink" class="btn btn-secondary-sm w-100" onclick="edit()"><i class='fas fa-edit'></i> Edit</button>
                                                <button type="button" id="cancelInputLink" class="btn btn-secondary-sm w-100" style='display:none;' onclick="cancel()">Cancel</button>
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
                                <form method="POST">

                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">First Name</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="text" class="form-control" id="first-name" name="firstName" value="$user->firstName" required />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Last Name</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="text" class="form-control" id="last-name" name="lastName" value="$user->lastName" required />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Email</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="text" class="form-control" id="email" name="email" value="$user->email" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" title="Must contain email format E.g. johndoe@mail.com" required />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Phone</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="tel" class="form-control" id="phone" name="phone" value="$user->phone" pattern="^(\+?\(61\)|\(\+?61\)|\+?61|\(0[1-9]\)|0[1-9])?( ?-?[0-9]){7,9}$" title="Must have phone number format and at least 7 characters long" required />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Date of Birth</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="date" class="form-control" id="dob" name="dob" value="$user->dob" required />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Field of Expertise</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <select class="form-select" aria-label=".form-select-lg example" id="fieldOfExpertise-form" name="field" required>
                                                <option readonly selected value="$user->field">$user->field</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Username</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="text" class="form-control" id="username" name="username" value="$user->username" required/>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Password</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start ">
                                            <input type="password" class="form-control" id="password" name="password" value="$user->password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,20}" title="Must contain at least one number and one uppercase and lowercase letter, and 5 to 20 characters" required />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button class="btn btn-secondary-sm" id="cancel" type="submit" name="cancel"><i class='fa fa-times' aria-hidden='true'></i> Cancel</button>
                                            <button class="btn btn-success-sm" onclick="javascript:return confirm('Update detail?');" id="update" type="submit" name="update"><i class='fa fa-check' aria-hidden='true'></i> Save Changes</button>
                                        </div>
                                    </div>
                                </form>

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
} elseif ($usertype == "employer") {
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
                                    <img src="data:image/png;base64, $userImage" alt="User" class="rounded-circle" width="150" height="150">
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
                                                            <input type="file" class="form-control" id="image" name="image" />
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary-sm" data-bs-dismiss="modal">Cancel</button>
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
                                                    </svg>&nbsp; LinkedIn
                                                </h6>
                                            </div>
                                            <div class="col-7">
                                                <input disabled type="text" id="linkedinLink" name="linkedin" class="form-control" style="text-align:right;" value="$social->linkedin" required />
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
                                                <input disabled type="text" id="githubLink" name="github" class="form-control" style="text-align:right;" value="$social->github" required />
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
                                                <input disabled type="text" id="twitterLink" name="twitter" class="form-control" style="text-align:right;" value="$social->twitter" required />
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
                                                <input disabled type="text" id="instagramLink" name="instagram" class="form-control" style="text-align:right;" value="$social->instagram" required />
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
                                                <input disabled type="text" id="facebookLink" name="facebook" class="form-control" style="text-align:right;" value="$social->facebook" required />
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col text-start">
                                                <button type="submit" id="doneInputLink" class="btn btn-solid-sm w-100" name="done" style='display:none;'>Done</button>
                                            </div>
                                            <div class="col text-end">
                                                <button type="button" id="editInputLink" class="btn btn-secondary-sm w-100" onclick="edit()"><i class='fas fa-edit'></i> Edit</button>
                                                <button type="button" id="cancelInputLink" class="btn btn-secondary-sm w-100" style='display:none;' onclick="cancel()">Cancel</button>
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
                                <form method="POST">

                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">First Name</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="text" class="form-control" id="first-name" name="firstName" value="$user->firstName" required />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Last Name</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="text" class="form-control" id="last-name" name="lastName" value="$user->lastName" required />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Email</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="text" class="form-control" id="email" name="email" value="$user->email" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" title="Must contain email format E.g. johndoe@mail.com" required />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Phone</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="tel" class="form-control" id="phone" name="phone" value="$user->phone" pattern="^(\+?\(61\)|\(\+?61\)|\+?61|\(0[1-9]\)|0[1-9])?( ?-?[0-9]){7,9}$" title="Must have phone number format and at least 7 characters long" required />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Date of Birth</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="date" class="form-control" id="dob" name="dob" value="$user->dob" required />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Position</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start ">
                                            <input type="text" class="form-control" id="position" name="position" value="$user->position" required/>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Username</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="text" class="form-control" id="username" name="username" value="$user->username" required/>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Password</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start ">
                                            <input type="password" class="form-control" id="password" name="password" value="$user->password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,20}" title="Must contain at least one number and one uppercase and lowercase letter, and 5 to 20 characters" required />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button class="btn btn-secondary-sm" id="cancel" type="submit" name="cancel"><i class='fa fa-times' aria-hidden='true'></i> Cancel</button>
                                            <button class="btn btn-success-sm" onclick="javascript:return confirm('Update detail?');" id="update" type="submit" name="update"><i class='fa fa-check' aria-hidden='true'></i> Save Changes</button>
                                        </div>
                                    </div>
                                </form>

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
}elseif ($usertype == "admin") {
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
                                    <img src="data:image/png;base64, $userImage" alt="User" class="rounded-circle" width="150" height="150">
                                    <div class="mt-3">
                                        <h4>$user->firstName $user->lastName</h4>
                                        <p class="text-secondary">$user->position</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <form method="POST">

                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">First Name</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="text" class="form-control" id="first-name" name="firstName" value="$user->firstName" required />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Last Name</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="text" class="form-control" id="last-name" name="lastName" value="$user->lastName" required />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Email</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="text" class="form-control" id="email" name="email" value="$user->email" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" title="Must contain email format E.g. johndoe@mail.com" required />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Phone</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="tel" class="form-control" id="phone" name="phone" value="$user->phone" pattern="^(\+?\(61\)|\(\+?61\)|\+?61|\(0[1-9]\)|0[1-9])?( ?-?[0-9]){7,9}$" title="Must have phone number format and at least 7 characters long" required />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Date of Birth</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="date" class="form-control" id="dob" name="dob" value="$user->dob" required />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Position</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start ">
                                            <input type="text" class="form-control" id="position" name="position" value="$user->position" required/>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Username</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="text" class="form-control" id="username" name="username" value="$user->username" required/>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Password</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start ">
                                            <input type="password" class="form-control" id="password" name="password" value="$user->password" required />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button class="btn btn-secondary-sm" id="cancel" type="submit" name="cancel"><i class='fa fa-times' aria-hidden='true'></i> Cancel</button>
                                            <button class="btn btn-success-sm" onclick="javascript:return confirm('Update detail?');" id="update" type="submit" name="update"><i class='fa fa-check' aria-hidden='true'></i> Save Changes</button>
                                        </div>
                                    </div>
                                </form>
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
?>


    <!-- footer start -->
    <?php
    require_once("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>