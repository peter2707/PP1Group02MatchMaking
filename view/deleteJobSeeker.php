<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | Sign Up</title>
    <?php
        require_once("component/header.php");
    ?>
</head>

<body data-bs-spy="scroll" data-bs-target="#navbarExample">

    <!-- Navigation Start  -->
    <?php
        require_once("component/navbar.php");
    ?>
    <!-- Navigation End  -->

    <!-- Header -->
    <header id="ex-header" class="ex-header">
        <div class="container">
            <div class="row">
                <?php
                require_once '../model/db_connection.php';
                $id = $_GET['id'];

                if (isset($_POST['submit'])) {
                    $submit = $_POST['submit'];

                    $query = "DELETE FROM jobseeker WHERE id = ?";
                    $stmt = $db->prepare($query);
                    $stmt->bind_param("i",$id);
                    $stmt->execute();

                    $affectedRows = $stmt->affected_rows;
                    $stmt->close();
                    $db->close();

                    if ($affectedRows == 1) {
                        echo "Successfully Deleted Job Seeker<br><br>";
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

                    $query = "SELECT * FROM jobseeker WHERE id = ?";
                    $stmtSeeker = $db->prepare($query);
                    $stmtSeeker->bind_param("i", $id);

                    $stmtSeeker->execute();
                    $result = $stmtSeeker->get_result();
                    $stmtSeeker->close();

                    $row = $result->fetch_assoc();

                    $firstName = $row['firstName'];
                    $lastName = $row['lastName'];
                    $username = $row['username'];
                    $password = $row['password'];
                    $dob = $row['dateOfBirth'];
                    $phone = $row['phone'];
                    $email = $row['email'];
                    $exp = $row['experience'];
                    $field = $row['field'];

                    echo <<<END
				
				<form action="" method="POST">
					<table class=”table”>
                        <tr>
                            <td scope="row">First Name:</td>
                            <td scope="row">$firstName</td>
                        </tr>
                        <tr>
                            <td scope="row">Last Name:</td>
                            <td scope="row">$lastName</td>
                        </tr>

                        <tr>
                            <td scope="row">Username:</td>
                            <td scope="row">$username</td>
                        </tr>
                        <tr>
                            <td scope="row">Password:</td>
                            <td scope="row">$password</td>
                        </tr>
                        <tr>
                            <td scope="row">Date of Birth:</td>
                            <td scope="row">$dob</td>
                        </tr>
                        <tr>
                            <td scope="row">Phone:</td>
                            <td scope="row">$phone</td>
                        </tr>
                        <tr>
                            <td scope="row">Email:</td>
                            <td scope="row">$email</td>
                        </tr>
                        <tr>
                            <td scope="row">field:</td>
                            <td scope="row">$field</td>
                        </tr>
					</table>
					<br>
					<input type="hidden" name="id" value=$id>
					<input type="submit" name="submit" value="Delete">
					<input type="button" value="Cancel" class="homebutton" id="btnHome" onClick="document.location.href='adminIndex.php'" />
				</form>
END;
                    $result->free();
                }
                $db->close();

                ?>


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