<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | Edit</title>
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
                <div class="col-xl-11 mb-4">
                    <h1>Edit</h1>
                </div>

                <div class="col-xl-11">
                    <?php
                    require_once '../model/db_connection.php';
                    $id = $_GET['id'];

                    if (isset($_POST['submit'])) {
                        $submit = $_POST['submit'];



                        $firstName = $_POST['firstName'];
                        $lastName = $_POST['lastName'];
                        $username = $_POST['username'];
                        $password = $_POST['password'];
                        $dob = $_POST['dob'];
                        $phone = $_POST['phone'];
                        $email = $_POST['email'];
                        $rate = $_POST['rate'];

                        $query = "UPDATE employer SET firstName=?, lastName=?, username=?, password=?, dateOfBirth=?, phone=?, email=?, rating=? WHERE id = ?";

                        $stmt = $db->prepare($query);
                        $stmt->bind_param("ssssssssi", $firstName, $lastName, $username, $password, $dob, $phone, $email, $rate, $id);
                        $stmt->execute();

                        $affectedRows = $stmt->affected_rows;
                        $stmt->close();
                        $db->close();

                        if ($affectedRows == 1) {
                            echo "Successfully Updated Job<br><br>";
                            echo "<a href=\"adminIndex.php\" class=\"btn btn-success\">Back to Job List</a>";
                            echo "<br><hr>";
                            exit;
                        } else {
                            echo "Failed to Updated Job<br><br>";
                            echo "<a href=\"adminIndex.php\" class=\"btn btn-success\">Back to Job List</a>";
                            echo "<br><hr>";
                            exit;
                        }
                    } else {
                        $queryEmp = "SELECT * FROM employer WHERE id = ?";
                        $stmtEmp = $db->prepare($queryEmp);
                        $stmtEmp->bind_param("i", $id);

                        $stmtEmp->execute();
                        $result = $stmtEmp->get_result();
                        $stmtEmp->close();

                        $row = $result->fetch_assoc();

                        $firstName = $row['firstName'];
                        $lastName = $row['lastName'];
                        $username = $row['username'];
                        $password = $row['password'];
                        $dob = $row['dateOfBirth'];
                        $phone = $row['phone'];
                        $email = $row['email'];
                        $rate = $row['rating'];

                        echo <<<END
                    
                    <form action="" method="POST">
                        <table class="table">
                            <tr>
                                <td scope="row">First Name:</td>
                                <td scope="row"><input type="text" name="firstName" value="$firstName" required></td>
                            </tr>
                            <tr>
                                <td scope="row">Last Name:</td>
                                <td scope="row"><input type="text" name="lastName" value="$lastName" required ></td>
                            </tr>

                            <tr>
                                <td scope="row">Username:</td>
                                <td scope="row"><input type="text" name="username" value="$username" required></td>
                            </tr>
                            <tr>
                                <td scope="row">Password:</td>
                                <td scope="row"><input type="password" name="password" value="$password" required></td>
                            </tr>
                            <tr>
                                <td scope="row">Date of Birth:</td>
                                <td scope="row"><input type="text" name="dob" value="$dob" required></td>
                            </tr>
                            <tr>
                                <td scope="row">Phone:</td>
                                <td scope="row"><input type="text" name="phone" value="$phone" required></td>
                            </tr>
                            <tr>
                                <td scope="row">Email:</td>
                                <td scope="row"><input type="text" name="email" value="$email" required></td>
                            </tr>
                            <tr>
                                <td scope="row">Rating:</td>
                                <td scope="row"><input type="text" name="rate" value="$rate" required></td>
                            </tr>
                        </table>
                        <br>
                        <input type="hidden" name="id" value=$id>
                        <input type="submit" name="submit" value="Update">
                        <input type="button" value="Cancel" class="homebutton" id="btnHome" onClick="document.location.href='adminIndex.php'" />
                    </form>
    END;
                        $result->free();
                    }
                    $db->close();

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
        include("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>