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

    public function findMatch($position, $salary, $location, $type, $jobseeker){
        if(!$position||!$salary||!$type||!$location||!$jobseeker){
            header("location: ../view/jobseeker_match.php?error=emptyinput");
        }elseif(is_numeric($position)){
            header("location: ../view/jobseeker_match.php?error=positionnumeric");
        }else{
            require_once '../model/matchmaking_model.php';
            require_once '../model/db_connection.php';
            $mmm = new MatchmakingModel();
            if($mmm->findMatch($db, $position, $salary, $location, $type, $jobseeker)){
                header("location: ../view/jobseeker_match.php?success=matchfound");
            }else{
                header("location: ../view/jobseeker_match.php?error=nomatch");
            }
        }
    }

    public function postJob($position, $field, $salary, $type, $description, $requirements, $location, $username, $contact){
        if(!$position||!$salary||!$type||!$description||!$requirements||!$location||!$username||!$contact){
            header("location: ../view/employer_post.php?error=emptyinput");
        }elseif(is_numeric($position)){
            header("location: ../view/employer_post.php?error=positionnumeric");
        }elseif(!$field){
            header("location: ../view/employer_post.php?error=fieldnull");
        }else{
            require_once '../model/matchmaking_model.php';
            require_once '../model/db_connection.php';
            $mmm = new MatchmakingModel();
            $mmm->postNewJob($db, $position, $field, $salary, $type, $description, $requirements, $location, $username, $contact);
        }
    }

    public function getJobPosts($username){
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        return $mmm->getJobPosts($db, $username);
    }

    public function getJobPostByID($jobID){
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        return $mmm->getJobPostByID($db, $jobID);
    }

    public function updatePost($position, $field, $salary, $type, $description, $requirements, $location, $contact, $id){
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        return $mmm->updatePost($db, $position, $field, $salary, $type, $description, $requirements, $location, $contact, $id);
    }

    public function deletePost($id) {
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        $mmm->deletePost($db, $id);
    }

    public function denyMatch($id, $usertype){
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        $mmm->denyMatch($db, $id, $usertype);
    }

}
