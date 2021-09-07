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
    include("footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>