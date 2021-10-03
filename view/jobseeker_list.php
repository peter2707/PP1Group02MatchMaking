<?php
if (isset($_POST['delete'])) {
    require_once "../controller/admin_controller.php";
    $adminController= new AdminController();
    $username = $_POST['username'];    
    $adminController->deleteJobSeeker($username);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | JobSeeker</title>
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
                <div class="col-xl-11 mb-5">
                    <h1>All Job Seeker</h1>
                    
                </div>

                <div class="col-xl-11 mb-5" style="min-height: 200px;">
                    <?php
                    require_once '../model/db_connection.php';
                    $query = "SELECT * FROM jobseeker ORDER BY id";
                    $result = $db->query($query);
                    $numResults = $result->num_rows;
                    ?>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">FirstName</th>
                                <th scope="col">LastName</th>
                                <th scope="col">Username</th>
                                <th scope="col">DateOfBirth</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Email</th>
                                <th scope="col">field</th>
                                <th scope="col">Action</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if($numResults > 1){
                                echo "No result found!";
                            }else{
                                for ($i = 0; $i < $numResults; $i++) {
                                    $row = $result->fetch_assoc();
                                    $id = $row['id'];
                                    $firstName = $row['firstName'];
                                    $lastName = $row['lastName'];
                                    $username = $row['username'];
                                    $dob = $row['dateOfBirth'];
                                    $phone = $row['phone'];
                                    $email = $row['email'];
                                    $exp = $row['experience'];
                                    $field = $row['field'];
    
                                    echo "<tr>";
                                    echo "<td scope=\"row\">$id</td>";
                                    echo "<td scope=\"row\">$firstName</td>";
                                    echo "<td scope=\"row\">$lastName</td>";
                                    echo "<td scope=\"row\">$username</td>";
                                    echo "<td scope=\"row\">$dob</td>";
                                    echo "<td scope=\"row\">$phone</td>";
                                    echo "<td scope=\"row\">$email</td>";
                                    echo "<td scope=\"row\">$field</td>";
                                    createEditButton("id", $id, "Edit", "edit_jobseeker.php");
                                    createDeleteButton("username", $username, "Delete");
                                    echo "</tr>";
                                }
    
                                $result->free();
                                $db->close();
    
                                function createEditButton($hiddenName, $hiddenValue, $buttonText, $actionPage){
                                    echo "<td>";
                                    echo "<form action=$actionPage method=\"GET\">";
                                    echo "<input type=\"hidden\" name=$hiddenName value=$hiddenValue>";
                                    echo "<button type=\"submit\" class=\"btn btn-primary\">$buttonText</button>";
                                    echo "</form>";
                                    echo "</td>";
                                }
                                function createDeleteButton($hiddenName, $username, $buttonText){
                                    echo "<td>";
                                    echo "<form method=\"POST\">";
                                    echo "<input type=\"hidden\" name=$hiddenName value=$username>";
                                    echo "<button name=\"delete\" type=\"submit\" class=\"btn btn-danger\" onclick=\"return confirm('Are you sure you want to delete $username ?')\" >$buttonText</button>";
                                    echo "</form>";
                                    echo "</td>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
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