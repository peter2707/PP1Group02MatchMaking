<?php
class MatchmakingModel {

	public function postNewJob($db, $position, $field, $salary, $type, $description, $requirements, $location, $username, $contact) {
		$query = "INSERT INTO jobpost (position, field, salary, type, description, requirements, location, employer, contact) VALUES ('$position', '$field', '$salary', '$type', '$description', '$requirements', '$location', '$username', '$contact')";
		mysqli_query($db, $query) or die(mysqli_error($db));
		$db->close();
		return true;
	}

	public function getJobPostsByField($db, $field) {
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

	public function getJobPostsByEmployer($db, $username) {
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

	public function getJobPostByID($db, $jobID) {
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

	public function countJobPosts($db, $employer) {
		$result = $db->query("SELECT COUNT(*) as totalPosts FROM jobpost WHERE employer='$employer'");
		$row = $result->fetch_assoc();
		$countJobPosts = $row['totalPosts'];
		return $countJobPosts;
	}

	public function countJobMatches($db, $jobID) {
		$result = $db->query("SELECT COUNT(*) as totalmatches FROM jobmatch WHERE jobPostID='$jobID'");
		$row = $result->fetch_assoc();
		$countJobMatches = $row['totalmatches'];
		return $countJobMatches;
	}

	public function updatePost($db, $position, $field, $salary, $type, $description, $requirements, $location, $contact, $id) {
		$success = false;
		$query = "UPDATE jobpost SET position=?, field=?, salary=?, type=?, description=?, requirements=?, location=?, contact=? WHERE id=?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("ssssssssi", $position, $field, $salary, $type, $description, $requirements, $location, $contact, $id);
		$stmt->execute();

		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		if ($affectedRows == 1) {
			$success = true;
		}
		return $success;
	}

	public function deletePost($db, $id) {
		$success = false;
		$query = "DELETE FROM jobpost WHERE id = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$affectedRows = $stmt->affected_rows;
		$stmt->close();

		if ($affectedRows == 1) {
			$this->deleteMatchByPostID($db, $id);
			$success = true;
		}
		$db->close();
		return $success;
	}

	public function deletePostByEmployer($db, $employer) {
		$success = false;
		$query = "DELETE FROM jobpost WHERE employer = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("s", $employer);
		$stmt->execute();
		$affectedRows = $stmt->affected_rows;
		$stmt->close();

		if ($affectedRows == 1) {
			$this->deleteMatchByUsername($db, $employer, "employer");
			$success = true;
		}
		return $success;
	}

	public function getJobMatch($db, $user) {
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

	public function getJobMatchbyPostID($db, $postID, $employer) {
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

	public function getJobMatchByID($db, $jobID) {
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

		return $jobMatch;
	}

	public function getDate($db, $table, $id) {
		$result = $db->query("SELECT date FROM $table WHERE id = '$id'");
		$row = $result->fetch_assoc();
		$date = $row['date'];
		return $date;
	}

	public function getEmployerRating($db, $employer) {
		$rating = 0.0;
		$result = $db->query("SELECT rating FROM employer WHERE username='$employer'");
		$row = $result->fetch_assoc();
		if (isset($row['rating'])) {
			$rating = $row['rating'];
		}
		return $rating;
	}

	public function getPreviousMatch($db, $jobseeker, $jobID) {
		$query = "SELECT count(*) FROM jobmatch WHERE jobSeeker = '$jobseeker' AND jobPostID = '$jobID'";
		$stmt = $db->prepare($query);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();

		if (!$result) {
			return false;
		}
		$row = $result->fetch_row();
		if ($row[0] > 0) {
			return true;
		}
	}

	public function setJobMatch($db, $employer, $jobseeker, $jobPostID, $percentage) {
		$query = "INSERT INTO jobmatch (employer, jobseeker, jobPostID, percentage) VALUES ('$employer', '$jobseeker', '$jobPostID', '$percentage')";
		mysqli_query($db, $query) or die(mysqli_error($db));
		$this->sendFoundMatchEmail($db, $jobseeker, "jobseeker");
		$this->sendFoundMatchEmail($db, $employer, "employer");
	}

	public function findMatch($db, $position, $salary, $location, $type, $field, $jobseeker) {
		$found = false;
		$jobposts = array();
		$jobposts = $this->getJobPostsByField($db, $field);
		$position = strtolower($position);
		foreach ($jobposts as $post => $val) {
			if (preg_match('/\b' . $position . '\b/', strtolower($val->position)) && $val->salary == $salary && $val->location == $location && $val->type == $type) {
				if (!$this->getPreviousMatch($db, $jobseeker, $val->id)) {
					$this->setJobMatch($db, $val->employer, $jobseeker, $val->id, 100);
					unset($jobposts[$post]);
					$found = true;
				}
			} elseif (
				preg_match('/\b' . $position . '\b/', strtolower($val->position)) && $val->salary == $salary && $val->location == $location
				|| preg_match('/\b' . $position . '\b/', strtolower($val->position)) && $val->salary == $salary && $val->type == $type
				|| preg_match('/\b' . $position . '\b/', strtolower($val->position)) && $val->location == $location && $val->type == $type
			) {
				if (!$this->getPreviousMatch($db, $jobseeker, $val->id)) {
					$this->setJobMatch($db, $val->employer, $jobseeker, $val->id, 75);
					unset($jobposts[$post]);
					$found = true;
				}
			} elseif (
				preg_match('/\b' . $position . '\b/', strtolower($val->position)) && $val->salary == $salary
				|| preg_match('/\b' . $position . '\b/', strtolower($val->position)) && $val->location == $location
				|| preg_match('/\b' . $position . '\b/', strtolower($val->position)) && $location && $val->type == $type
			) {
				if (!$this->getPreviousMatch($db, $jobseeker, $val->id)) {
					$this->setJobMatch($db, $val->employer, $jobseeker, $val->id, 50);
					unset($jobposts[$post]);
					$found = true;
				}
			} elseif (preg_match('/\b' . $position . '\b/', strtolower($val->position))) {
				if (!$this->getPreviousMatch($db, $jobseeker, $val->id)) {
					$this->setJobMatch($db, $val->employer, $jobseeker, $val->id, 25);
					unset($jobposts[$post]);
					$found = true;
				}
			}
		}
		return $found;
	}

	public function deleteMatchByUsername($db, $username) {
		$query = "DELETE FROM jobmatch WHERE employer = ? OR jobSeeker = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("ss", $username, $username);
		$stmt->execute();
		$stmt->close();
	}

	public function deleteMatchByPostID($db, $id) {
		$query = "DELETE FROM jobmatch WHERE jobPostID = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->close();
	}

	public function denyMatch($db, $id) {
		$success = false;
		$query = "DELETE FROM jobmatch WHERE id = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$affectedRows = $stmt->affected_rows;
		$stmt->close();

		if ($affectedRows == 1) {
			$success = true;
		}
		return $success;
	}

	public function addFeedback($db, $rating, $feedback, $id) {
		$success = false;
		$query = "UPDATE jobmatch SET rating=?, feedback=? WHERE id=?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("isi", $rating, $feedback, $id);
		$stmt->execute();
		$affectedRows = $stmt->affected_rows;
		$stmt->close();

		if ($affectedRows == 1) {
			$newRating = $this->calculateRating($db);
			$jobmatch = $this->getJobMatchByID($db, $id);
			if ($this->updateEmployerRating($db, $jobmatch->employer, $newRating)) {
				$success = true;
			}
		}
		return $success;
	}

	public function updateEmployerRating($db, $employer, $rating) {
		$success = false;
		$query = "UPDATE employer SET rating=? WHERE username=?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("is", $rating, $employer);
		$stmt->execute();
		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		$db->close();

		if ($affectedRows == 1) {
			$success = true;
		}
		return $success;
	}

	public function calculateRating($db) {
		$onestar = 0;
		$twostar = 0;
		$threestar = 0;
		$fourstar = 0;
		$fivestar = 0;
		$query = "SELECT * FROM jobmatch";
		$result = $db->query($query);
		$numResults = $result->num_rows;

		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			if ($row['rating'] == "1") {
				$onestar++;
			} elseif ($row['rating'] == "2") {
				$twostar++;
			} elseif ($row['rating'] == "3") {
				$threestar++;
			} elseif ($row['rating'] == "4") {
				$fourstar++;
			} elseif ($row['rating'] == "5") {
				$fivestar++;
			}
		}
		$result->free();
		return ($fivestar * 5 + $fourstar * 4 + $threestar * 3 + $twostar * 2 + $onestar * 1) / ($fivestar + $fourstar + $threestar + $twostar + $onestar);
	}

	public function reportMatch($db, $username, $type, $id, $reason, $comment) {
		$query = "INSERT INTO report (username, type, matchID, reason, comment) VALUES ('$username', '$type', '$id', '$reason', '$comment')";
		mysqli_query($db, $query) or die(mysqli_error($db));
		$db->close();
		return true;
	}

	public function sendFoundMatchEmail($db, $username, $type) {
		require_once('../vendor/autoload.php');
		$query = "SELECT * FROM $type WHERE username = ?";
		$stmtEmp = $db->prepare($query);
		$stmtEmp->bind_param("s", $username);
		$stmtEmp->execute();
		$result = $stmtEmp->get_result();
		$stmtEmp->close();
		$row = $result->fetch_assoc();

		if ($row) {
			try {
				$email = filter_var($row['email'], FILTER_SANITIZE_EMAIL);
				$mail = new \SendGrid\Mail\Mail();
				$mail->setFrom("jobmatchdemo@gmail.com", "JobMatch");
				$mail->addTo(
					$email,
					$row['firstName'] . ' ' . $row['lastName'],
					[
						'username' => $row['username'],
						'support' => 'https://jobmatchdemo.herokuapp.com/view/index.php#contact',
						'link' => 'https://jobmatchdemo.herokuapp.com/view/login.php'
					],
				);
				$mail->setTemplateId("d-2098ec8ca08741b295d46f8e404c8baa");
				$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/environment');
				$dotenv->load();
				$sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
				try {
					$sendgrid->send($mail);
				} catch (Exception $e) {
					echo 'Caught exception: ' . $e->getMessage() . "\n";
				}
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}

	function getTimeElapsed($date, $tense = 'ago') {
		if ($this->is_localhost()) {
			date_default_timezone_set('Australia/Melbourne');
			$date = new DateTime($date);
		} else {
			$date = new DateTime($date, new DateTimeZone('UTC'));
			$date->setTimezone(new DateTimeZone("Australia/Sydney"));
		}

		// declaring periods as static function var for future use
		static $periods = array('year', 'month', 'day', 'hour', 'minute', 'second');

		// getting diff between now and time
		$now  = new DateTime('now');
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
		if (!$value) {
			$period = 'seconds';
			$value  = 0;
		} else {
			// converting days to weeks
			if ($period == 'day' && $value >= 7) {
				$period = 'week';
				$value  = floor($value / 7);
			}
			// adding 's' to period for human readability
			if ($value > 1) {
				$period .= 's';
			}
		}
		return "$value $period $tense";
	}

	function is_localhost() {
		$whitelist = array('127.0.0.1', '::1');
		if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {	// check if the server is in the array
			return true;	// this is a local environment
		}
	}
}
