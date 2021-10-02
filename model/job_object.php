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

class JobMatch{
    public function __construct($id, $employer, $position, $salary, $type, $description, $requirement, $location, $percentage) {
        $this->id = $id;
        $this->employer = $employer;
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
