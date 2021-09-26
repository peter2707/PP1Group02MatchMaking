<?php
class UserController{
    public function getUserData(){
        include '../model/user_model.php';
        include '../model/db_connection.php';
        $user_model = new UserModel();
        return $user_model->getUser($db);

    }
}
?> 