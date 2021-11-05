<?php
class MatchmakingController {

    public function postJob($position, $field, $salary, $type, $description, $requirements, $location, $username, $contact) {
        if (!isset($position) || empty(trim($position, " ")) || !isset($salary) || !isset($type) || !isset($description) || !isset($requirements) || !isset($location) || !isset($username) || !isset($contact)) {
            header("location: ../view/employer_post.php?error=emptyinput");
        } elseif (is_numeric($position)) {
            header("location: ../view/employer_post.php?error=positionnumeric");
        } elseif (!$field) {
            header("location: ../view/employer_post.php?error=fieldnotfound");
        } else {
            require_once '../model/matchmaking_model.php';
            include '../model/db_connection.php';
            $mmm = new MatchmakingModel();
            if ($mmm->postNewJob($db, $position, $field, $salary, $type, $description, $requirements, $location, $username, $contact)) {
                header("location: ../view/employer_post.php?success=posted");
            } else {
                header("location: ../view/employer_post.php?success=postfailed");
            }
        }
    }

    public function getJobPostsByEmployer($username) {
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        return $mmm->getJobPostsByEmployer($db, $username);
    }

    public function getJobPostByID($jobID) {
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        return $mmm->getJobPostByID($db, $jobID);
    }

    public function countJobPosts($employer) {
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        return $mmm->countJobPosts($db, $employer);
    }

    public function updatePost($position, $field, $salary, $type, $description, $requirements, $location, $contact, $id) {
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        if (!isset($position) || empty(trim($position, " ")) || !isset($salary) || !isset($type) || !isset($description) || !isset($requirements) || !isset($location) || !isset($username) || !isset($contact)) {
            header("location: ../view/employer_post.php?error=emptyinput");
        } elseif (is_numeric($position)) {
            header("location: ../view/employer_post.php?error=positionnumeric");
        } elseif (!$field) {
            header("location: ../view/employer_post.php?error=fieldnotfound");
        } else {
            if ($mmm->updatePost($db, $position, $field, $salary, $type, $description, $requirements, $location, $contact, $id)) {
                header("location: ../view/employer_post.php?success=updated");
            } else {
                header("location: ../view/employer_post.php?error=updatefailed");
            }
        }
        
    }

    public function deletePost($id) {
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        if ($mmm->deletePost($db, $id)) {
            header("location: ../view/employer_post.php?success=deleted");
        } else {
            header("location: ../view/employer_post.php?error=deletefailed");
        }
    }

    public function getAllMatches($user) {
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        return $mmm->getJobMatch($db, $user);
    }

    public function getJobMatchByID($jobID) {
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        return $mmm->getJobMatchByID($db, $jobID);
    }

    public function getJobMatchByPostID($jobID, $employer) {
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        return $mmm->getJobMatchByPostID($db, $jobID, $employer);
    }

    public function findMatch($position, $salary, $location, $type, $field, $jobseeker) {
        if (!isset($position) || empty(trim($position, " ")) || !isset($salary) || !isset($type) || !isset($location) || !isset($jobseeker) ) {
            header("location: ../view/jobseeker_match.php?error=emptyinput");
        } elseif (is_numeric($position)) {
            header("location: ../view/jobseeker_match.php?error=positionnumeric");
        } elseif (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $position)) {
            header("location: ../view/jobseeker_match.php?error=specialcharacter");
        } else {
            require_once '../model/matchmaking_model.php';
            include '../model/db_connection.php';
            $mmm = new MatchmakingModel();
            if ($mmm->findMatch($db, $position, $salary, $location, $type, $field, $jobseeker)) {
                header("location: ../view/jobseeker_match.php?success=matchfound");
            } else {
                header("location: ../view/jobseeker_match.php?warning=nomatch");
            }
        }
    }

    public function denyMatch($id, $usertype) {
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        if ($mmm->denyMatch($db, $id, $usertype)) {
            if ($usertype == 'jobseeker') {
                header("location: ../view/jobseeker_match.php?success=denied");
            } elseif ($usertype == 'employer') {
                header("location: ../view/employer_post.php?success=denied");
            }
        } else {
            if ($usertype == 'jobseeker') {
                header("location: ../view/jobseeker_match.php?error=errordeny");
            } elseif ($usertype == 'employer') {
                header("location: ../view/employer_post.php?error=errordeny");
            }
        }
    }

    public function addFeedback($rating, $feedback, $id) {
        if (!isset($rating) || !isset($feedback) || !isset($id)) {
            header("location: ../view/feedback.php?error=emptyinput");
        } else {
            require_once '../model/matchmaking_model.php';
            include '../model/db_connection.php';
            $mmm = new MatchmakingModel();
            if ($mmm->addFeedback($db, $rating, $feedback, $id)) {
                header("location: ../view/jobseeker_match.php?success=addedfeedback");
            } else {
                header("location: ../view/jobseeker_match.php?error=failedfeedback");
            }
        }
    }

    public function reportMatch($username, $type, $id, $reason, $comment) {
        if (!isset($username) || !isset($type) || !isset($id) || !isset($reason) || !isset($comment)) {
            header("location: ../view/report.php?error=emptyinput");
        } else {
            require_once '../model/matchmaking_model.php';
            include '../model/db_connection.php';
            $mmm = new MatchmakingModel();
            if ($mmm->reportMatch($db, $username, $type, $id, $reason, $comment)) {
                header("location: ../view/report.php?success=reported");
            } else {
                header("location: ../view/report.php?error=failedReport");
            }
        }
    }
}
