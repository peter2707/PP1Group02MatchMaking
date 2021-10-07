<?php



class MatchmakingModel
{

	public function postNewJob($db, $position, $field, $salary, $type, $description, $requirements, $location, $username, $contact)
	{

		$sql = "INSERT INTO jobpost (position, field, salary, type, description, requirements, location, employer, contact) VALUES('$position', '$field', '$salary', '$type', '$description', '$requirements', '$location', '$username', '$contact')";

		if ($stmt = $db->prepare($sql)) {
			if ($stmt->execute()) {
				return true;   
			} else {
				return false;
			}
		}
		$db->close();
	}

	public function getAllPosts($db)
	{
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

	public function getJobPosts($db, $username, $path)
	{
		require_once $path;
		$jobposts = array();

		$query = "SELECT * FROM jobpost WHERE employer='$username'";
		$result = $db->query($query) or die(mysqli_error($db));
		$numResults = $result->num_rows;
		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$jobID = $row['id'];
			$result2 = $db->query("SELECT COUNT(*) as totalmatches FROM jobmatch WHERE jobPostID='$jobID'");
			$row2 = $result2->fetch_assoc();
			$countMatch = $row2['totalmatches'];
			$jobposts[$i] = new EmpJobPost($row['id'], $row['position'], $row['field'], $row['salary'], $row['type'], $row['description'], $row['requirements'], $row['location'], $row['contact'], $countMatch);
		}

		$result->free();
		return $jobposts;
	}

	public function getJobPostByID($db, $jobID)
	{
		require_once '../model/job_object.php';
		$query = "SELECT * FROM jobpost 
					WHERE id='$jobID'";
		$result = $db->query($query);
		$row = $result->fetch_assoc();

		$result2 = $db->query("SELECT COUNT(*) as totalmatches FROM jobmatch WHERE jobPostID='$jobID'");
		$row2 = $result2->fetch_assoc();
		$countMatch = $row2['totalmatches'];

		$jobPost = new EmpJobPost($row['id'], $row['position'], $row['field'], $row['salary'], $row['type'], $row['description'], $row['requirements'], $row['location'], $row['contact'], $countMatch);
		$result->free();
		$db->close();

		return $jobPost;
	}

	public function updatePost($db, $position, $field, $salary, $type, $description, $requirements, $location, $contact, $id)
	{
		$query = "UPDATE jobpost SET position=?, field=?, salary=?, type=?, description=?, requirements=?, location=?, contact=? WHERE id=?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("ssssssssi", $position, $field, $salary, $type, $description, $requirements, $location, $contact, $id);
		$stmt->execute();

		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		if ($affectedRows == 1) {
			header("location: ../view/employer_post.php?success=successupdate");
		} else {
			header("location: ../view/employer_post.php?error=errorupdate");
		}
	}

	public function deletePost($db, $id)
	{
		
		$this->deleteMatchByPostID($db, $id);
		$query = "DELETE FROM jobpost WHERE id = '$id'";
		if ($stmt = $db->prepare($query)) {
			if ($stmt->execute()) {
				$affectedRows = $stmt->affected_rows;
					if ($affectedRows == 1) {
						return true;
					} else {
						return false;
					}
				$stmt->close();
				$db->close();
			} else {
				return false;
			}
		}
		
	}

	public function getJobMatch($db, $user)
	{
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
			$jobMatch[$i] = new JobMatch($row['id'], $row['employer'], $row['jobSeeker'], '', $row['contact'], $row['position'], $row['field'], $row['salary'], $row['type'], $row['description'], $row['requirements'], $row['location'], $row['percentage']);
		}
		$result->free();
		$db->close();

