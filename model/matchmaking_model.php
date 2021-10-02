<?php
class MatchmakingModel{

	public function getJobPost($db){
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
		$query = "SELECT * FROM jobpost INNER JOIN jobmatch ON jobpost.employer = jobmatch.employer	WHERE jobmatch.jobSeeker='$user'";
		$result = $db->query($query)or die(mysqli_error($db));
		$numResults = $result->num_rows;

		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$jobMatch[$i] = new JobMatch($row['id'], $row['employer'], $row['position'], $row['salary'], $row['type'], $row['description'], $row['requirements'], $row['location'], $row['percentage']);
		}
		$result->free();
		$db->close();

		return $jobMatch;
	}

	public function setJobMatch($db, $employer, $jobseeker, $jobPostID, $percentage){
		$query = "INSERT INTO jobmatch (employer, jobseeker, jobPostID, percentage) VALUES ('$employer', '$jobseeker', '$jobPostID', '$percentage')";
		mysqli_query($db, $query) or die(mysqli_error($db));
		
	}

	public function findMatch($db, $position, $salary, $location, $type, $jobseeker){
		$found = false;
		$jobposts = array();
        $jobposts = $this->getJobPost($db);

		foreach($jobposts as $post){
			if(str_contains(strtolower($post->position), strtolower($position)) !== false && $post->salary == $salary && $post->location == $location && $post->type == $type){
				$this->setJobMatch($db, $post->employer, $jobseeker, $post->id, 100);
				$found = true;
			}elseif(str_contains(strtolower($post->position), strtolower($position)) !== false && $post->salary == $salary && $post->location == $location){
				$this->setJobMatch($db, $post->employer, $jobseeker, $post->id, 75);
				$found = true;
			}elseif(str_contains(strtolower($post->position), strtolower($position)) !== false && $post->salary == $salary){
				$this->setJobMatch($db, $post->employer, $jobseeker, $post->id, 50);
				$found = true;
			}elseif(str_contains(strtolower($post->position), strtolower($position)) !== false){
				$this->setJobMatch($db, $post->employer, $jobseeker, $post->id, 25);
				$found = true;
			}
		}
		return $found;
	}
}
