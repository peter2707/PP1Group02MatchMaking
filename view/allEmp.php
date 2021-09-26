<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | Employer</title>
    <?php
        include("component/header.php");
    ?>
</head>

<body data-bs-spy="scroll" data-bs-target="#navbarExample" class="text-center">

    <!-- Navigation Start  -->
    <?php
        include("component/navbar.php");
    ?>
    <!-- Navigation End  -->

    <!-- Header -->
    <header id="ex-header" class="ex-header">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-xl-11 mb-2">
                    <h1>All Employer</h1>
                    <p class="mt-5 mb-2" style="color: red;">
                        <?php
                        // Error messages
                        if (isset($_GET["error"])) {
                            if ($_GET["error"] == "emptyusername") {
                                echo "You must enter a valid username!";
                            } else if ($_GET["error"] == "emptypassword") {
                                echo "You must enter a valid password!";
                            } else if ($_GET["error"] == "failed") {
                                echo "Something went wrong. Please try again!";
                            } else if ($_GET["error"] == "incorrect") {
                                echo "Incorrect password or email. Please try again!";
                            }
                        }
                        ?>
                    </p>
                    <p class="mt-5 mb-2" style="color: #4BB543;">
                        <?php
                        // Account created message
                        if (isset($_GET["success"])) {
                            if ($_GET["success"] == "created") {
                                echo "Your account has been successfully created.<br>Please log in to continue!";
                            }
                        }
                        ?>
                    </p>
                </div>
                <div class="col-xl-11 mb-5">
                    <?php
                    require_once '../model/db_connection.php';
                    $query = "SELECT * FROM employer ORDER BY id";
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
                                <th scope="col">Rating</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 0; $i < $numResults; $i++) {
                                $row = $result->fetch_assoc();
                                $id = $row['id'];
                                $firstName = $row['firstName'];
                                $lastName = $row['lastName'];
                                $username = $row['username'];
                                $dob = $row['dateOfBirth'];
                                $phone = $row['phone'];
                                $email = $row['email'];
                                $rate = $row['rating'];

                                echo "<tr>";
                                echo "<td scope=\"row\" >$id</td>";
                                echo "<td scope=\"row\">$firstName</td>";
                                echo "<td scope=\"row\">$lastName</td>";
                                echo "<td scope=\"row\">$username</td>";
                                echo "<td scope=\"row\">$dob</td>";
                                echo "<td scope=\"row\">$phone</td>";
                                echo "<td scope=\"row\">$email</td>";
                                echo "<td scope=\"row\">$rate</td>";
                                createEditButton("id", $id, "Edit", "editEmp.php");
                                createDeleteButton("id", $id, "Delete", "deleteEmp.php");
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
                            function createDeleteButton($hiddenName, $hiddenValue, $buttonText, $actionPage){
                                echo "<td>";
                                echo "<form action=$actionPage method=\"GET\">";
                                echo "<input type=\"hidden\" name=$hiddenName value=$hiddenValue>";
                                echo "<button type=\"submit\" class=\"btn btn-danger\">$buttonText</button>";
                                echo "</form>";
                                echo "</td>";
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
        include("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>