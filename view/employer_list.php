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

$allEmployers = array();
$allEmployers = $ac->getAllEmployer();

if (isset($_POST['delete'])) {
    $username = $_POST['username'];
    $ac->deleteAccount($username, "employer");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | Employer List</title>
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
            <h1>Employers</h1>
        </div>
            <!-- end of container -->
    </header>
    <!-- end of header -->
    <div class="container mt-5">
        <div class="mb-5" style="min-height: 400px;">
            <?php
            
            if (count($allEmployers) < 1) {
                echo "<h3>No result found yet.</h3> <small>To add a user, click on the Add New User button</small>";
            } else {
                echo "<table class='table'>";
                echo "      <thead>";
                echo "        <tr>";
                echo "            <th scope='col'>ID</th>";
                echo "            <th scope='col'>FirstName</th>";
                echo "            <th scope='col'>LastName</th>";
                echo "            <th scope='col'>Username</th>";
                echo "            <th scope='col'>DateOfBirth</th>";
                echo "            <th scope='col'>Phone</th>";
                echo "            <th scope='col'>Email</th>";
                echo "            <th scope='col'>Position</th>";
                echo "            <th scope='col'>Location</th>";
                echo "            <th scope='col'>Rating</th>";
                echo "            <th scope='col'>Action</th>";
                echo "            <th scope='col'></th>";
                echo "        </tr>";
                echo "      </thead>";
                echo "      <tbody>";
                foreach ($allEmployers as $employer) {
                    echo "        <tr>";
                    echo "          <td scope=\"row\">$employer->id</td>";
                    echo "          <td scope=\"row\">$employer->firstName</td>";
                    echo "          <td scope=\"row\">$employer->lastName</td>";
                    echo "          <td scope=\"row\">$employer->username</td>";
                    echo "          <td scope=\"row\">$employer->dob</td>";
                    echo "          <td scope=\"row\">$employer->phone</td>";
                    echo "          <td scope=\"row\">$employer->email</td>";
                    echo "          <td scope=\"row\">$employer->position</td>";
                    echo "          <td scope=\"row\">$employer->location</td>";
                    echo "          <td scope=\"row\">$employer->rating</td>";
                    createEditButton("employer", $employer->username, "<i class='fa fa-wrench' aria-hidden='true'>", "admin_edit_user.php");
                    createDeleteButton("username", $employer->username, "<i class='fa fa-trash' aria-hidden='true'>");
                    echo "        </tr>";
                }
                echo "      </tbody>";
                echo "</table>";
                unset($allEmployers);
            }
            function createEditButton($hiddenName, $hiddenValue, $buttonText, $actionPage)
            {
                echo "<td>";
                echo "<form action=$actionPage method=\"GET\">";
                echo "<input type=\"hidden\" name=$hiddenName value=$hiddenValue>";
                echo "<button type=\"submit\" class=\"btn btn-primary btn-sm\">$buttonText</button>";
                echo "</form>";
                echo "</td>";
            }
            function createDeleteButton($hiddenName, $employer, $buttonText)
            {
                echo "<td>";
                echo "<form method=\"POST\">";
                echo "<input type=\"hidden\" name=$hiddenName value=$employer>";
                echo "<button name=\"delete\" type=\"submit\" class=\"btn btn-danger btn-sm\" onclick=\"return confirm('Are you sure you want to delete $employer ?')\" >$buttonText</button>";
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