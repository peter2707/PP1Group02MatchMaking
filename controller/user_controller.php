<?php
class UserController {
    public function getUser($userType, $username) {
        require_once '../model/user_model.php';
        require_once '../model/db_connection.php';
        $userModel = new UserModel();
        return $userModel->getUser($db, $userType, $username);
    }

    public function updateJobSeeker($firstName, $lastName, $username, $password, $dob, $phone, $email, $field, $location, $id) {
        if(!isset($firstName)||!isset($lastName)||!isset($username)||!isset($password)||!isset($dob)||!isset($phone)||!isset($email)||!isset($field)||!isset($location)||!isset($id)){
            header("location: ../view/user_settings.php?error=emptyInput");
        }
        require_once '../model/user_model.php';
        require_once '../model/db_connection.php';
        $userModel = new UserModel();
        if($userModel->updateJobSeeker($db, $firstName, $lastName, $username, $password, $dob, $phone, $email, $field, $location, $id)){
            header("location: ../view/user_settings.php?success=accountupdated");
		} else {
			header("location: ../view/user_settings.php?error=failed");
		}
    }

    public function updateEmployer($firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $location, $id) {
        if(!isset($firstName)||!isset($lastName)||!isset($username)||!isset($password)||!isset($dob)||!isset($phone)||!isset($email)||!isset($position)||!isset($location)||!isset($id)){
            header("location: ../view/user_settings.php?error=emptyInput");
        }
        require_once '../model/user_model.php';
        require_once '../model/db_connection.php';
        $userModel = new UserModel();
        if ($userModel->updateEmployer($db, $firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $location, $id)) {
			header("location: ../view/user_settings.php?success=accountupdated");
		} else {
			header("location: ../view/user_settings.php?error=failed");
		}
    }

    public function deleteAccount($username, $type){
        require_once '../model/db_connection.php';
        require_once '../model/user_model.php';
        $userModel = new UserModel();
        if($userModel->deleteAccount($db, $username, $type)){
            header("location: ../view/login.php?success=accountdeleted");
		} else {
			header("location: ../view/user_settings.php?error=deletefailed");
		}
    }

    public function changeProfilePicture($file, $username, $userType){
        include '../model/db_connection.php';
        require_once '../model/user_model.php';
        $userModel = new UserModel();
        if ($userModel->changeProfilePicture($db, $file, $username, $userType)) {
			header("location: ../view/user_profile.php?success=accountupdated");
		} else {
			header("location: ../view/user_profile.php?error=failed");
		}
    }

    public function addResume($file, $username){
        include '../model/db_connection.php';
        require_once '../model/user_model.php';
        $userModel = new UserModel();
        if ($userModel->addResume($db, $file, $username)) {
			header("location: ../view/user_profile.php?success=accountupdated");
		} else {
			header("location: ../view/user_profile.php?error=failed");
		}
    }

    public function removeResume($username, $filepath){
        include '../model/db_connection.php';
        require_once '../model/user_model.php';
        $userModel = new UserModel();
        if ($userModel->removeResume($db,$username)) {
			header("location: ../view/user_profile.php?success=accountupdated");
            unlink($filepath);
		} else {
			header("location: ../view/user_profile.php?error=failed");
		}
    }

    public function getResume($username){
        include '../model/db_connection.php';
        require_once '../model/user_model.php';
        $userModel = new UserModel();
        return $userModel->getResume($db, $username);
    }

    public function downloadResume($filepath, $filename){
        header("Content-type: application/pdf");
        header("Content-Disposition: inline; filename={$filename}");
        @readfile($filepath);
    }

    public function editSocialLink($username, $linkedin, $github, $twitter, $instagram, $facebook){
        include '../model/db_connection.php';
        require_once '../model/user_model.php';
        $userModel = new UserModel();
        if ($userModel->editSocialLink($db, $username, $linkedin, $github, $twitter, $instagram, $facebook)) {
            header("location: ../view/user_profile.php?success=accountupdated");
        } else {
            header("location: ../view/user_profile.php?error=failed");
        }
    }

