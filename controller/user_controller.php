<?php
class UserController{
    public function getUserData(){
        include '../model/user_model.php';
        include '../model/db_connection.php';
        $user_model = new UserModel();
        return $user_model->getUser($db);
    }

    public function updateUserData($firstname, $lastname, $password, $dob, $phone, $email, $exp, $skill, $username){
        include '../model/user_model.php';
        include '../model/db_connection.php';
        $user_model = new UserModel();
        if($user_model->updateUser($db, $firstname, $lastname, $password, $dob, $phone, $email, $exp, $skill, $username)){
            header("location: ../view/userprofile.php");
        }else{
            header("location: ../view/userhome.php");
        }
    }
}
?> 