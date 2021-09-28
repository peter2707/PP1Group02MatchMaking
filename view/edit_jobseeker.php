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
                    $firstName = $_POST['firstName'];
                    $lastName = $_POST['lastName'];
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $dob = $_POST['dob'];
                    $phone = $_POST['phone'];
                    $email = $_POST['email'];
                    $exp = $_POST['exp'];
                    $field = $_POST['field'];

                    $query = "UPDATE jobseeker SET firstName=?, lastName=?, username=?, password=?, dateOfBirth=?, phone=?, email=?, experience=?, field=? WHERE id = ?";

                    $stmt = $db->prepare($query);
                    $stmt->bind_param("sssssssssi", $firstName, $lastName, $username, $password, $dob, $phone, $email, $exp, $field, $id);
                    $stmt->execute();

                    $affectedRows = $stmt->affected_rows;
                    $stmt->close();
                    $db->close();

                    if ($affectedRows == 1) {
                        echo "Successfully Updated Job<br><br>";
                        echo "<a href=\"admin_index.php\" class=\"btn btn-success\">Back to Job List</a>";
                        echo "<br><hr>";
                        exit;
                    } else {
                        echo "Failed to Updated Job<br><br>";
                        echo "<a href=\"admin_index.php\" class=\"btn btn-success\">Back to Job List</a>";
                        echo "<br><hr>";
                        exit;
                    }
                } else {
                    $querySeeker = "SELECT * FROM jobseeker WHERE id = ?";
                    $stmtSeeker = $db->prepare($querySeeker);
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
                            <td scope="row">Experience:</td>
                            <td scope="row"><input type="text" name="exp" value="$exp" required></td>
                        </tr>
                        <tr>
                            <td scope="row">field:</td>
                            <td scope="row"><input type="text" name="field" value="$field" required></td>
                        </tr>
					</table>
					<br>
					<input type="hidden" name="id" value=$id>
					<input type="submit" name="submit" value="Update">
					<input type="button" value="Cancel" class="homebutton" id="btnHome" onClick="document.location.href='admin_index.php'" />
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