<?php

use \PHPUnit\Framework\TestCase;

class UnitTest extends TestCase
{
    public function testMatchMakingModel()
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

    public function testRegisterandUserModel()
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



        // test add education
        $um->addEducation($db, $username, 'RMIT', 'Bachelor of IT', 'Dec-2021');
        $edu = $um->getEducations($db, $username, '../job-match/model/job_object.php');

        foreach ($edu as $ed) {
            if ($ed->institution == 'RMIT' &&  $ed->graduation == 'Dec-2021' && $ed->degree == 'Bachelor of IT') {
                // check if the edu was added
                $this->assertEquals('RMIT', $ed->institution);
                $this->assertEquals('Bachelor of IT',  $ed->degree);
                $this->assertEquals('Dec-2021', $ed->graduation);
            }
        }

        // test delete education
        $um->deleteAllEducations($db, $username);
        $edu = $um->getEducations($db, $username, '../job-match/model/job_object.php');
        $this->assertTrue(empty($edu));


        // test add career
        $um->addCareer($db, $username, 'Software Developer', 'JobMatch', '1 - 3 Years');
        $career = $um->getCareers($db, $username, '../job-match/model/job_object.php');

        foreach ($career as $c) {
            if ($c->position == 'Software Developer' &&  $c->company == 'JobMatch' && $c->experience == '1 - 3 Years') {
                // check if the career was added
                $this->assertEquals('Software Developer', $c->position);
                $this->assertEquals('JobMatch',  $c->company);
                $this->assertEquals('1 - 3 Years', $c->experience);
            }
        }

        // test delete career
        $um->deleteAllCareers($db, $username);
        $career = $um->getEducations($db, $username, '../job-match/model/job_object.php');
        $this->assertTrue(empty($career));

        // test add social media
        $um->addSocialLink($db, $username, 'linkedin', 'github', 'twitter', 'instagram', 'facebook');
        $social = $um->getSocialLink($db, $username, '../job-match/model/job_object.php');

        // check social media
        $this->assertEquals('linkedin', $social->linkedin);
        $this->assertEquals('github', $social->github);
        $this->assertEquals('twitter', $social->twitter);
        $this->assertEquals('instagram', $social->instagram);
        $this->assertEquals('facebook', $social->facebook);

        // test edit social media
        if ($um->editSocialLink($db, $username, 'newlinkedin', 'newgithub', 'newtwitter', 'newinstagram', 'newfacebook')) {
            $social = $um->getSocialLink($db, $username, '../job-match/model/job_object.php');

            // check if the information has changed
            $this->assertEquals('newlinkedin', $social->linkedin);
            $this->assertEquals('newgithub', $social->github);
            $this->assertEquals('newtwitter', $social->twitter);
            $this->assertEquals('newinstagram', $social->instagram);
            $this->assertEquals('newfacebook', $social->facebook);
        } else {
            // let the test fail if edit is false
            $this->assertTrue(false);
        }

        // test delete social media
        $um->deleteAllSocials($db, $username);
        $social = $um->getSocialLink($db, $username, '../job-match/model/job_object.php');
        $this->assertTrue(is_object($social));


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
