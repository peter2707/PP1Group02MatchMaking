<?php
class JobPost{
    public function __construct($id, $position, $field, $salary, $type, $description, $requirements, $location, $employer, $contact, $matches, $date) {
        $this->id = $id;
        $this->position = $position;
        $this->field = $field;
        $this->salary = $salary;
        $this->type = $type;
        $this->description = $description;
        $this->requirements = $requirements;
        $this->location = $location;
        $this->employer = $employer;
        $this->contact = $contact;
        $this->matches = $matches;
        $this->date = $date;
    }
}

class JobMatch{
    public function __construct($id, $employer, $jobseeker, $contact, $position, $field, $salary, $type, $description, $requirements, $location, $percentage, $rating, $feedback, $date) {
        $this->id = $id;
        $this->employer = $employer;
        $this->jobseeker = $jobseeker;
        $this->contact = $contact;
        $this->position = $position;
        $this->field = $field;
        $this->salary = $salary;
        $this->type = $type;
        $this->description = $description;
        $this->requirements = $requirements;
        $this->location = $location;
        $this->percentage = $percentage;
        $this->rating = $rating;
        $this->feedback = $feedback;
        $this->date = $date;
    }
}

class Report{
    public function __construct($id, $username, $type, $matchID, $reason, $comment, $date) {
        $this->id = $id;
        $this->username = $username;
        $this->type = $type;
        $this->matchID = $matchID;
        $this->reason = $reason;
        $this->comment = $comment;
        $this->date = $date;
    }
}

class Feedback{
    public function __construct($id, $username, $rating, $comment, $date) {
        $this->id = $id;
        $this->username = $username;
        $this->rating = $rating;
        $this->comment = $comment;
        $this->date = $date;
    }
}
