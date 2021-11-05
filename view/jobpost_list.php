<?php
require_once '../controller/admin_controller.php';
require_once '../controller/session_controller.php';
// call controllers
$sc = new SessionController();
$ac = new AdminController();

// check if the session has not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    $allJobPosts = array();
    $allJobPosts = $ac->getAllJobPost();
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | Admin List</title>
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
                <div class="col-xl-11 mb-2">
                    <h1>Job Posts</h1>
                </div>
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </header>
    <!-- end of header -->

    <div class="container mt-5">
        <div class="mb-5" style="min-height: 400px;">
            <?php
            if($sc->getUserType() == "admin"){
                if (count($allJobPosts) < 1) {
                    echo "<h3>No data available yet.</h3> <small>All job posts will be displayed here once available.</small>";
                } else {
                    foreach ($allJobPosts as $post) {
                        $badge = "badge bg-primary";
                        if ($post->type == "Full Time") {
                            $badge = "badge bg-success";
                        } elseif ($post->type == "Part Time") {
                            $badge = "badge bg-primary";
                        } elseif ($post->type == "Casual") {
                            $badge = "badge bg-warning";
                        } elseif ($post->type == "Contract") {
                            $badge = "badge bg-danger";
                        }
                        echo <<< END
                            <div class="job-card">
                                <div class="card border-0 mb-5">
                                    <div class="card-body">
                                        <div class="row d-flex align-items-center">
                                            <div class="col text-start">
                                                <small class="ms-1"><span class="$badge">$post->type</span></small>
                                                <h4 style="font-size: 30px; font-weight: lighter;" class="text-start">$post->position</h4>
                                                <p class="card-text"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp; $post->location &nbsp;&nbsp; <i style="font-size: 20px" class="bi bi-cash"></i>&nbsp; $post->salary</p>
                                                <small class="card-text text-success"><i class="fa fa-users" aria-hidden="true"></i>&nbsp; Match: $post->matches time(s)</small>
                                                <br>
                                                <small class="card-text"><i class="fa fa-clock" aria-hidden="true"></i>&nbsp; $post->date</small>
                                                <br><br>
                                                <p class="card-text"><b>ID:</b> $post->id &nbsp;&nbsp;&nbsp; <b>Employer:</b> $post->employer</p>
                                            </div>
                                            <div class="col text-end">
                                                <form action="employer_view_post.php" method="GET">
                                                    <input type="hidden" name="id" value=$post->id>
                                                    <button type="submit" class="btn btn-solid-lg">View</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        END;
                    }
                    unset($allJobPosts);
                }
            } else {
                echo "<div class='col-xl-10 offset-xl-1' style='height: 300px;'>
                            <h4>You don't have access to this page. Please <a href='login.php'>log in</a></h4>
                        </div>";
            }
            ?>
        </div>
    </div>

    <!-- footer start -->
    <?php
    require_once("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>