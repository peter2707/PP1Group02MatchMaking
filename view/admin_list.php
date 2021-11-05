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

$allAdmins = array();
$allAdmins = $ac->getAllAdmin();

if (isset($_POST['delete'])) {
    $username = $_POST['username'];
    $ac->deleteAccount($username, "admin");
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
                    <h1>Admins</h1>
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
                if (count($allAdmins) < 1) {
                    echo "<h3>No result found yet.</h3> <small><b>To add a user</b>, click on the Add New User button</small>";
                } else {
                    foreach ($allAdmins as $admin) {
                        echo <<< END
                            <div class="job-card">
                                <div class="card border-0 mb-5">
                                    <div class="card-body">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-md-1 text-center" id="content-desktop"><img src='../images/user.png' alt='User' class='rounded-circle' width='50' height='50'></div>
                                            <div class="col text-start">
                                                <small class="ms-1"><span class="badge bg-secondary">ID: $admin->id</span></small>
                                                <h4 style="font-size: 30px; font-weight: lighter;" class="text-start">$admin->firstName $admin->lastName</h4>
                                                <p class="card-text"><i class="fa fa-address-card" aria-hidden="true"></i>&nbsp; $admin->position</p>
                                                <small class="card-text text-success"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp; $admin->phone</small>
                                            </div>
                                            
                                            <div class="col row text-end">
                                                <div class="col text-end">
                                                    <form action="admin_edit_user.php" method="GET">
                                                        <input type="hidden" name="admin" value=$admin->username>
                                                        <button type="submit" class="btn btn-solid-sm"><i class="fa fa-wrench" aria-hidden="true"></i></button>
                                                    </form>
                                                </div>
                                                <div class="col text-start">
                                                    <form method="POST">
                                                        <input type="hidden" name="username" value=$admin->username>
                                                        <button name="delete" type="submit" class="btn btn-danger-sm" onclick="return confirm('Are you sure you want to delete $admin->username ?')" ><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        END;
                    }
                    unset($allAdmins);
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