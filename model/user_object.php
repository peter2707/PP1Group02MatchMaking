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
    public function __construct($id, $firstName, $lastName, $username, $password, $dob, $phone, $email, $position) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->password = $password;
        $this->dob = $dob;
        $this->phone = $phone;
        $this->email = $email;
        $this->position = $position;
    }
}

class Social{
    public function __construct($username, $linkedin, $github, $twitter, $instagram, $facebook) {
        $this->username = $username;
        $this->linkedin = $linkedin;
        $this->github = $github;
        $this->twitter = $twitter;
        $this->instagram = $instagram;
        $this->facebook = $facebook;
    }
}

class Skill{
    public function __construct($id, $username, $skill, $experience) {
        $this->id = $id;
        $this->username = $username;
        $this->skill = $skill;
        $this->experience = $experience;
    }
}

class Education{
    public function __construct($id, $username, $institution, $degree, $graduation) {
        $this->id = $id;
        $this->username = $username;
        $this->institution = $institution;
        $this->degree = $degree;
        $this->graduation = $graduation;
    }
}

class Career{
    public function __construct($id, $username, $position, $company, $experience) {
        $this->id = $id;
        $this->username = $username;
        $this->position = $position;
        $this->company = $company;
        $this->experience = $experience;
    }
}

?> 