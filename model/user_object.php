<?php
class JobSeeker {
    public function __construct($id, $firstName, $lastName, $username, $password, $dob, $phone, $email, $field, $location, $image) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->password = $password;
        $this->dob = $dob;
        $this->phone = $phone;
        $this->email = $email;
        $this->field = $field;
        $this->location = $location;
        $this->image = $image;
    }
    
}

class Employer {
    public function __construct($id, $firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $location, $rating, $image) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->password = $password;
        $this->dob = $dob;
        $this->phone = $phone;
        $this->email = $email;
        $this->position = $position;
        $this->location = $location;
        $this->rating = $rating;
        $this->image = $image;
    }
}

class Admin {
    public function __construct($id, $firstName, $lastName, $username, $password, $dob, $phone, $email, $position, $image) {
        $this->id = $id;
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