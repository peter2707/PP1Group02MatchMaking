<?php
    // check if the session has not started yet
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // require files
    require_once '../controller/session_controller.php';
    require_once '../controller/user_controller.php';

    // call controllers
    $sessionController = new SessionController();
    $userController = new UserController();

    // get current user session
    $validSession = $sessionController->checkSession();
    $userType = $sessionController->getUserType();

    if (isset($_POST['update'])) {
        if ($userType == "jobseeker") {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $dob = $_POST['dob'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $field = $_POST['field'];
            $location = $_POST['location'];
            $password = $_POST['password'];

            $userController->updateJobSeeker(ucfirst($firstName), ucfirst($lastName), $password, $dob, $phone, $email, $field, $location, $sessionController->getUserName());
        } elseif ($userType == "employer") {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $dob = $_POST['dob'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $position = $_POST['position'];
            $location = $_POST['location'];
            $password = $_POST['password'];

            $userController->updateEmployer(ucfirst($firstName), ucfirst($lastName), $password, $dob, $phone, $email, $position, $location, $sessionController->getUserName());
        }
    } elseif (isset($_POST['delete'])) {
        $userController->deleteAccount($sessionController->getUserName(), $userType);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | Settings</title>
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
        $user = $userController->getUser($userType, $sessionController->getUserName());
        if ($userType == "jobseeker") {
            echo <<<END
            <!-- User Profile section start -->
            <header class="ex-header">
                <div class="container">
END;
                    if (isset($_GET["error"])) {
                        echo "<h5><span class='mb-2 badge bg-danger'>";
                        if ($_GET["error"] == "emptyinput") {
                            echo "Please complete all required columns!";
                        } else if ($_GET["error"] == "failed") {
                            echo "Something went wrong. Please try again!";
                        } else if ($_GET["error"] == "deletefailed") {
                            echo "There was a problem while deleting your account. Please try again!";
                        }
                        echo "</span></h5>";
                    }elseif (isset($_GET["success"])) {
                        echo "<h5><span class='mt-5 mb-2 badge bg-success'>";
                        if ($_GET["success"] == "accountupdated") {
                            echo "Your account has been successfully Updated.";
                        }
                        echo"</span></h5>";
                    }
                    echo <<<END
                    <div class="main-body">
                        <div class="row gutters-sm">
                            <div class="col-md-8 offset-md-2">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <form method="POST">
                                            
                                            <div class="row">
                                                <div class="col-sm-4 text-start">
                                                    <h6 class="mt-2 ms-5">First Name</h6>
                                                </div>
                                                <div class="col-sm-7 text-secondary text-start">
                                                    <input type="text" class="form-control" id="first-name" name="firstName" value="$user->firstName" pattern="^[a-zA-Z, ]+$" title="Must contain only letters" required/>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4 text-start">
                                                    <h6 class="mt-2 ms-5">Last Name</h6>
                                                </div>
                                                <div class="col-sm-7 text-secondary text-start">
                                                    <input type="text" class="form-control" id="last-name" name="lastName" value="$user->lastName" pattern="^[a-zA-Z, ]+$" title="Must contain only letters" required/>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4 text-start">
                                                    <h6 class="mt-2 ms-5">Email</h6>
                                                </div>
                                                <div class="col-sm-7 text-secondary text-start">
                                                    <input type="text" class="form-control" id="email" name="email" value="$user->email" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" title="Must contain email format E.g. johndoe@mail.com" required/>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4 text-start">
                                                    <h6 class="mt-2 ms-5">Phone</h6>
                                                </div>
                                                <div class="col-sm-7 text-secondary text-start">
                                                    <input type="tel" class="form-control" id="phone" name="phone" value="$user->phone" pattern="^(\+?\(61\)|\(\+?61\)|\+?61|\(0[1-9]\)|0[1-9])?( ?-?[0-9]){7,9}$" title="Must have phone number format and at least 7 characters long" required/>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4 text-start">
                                                    <h6 class="mt-2 ms-5">Date of Birth</h6>
                                                </div>
                                                <div class="col-sm-7 text-secondary text-start">
                                                    <input type="date" class="form-control" id="dob" name="dob" value="$user->dob" required/>
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
                                                    <input type="text" class="form-control" id="username" name="username" value="$user->username" readonly/>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4 text-start">
                                                    <h6 class="mt-2 ms-5">Password</h6>
                                                </div>
                                                <div class="col-sm-7 text-secondary text-start ">
                                                    <input type="password" class="form-control" id="password" name="password" value="$user->password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,20}" title="Must contain at least one number and one uppercase and lowercase letter, and 5 to 20 characters" required/>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <button class="btn btn-success-lg" onclick="javascript:return confirm('Update detail?');" id="update" type="submit" name="update"><i class='fa fa-check' aria-hidden='true'></i> Save Changes</button>
                                                    <button class="btn btn-danger-lg" onclick="javascript:return confirm('Are you sure you want to delete your account?');" id="delete" type="submit" name="delete"><i class='fa fa-trash' aria-hidden='true'></i> Delete Account</button>
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
        } elseif ($userType == "employer") {
            echo <<<END
            <!-- User Profile section start -->
            <header class="ex-header">
                <div class="container">
END;
            if (isset($_GET["error"])) {
                echo "<h5><span class='mb-2 badge bg-danger'>";
                if ($_GET["error"] == "emptyinput") {
                    echo "Please complete all required columns!";
                } else if ($_GET["error"] == "failed") {
                    echo "Something went wrong. Please try again!";
                } else if ($_GET["error"] == "deletefailed") {
                    echo "There was a problem while deleting your account. Please try again!";
                }
                echo "</span></h5>";
            }elseif (isset($_GET["success"])) {
                echo "<h5><span class='mt-5 mb-2 badge bg-success'>";
                if ($_GET["success"] == "accountupdated") {
                    echo "Your account has been successfully Updated.";
                }
                echo"</span></h5>";
            }
            echo <<<END
                    <div class="main-body">
                        <div class="row gutters-sm">
                            <div class="col-md-8 offset-md-2">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <form method="POST">

                                            <div class="row">
                                                <div class="col-sm-4 text-start">
                                                    <h6 class="mt-2 ms-5">First Name</h6>
                                                </div>
                                                <div class="col-sm-7 text-secondary text-start">
                                                    <input type="text" class="form-control" id="first-name" name="firstName" value="$user->firstName" pattern="^[a-zA-Z, ]+$" title="Must contain only letters" required/>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4 text-start">
                                                    <h6 class="mt-2 ms-5">Last Name</h6>
                                                </div>
                                                <div class="col-sm-7 text-secondary text-start">
                                                    <input type="text" class="form-control" id="last-name" name="lastName" value="$user->lastName" pattern="^[a-zA-Z, ]+$" title="Must contain only letters" required/>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4 text-start">
                                                    <h6 class="mt-2 ms-5">Email</h6>
                                                </div>
                                                <div class="col-sm-7 text-secondary text-start">
                                                    <input type="text" class="form-control" id="email" name="email" value="$user->email" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" title="Must contain email format E.g. johndoe@mail.com" required/>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4 text-start">
                                                    <h6 class="mt-2 ms-5">Phone</h6>
                                                </div>
                                                <div class="col-sm-7 text-secondary text-start">
                                                    <input type="tel" class="form-control" id="phone" name="phone" value="$user->phone" pattern="^(\+?\(61\)|\(\+?61\)|\+?61|\(0[1-9]\)|0[1-9])?( ?-?[0-9]){7,9}$" title="Must have phone number format and at least 7 characters long" required/>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4 text-start">
                                                    <h6 class="mt-2 ms-5">Date of Birth</h6>
                                                </div>
                                                <div class="col-sm-7 text-secondary text-start">
                                                    <input type="date" class="form-control" id="dob" name="dob" value="$user->dob" required/>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4 text-start">
                                                    <h6 class="mt-2 ms-5">Username</h6>
                                                </div>
                                                <div class="col-sm-7 text-secondary text-start ">
                                                    <input type="text" class="form-control" id="username" name="username" value="$user->username" readonly/>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4 text-start">
                                                    <h6 class="mt-2 ms-5">Password</h6>
                                                </div>
                                                <div class="col-sm-7 text-secondary text-start ">
                                                    <input type="password" class="form-control" id="password" name="password" value="$user->password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,20}" title="Must contain at least one number and one uppercase and lowercase letter, and 5 to 20 characters" required/>
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
                                                <div class="col-sm-12">
                                                    <button class="btn btn-success-sm" onclick="javascript:return confirm('Update detail?');" id="update" type="submit" name="update"><i class='fa fa-check' aria-hidden='true'></i> Save Changes</button>
                                                    <button class="btn btn-danger-sm" onclick="javascript:return confirm('Are you sure you want to delete your account?');" id="delete" type="submit" name="delete"><i class='fa fa-trash' aria-hidden='true'></i> Delete Account</button>
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
    } else {
        echo "<header class='ex-header'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-xl-10 offset-xl-1'>
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