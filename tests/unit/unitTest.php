<?php

use \PHPUnit\Framework\TestCase;

class UnitTest extends TestCase{
    public function testGetPost(){
        include '../job-match/model/db_connection.php';
        include '../job-match/model/matchmaking_model.php';

        $mmm = new MatchmakingModel();
        
        $tempCount = $mmm->countJobPosts($db, 'username');
        // check the count of job post from a user that has not been added
        // expected result should be 0
        $this->assertTrue($tempCount == 0);
           
        // Add New Job
        if($mmm->postNewJob($db, 'position', 'field', 'salary', 'type', 'description', 'requirements', 'location', 'username', 'contact')){

            // count the job post that just created
            $newCount = $mmm->countJobPosts($db, 'username');


            // check add function
            $this->assertTrue($newCount > $tempCount);
           

            $jobpost = $mmm->getJobPostsByEmployer($db, 'username', '../job-match/model/job_object.php');

            // delete the added job 
            foreach ($jobpost as $post) {
                if($mmm->deletePost($db, $post->id)){
                    $jobpost = array();
                }
            }
            $removePost = count($jobpost);

            // check delete function
            // remove array element if delete returns true
            $this->assertTrue($removePost == 0);
            
        } else {
            $this->assertTrue(false);
        }
        
    }


}