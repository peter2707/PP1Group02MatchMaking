<?php
class JobSeeker {
    public function __construct($firstName, $lastName, $username, $password, $dob, $phone, $email, $field, $image) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->password = $password;
        $this->dob = $dob;
        $this->phone = $phone;
        $this->email = $email;
        $this->field = $field;
        $this->image = $image;
    }
    
}

class Employer {
    public function __construct($firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $rating, $image) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->password = $password;
        $this->dob = $dob;
        $this->phone = $phone;
        $this->email = $email;
        $this->position = $position;
        $this->rating = $rating;
        $this->image = $image;
    }
}

class Admin {
    public function __construct($firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $image) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->password = $password;
        $this->dob = $dob;
        $this->phone = $phone;
        $this->email = $email;
        $this->position = $position;
        $this->image = $image;
    }
}
?> 