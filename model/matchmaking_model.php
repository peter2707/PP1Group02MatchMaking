<?php
class MatchmakingModel{

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

	

	public function getJobMatch($db, $user){
		require_once '../model/job_object.php';
		$jobMatch = array();
		$query = "SELECT * FROM jobpost INNER JOIN jobmatch ON jobpost.employer = jobmatch.employer	WHERE jobmatch.jobSeeker='$user' AND jobmatch.jobPostID = jobpost.id";
		$result = $db->query($query);
		$numResults = $result->num_rows;

		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$jobMatch[$i] = new JobMatch($row['id'], $row['employer'], $row['contact'], $row['position'], $row['salary'], $row['type'], $row['description'], $row['requirements'], $row['location'], $row['percentage']);
		}
		$result->free();
		$db->close();

		return $jobMatch;
	}

	public function setJobMatch($db, $employer, $jobseeker, $jobPostID, $percentage){
		$query = "INSERT INTO jobmatch (employer, jobseeker, jobPostID, percentage) VALUES ('$employer', '$jobseeker', '$jobPostID', '$percentage')";
		mysqli_query($db, $query);
	}

	public function findMatch($db, $position, $salary, $location, $type, $jobseeker){
		$found = false;
		$jobposts = array();
        $jobposts = $this->getAllPosts($db);

		foreach($jobposts as $post => $val){
			if(strtolower($val->position) == strtolower($position) && $val->salary == $salary && $val->location == $location && $val->type == $type){
				$this->setJobMatch($db, $val->employer, $jobseeker, $val->id, 100);
				unset($jobposts[$post]);
				$found = true;
			}elseif(strtolower($val->position) == strtolower($position) && $val->salary == $salary && $val->location == $location){
				$this->setJobMatch($db, $val->employer, $jobseeker, $val->id, 75);
				unset($jobposts[$post]);
				$found = true;
			}elseif(strtolower($val->position) == strtolower($position) && $val->salary == $salary){
				$this->setJobMatch($db, $val->employer, $jobseeker, $val->id, 50);
				unset($jobposts[$post]);
				$found = true;
			}elseif(strtolower($val->position) == strtolower($position)){
				$this->setJobMatch($db, $val->employer, $jobseeker, $val->id, 25);
				unset($jobposts[$post]);
				$found = true;
			}
		}
		return $found;
	}

	public function postNewJob($db, $position, $salary, $type, $description, $requirements, $location, $username, $contact){
		$query = "INSERT INTO jobpost (position, salary, type, description, requirements, location, employer, contact) VALUES ('$position', '$salary', '$type', '$description', '$requirements', '$location', '$username', '$contact')";
		mysqli_query($db, $query) or die(mysqli_error($db));
		$db->close();
		header("location: ../view/employer_post.php?success=posted");
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
	
}
