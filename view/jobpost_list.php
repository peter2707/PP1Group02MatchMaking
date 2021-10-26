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

if (isset($_POST['delete'])) {
    require_once "../controller/admin_controller.php";
    $adminController = new AdminController();
    $username = $_POST['username'];
    $adminController->deleteAccount($username, "admin");
} else {
    $allFeedbacks = array();
    $allFeedbacks = $ac->getAllFeedback();

    $allReports = array();
    $allReports = $ac->getAllReport();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | Admin List</title>
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
            <div class="row justify-content-md-center">
                <div class="col-xl-11 mb-2">
                    <h1>All Feedbacks</h1>
                </div>
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </header>
    <!-- end of header -->

    <div class="container mt-5">
        <div class="mb-5" style="min-height: 200px;">
            <?php
            if (count($allFeedbacks) < 1) {
                echo "<h3>No result found yet.</h3> <small>All feedback made by user will be appeared here.</small>";
            } else {
                echo "<table class='table'>";
                echo "      <thead>";
                echo "        <tr>";
                echo "            <th scope='col'>ID</th>";
                echo "            <th scope='col'>User</th>";
                echo "            <th scope='col'>Rating</th>";
                echo "            <th scope='col'>Comment</th>";
                echo "            <th scope='col'>Date</th>";
                echo "            <th scope='col'></th>";
                echo "        </tr>";
                echo "      </thead>";
                echo "      <tbody>";
                foreach ($allFeedbacks as $feedback) {
                    echo "        <tr>";
                    echo "          <td scope=\"row\">$admin->id</td>";
                    echo "          <td scope=\"row\">$admin->username</td>";
                    echo "          <td scope=\"row\">$admin->rating</td>";
                    echo "          <td scope=\"row\">$admin->comment</td>";
                    echo "          <td scope=\"row\">$admin->date</td>";
                    createDeleteButton("username", $admin->username, "Delete");
                    echo "        </tr>";
                }
                echo "      </tbody>";
                echo "</table>";
                unset($allFeedbacks);
            }
            function createDeleteButton($hiddenName, $admin, $buttonText)
            {
                echo "<td>";
                echo "<form method=\"POST\">";
                echo "<input type=\"hidden\" name=$hiddenName value=$admin>";
                echo "<button name=\"delete\" type=\"submit\" class=\"btn btn-danger-sm\" onclick=\"return confirm('Are you sure you want to delete $admin ?')\" >$buttonText</button>";
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