<?php
if(isset($_POST['logout'])){
    require_once '../controller/login_controller.php';
    $loginController = new LoginController();
    $loginController->logOut();
}
// check if the session has not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../controller/session_controller.php';

$sessionController = new SessionController();
$validSession = $sessionController->checkSession();
$userType = $sessionController->getUserType();

if ($validSession && $userType == "jobseeker") {                       //jobseeker nav-bar
    $username = $sessionController->getUserName();
    echo <<<END

        <!-- Navigation -->
        <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
            <div class="container">

                <!-- Image Logo -->
                <a class="navbar-brand logo-image" href="index.php"><img src="../images/logo.svg" alt="Logo"></a>

                <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                    <ul class="navbar-nav ms-auto navbar-nav-scroll">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php#header">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="jobseeker_match.php">Your Matches</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="advice.php">Career Advices</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">$username</a>
                            <ul class="dropdown-menu" aria-labelledby="dropdown01">
                                <li><a class="dropdown-item" href="user_profile.php">Profile</a></li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li><a class="dropdown-item" href="user_settings.php">Settings</a></li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li><a class="dropdown-item" href="helpcentre.php">Help Centre</a></li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <form method="POST">
                                <li><button class="dropdown-item text-danger" type="submit" name="logout">Log Out</button></li>
                                </form>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- end of navbar-collapse -->
            </div>
            <!-- end of container -->
        </nav>
        <!-- end of navbar -->
        <!-- end of navigation -->

    END;
} elseif ($validSession && $userType == "employer") {                    //employer nav-bar
    $username = $sessionController->getUserName();
    echo <<<END

    <!-- Navigation -->
    <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
        <div class="container">

            <!-- Image Logo -->
            <a class="navbar-brand logo-image" href="index.php"><img src="../images/logo.svg" alt="Logo"></a>

            <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav ms-auto navbar-nav-scroll">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php#header">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="employer_post.php">Your Posts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="advice.php">Hiring Advices</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">$username</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown01">
                            <li><a class="dropdown-item" href="user_profile.php">Profile</a></li>
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                            <li><a class="dropdown-item" href="user_settings.php">Settings</a></li>
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                            <li><a class="dropdown-item" href="helpcentre.php">Help Centre</a></li>
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                            <form method="POST">
                                <li><button class="dropdown-item text-danger" type="submit" name="logout">Log Out</button></li>
                            </form>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- end of navbar-collapse -->
        </div>
        <!-- end of container -->
    </nav>
    <!-- end of navbar -->
    <!-- end of navigation -->

    END;
} elseif ($validSession && $userType == "admin") {                     //admin nav-bar
    $username = $sessionController->getUserName();
    echo <<<END

    <!-- Navigation -->
    <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
        <div class="container">

            <!-- Image Logo -->
            <a class="navbar-brand logo-image" href="index.php"><img src="../images/logo.svg" alt="Logo"></a>

            <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav ms-auto navbar-nav-scroll">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="admin_index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">View Users</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown01">
                            <li><a class="dropdown-item" href="jobseeker_list.php">Job Seeker</a></li>
                            <li><div class="dropdown-divider"></div></li>
                            <li><a class="dropdown-item" href="employer_list.php">Employer</a></li>
                            <li><div class="dropdown-divider"></div></li>
                            <li><a class="dropdown-item" href="admin_list.php">Admin</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown02" data-bs-toggle="dropdown" aria-expanded="false">View Jobs</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown02">
                            <li><a class="dropdown-item" href="jobmatch_list.php">Job Matches</a></li>
                            <li><div class="dropdown-divider"></div></li>
                            <li><a class="dropdown-item" href="jobpost_list.php">Job Posts</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="feedback_list.php">Feedbacks</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">$username</a>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li>
                                <form action="admin_edit_user.php" method="GET">
                                    <input type="hidden" name=admin value=$username>
                                    <button type="submit" class="dropdown-item">Settings</button>
                                </form>
                            </li>
                            <li><div class="dropdown-divider"></div></li>
                            <form method="POST">
                                <li><button class="dropdown-item text-danger" type="submit" name="logout">Log Out</button></li>
                            </form>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- end of navbar-collapse -->
        </div>
        <!-- end of container -->
    </nav>
    <!-- end of navbar -->
    <!-- end of navigation -->

    END;
} else {                                                        //non logged-in-user nav-bar
    echo <<<END

    <!-- Navigation -->
    <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
        <div class="container">

            <!-- Image Logo -->
            <a class="navbar-brand logo-image" href="index.php"><img src="../images/logo.svg" alt="Logo"></a>

            <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav ms-auto navbar-nav-scroll">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php#header">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#getstarted">Get Started</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#aboutUs">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#contact">Help & Support</a>
                    </li>
                </ul>
                <span class="nav-item">
                    <a class="btn-solid-sm" href="login.php">Log In</a>
                </span>
            </div>
            <!-- end of navbar-collapse -->
        </div>
        <!-- end of container -->
    </nav>
    <!-- end of navbar -->
    <!-- end of navigation -->
    
    END;
}
