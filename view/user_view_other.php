<?php
if(isset($_GET['jobseeker'])){
    $usertype = "jobseeker";
    $username = $_GET['jobseeker'];
}elseif(isset($_GET['employer'])){
    $usertype = "employer";
    $username = $_GET['employer'];
}

require_once '../controller/user_controller.php';
// check if the session has not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// call controllers
$uc = new UserController();
$viewUser = $uc->getUser($usertype, $username);
$social = $uc->getSocialLink($viewUser->username);
$userImage = $viewUser->image;
if ($viewUser->image == NULL) {
    $defaultImage = file_get_contents("../images/user.png");
    $userImage = base64_encode($defaultImage);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Webpage Title -->
    <title>JobMatch | <?php echo "$viewUser->username"; ?></title>
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

    <!-- User Profile section start -->
    <header class="ex-header">
        <div class="container">
            <div class="main-body">
                <div class="row gutters-sm">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <?php echo "<img src='data:image/png;base64, $userImage' alt='User' class='rounded-circle' width='150' height='150'>"; ?>
                                    <div class="mt-3">
                                        <h4><?php echo "$viewUser->firstName $viewUser->lastName"; ?></h4>
                                        
                                        <p class="text-secondary">
                                        <?php 
                                        if($usertype == "jobseeker"){
                                            echo "$viewUser->field";
                                        }elseif($usertype == "employer"){
                                            echo "$viewUser->position";
                                        }
                                        ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-linkedin icon-inline text-primary">
                                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                                            <rect x="2" y="9" width="4" height="12"></rect>
                                            <circle cx="4" cy="4" r="2"></circle>
                                        </svg>&nbsp; LinkedIn</h6>
                                    <span class="text-secondary"><?php echo "$social->linkedin"; ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github mr-2 icon-inline">
                                            <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                                        </svg>&nbsp; Github</h6>
                                    <span class="text-secondary"><?php echo "$social->github"; ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter mr-2 icon-inline text-info">
                                            <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                                        </svg>&nbsp; Twitter</h6>
                                    <span class="text-secondary"><?php echo "$social->twitter"; ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram mr-2 icon-inline text-danger">
                                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                        </svg>&nbsp; Instagram</h6>
                                    <span class="text-secondary"><?php echo "$social->instagram"; ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook mr-2 icon-inline text-primary">
                                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                        </svg>&nbsp; Facebook</h6>
                                    <span class="text-secondary"><?php echo "$social->facebook"; ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="text-center pt-4 pb-5">
                            <?php echo "<h3>$viewUser->username's Detail</h3>"; ?>
                            </div>
                            <div class="card-body">
                                <hr>
                                <div class="row">
                                    <div class="col-sm-4 text-start">
                                        <h6 class="mt-2 ms-5">Email</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary text-start mt-1">
                                        <span class="text-secondary"><?php echo "$viewUser->email"; ?></span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-4 text-start">
                                        <h6 class="mt-2 ms-5">Phone</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary text-start mt-1">
                                    <span class="text-secondary"><?php echo "$viewUser->phone"; ?></span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-4 text-start">
                                        <h6 class="mt-2 ms-5">Date of Birth</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary text-start mt-1">
                                    <span class="text-secondary"><?php echo "$viewUser->dob"; ?></span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-4 text-start">
                                        <?php 
                                            if($usertype == "jobseeker"){
                                                echo "<h6 class='mt-2 ms-5'>Field</h6>";
                                            }elseif($usertype == "employer"){
                                                echo "<h6 class='mt-2 ms-5'>Position</h6>";
                                            }
                                        ?>
                                        
                                    </div>
                                    <div class="col-sm-7 text-secondary text-start mt-1">
                                    <span class="text-secondary">
                                        <?php 
                                            if($usertype == "jobseeker"){
                                                echo "$viewUser->field";
                                            }elseif($usertype == "employer"){
                                                echo "$viewUser->position";
                                            }
                                        ?>
                                    </span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row pt-1 pb-1">
                                    <div class="col-sm-12">
                                        <?php echo "
                                            <a href='mailto:$viewUser->email?subject=Subject...&body=Message...'>
                                                <button class='btn btn-success-sm'><i class='fa fa-envelope' aria-hidden='true'></i> Send Email</button>
                                            </a>
                                        "; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of container -->
    </header>
    <!-- User Profile section End -->


    <!-- footer start -->
    <?php
    require_once("component/footer.php");
    ?>
    <!-- end of footer -->

</body>

</html>