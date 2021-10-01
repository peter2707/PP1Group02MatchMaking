<?php
class MatchmakingController {

    public function getAllMatches($user){
        require_once '../model/matchmaking_model.php';
        require_once '../model/user_object.php';
        include '../model/db_connection.php';

        $mmm = new MatchmakingModel();
        $jobMatch = array();
        $jobMatch = $mmm->getJobMatch($db, $user);

        return $jobMatch;
    }

    public function compareParam($salary, $location, $type, $job, $jobseeker){
        require_once '../model/matchmaking_model.php';
        require_once '../model/user_object.php';
        require_once '../model/db_connection.php';
        require_once '../controller/session_controller.php';

        $mmm = new MatchmakingModel();
        $jobposts = array();
        $jobposts = $mmm->getJobPost($db);
        $feedback = "test";
        $id = 1;



        foreach($jobposts as $post){
            if($post->salary == $salary || $post->location == $location || $post->type == $type || $post->job == $job){
                $mmm->setJobMatch($db, $post->employer, $jobseeker, $id, $feedback);
            }
        }
    }



}
