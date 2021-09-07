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
    <header id="ex-header" class="ex-header">
        <div class="container">
            <div class="row">
                <a href="adminIndex.php" class="btn btn-success">Back to home</a>

                <?php
                require_once 'includes/db_connection.inc.php';
                $id = $_GET['id'];

                if (isset($_POST['submit'])) {
                    $submit = $_POST['submit'];


                    $query = "DELETE FROM employer WHERE id = ?";

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

                    $query = "SELECT * FROM employer WHERE id = ?";
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
                    $rate = $row['rating'];


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
                            <td scope="row">Rating:</td>
                            <td scope="row">$rate</td>
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
    include("footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>