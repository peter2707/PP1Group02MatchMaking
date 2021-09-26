<?php
if(isset($_POST['register'])){
    include "../model/admin_model.php";
    $adminModel = new AdminModel();

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $type = $_POST['type'];
    $position = $_POST['position'];
    $exp = $_POST['exp'];
    $skill = $_POST['skill'];
    
    $adminModel->register($firstName, $lastName, $username, $password, $confirmPassword, $dateOfBirth, $phone, $email, $type, $position, $exp, $skill);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | Sign Up</title>
    <?php
        include("component/header.php");
    ?>
</head>


<body class="text-center">

    <!-- Navigation Start  -->
    <?php
        include("component/navbar.php");
    ?>
    <!-- Navigation End  -->


    <!-- register section start -->
    <header class="ex-header">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-md-1 mb-3">
                    <h1>Add New User</h1>
                    <p class="mt-5 mb-2 text-muted">Enter your details below:</p>
                </div>
                <div class="col-md-4 offset-md-4">
                    <main class="form-register">
                        <form action="" method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Firstname" name="firstName">
                                <label for="floatingInput">Firstname</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Lastname" name="lastName">
                                <label for="floatingInput">Lastname</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Username" name="username">
                                <label for="floatingInput">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                                <label for="floatingPassword">Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPassword" placeholder="Confirm Password" name="confirmPassword">
                                <label for="floatingPassword">Confirm Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="floatingInput" placeholder="Date of Birth" name="dateOfBirth">
                                <label for="floatingInput">Date of Birth</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="tel" class="form-control" id="floatingInput" placeholder="Phone" name="phone">
                                <label for="floatingInput">Phone</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInput" placeholder="Email" name="email">
                                <label for="floatingInput">Email</label>
                            </div>


                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="job-seeker" value="jobseeker" onclick="toggleAddUser();" checked>
                                <label class="form-check-label" for="job-seeker">Job Seeker</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="employer" value="employer" onclick="toggleAddUser();">
                                <label class="form-check-label" for="employer">Employer</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="admin" value="admin" onclick="toggleAddUser();">
                                <label class="form-check-label" for="admin">Admin</label>
                            </div>
                            
                            <div id="job-seeker-form">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="job-seeker-form-exp" name="exp" placeholder="Experience (How many years?)">
                                    <label for="job-seeker-form-exp">Experience (How many years?)</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="job-seeker-form-skill" name="skill" placeholder="Skill">
                                    <label for="job-seeker-form-skill">Skill</label>
                                </div>
                            </div>
                            <div class="form-floating mb-3" id="employer-form" style="display:none;">
                                <input type="text" class="form-control" id="employer-form-position" name="position" placeholder="Position">
                                <label for="employer-form-label">Position</label>
                            </div>
                            <div class="form-floating mb-3" id="admin-form" style="display:none;">
                                <input type="text" class="form-control" id="admin-form-position" name="position" placeholder="Position">
                                <label for="admin-form-position">Position</label>
                            </div>

                            <p class="mt-5 mb-2" style="color: red;">
                                <?php
                                // Error messages
                                if (isset($_GET["error"])) {
                                    if ($_GET["error"] == "emptyinput") {
                                        echo "Fill in all fields!";
                                    } else if ($_GET["error"] == "invaliduid") {
                                        echo "Choose a proper username!";
                                    } else if ($_GET["error"] == "invalidemail") {
                                        echo "Choose a proper email!";
                                    } else if ($_GET["error"] == "passwordsdontmatch") {
                                        echo "Passwords doesn't match!";
                                    } else if ($_GET["error"] == "stmtfailed") {
                                        echo "Something went wrong!";
                                    } else if ($_GET["error"] == "usernametaken") {
                                        echo "Username already taken!";
                                    }
                                }
                                ?>
                            </p>
                            <div class="row mb-5 mt-2">
                                <div class="col">
                                    <a style="text-decoration : none" class="w-100 btn btn-lg btn-secondary" href="adminIndex.php">Cancel</a>
                                </div>
                                <div class="col">
                                    <button class="w-100 btn btn-lg btn-primary" type="submit" name="register">Add</button>
                                </div>
                            </div>
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
        include("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>