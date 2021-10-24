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

$user = $uc->getUser($usertype, $username);
$social = $uc->getSocialLink($user->username);

if (isset($_POST['update'])) {
    if ($usertype == "jobseeker") {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $dob = $_POST['dob'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $field = $_POST['field'];
        $location = $_POST['location'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $ac->updateJobSeeker(ucfirst($firstName), ucfirst($lastName), $username, $password, $dob, $phone, $email, $field, $location, $user->id);
    } elseif ($usertype == "employer") {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $dob = $_POST['dob'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $position = $_POST['position'];
        $location = $_POST['location'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $ac->updateEmployer(ucfirst($firstName), ucfirst($lastName), $username, $password, $dob, $phone, $email, $position, $location, $user->id);
    } elseif ($usertype == "admin") {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $dob = $_POST['dob'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $position = $_POST['position'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $ac->updateAdmin(ucfirst($firstName), ucfirst($lastName), $username, $password, $dob, $phone, $email, $position, $user->id);
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
        header("location: ../view/user_profile.php?error=imagenotfound");
    }
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
        if ($user->image == NULL) {
            $defaultImage = file_get_contents("../images/user.png");
            $user->image = base64_encode($defaultImage);
        }
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
                                    <img src="data:image/png;base64, $user->image" alt="User" class="rounded-circle" width="150" height="150">
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
                                            <input type="text" class="form-control" id="first-name" name="firstName" value="$user->firstName" pattern="^[a-zA-Z, ]+$" title="Must contain only letters" required />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Last Name</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="text" class="form-control" id="last-name" name="lastName" value="$user->lastName" pattern="^[a-zA-Z, ]+$" title="Must contain only letters" required />
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
                                            <h6 class="mt-2 ms-5">Location</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <select class="form-select" aria-label=".form-select-lg example" id="location-field" name="location" required>
                                                <option readonly selected value="$user->location">$user->location</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Username</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="text" class="form-control" id="username" name="username" value="$user->username" pattern="(?=.*[a-z])(?=.*[A-Z]).{5,20}" title="Must contain at least one uppercase and lowercase letter, and 5 to 20 characters" required/>
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
    if ($user->image == NULL) {
        $defaultImage = file_get_contents("../images/user.png");
        $user->image = base64_encode($defaultImage);
    }
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
                                    <img src="data:image/png;base64, $user->image" alt="User" class="rounded-circle" width="150" height="150">
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
                                            <input type="text" class="form-control" id="first-name" name="firstName" value="$user->firstName" pattern="^[a-zA-Z, ]+$" title="Must contain only letters" required />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Last Name</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="text" class="form-control" id="last-name" name="lastName" value="$user->lastName" pattern="^[a-zA-Z, ]+$" title="Must contain only letters" required />
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
                                            <input type="text" class="form-control" id="position" name="position" value="$user->position" pattern="^[a-zA-Z, ]+$" title="Must contain only letters" required/>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Location</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <select class="form-select" aria-label=".form-select-lg example" id="location-field" name="location" required>
                                                <option readonly selected value="$user->location">$user->location</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Username</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="text" class="form-control" id="username" name="username" value="$user->username" pattern="(?=.*[a-z])(?=.*[A-Z]).{5,20}" title="Must contain at least one uppercase and lowercase letter, and 5 to 20 characters" required/>
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
    $adminImage = base64_encode(file_get_contents("../images/user.png"));
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
                                    <img src="data:image/png;base64, $adminImage" alt="User" class="rounded-circle" width="150" height="150">
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
                                            <input type="text" class="form-control" id="first-name" name="firstName" value="$user->firstName" pattern="^[a-zA-Z, ]+$" title="Must contain only letters" required />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Last Name</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="text" class="form-control" id="last-name" name="lastName" value="$user->lastName" pattern="^[a-zA-Z, ]+$" title="Must contain only letters" required />
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
                                            <input type="text" class="form-control" id="position" name="position" value="$user->position" pattern="^[a-zA-Z, ]+$" title="Must contain only letters" required/>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-start">
                                            <h6 class="mt-2 ms-5">Username</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary text-start">
                                            <input type="text" class="form-control" id="username" name="username" value="$user->username"value="$user->username" pattern="(?=.*[a-z])(?=.*[A-Z]).{5,20}" title="Must contain at least one uppercase and lowercase letter, and 5 to 20 characters" required/>
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
}
?>


    <!-- footer start -->
    <?php
    require_once("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>