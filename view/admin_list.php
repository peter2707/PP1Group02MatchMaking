<?php
if (isset($_POST['delete'])) {
    require_once "../controller/admin_controller.php";
    $adminController= new AdminController();
    $username = $_POST['username'];    
    $adminController->deleteAccount($username, "admin");
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
                    <h1>All Admins</h1>
                    
                </div>
                <div class="col-xl-11 mb-5" style="min-height: 200px;">
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

                    $allAdmins = array();
                    $allAdmins = $ac->getAllAdmin();
                    if (count($allAdmins) < 1) {
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
                            echo "            <th scope='col'>Action</th>";
                            echo "            <th scope='col'></th>";
                            echo "        </tr>";
                            echo "      </thead>";
                            echo "      <tbody>";
                        foreach ($allAdmins as $admin) {
                            echo "        <tr>";
                            echo "          <td scope=\"row\">$admin->id</td>";
                            echo "          <td scope=\"row\">$admin->firstName</td>";
                            echo "          <td scope=\"row\">$admin->lastName</td>";
                            echo "          <td scope=\"row\">$admin->username</td>";
                            echo "          <td scope=\"row\">$admin->dob</td>";
                            echo "          <td scope=\"row\">$admin->phone</td>";
                            echo "          <td scope=\"row\">$admin->email</td>";
                            echo "          <td scope=\"row\">$admin->position</td>";
                            createEditButton("id", $admin->id, "Edit", "edit_emp.php");
                            createDeleteButton("username", $admin->username, "Delete");
                            echo "        </tr>";
                        }
                            echo "      </tbody>";
                            echo "</table>";
                            unset($allAdmins);
                    }
                    function createEditButton($hiddenName, $hiddenValue, $buttonText, $actionPage){
                        echo "<td>";
                        echo "<form action=$actionPage method=\"GET\">";
                        echo "<input type=\"hidden\" name=$hiddenName value=$hiddenValue>";
                        echo "<button type=\"submit\" class=\"btn btn-solid-sm\">$buttonText</button>";
                        echo "</form>";
                        echo "</td>";
                    }
                    function createDeleteButton($hiddenName, $admin, $buttonText){
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
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </header>
    <!-- end of header -->



    <!-- footer start -->
    <?php
        require_once("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>