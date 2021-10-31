<?php
class AdminController {

    public function register($firstName, $lastName, $username, $password, $confirmPassword, $dateOfBirth, $phone, $email, $location, $type, $positionEmployer, $positionAdmin, $field) {
        require_once '../model/utility.php';
        require_once '../model/db_connection.php';
        require_once '../model/admin_model.php';
        require_once '../model/register_model.php';
        $adminModel = new AdminModel();
        $registerModel = new RegisterModel();

        if (emptyInputRegister($firstName, $lastName, $username, $password, $confirmPassword, $dateOfBirth, $phone, $email, $location, $type) !== false) {
            header("location: ../view/admin_add_user.php?error=emptyinput");
            exit();
        } elseif (invalidUsername($username) !== false) {                               // Proper username chosen
            header("location: ../view/admin_add_user.php?error=invalidusername");
            exit();
        } elseif (invalidEmail($email) !== false) {                                     // Proper email chosen
            header("location: ../view/admin_add_user.php?error=invalidemail");
            exit();
        } elseif (passwordMatch($password, $confirmPassword) !== false) {               // Do the two passwords match?
            header("location: ../view/admin_add_user.php?error=passwordsdontmatch");
            exit();
        } else {
            if ($type == "admin") {
                if (!$positionAdmin) {
                    header("location: ../view/admin_add_user.php?error=positionnotfound");
                } elseif (usernameExists($db, $username, $email, "admin") !== false) {              // Is the username taken already
                    header("location: ../view/admin_add_user.php?error=usernametaken");
                    exit();
                } else {
                    if ($adminModel->registerAdmin($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $positionAdmin)) {
                        header("location: ../view/admin_index.php?success=created");
                    }
                }
            } elseif ($type == "employer") {
                if (!$positionEmployer) {
                    header("location: ../view/admin_add_user.php?error=positionnotfound");
                } elseif (usernameExists($db, $username, $email, "employer") !== false) {              // Is the username taken already
                    header("location: ../view/admin_add_user.php?error=usernametaken");
                    exit();
                } else {
                    if ($registerModel->registerEmployer($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $positionEmployer, $location)) {
                        header("location: ../view/admin_index.php?success=created");
                    }
                }
            } else {
                if (!$field) {
                    header("location: ../view/admin_add_user.php?error=fieldnotfound");
                } elseif (usernameExists($db, $username, $email, "jobseeker") !== false) {              // Is the username taken already
                    header("location: ../view/admin_add_user.php?error=usernametaken");
                    exit();
                } else {
                    if ($registerModel->registerJobSeeker($db, $firstName, $lastName, $username, $password, $dateOfBirth, $phone, $email, $field, $location)) {
                        header("location: ../view/admin_index.php?success=created");
                    }
                }
            }
        }
    }

    public function deleteAccount($username, $usertype) {
        require_once '../model/user_model.php';
        include '../model/db_connection.php';
        $userModel = new UserModel();
        if ($userModel->deleteAccount($db, $username, $usertype)) {
            header("location: ../view/admin_index.php?success=deleted");
        } else {
            header("location: ../view/admin_index.php?error=deletefailed");
        }
    }

    public function getAllJobSeeker() {
        require_once '../model/admin_model.php';
        include '../model/db_connection.php';
        $adminModel = new AdminModel();
        return $adminModel->getAllJobSeeker($db);
    }

    public function getAllEmployer() {
        require_once '../model/admin_model.php';
        include '../model/db_connection.php';
        $adminModel = new AdminModel();
        return $adminModel->getAllEmployer($db);
    }

    public function getAllAdmin() {
        require_once '../model/admin_model.php';
        include '../model/db_connection.php';
        $adminModel = new AdminModel();
        return $adminModel->getAllAdmin($db);
    }

    public function updateJobSeeker($firstName, $lastName, $username, $password, $dob, $phone, $email, $field, $location, $id) {
        require_once '../model/user_model.php';
        include '../model/db_connection.php';
        $userModel = new UserModel();
        if ($userModel->updateJobSeeker($db, $firstName, $lastName, $username, $password, $dob, $phone, $email, $field, $location, $id)) {
            header("location: ../view/admin_index.php?success=updated");
        } else {
            header("location: ../view/admin_index.php?error=updatefailed");
        }
    }

    public function updateEmployer($firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $location, $id) {
        require_once '../model/user_model.php';
        include '../model/db_connection.php';
        $userModel = new UserModel();
        if ($userModel->updateEmployer($db, $firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $location, $id)) {
            header("location: ../view/admin_index.php?success=updated");
        } else {
            header("location: ../view/admin_index.php?error=updatefailed");
        }
    }

    public function updateAdmin($firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $id) {
        require_once '../model/admin_model.php';
        include '../model/db_connection.php';
        $adminModel = new AdminModel();
        if ($adminModel->updateAdmin($db, $firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $id)) {
            header("location: ../view/admin_index.php?success=updated");
        } else {
            header("location: ../view/admin_index.php?error=updatefailed");
        }
    }

    public function getAllFeedback() {
        require_once '../model/admin_model.php';
        include '../model/db_connection.php';
        $adminModel = new AdminModel();
        return $adminModel->getAllFeedback($db);
    }

    public function getAllReport() {
        require_once '../model/admin_model.php';
        include '../model/db_connection.php';
        $adminModel = new AdminModel();
        return $adminModel->getAllReport($db);
    }

    public function getAllJobMatch() {
        require_once '../model/admin_model.php';
        include '../model/db_connection.php';
        $adminModel = new AdminModel();
        return $adminModel->getAllJobMatch($db);
    }

    public function getAllJobPost() {
        require_once '../model/admin_model.php';
        include '../model/db_connection.php';
        $adminModel = new AdminModel();
        return $adminModel->getAllJobPost($db);
    }

    public function updatePost($position, $field, $salary, $type, $description, $requirements, $location, $contact, $id) {
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        if ($mmm->updatePost($db, $position, $field, $salary, $type, $description, $requirements, $location, $contact, $id)) {
            header("location: ../view/admin_index.php?success=updated");
        } else {
            header("location: ../view/admin_index.php?error=updatefailed");
        }
    }

    public function deletePost($id) {
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        if ($mmm->deletePost($db, $id)) {
            header("location: ../view/admin_index.php?success=deleted");
        } else {
            header("location: ../view/admin_index.php?error=deletefailed");
        }
    }

    public function denyMatch($id) {
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        if ($mmm->denyMatch($db, $id, $usertype)) {
            header("location: ../view/admin_index.php?success=deleted");
        } else {
            header("location: ../view/admin_index.php?error=deletefailed");
        }
    }

    public function deleteReport($id) {
        require_once '../model/db_connection.php';
        require_once '../model/admin_model.php';
        $adminModel = new AdminModel();
        if ($adminModel->deleteReport($db, $id)) {
            header("location: ../view/admin_index.php?success=deleted");
        } else {
            header("location: ../view/admin_index.php?error=deletefailed");
        }
    }

    public function deleteFeedback($id) {
        require_once '../model/db_connection.php';
        require_once '../model/admin_model.php';
        $adminModel = new AdminModel();
        if ($adminModel->deleteFeedback($db, $id)) {
            header("location: ../view/admin_index.php?success=deleted");
        } else {
            header("location: ../view/admin_index.php?error=deletefailed");
        }
    }

    public function generateReport($table) {
        require_once '../model/admin_model.php';
        include '../model/db_connection.php';
        $adminModel = new AdminModel();
        $adminModel->generateReport($db, $table);
    }
}
