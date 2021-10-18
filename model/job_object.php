<?php
class JobPost{
    public function __construct($id, $employer, $position, $salary, $location, $type) {
        $this->id = $id;
        $this->employer = $employer;
        $this->position = $position;
        $this->salary = $salary;
        $this->location = $location;
        $this->type = $type;
    }
}

class EmpJobPost{
    public function __construct($id, $position, $field, $salary, $type, $description, $requirements, $location, $contact, $matches, $date) {
        $this->id = $id;
        $this->position = $position;
        $this->field = $field;
        $this->salary = $salary;
        $this->type = $type;
        $this->description = $description;
        $this->requirements = $requirements;
        $this->location = $location;
        $this->contact = $contact;
        $this->matches = $matches;
        $this->date = $date;
    }
}

class JobMatch{
    public function __construct($id, $employer, $jobseeker, $rating, $contact, $position, $field, $salary, $type, $description, $requirements, $location, $percentage) {
        $this->id = $id;
        $this->employer = $employer;
        $this->jobseeker = $jobseeker;
        $this->rating = $rating;
        $this->contact = $contact;
        $this->position = $position;
        $this->field = $field;
        $this->salary = $salary;
        $this->type = $type;
        $this->description = $description;
        $this->requirements = $requirements;
        $this->location = $location;
        $this->percentage = $percentage;
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
