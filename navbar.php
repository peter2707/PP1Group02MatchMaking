<?php
session_start();
$validSession = require('includes/check_session.inc.php');
if ($validSession) {
    $username = $_SESSION['valid_user'];
    echo <<<END

        <!-- Navigation -->
        <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
            <div class="container">

                <!-- Image Logo -->
                <a class="navbar-brand logo-image" href="index.php"><img src="images/logo.svg" alt="Logo"></a>

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
                            <a class="nav-link" href="index.php#details">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#contact">Contact Support</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">$username</a>
                            <ul class="dropdown-menu" aria-labelledby="dropdown01">
                                <li><a class="dropdown-item" href="userprofile.php">Profile</a></li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li><a class="dropdown-item" href="terms.html">Matches</a></li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li><a class="dropdown-item" href="terms.html">Settings</a></li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li><a class="dropdown-item" href="includes/logout.inc.php">Logout</a></li>
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
} else {
    if (isset($_SESSION['valid_user'])) {
    }
    echo <<<END

    <!-- Navigation -->
    <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
        <div class="container">

            <!-- Image Logo -->
            <a class="navbar-brand logo-image" href="index.php"><img src="images/logo.svg" alt="Logo"></a>

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
                        <a class="nav-link" href="index.php#details">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#contact">Contact Support</a>
                    </li>
                </ul>
                <span class="nav-item">
                    <a class="btn-solid-sm" href="login.php">Login</a>
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