    public function getSocialLink($username) {
        require_once '../model/user_model.php';
        include '../model/db_connection.php';
        $userModel = new UserModel();
        return $userModel->getSocialLink($db, $username);
    }

    public function getSkills($username){
        require_once '../model/user_model.php';
        include '../model/db_connection.php';
        $userModel = new UserModel();
        return $userModel->getSkills($db, $username);
    }

    public function addSkill($username, $skill, $experience){
        include '../model/db_connection.php';
        require_once '../model/user_model.php';
        $userModel = new UserModel();
        if($userModel->addSkill($db, $username, $skill, $experience)){
            header("location: ../view/user_profile.php?success=accountupdated");
        } else {
            header("location: ../view/user_profile.php?error=failed");
        }
    }

    public function deleteSkill($id, $username){
        include '../model/db_connection.php';
        require_once '../model/user_model.php';
        $userModel = new UserModel();
        if ($userModel->deleteSkill($db, $id, $username)) {
			header("location: ../view/user_profile.php?success=accountupdated");
		} else {
			header("location: ../view/user_profile.php?error=failed");
		}
    }

    public function getEducations($username){
        require_once '../model/user_model.php';
        include '../model/db_connection.php';
        $userModel = new UserModel();
        return $userModel->getEducations($db, $username);
    }

    public function addEducation($username, $institution, $degree, $graduation){
        include '../model/db_connection.php';
        require_once '../model/user_model.php';
        $userModel = new UserModel();
        if ($userModel->addEducation($db, $username, $institution, $degree, $graduation)) {
			header("location: ../view/user_profile.php?success=accountupdated");
		} else {
			header("location: ../view/user_profile.php?error=failed");
		}
    }

    public function deleteEducation($id, $username){
        include '../model/db_connection.php';
        require_once '../model/user_model.php';
        $userModel = new UserModel();
        if ($userModel->deleteEducation($db, $id, $username)) {
			header("location: ../view/user_profile.php?success=accountupdated");
		} else {
			header("location: ../view/user_profile.php?error=failed");
		}
    }

    public function getCareers($username){
        require_once '../model/user_model.php';
        include '../model/db_connection.php';
        $userModel = new UserModel();
        return $userModel->getCareers($db, $username);
    }

    public function addCareer($username, $position, $company, $experience){
        include '../model/db_connection.php';
        require_once '../model/user_model.php';
        $userModel = new UserModel();
        if ($userModel->addCareer($db, $username, $position, $company, $experience)) {
			header("location: ../view/user_profile.php?success=accountupdated");
		} else {
			header("location: ../view/user_profile.php?error=failed");
		}
    }

    public function deleteCareer($id, $username){
        include '../model/db_connection.php';
        require_once '../model/user_model.php';
        $userModel = new UserModel();
        if ($userModel->deleteCareer($db, $id, $username)) {
			header("location: ../view/user_profile.php?success=accountupdated");
		} else {
			header("location: ../view/user_profile.php?error=failed");
		}
    }

    public function resetPassword($type, $password, $confirmPassword, $email, $token) {
        require_once '../model/utility.php';
        if(!isset($type) || !isset($password) || !isset($confirmPassword) || !isset($email) || !isset($token)){
            header("location: ../view/reset_password.php?error=emptyinput");
            exit();
        }elseif (passwordMatch($password, $confirmPassword) !== false) {               // Do the two passwords match?
            header("location: ../view/reset_password.php?error=passwordsdontmatch");
            exit();
        }else{
            require_once '../model/user_model.php';
            include '../model/db_connection.php';
            $userModel = new UserModel();
            if ($userModel->resetPassword($db, $type, $password, $email, $token)) {
				header("location: ../view/login.php?success=reset");
			} else {
				header("location: ../view/reset_password.php?error=resetfailed");
			}
        }
    }

