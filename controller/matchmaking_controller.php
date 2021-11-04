<?php
class MatchmakingController {
    // function to get all matches 
    public function getAllMatches($user){
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        return $mmm->getJobMatch($db, $user);
    }

    // function to get all matches by job id
    public function getJobMatchByID($jobID){
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        return $mmm->getJobMatchByID($db, $jobID);
    }

    // function to get all matches by post id
    public function getJobMatchByPostID($jobID, $employer){
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        return $mmm->getJobMatchByPostID($db, $jobID, $employer);
    }

    // function to find match
    public function findMatch($position, $salary, $location, $type, $field, $jobseeker){
        if(!isset($position)||!isset($salary)||!isset($type)||!isset($location)||!isset($jobseeker)){   // check all the variable if null
            header("location: ../view/jobseeker_match.php?error=emptyinput");
        }elseif(is_numeric($position)){
            header("location: ../view/jobseeker_match.php?error=positionnumeric");
        }else{
            require_once '../model/matchmaking_model.php';
            include '../model/db_connection.php';
            $mmm = new MatchmakingModel();
            if($mmm->findMatch($db, $position, $salary, $location, $type, $field, $jobseeker)){     // on valid input, call findMatch function
                header("location: ../view/jobseeker_match.php?success=matchfound");
            }else{
                header("location: ../view/jobseeker_match.php?warning=nomatch");
            }
        }
    }

    // funciton to post a new job
    public function postJob($position, $field, $salary, $type, $description, $requirements, $location, $username, $contact){
        // check all the variable if null
        if(!isset($position)||!isset($salary)||!isset($type)||!isset($description)||!isset($requirements)||!isset($location)||!isset($username)||!isset($contact)){    
            header("location: ../view/employer_post.php?error=emptyinput");
        }elseif(is_numeric($position)){ // check if position is in number
            header("location: ../view/employer_post.php?error=positionnumeric");
        }elseif(!$field){   // check if the field is true
            header("location: ../view/employer_post.php?error=fieldnotfound");
        }else{
            require_once '../model/matchmaking_model.php';
            include '../model/db_connection.php';
            $mmm = new MatchmakingModel();
            // post new job with all input parameters
            $mmm->postNewJob($db, $position, $field, $salary, $type, $description, $requirements, $location, $username, $contact);
        }
    }

    // function to retrieve all job post by employer
    public function getJobPostsByEmployer($username){
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        return $mmm->getJobPostsByEmployer($db, $username);
    }

    // function to retrieve all job post by job id
    public function getJobPostByID($jobID){
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        return $mmm->getJobPostByID($db, $jobID);
    }

    // function to count job posts
    public function countJobPosts($employer){
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        return $mmm->countJobPosts($db, $employer);
    }

    // function to update post
    public function updatePost($position, $field, $salary, $type, $description, $requirements, $location, $contact, $id){
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        return $mmm->updatePost($db, $position, $field, $salary, $type, $description, $requirements, $location, $contact, $id);
    }

    // function to delete post by post id
    public function deletePost($id) {
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        $mmm->deletePost($db, $id);
    }

    // function to decline a match
    public function denyMatch($id, $usertype){
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';
        $mmm = new MatchmakingModel();
        $mmm->denyMatch($db, $id, $usertype);
    }

    // function to add feedback 
    public function addFeedback($rating, $feedback, $id){
        if(!isset($rating)||!isset($feedback)||!isset($id)){    // check if rating, feedback and id is not null
            header("location: ../view/feedback.php?error=emptyinput");
        }else{
            require_once '../model/matchmaking_model.php';
            include '../model/db_connection.php';
            $mmm = new MatchmakingModel();
            // add feedback on success validation
            $mmm->addFeedback($db, $rating, $feedback, $id);
        }
    }

    // function to report a match 
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
