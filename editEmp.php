<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- SEO Meta Tags -->
    <meta name="description" content="Your description">
    <meta name="author" content="Your name">

    <!-- OG Meta Tags to improve the way the post looks when you share the page on Facebook, Twitter, LinkedIn -->
    <meta property="og:site_name" content="" />
    <!-- website name -->
    <meta property="og:site" content="" />
    <!-- website link -->
    <meta property="og:title" content="" />
    <!-- title shown in the actual shared post -->
    <meta property="og:description" content="" />
    <!-- description shown in the actual shared post -->
    <meta property="og:image" content="" />
    <!-- image link, make sure it's jpg -->
    <meta property="og:url" content="" />
    <!-- where do you want your post to link to -->
    <meta name="twitter:card" content="summary_large_image">
    <!-- to have large image post format in Twitter -->

    <!-- Webpage Title -->
    <title>JobMatch | Home</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/fontawesome-all.min.css" rel="stylesheet">
    <link href="css/swiper.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    <!-- Favicon  -->
    <link rel="icon" href="images/favicon.png">
</head>

<body data-bs-spy="scroll" data-bs-target="#navbarExample">

    <!-- Navigation Start  -->
    <?php
    include("navbar.php");
    ?>
    <!-- Navigation End  -->

    <!-- Header -->
    <header id="header" class="header">
        <div class="container">
            <div class="row">
                <a href="adminIndex.php" class="btn btn-success">Back to home</a>

                <?php
                require_once 'includes/db_connection.inc.php';
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
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </header>
    <!-- end of header -->



    <!-- footer start -->
    <?php
    include("footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>