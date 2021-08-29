<?php
session_start();
$validLogin = require('php/login.php');
$validSession = require('php/check_session.php');
if ($validLogin || $validSession) {
    $username = $_SESSION['valid_user'];
    echo <<<END
                    <nav class="navbar navbar-default navbar-sticky bootsnav">
                        <div class="container">      
                            <!-- Start Header Navigation -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <a class="navbar-brand" href="index.php"><img src="img/logo.png" class="logo" alt="" style="width:250px;height:40px;" ></a>
                            </div>
                            <!-- End Header Navigation -->

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="navbar-menu">
                                <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                                        <li><a href="">Welcome, $username</a></li>
                                        <li><a href="login.php">Login</a></li>
                                        <li><a href="companies.php">Companies</a></li> 
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Browse</a>
                                            <ul class="dropdown-menu animated fadeOutUp" style="display: none; opacity: 1;">
                                                <li class="active"><a href="browse-job.php">Browse Jobs</a></li>
                                                <li><a href="company-detail.php">Job Detail</a></li>
                                                <li><a href="resume.php">Resume Detail</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="logout.php">Logout</a></li> 
                                    </ul>
                            </div><!-- /.navbar-collapse -->
                        </div>   
                    </nav>
    END;
} else {
    if (isset($_SESSION['valid_user'])) {
    }
    echo <<<END
    <nav class="navbar navbar-default navbar-sticky bootsnav">
        <div class="container">      
            <!-- Start Header Navigation -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="index.php"><img src="img/logo.png" class="logo" alt="" style="width:250px;height:40px;" ></a>
            </div>
            <!-- End Header Navigation -->

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                        <li><a href="login.php">Login</a></li>        
                        <li><a href="register.php">Sign Up</a></li> 
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Browse</a>
                            <ul class="dropdown-menu animated fadeOutUp" style="display: none; opacity: 1;">
                                <li class="active"><a href="browse-job.php">Browse Jobs</a></li>
                                <li><a href="companies.php">Companies</a></li>
                                <li><a href="company-detail.php">Job Detail</a></li>
                                <li><a href="resume.php">Resume Detail</a></li>
                            </ul>
                        </li>
                    </ul>
            </div><!-- /.navbar-collapse -->
        </div>   
    </nav>
    END;
}
