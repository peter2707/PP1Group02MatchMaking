<?php
if (isset($_POST['match'])) {
    require_once '../controller/matchmaking_controller.php';
    $mmc = new MatchmakingController();

    // require files
    require_once '../controller/session_controller.php';
    // check if the session has not started yet
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // call controllers
    $sc = new SessionController();

    $salary = $_POST['salary'];
    $job = $_POST['job'];
    $location = $_POST['location'];
    $type = $_POST['type'];

    $mmc->compareParam($salary, $location, $type, $job, $sc->getUserName());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | User</title>
    <?php
    require_once("component/header.php");
    ?>
</head>

<body class="text-center">

    <!-- Navigation Start  -->
    <?php
    require_once("component/navbar.php");
    ?>
    <!-- Navigation End  -->

    <!-- Header -->
    <header class="ex-header">
        <div class="container">
            <div class="row">

            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header> <!-- end of ex-header -->
    <!-- end of header -->


    <div class="ex-basic-1 pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1">
                    <form method="POST">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Input your desire salary" name="salary">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Input your desire job type" name="job">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Input your desire location" name="location">
                        </div>
                        <div class="mb-3">
                            <select class="form-select" name="type">
                                <option value="fulltime">Full Time</option>
                                <option value="parttime">Part Time</option>
                            </select>
                        </div>

                        <button class="btn btn-primary btn-sm" type="submit" name="match">Match</button>
                    </form>

                </div> <!-- end of col -->

            </div> <!-- end of row -->

        </div> <!-- end of container -->

    </div> <!-- end of ex-basic-1 -->
    <!-- end of basic -->

    <?php
    if (isset($_POST['match'])) {
        require_once("../controller/matchmaking_controller.php");
        // require files
        require_once '../controller/session_controller.php';
        // check if the session has not started yet
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // call controllers
        $sc = new SessionController();
        $mmc = new MatchmakingController();
        $jobposts = array();
        $jobposts = $mmc->getAllMatches($sc->getUserName());



        foreach ($jobposts as $post) {
            echo <<<END
            <div class="container">
                <div class="row">
                    <p>$post->employer $post->requirement $post->contact $post->description</p>
                </div>
            </div>
        END;
        }
    }
    ?>
    <!-- footer start -->
    <?php
    require_once("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>