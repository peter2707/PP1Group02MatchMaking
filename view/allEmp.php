<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | Sign Up</title>
    <?php
        include("component/header.php");
    ?>
</head>

<body data-bs-spy="scroll" data-bs-target="#navbarExample">

    <!-- Navigation Start  -->
    <?php
        include("component/navbar.php");
    ?>
    <!-- Navigation End  -->

    <!-- Header -->
    <header id="ex-header" class="ex-header">
        <div class="container">
            <div class="row">

                <a href="adminIndex.php" class="btn btn-success">Back to home</a>
                <?php
                require_once '../includes/db_connection.inc.php';

                $query = "SELECT * FROM employer ORDER BY id";
                $result = $db->query($query);
                $numResults = $result->num_rows;

                ?>

                <table class=”table”>
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Username</th>
                            <th scope="col">Password</th>
                            <th scope="col">Date of Birth</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Email</th>
                            <th scope="col">Rating</th>
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
                            $password = $row['password'];
                            $dob = $row['dateOfBirth'];
                            $phone = $row['phone'];
                            $email = $row['email'];
                            $rate = $row['rating'];

                            echo "<tr>";
                            echo "<td scope=\"row\" >$id</td>";
                            echo "<td scope=\"row\">$firstName</td>";
                            echo "<td scope=\"row\">$lastName</td>";
                            echo "<td scope=\"row\">$username</td>";
                            echo "<td scope=\"row\">$password</td>";
                            echo "<td scope=\"row\">$dob</td>";
                            echo "<td scope=\"row\">$phone</td>";
                            echo "<td scope=\"row\">$email</td>";
                            echo "<td scope=\"row\">$rate</td>";
                            createButtonColumn("id", $id, "Edit", "editEmp.php");
                            createButtonColumn("id", $id, "Delete", "deleteEmp.php");
                            echo "</tr>";
                        }

                        $result->free();
                        $db->close();

                        function createButtonColumn($hiddenName, $hiddenValue, $buttonText, $actionPage)
                        {
                            echo "<td>";
                            echo "<form action=$actionPage method=\"GET\">";
                            echo "<input type=\"hidden\" name=$hiddenName value=$hiddenValue>";
                            echo "<button type=\"submit\" class=\"btn btn-primary\">$buttonText</button>";
                            echo "</form>";
                            echo "</td>";
                        }


                        ?>

                    </tbody>
                </table>
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