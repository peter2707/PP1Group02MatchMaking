<?php
class MatchmakingController {

    public function getAllMatches($user){
        require_once '../model/matchmaking_model.php';
        include '../model/db_connection.php';

        $mmm = new MatchmakingModel();
        return $mmm->getJobMatch($db, $user);
    }

    public function findMatch($position, $salary, $location, $type, $jobseeker){
        require_once '../model/matchmaking_model.php';
        require_once '../model/db_connection.php';

        $mmm = new MatchmakingModel();
        if($mmm->findMatch($db, $position, $salary, $location, $type, $jobseeker)){
            header("location: ../view/jobseeker_match.php?success=matchfound");
        }else{
            header("location: ../view/jobseeker_match.php?failed=nomatch");
        }
    }



}
