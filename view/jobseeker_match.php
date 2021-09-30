<?php
if (isset($_POST['match'])) {
    require_once '../controller/register_controller.php';
    $registerController = new RegisterController();

    $firstName = $_POST['salary'];
    $lastName = $_POST['job'];
    $username = $_POST['location'];
    $password = $_POST['type'];
    $confirmPassword = $_POST['confirmPassword'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $type = $_POST['type'];
    $field = $_POST['field'];
    $position = $_POST['position'];

    $registerController->register($firstName, $lastName, $username, $password, $confirmPassword, $dateOfBirth, $phone, $email, $type, $field, $position);
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

    <!-- Header -->
    <header class="ex-header">
        <div class="container">
            <div class="row">

            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header> <!-- end of ex-header -->
    <!-- end of header -->


    <div class="ex-basic-1 pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1">
                    <form method="POST">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Input your desire salary" name="salary">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Input your desire job type" name="job">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Input your desire location" name="location">
                        </div>
                        <div class="mb-3">
                            <select class="form-select" name="type">
                                <option value="fulltime">Full Time</option>
                                <option value="parttime">Part Time</option>
                            </select>
                        </div>

                        <button class="btn btn-primary btn-sm" type="submit" name="match">Match</button>
                    </form>

                </div> <!-- end of col -->

            </div> <!-- end of row -->

        </div> <!-- end of container -->

    </div> <!-- end of ex-basic-1 -->
    <!-- end of basic -->


    <!-- footer start -->
    <?php
    require_once("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>