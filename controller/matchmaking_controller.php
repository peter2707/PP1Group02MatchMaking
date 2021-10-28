<?php
class MatchmakingController {

    public function getAllMatches($user){
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        return $mmm->getJobMatch($db, $user);
    }

    public function getJobMatchByID($jobID){
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        return $mmm->getJobMatchByID($db, $jobID);
    }

    public function getJobMatchByPostID($jobID, $employer){
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        return $mmm->getJobMatchByPostID($db, $jobID, $employer);
    }

    public function findMatch($position, $salary, $location, $type, $field, $jobseeker){
        if(!isset($position)||!isset($salary)||!isset($type)||!isset($location)||!isset($jobseeker)){
            header("location: ../view/jobseeker_match.php?error=emptyinput");
        }elseif(is_numeric($position)){
            header("location: ../view/jobseeker_match.php?error=positionnumeric");
        }else{
            require_once '../model/matchmaking_model.php';
            include '../model/db_connection.php';
            $mmm = new MatchmakingModel();
            if($mmm->findMatch($db, $position, $salary, $location, $type, $field, $jobseeker)){
                header("location: ../view/jobseeker_match.php?success=matchfound");
            }else{
                header("location: ../view/jobseeker_match.php?warning=nomatch");
            }
        }
    }

    public function postJob($position, $field, $salary, $type, $description, $requirements, $location, $username, $contact){
        if(!isset($position)||!isset($salary)||!isset($type)||!isset($description)||!isset($requirements)||!isset($location)||!isset($username)||!isset($contact)){
            header("location: ../view/employer_post.php?error=emptyinput");
        }elseif(is_numeric($position)){
            header("location: ../view/employer_post.php?error=positionnumeric");
        }elseif(!$field){
            header("location: ../view/employer_post.php?error=fieldnotfound");
        }else{
            require_once '../model/matchmaking_model.php';
            include '../model/db_connection.php';
            $mmm = new MatchmakingModel();
            $mmm->postNewJob($db, $position, $field, $salary, $type, $description, $requirements, $location, $username, $contact);
        }
    }

    public function getJobPostsByEmployer($username){
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        return $mmm->getJobPostsByEmployer($db, $username);
    }

    public function getJobPostByID($jobID){
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        return $mmm->getJobPostByID($db, $jobID);
    }

    public function countJobPosts($employer){
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        return $mmm->countJobPosts($db, $employer);
    }

    public function updatePost($position, $field, $salary, $type, $description, $requirements, $location, $contact, $id){
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        return $mmm->updatePost($db, $position, $field, $salary, $type, $description, $requirements, $location, $contact, $id);
    }

    public function deletePost($id, $usertype) {
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        $mmm->deletePost($db, $id, $usertype);
    }

    public function denyMatch($id, $usertype){
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        $mmm->denyMatch($db, $id, $usertype);
    }

    public function addFeedback($rating, $feedback, $id){
        if(!isset($rating)||!isset($feedback)||!isset($id)){
            header("location: ../view/feedback.php?error=emptyinput");
        }else{
            require_once '../model/matchmaking_model.php';
            include '../model/db_connection.php';
            $mmm = new MatchmakingModel();
            $mmm->addFeedback($db, $rating, $feedback, $id);
        }
    }

    public function reportMatch($username, $type, $id, $reason, $comment){
        if(!isset($username)||!isset($type)||!isset($id)||!isset($reason)||!isset($comment)){
            header("location: ../view/report.php?error=emptyinput");
        }else{
            require_once '../model/matchmaking_model.php';
            include '../model/db_connection.php';
            $mmm = new MatchmakingModel();
            $mmm->reportMatch($db, $username, $type, $id, $reason, $comment);
        }
    }
}
