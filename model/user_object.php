<?php
class JobSeeker {
    public function __construct($firstName, $lastName, $username, $password, $dob, $phone, $email, $field) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->password = $password;
        $this->dob = $dob;
        $this->phone = $phone;
        $this->email = $email;
        $this->field = $field;
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

class JobPost{
    public $employer;
    public $salary;
    public $type;
    public $location;
    public $job;
}
class JobMatch{
    public $employer;
    public $requirement;
    public $contact;
    public $description;
}
?> 