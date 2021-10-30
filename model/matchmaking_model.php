<?php
class MatchmakingModel{

	public function postNewJob($db, $position, $field, $salary, $type, $description, $requirements, $location, $username, $contact){
		$query = "INSERT INTO jobpost (position, field, salary, type, description, requirements, location, employer, contact) VALUES ('$position', '$field', '$salary', '$type', '$description', '$requirements', '$location', '$username', '$contact')";
		mysqli_query($db, $query) or die(mysqli_error($db));
		$db->close();
		header("location: ../view/employer_post.php?success=posted");
	}
	
	public function getJobPostsByField($db, $field){
		require_once '../model/job_object.php';
		$jobposts = array();

		$query = "SELECT * FROM jobpost WHERE field = '$field'";
		$result = $db->query($query);
		$numResults = $result->num_rows;

		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$totalMatches = $this->countJobMatches($db, $row['id']);
			$timeElapsed = $this->getTimeElapsed($row['date']);
			$jobposts[$i] = new JobPost($row['id'], $row['position'], $row['field'], $row['salary'], $row['type'], $row['description'], $row['requirements'], $row['location'], $row['employer'], $row['contact'], $totalMatches, $timeElapsed);
		}

		$result->free();
		return $jobposts;
	}

	public function getJobPostsByEmployer($db, $username){
		require_once '../model/job_object.php';
		$jobposts = array();
		$query = "SELECT * FROM jobpost WHERE employer='$username'";
		$result = $db->query($query) or die(mysqli_error($db));
		$numResults = $result->num_rows;
		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$totalMatches = $this->countJobMatches($db, $row['id']);
			$timeElapsed = $this->getTimeElapsed($row['date']);
			$jobposts[$i] = new JobPost($row['id'], $row['position'], $row['field'], $row['salary'], $row['type'], $row['description'], $row['requirements'], $row['location'], $row['employer'], $row['contact'], $totalMatches, $timeElapsed);
		}

		$result->free();
		return $jobposts;
	}

	public function getJobPostByID($db, $jobID){
		require_once '../model/job_object.php';
		$query = "SELECT * FROM jobpost WHERE id='$jobID'";
		$result = $db->query($query);
		$row = $result->fetch_assoc();
		$totalMatches = $this->countJobMatches($db, $jobID);
		$timeElapsed = $this->getTimeElapsed($row['date']);
		$jobPost = new JobPost($row['id'], $row['position'], $row['field'], $row['salary'], $row['type'], $row['description'], $row['requirements'], $row['location'], $row['employer'], $row['contact'], $totalMatches, $timeElapsed);
		$result->free();
		$db->close();

		return $jobPost;
	}

	public function countJobPosts($db, $employer){
		$result = $db->query("SELECT COUNT(*) as totalPosts FROM jobpost WHERE employer='$employer'");
		$row = $result->fetch_assoc();
		$countJobPosts = $row['totalPosts'];
		return $countJobPosts;
	}

	public function countJobMatches($db, $jobID){
		$result = $db->query("SELECT COUNT(*) as totalmatches FROM jobmatch WHERE jobPostID='$jobID'");
		$row = $result->fetch_assoc();
		$countJobMatches = $row['totalmatches'];
		return $countJobMatches;
	}

	public function updatePost($db, $position, $field, $salary, $type, $description, $requirements, $location, $contact, $id){
		$query = "UPDATE jobpost SET position=?, field=?, salary=?, type=?, description=?, requirements=?, location=?, contact=? WHERE id=?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("ssssssssi", $position, $field, $salary, $type, $description, $requirements, $location, $contact, $id);
		$stmt->execute();

		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		if ($affectedRows == 1) {
			header("location: ../view/employer_post.php?success=updated");
		} else {
			header("location: ../view/employer_post.php?error=updatefailed");
		}
	}

	public function deletePost($db, $id, $usertype) {
		$this->deleteMatchByPostID($db, $id);
		$query = "DELETE FROM jobpost WHERE id = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $id);
		$stmt->execute();

		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		if ($affectedRows == 1) {
			if($usertype == "admin"){
				header("location: ../view/admin_index.php?success=deleted");
			}else{
				header("location: ../view/employer_post.php?success=deleted");
			}
		} else {
			if($usertype == "admin"){
				header("location: ../view/admin_index.php?error=deletefailed");
			}else{
				header("location: ../view/employer_post.php?error=deletefailed");	
			}
		}
	}

	public function getJobMatch($db, $user){
		require_once '../model/job_object.php';
		$jobMatch = array();
		$query = "SELECT *, jobpost.id as jid, jobmatch.id as mid FROM jobpost 
					INNER JOIN jobmatch ON jobpost.employer = jobmatch.employer	
					WHERE jobmatch.jobSeeker='$user' 
					AND jobmatch.jobPostID = jobpost.id";
		$result = $db->query($query);
		$numResults = $result->num_rows;

		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$rating = $this->getEmployerRating($db, $row['employer']);
			$date = $this->getDate($db, 'jobmatch', $row['mid']);
			$timeElapsed = $this->getTimeElapsed($date);
			$jobMatch[$i] = new JobMatch($row['id'], $row['employer'], $row['jobSeeker'], $row['contact'], $row['position'], $row['field'], $row['salary'], $row['type'], $row['description'], $row['requirements'], $row['location'], $row['percentage'], $rating, $row['feedback'], $timeElapsed);
		}
		$result->free();
		$db->close();

		return $jobMatch;
	}

	public function getJobMatchbyPostID($db, $postID, $employer){
		require_once '../model/job_object.php';
		$jobMatch = array();
		$query = "SELECT *, jobpost.id as jid, jobmatch.id as mid FROM jobmatch 
					INNER JOIN jobpost ON jobpost.id = jobmatch.jobPostID	
					WHERE jobmatch.employer= '$employer' 
					AND jobmatch.jobPostID = '$postID'";
		$result = $db->query($query);
		$numResults = $result->num_rows;

		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$rating = $this->getEmployerRating($db, $row['employer']);
			$date = $this->getDate($db, 'jobmatch', $row['mid']);
			$timeElapsed = $this->getTimeElapsed($date);
			$jobMatch[$i] = new JobMatch($row['mid'], $row['employer'], $row['jobSeeker'], $row['contact'], $row['position'], $row['field'], $row['salary'], $row['type'], $row['description'], $row['requirements'], $row['location'], $row['percentage'], $rating, $row['feedback'], $timeElapsed);
		}
		$result->free();
		$db->close();

		return $jobMatch;
	}

	public function getJobMatchByID($db, $jobID){
		require_once '../model/job_object.php';
		$query = "SELECT *, jobpost.id as jid, jobmatch.id as mid FROM jobmatch 
					INNER JOIN jobpost ON jobpost.employer = jobmatch.employer 
					WHERE jobmatch.id='$jobID' 
					AND jobmatch.jobPostID = jobpost.id";
		$result = $db->query($query);
		$row = $result->fetch_assoc();
		$rating = $this->getEmployerRating($db, $row['employer']);
		$date = $this->getDate($db, 'jobmatch', $row['mid']);
		$timeElapsed = $this->getTimeElapsed($date);
		$jobMatch = new JobMatch($row['id'], $row['employer'], $row['jobSeeker'], $row['contact'], $row['position'], $row['field'], $row['salary'], $row['type'], $row['description'], $row['requirements'], $row['location'], $row['percentage'], $rating, $row['feedback'], $timeElapsed);
		$result->free();
		$db->close();

		return $jobMatch;
	}

	public function getDate($db, $table, $id){
		$result = $db->query("SELECT date FROM $table WHERE id = '$id'");
		$row = $result->fetch_assoc();
		$date = $row['date'];
		return $date;
	}

	public function getEmployerRating($db, $employer){
		$rating = 0.0;
		$result = $db->query("SELECT rating FROM employer WHERE username='$employer'");
		$row = $result->fetch_assoc();
		if(isset($row['rating'])){
			$rating = $row['rating'];
		}
		return $rating;
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

	public function findMatch($db, $position, $salary, $location, $type, $field, $jobseeker){
		$found = false;
		$jobposts = array();
        $jobposts = $this->getJobPostsByField($db, $field);
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

	public function deleteMatchByPostID($db, $id) {
		$query = "DELETE FROM jobmatch WHERE jobPostID = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->close();
	}

	public function denyMatch($db, $id, $usertype) {
		$query = "DELETE FROM jobmatch WHERE id = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$affectedRows = $stmt->affected_rows;
		$stmt->close();

		if ($affectedRows == 1) {
			if($usertype == 'jobseeker'){
				header("location: ../view/jobseeker_match.php?success=successdeny");
			}elseif($usertype == 'employer'){
				header("location: ../view/employer_post.php?success=successdeny");
			}else{
				header("location: ../view/admin_index.php?success=deleted");
			}
		} else {
			if($usertype == 'jobseeker'){
				header("location: ../view/jobseeker_match.php?error=errordeny");
			}elseif($usertype == 'employer'){
				header("location: ../view/employer_post.php?error=errordeny");
			}else{
				header("location: ../view/admin_index.php?error=deletefailed");
			}
		}
	}

	public function addFeedback($db, $rating, $feedback, $id){
		$query = "UPDATE jobmatch SET rating=?, feedback=? WHERE id=?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("isi", $rating, $feedback, $id);
		$stmt->execute();
		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		if ($affectedRows == 1) {
			header("location: ../view/jobseeker_match.php?success=donefeedback");
		} else {
			header("location: ../view/jobseeker_match.php?error=errorfeedback");
		}
	}

	public function reportMatch($db, $username, $type, $id, $reason, $comment){
		$query = "INSERT INTO report (username, type, matchID, reason, comment) VALUES ('$username', '$type', '$id', '$reason', '$comment')";
		mysqli_query($db, $query) or die(mysqli_error($db));
		$db->close();
		header("location: ../view/report.php?success=reported");
	}

	function getTimeElapsed($date, $tense = 'ago') {
		date_default_timezone_set('Australia/Melbourne');
		// declaring periods as static function var for future use
		static $periods = array('year', 'month', 'day', 'hour', 'minute', 'second');

		// checking time format
		if(!(strtotime($date)>0)) {
			return trigger_error("Wrong time format: '$date'", E_USER_ERROR);
		}
	
		// getting diff between now and time
		$now  = new DateTime('now');
		$date = new DateTime($date);
		$diff = $now->diff($date)->format('%y %m %d %h %i %s');
		// combining diff with periods
		$diff = explode(' ', $diff);
		$diff = array_combine($periods, $diff);
		// filtering zero periods from diff
		$diff = array_filter($diff);
		// getting first period and value
		$period = key($diff);
		$value  = current($diff);
	
		// if input time was equal now, value will be 0, so checking it
		if(!$value) {
			$period = 'seconds';
			$value  = 0;
		} else {
			// converting days to weeks
			if($period=='day' && $value>=7) {
				$period = 'week';
				$value  = floor($value/7);
			}
			// adding 's' to period for human readability
			if($value>1) {
				$period .= 's';
			}
		}
		return "$value $period $tense";
	 }
	
}
