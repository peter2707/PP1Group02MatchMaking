<?php


class JobPostTest extends \PHPUnit\Framework\TestCase{

    public function testGetPost(){
        $matchMakingController = new \App\Controller\MatchmakingController;
        $jobposts = array();
        $jobposts = $matchMakingController.getJobPosts('www');
        $this->assertTrue(empty($jobposts));
    }
}

