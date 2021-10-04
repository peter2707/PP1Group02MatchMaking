<?php
class MatchmakingModel{

	public function postNewJob($db, $position, $field, $salary, $type, $description, $requirements, $location, $username, $contact){
		$query = "INSERT INTO jobpost (position, field, salary, type, description, requirements, location, employer, contact) VALUES ('$position', '$field', '$salary', '$type', '$description', '$requirements', '$location', '$username', '$contact')";
		mysqli_query($db, $query) or die(mysqli_error($db));
		$db->close();
		header("location: ../view/employer_post.php?success=posted");
	}
	
	public function getAllPosts($db){
		require_once '../model/job_object.php';
		$jobposts = array();

		$query = "SELECT * FROM jobpost";
		$result = $db->query($query);
		$numResults = $result->num_rows;

		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$jobposts[$i] = new JobPost($row['id'], $row['employer'], $row['position'], $row['salary'], $row['location'], $row['type']);
		}

		$result->free();
		return $jobposts;
	}

	public function getJobPosts($db, $username){
		require_once '../model/job_object.php';
		$jobposts = array();

		$query = "SELECT * FROM jobpost WHERE employer='$username'";
		$result = $db->query($query) or die(mysqli_error($db));
		$numResults = $result->num_rows;
		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$jobID=$row['id'];
			$result2 = $db->query("SELECT COUNT(*) as totalmatches FROM jobmatch WHERE jobPostID='$jobID'");
			$row2 = $result2->fetch_assoc();
			$countMatch = $row2['totalmatches'];
			$jobposts[$i] = new EmpJobPost($row['id'], $row['position'], $row['salary'], $row['type'], $row['description'], $row['requirements'], $row['location'], $row['contact'], $countMatch);
		}

		$result->free();
		return $jobposts;
	}

	public function getJobMatch($db, $user){
		require_once '../model/job_object.php';
		$jobMatch = array();
		$query = "SELECT * FROM jobpost 
					INNER JOIN jobmatch ON jobpost.employer = jobmatch.employer	
					WHERE jobmatch.jobSeeker='$user' 
					AND jobmatch.jobPostID = jobpost.id";
		$result = $db->query($query);
		$numResults = $result->num_rows;

		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$jobMatch[$i] = new JobMatch($row['id'], $row['employer'], '', $row['contact'], $row['position'], $row['field'], $row['salary'], $row['type'], $row['description'], $row['requirements'], $row['location'], $row['percentage']);
		}
		$result->free();
		$db->close();

		return $jobMatch;
	}

	public function getJobMatchByID($db, $jobID){
		require_once '../model/job_object.php';
		$query = "SELECT * FROM jobpost 
					INNER JOIN jobmatch ON jobpost.employer = jobmatch.employer 
					WHERE jobmatch.id='$jobID' 
					AND jobmatch.jobPostID = jobpost.id";
		$result = $db->query($query);
		$row = $result->fetch_assoc();

		$employer = $row['employer'];
		$result2 = $db->query("SELECT rating as Emprating FROM employer WHERE username='$employer'");
		$row2 = $result2->fetch_assoc();
		$rating = $row2['Emprating'];
		
		$jobMatch = new JobMatch($row['id'], $row['employer'], $rating, $row['contact'], $row['position'], $row['field'], $row['salary'], $row['type'], $row['description'], $row['requirements'], $row['location'], $row['percentage']);
		$result->free();
		$db->close();

		return $jobMatch;
	}

	public function getPreviousMatch($db, $jobseeker, $jobID){
		$query = "SELECT count(*) FROM jobmatch WHERE jobSeeker = '$jobseeker' AND jobPostID = '$jobID'";		
		$stmt = $db->prepare($query);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();

		if (!$result) {
			return false;
			$db->close();
		}
		$row = $result->fetch_row();
		if ($row[0] > 0) {
			return true;
		}
	}

	public function setJobMatch($db, $employer, $jobseeker, $jobPostID, $percentage){
		$query = "INSERT INTO jobmatch (employer, jobseeker, jobPostID, percentage) VALUES ('$employer', '$jobseeker', '$jobPostID', '$percentage')";
		mysqli_query($db, $query) or die(mysqli_error($db));
	}

	public function findMatch($db, $position, $salary, $location, $type, $jobseeker){
		$found = false;
		$jobposts = array();
        $jobposts = $this->getAllPosts($db);
		foreach($jobposts as $post => $val){
			if(strtolower($val->position) == strtolower($position) && $val->salary == $salary && $val->location == $location && $val->type == $type){
				if(!$this->getPreviousMatch($db, $jobseeker, $val->id)){
					$this->setJobMatch($db, $val->employer, $jobseeker, $val->id, 100);
					unset($jobposts[$post]);
					$found = true;
				}
			}elseif(strtolower($val->position) == strtolower($position) && $val->salary == $salary && $val->location == $location
					|| strtolower($val->position) == strtolower($position) && $val->salary == $salary && $val->type == $type
					|| strtolower($val->position) == strtolower($position) && $val->location == $location && $val->type == $type){
				if(!$this->getPreviousMatch($db, $jobseeker, $val->id)){
					$this->setJobMatch($db, $val->employer, $jobseeker, $val->id, 75);
					unset($jobposts[$post]);
					$found = true;
				}
			}elseif(strtolower($val->position) == strtolower($position) && $val->salary == $salary
					|| strtolower($val->position) == strtolower($position) && $val->location == $location
					|| strtolower($val->position) == strtolower($position) && $location && $val->type == $type){
				if(!$this->getPreviousMatch($db, $jobseeker, $val->id)){
					$this->setJobMatch($db, $val->employer, $jobseeker, $val->id, 50);
					unset($jobposts[$post]);
					$found = true;
				}
			}elseif(strtolower($val->position) == strtolower($position)){
				if(!$this->getPreviousMatch($db, $jobseeker, $val->id)){
					$this->setJobMatch($db, $val->employer, $jobseeker, $val->id, 25);
					unset($jobposts[$post]);
					$found = true;
				}
			}
		}
		return $found;
	}
	
}
