<?php

use \PHPUnit\Framework\TestCase;

class UnitTest extends TestCase
{
    public function testGetPost()
    {
        include '../job-match/model/db_connection.php';
        include_once '../job-match/model/matchmaking_model.php';

        $mmm = new MatchmakingModel();

        $tempCount = $mmm->countJobPosts($db, 'username');
        // check the count of job post from a user that has not been added
        // expected result should be 0
        $this->assertTrue($tempCount == 0);

        // Add New Job
        if ($mmm->postNewJob($db, 'position', 'field', 'salary', 'type', 'description', 'requirements', 'location', 'username', 'contact')) {

            // count the job post that just created
            $newCount = $mmm->countJobPosts($db, 'username');


            // check add function
            $this->assertTrue($newCount > $tempCount);


            $jobpost = $mmm->getJobPostsByEmployer($db, 'username', '../job-match/model/job_object.php');

            // delete the added job 
            foreach ($jobpost as $post) {
                if ($mmm->deletePost($db, $post->id)) {
                    $jobpost = $mmm->getJobPostsByEmployer($db, 'username', '../job-match/model/job_object.php');
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

    public function testRegister()
    {
        include '../job-match/model/db_connection.php';
        include_once '../job-match/model/register_model.php';
        include_once '../job-match/model/user_model.php';
        include_once '../job-match/model/login_model.php';



        // Register
        $rm = new RegisterModel();
        $lm = new LoginModel();
        $um = new UserModel();
        $username = 'Username';
        $password = 'password';

        // Register as Jobseeker
        $rm->registerJobSeeker($db, 'firstname', 'lastname', $username, $password, 'dateOfBirth', 'phone', 'email', 'field', 'location');
        // check login successfully as job seeker
        $checkLoginJS = $lm->checkJobSeeker($db, $username, $password);
        $this->assertTrue($checkLoginJS);

        // test update as Job seeker
        $um->updateJobSeeker($db, 'newFirstname', 'lastname', $password, 'dateOfBirth', 'phone', 'email', 'field', 'location', 'username');
        $jobseeker = $um->getUser($db, 'jobseeker', $username, '../job-match/model/user_object.php');
        $newFirstname = $jobseeker->firstName;
        $this->assertEquals('newFirstname', $newFirstname);


        // test add skill to job seeker
        $um->addSkill($db, $username, "Software Engineer", "10 years or more");
        $skill = $um->getSkills($db, $username, '../job-match/model/job_object.php');
        foreach ($skill as $s) {
            if ($s->skill == 'Software Engineer' && $s->experience == '10 years or more') {
                // check if the skill was added
                $this->assertEquals('Software Engineer', $s->skill);
                $this->assertEquals('10 years or more', $s->experience);
            }
        }

    
        // test delete skill
        $um->deleteAllSkills($db, $username);
        $skill = $um->getSkills($db, $username, '../job-match/model/job_object.php');
        $this->assertTrue(empty($skill));







        // check delete the registered account successfully as job seeker
        $checkDeleteJS = $um->deleteAccount($db, $username, 'jobseeker', '../job-match/model/session_model.php');
        $this->assertTrue($checkDeleteJS);












        // Register as Employer
        $rm->registerEmployer($db, 'firstName', 'lastName', $username, $password, 'dateOfBirth', 'phone', 'email', 'position', 'location');
        // check login successfully as employer
        $checkLoginEmp = $lm->checkEmployer($db, $username, $password);
        // check login successfully as employer
        $this->assertTrue($checkLoginEmp);

        // update as Employer
        $um->updateEmployer($db, 'newFirstname', 'lastname', $password, 'dateOfBirth', 'phone', 'email', 'field', 'location', 'username');
        $jobseeker = $um->getUser($db, 'employer', $username, '../job-match/model/user_object.php');
        $newFirstname = $jobseeker->firstName;
        $this->assertEquals('newFirstname', $newFirstname);

        // check delete the registered account successfully as employer
        $checkDeleteEmp = $um->deleteAccount($db, $username, 'employer', '../job-match/model/session_model.php');
        $this->assertTrue($checkDeleteEmp);

    }
}
