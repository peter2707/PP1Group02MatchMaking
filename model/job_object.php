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
    public function __construct($id, $position, $salary, $type, $description, $requirement, $location, $contact, $matches) {
        $this->id = $id;
        $this->position = $position;
        $this->salary = $salary;
        $this->type = $type;
        $this->description = $description;
        $this->requirements = $requirement;
        $this->location = $location;
        $this->contact = $contact;
        $this->matches = $matches;
    }
}

class JobMatch{
    public function __construct($id, $employer, $contact, $position, $salary, $type, $description, $requirement, $location, $percentage) {
        $this->id = $id;
        $this->employer = $employer;
        $this->contact = $contact;
        $this->position = $position;
        $this->salary = $salary;
        $this->type = $type;
        $this->description = $description;
        $this->requirement = $requirement;
        $this->location = $location;
        $this->percentage = $percentage;
    }
}
?>
