<?php
if (isset($_POST['delete'])) {
    require_once "../controller/admin_controller.php";
    $adminController = new AdminController();
    $username = $_POST['username'];
    $adminController->deleteAccount($username, "jobseeker");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | JobSeeker List</title>
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
            <h1>All JobSeekers</h1>
        </div>
        <!-- end of container -->
    </header>
    <!-- end of header -->

    <div class="container mt-5">
        <div class="mb-5" style="min-height: 200px;">
            <?php
            require_once '../controller/admin_controller.php';
            require_once '../controller/session_controller.php';
            // call controllers
            $sc = new SessionController();
            $ac = new AdminController();

            // check if the session has not started yet
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $allJobSeekers = array();
            $allJobSeekers = $ac->getAllJobSeeker();
            if (count($allJobSeekers) < 1) {
                echo "<h3>No result found yet.</h3> <small>To add a user, click on the Add New User button</small>";
            } else {
                echo "<table class='table'>";
                echo "    <thead>";
                echo "        <tr>";
                echo "            <th scope='col'>ID</th>";
                echo "            <th scope='col'>FirstName</th>";
                echo "            <th scope='col'>LastName</th>";
                echo "            <th scope='col'>Username</th>";
                echo "            <th scope='col'>DateOfBirth</th>";
                echo "            <th scope='col'>Phone</th>";
                echo "            <th scope='col'>Email</th>";
                echo "            <th scope='col'>Field</th>";
                echo "            <th scope='col'>Location</th>";
                echo "            <th scope='col'>Action</th>";
                echo "            <th scope='col'></th>";
                echo "        </tr>";
                echo "    </thead>";
                echo "<tbody>";
                foreach ($allJobSeekers as $jobSeeker) {
                    echo "    <tr>";
                    echo "        <td scope=\"row\">$jobSeeker->id</td>";
                    echo "        <td scope=\"row\">$jobSeeker->firstName</td>";
                    echo "        <td scope=\"row\">$jobSeeker->lastName</td>";
                    echo "        <td scope=\"row\">$jobSeeker->username</td>";
                    echo "        <td scope=\"row\">$jobSeeker->dob</td>";
                    echo "        <td scope=\"row\">$jobSeeker->phone</td>";
                    echo "        <td scope=\"row\">$jobSeeker->email</td>";
                    echo "        <td scope=\"row\">$jobSeeker->field</td>";
                    echo "        <td scope=\"row\">$jobSeeker->location</td>";
                    createEditButton("jobseeker", $jobSeeker->username, "Edit", "admin_edit_user.php");
                    createDeleteButton("username", $jobSeeker->username, "Delete");
                    echo "    </tr>";
                }
                echo "</tbody>";
                echo "</table>";
                unset($allJobSeekers);
            }
            function createEditButton($hiddenName, $hiddenValue, $buttonText, $actionPage)
            {
                echo "<td>";
                echo "<form action=$actionPage method=\"GET\">";
                echo "<input type=\"hidden\" name=$hiddenName value=$hiddenValue>";
                echo "<button type=\"submit\" class=\"btn btn-solid-sm\">$buttonText</button>";
                echo "</form>";
                echo "</td>";
            }
            function createDeleteButton($hiddenName, $jobseeker, $buttonText)
            {
                echo "<td>";
                echo "<form method=\"POST\">";
                echo "<input type=\"hidden\" name=$hiddenName value=$jobseeker>";
                echo "<button name=\"delete\" type=\"submit\" class=\"btn btn-danger-sm\" onclick=\"return confirm('Are you sure you want to delete $jobseeker ?')\" >$buttonText</button>";
                echo "</form>";
                echo "</td>";
            }
            ?>

        </div>

    </div>

    <!-- footer start -->
    <?php
    require_once("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>