		return $jobMatch;
	}

	public function getJobMatchbyPostID($db, $postID, $employer)
	{
		require_once '../model/job_object.php';
		$jobMatch = array();
		$query = "SELECT * FROM jobmatch 
					INNER JOIN jobpost ON jobpost.id = jobmatch.jobPostID	
					WHERE jobmatch.employer= '$employer' 
					AND jobmatch.jobPostID = '$postID'";
		$result = $db->query($query);
		$numResults = $result->num_rows;

		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$jobMatch[$i] = new JobMatch($row['id'], $row['employer'], $row['jobSeeker'], '', $row['contact'], $row['position'], $row['field'], $row['salary'], $row['type'], $row['description'], $row['requirements'], $row['location'], $row['percentage']);
		}
		$result->free();
		$db->close();

		return $jobMatch;
	}

	public function getJobMatchByID($db, $jobID)
	{
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

		$jobMatch = new JobMatch($row['id'], $row['employer'], $row['jobSeeker'], $rating, $row['contact'], $row['position'], $row['field'], $row['salary'], $row['type'], $row['description'], $row['requirements'], $row['location'], $row['percentage']);
		$result->free();
		$db->close();

		return $jobMatch;
	}

	public function getPreviousMatch($db, $jobseeker, $jobID)
	{
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

	public function setJobMatch($db, $employer, $jobseeker, $jobPostID, $percentage)
	{
		$query = "INSERT INTO jobmatch (employer, jobseeker, jobPostID, percentage) VALUES ('$employer', '$jobseeker', '$jobPostID', '$percentage')";
		mysqli_query($db, $query) or die(mysqli_error($db));
	}

	public function findMatch($db, $position, $salary, $location, $type, $jobseeker)
	{
		$found = false;
		$jobposts = array();
		$jobposts = $this->getAllPosts($db);
		foreach ($jobposts as $post => $val) {
			if (strtolower($val->position) == strtolower($position) && $val->salary == $salary && $val->location == $location && $val->type == $type) {
				if (!$this->getPreviousMatch($db, $jobseeker, $val->id)) {
					$this->setJobMatch($db, $val->employer, $jobseeker, $val->id, 100);
					unset($jobposts[$post]);
					$found = true;
				}
			} elseif (
				strtolower($val->position) == strtolower($position) && $val->salary == $salary && $val->location == $location
				|| strtolower($val->position) == strtolower($position) && $val->salary == $salary && $val->type == $type
				|| strtolower($val->position) == strtolower($position) && $val->location == $location && $val->type == $type
			) {
				if (!$this->getPreviousMatch($db, $jobseeker, $val->id)) {
					$this->setJobMatch($db, $val->employer, $jobseeker, $val->id, 75);
					unset($jobposts[$post]);
					$found = true;
				}
			} elseif (
				strtolower($val->position) == strtolower($position) && $val->salary == $salary
				|| strtolower($val->position) == strtolower($position) && $val->location == $location
				|| strtolower($val->position) == strtolower($position) && $location && $val->type == $type
			) {
				if (!$this->getPreviousMatch($db, $jobseeker, $val->id)) {
					$this->setJobMatch($db, $val->employer, $jobseeker, $val->id, 50);
					unset($jobposts[$post]);
					$found = true;
				}
			} elseif (strtolower($val->position) == strtolower($position)) {
				if (!$this->getPreviousMatch($db, $jobseeker, $val->id)) {
					$this->setJobMatch($db, $val->employer, $jobseeker, $val->id, 25);
					unset($jobposts[$post]);
					$found = true;
				}
			}
		}
		return $found;
	}

	public function deleteMatchByPostID($db, $id)
	{
		$query = "DELETE FROM jobmatch WHERE jobPostID = '$id'";
		if ($stmt = $db->prepare($query)) {
			if ($stmt->execute()) {
				$affectedRows = $stmt->affected_rows;
					if ($affectedRows == 1) {
						return true;
					} else {
						return false;
					}
				$stmt->close();
				$db->close();
			} else {
				return false;
			}
		}
	}

	public function denyMatch($db, $id, $usertype)
	{
		$query = "DELETE FROM jobmatch WHERE id = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$affectedRows = $stmt->affected_rows;
		$stmt->close();

		if ($affectedRows == 1) {
			if ($usertype == 'jobseeker') {
				header("location: ../view/jobseeker_match.php?success=successdeny");
			} else {
				header("location: ../view/employer_post.php?success=successdeny");
			}
		} else {
			if ($usertype == 'jobseeker') {
				header("location: ../view/jobseeker_match.php?error=errordeny");
			} else {
				header("location: ../view/employer_post.php?error=errordeny");
			}
		}
	}
}
