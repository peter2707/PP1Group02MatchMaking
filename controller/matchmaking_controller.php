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

    public function findMatch($position, $salary, $location, $type, $jobseeker){
        if(!$position||!$salary||!$type||!$location||!$jobseeker){
            header("location: ../view/jobseeker_match.php?error=emptyinput");
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
        }elseif(!is_numeric($contact)){
            header("location: ../view/employer_post.php?error=notanumber");
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

}