    public function getMap($location){
        $map = "";
        if($location == "South Australia"){
            $map = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4635080.582955133!2d128.3802399115305!3d-31.79767083721273!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6aa7589e5be8c7f3%3A0xdb7e79993dfad0d8!2sSouth%20Australia!5e0!3m2!1sen!2sau!4v1634199832752!5m2!1sen!2sau"
                style="border:0; border-radius:20px; width:100%;"
                height="400"
                allowfullscreen="" 
                loading="lazy">
                </iframe>';
        }elseif($location == "New South Wales"){
            $map = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6872893.2402667375!2d145.56236296114977!3d-32.74171576484607!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b0dcb74f75e4b0d%3A0x1780af1122c49f2d!2sNew%20South%20Wales!5e0!3m2!1sen!2sau!4v1634200460004!5m2!1sen!2sau" 
                style="border:0; border-radius:20px; width:100%;"
                height="400"
                allowfullscreen="" 
                loading="lazy">
                </iframe>';
        }elseif($location == "Queensland"){
            $map = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15459488.740622992!2d136.75256125269178!3d-18.91858719247613!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6bd4df247a62dcfd%3A0xf5f2d0227612be99!2sQueensland!5e0!3m2!1sen!2sau!4v1634200597763!5m2!1sen!2sau" 
                style="border:0; border-radius:20px; width:100%;"
                height="400"
                allowfullscreen="" 
                loading="lazy">
                </iframe>';
        }elseif($location == "Northern Territory"){
            $map = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7752557.33792846!2d129.00700266545138!3d-18.418848751091282!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2b5172c2e6f3190f%3A0x2775!2sNorthern%20Territory!5e0!3m2!1sen!2sau!4v1634200638022!5m2!1sen!2sau" 
                style="border:0; border-radius:20px; width:100%;"
                height="400"
                allowfullscreen="" 
                loading="lazy">
                </iframe>';
        }elseif($location == "Western Australia"){
            $map = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14914874.922909884!2d111.94704545781225!3d-24.12515580577404!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2a392a2e89f384d1%3A0x6e0e4adf3200a399!2sWestern%20Australia!5e0!3m2!1sen!2sau!4v1634200676344!5m2!1sen!2sau" 
                style="border:0; border-radius:20px; width:100%;"
                height="400"
                allowfullscreen="" 
                loading="lazy">
                </iframe>';
        }elseif($location == "Victoria"){
            $map = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3282328.357228456!2d143.2263467636101!3d-36.54449643080819!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad4314b7e18954f%3A0x5a4efce2be829534!2sVictoria!5e0!3m2!1sen!2sau!4v1634200706996!5m2!1sen!2sau" 
                style="border:0; border-radius:20px; width:100%;"
                height="400"
                allowfullscreen="" 
                loading="lazy">
                </iframe>';
        }elseif($location == "Tasmania"){
            $map = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3062672.5138291633!2d143.91829759460327!3d-41.44158396188258!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xaa7aed277e34facf%3A0x2a8fa5dd29404064!2sTasmania!5e0!3m2!1sen!2sau!4v1634200739277!5m2!1sen!2sau" 
                style="border:0; border-radius:20px; width:100%;"
                height="400"
                allowfullscreen="" 
                loading="lazy">
                </iframe>';
        }elseif($location == "Australian Capital Territory"){
            $map = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d415654.36564480094!2d148.80086086077307!3d-35.52159004323351!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b164cdfa09b104b%3A0xe75844385c6e7803!2sAustralian%20Capital%20Territory!5e0!3m2!1sen!2sau!4v1634200868647!5m2!1sen!2sau" 
                style="border:0; border-radius:20px; width:100%;"
                height="400"
                allowfullscreen="" 
                loading="lazy">
                </iframe>';
        }
        return $map;
    }
}
