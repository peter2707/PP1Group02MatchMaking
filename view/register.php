<?php
if(isset($_POST['register'])){
    require_once '../controller/register_controller.php';
    $registerController = new RegisterController();

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $type = $_POST['type'];
    $field = $_POST['field'];
    $position = $_POST['position'];
    $location = $_POST['location'];
    
    $registerController->register(ucfirst($firstName), ucfirst($lastName), $username, $password, $confirmPassword, $dateOfBirth, $phone, $email, $location, $type, $field, $position);
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | Register</title>
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


    <!-- register section start -->
    <header class="ex-header">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1 mb-3">
                    <h1>Create an Account</h1>
                    <?php
                    // Error messages
                    if (isset($_GET["error"])) {
                        echo "<h5><span class='mt-5 mb-2 badge bg-danger'>";
                        if ($_GET["error"] == "emptyinput") {
                            echo "Fill in all required fields!";
                        } else if ($_GET["error"] == "invalidusername") {
                            echo "Enter a valid username!";
                        } else if ($_GET["error"] == "invalidemail") {
                            echo "Enter a valid email!";
                        } else if ($_GET["error"] == "passwordsdontmatch") {
                            echo "Passwords do not match. Please try again!";
                        } else if ($_GET["error"] == "stmtfailed") {
                            echo "Something went wrong. Please try again!";
                        } else if ($_GET["error"] == "usernametaken") {
                            echo "Username is already taken!";
                        } else if ($_GET["error"] == "fieldnull") {
                            echo "You have to choose a field of expertise";
                        } else if ($_GET["error"] == "positionnull") {
                            echo "You have to enter your position";
                        }
                        echo "</span></h5>";
                    }
                    ?>
                    <p class="mt-5 mb-2 text-muted">Enter your details below:</p>
                </div>
                <div class="col-md-4 offset-md-4">
                <main class="form-register">
                    <form action="" method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Firstname" name="firstName" pattern="[A-Za-z]" title="Must contain only letters" required>
                            <label for="floatingInput">Firstname</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Lastname" name="lastName" pattern="[A-Za-z]" title="Must contain only letters" required>
                            <label for="floatingInput">Lastname</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Username" name="username" pattern="(?=.*[a-z])(?=.*[A-Z]).{5,20}" title="Must contain at least one uppercase and lowercase letter, and 5 to 20 characters" required>
                            <label for="floatingInput">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,20}" title="Must contain at least one number and one uppercase and lowercase letter, and 5 to 20 characters" required>
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Confirm Password" name="confirmPassword" required>
                            <label for="floatingPassword">Confirm Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="floatingInput" placeholder="Date of Birth" name="dateOfBirth" required>
                            <label for="floatingInput">Date of Birth</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="tel" class="form-control" id="floatingInput" placeholder="Phone" name="phone" pattern="^(\+?\(61\)|\(\+?61\)|\+?61|\(0[1-9]\)|0[1-9])?( ?-?[0-9]){7,9}$" title="Must have phone number format and at least 7 characters long" required>
                            <label for="floatingInput">Phone</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" placeholder="Email" name="email" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" title="Must contain email format E.g. johndoe@mail.com" required>
                            <label for="floatingInput">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select mb-3" aria-label=".form-select-lg example" id="location-field" name="location" required>
                                <option disabled selected value="">Choose...</option>"
                            </select>
                            <label for="location-field">Location</label>
                        </div>


                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="job-seeker" value="jobseeker" onclick="toggleRegister();" checked>
                            <label class="form-check-label" for="job-seeker">Job Seeker</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="employer" value="employer" onclick="toggleRegister();">
                            <label class="form-check-label" for="employer">Employer</label>
                        </div>
                        <div class="form-floating mb-3" id="job-seeker-form">
                            <select class="form-select mb-3" aria-label=".form-select-lg example" id="fieldOfExpertise-form" name="field">
                                <option disabled selected value="">Choose...</option>
                            </select>
                            <label for="fieldOfExpertise-form">Field of Expertise</label>
                        </div>
                        <div class="form-floating mb-3" id="employer-form" style="display:none;">
                            <input type="text" class="form-control" id="employer-form-rating" name="position" placeholder="Position">
                            <label for="employer-form-label">Position</label>
                        </div>

                        <button class="w-50 btn btn-success-lg mb-5 mt-2" type="submit" name="register">Register</button>
                        <p class="mb-3">Already have an account? <a href="login.php">Log In</a></p>
                    </form>
                </main>
            </div>
                <!-- end of col -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </header>
    <!-- register section End -->


    <!-- footer start -->
    <?php
        require_once("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>