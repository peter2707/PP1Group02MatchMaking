<?php
class UserModel
{

  public function getUser($db)
  {
    include '../model/user_object.php';
    $user = new User();
    $sessionController = new SessionController();
    $username = $sessionController->getUserName();

    $query = "SELECT * FROM jobseeker WHERE username = ?";
    $stmtEmp = $db->prepare($query);
    $stmtEmp->bind_param("s", $username);

    $stmtEmp->execute();
    $result = $stmtEmp->get_result();
    $stmtEmp->close();
    $row = $result->fetch_assoc();
    $db->close();

    $user->firstName = $row['firstName'];
    $user->lastName = $row['lastName'];
    $user->username = $row['username'];
    $user->dob = $row['dateOfBirth'];
    $user->phone = $row['phone'];
    $user->email = $row['email'];
    $user->skill = $row['skill'];
    $user->exp = $row['experience'];
    $user->password = $row['password'];
    return $user;
  }

  public function updateUser($db, $firstName, $lastName, $password, $dob, $phone, $email, $exp, $skill, $username)
  {
    $query = "UPDATE jobseeker SET firstName=?, lastName=? password=?, dateOfBirth=?, phone=?, email=?, experience=?, skill=? WHERE username = ?";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ssssssss", $firstName, $lastName, $password, $dob, $phone, $email, $exp, $skill, $username);
    $stmt->execute();

    $affectedRows = $stmt->affected_rows;
    $stmt->close();
    $db->close();

    if($affectedRows ==1){
      return true;
    } else {
      return false;
    }
  }
}
