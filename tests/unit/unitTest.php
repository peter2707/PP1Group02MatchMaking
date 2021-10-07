<?php

use \PHPUnit\Framework\TestCase;

class UnitTest extends TestCase{
    public function testGetPost(){
        include '../job-match/model/db_connection.php';
        include '../job-match/model/matchmaking_model.php';

        $mmm = new MatchmakingModel();
        
        // Add New Job
        if($mmm->postNewJob($db, 'abc', 'abc', 'abc', 'abc', 'abc', 'abc', 'abc', 'abc', 'abc')){

            // set into array
            $jobpost = array();
            $jobpost = $mmm->getJobPosts($db, 'abc', '../job-match/model/job_object.php');

            // check add function
            $this->assertTrue(count($jobpost) >= 1);

            // delete the added job 
            foreach ($jobpost as $post) {
                $mmm->deletePost($db, $post->id);
            }

            // check delete function
            $jobpost = $mmm->getJobPosts($db, 'abc', '../job-match/model/job_object.php');
            $this->assertFalse(count($jobpost) >= 1);
            
        } else {
            $this->assertTrue(false);
        }
        
    }

    public function testRegister(){
        include '../job-match/model/db_connection.php';
        include '../job-match/model/register_model.php';
        include '../job-match/model/user_model.php';
        include '../job-match/model/login_model.php';

        // Register
        $rm = new RegisterModel();
        $lm = new LoginModel();
        $um = new UserModel();
        $username = 'username';
        $password = 'password';

        // Register as Jobseeker
        $rm->registerJobSeeker($db, 'firstname', 'lastname', $username, $password, 'dateOfBirth', 'phone', 'email', 'field');
        // check login successfully as job seeker
        $checkLoginJS = $lm->checkJobSeeker($db, $username, $password);
        $this->assertTrue($checkLoginJS);

        // check delete the registered account successfully as job seeker
        $checkDeleteJS = $um->deleteAccount($db, $username, 'jobseeker');
        $this->assertTrue($checkDeleteJS);


        // Register as Employer
        $rm->registerEmployer($db, 'firstName', 'lastName', $username, $password, 'dateOfBirth', 'phone', 'email', 'position');
        // check login successfully as employer
        $checkLoginEmp = $lm->checkEmployer($db, $username, $password);
        // check login successfully as employer
        $this->assertTrue($checkLoginEmp);

        // check delete the registered account successfully as employer
        $checkDeleteEmp = $um->deleteAccount($db, $username, 'employer');
        $this->assertTrue($checkDeleteEmp);
    }
}

