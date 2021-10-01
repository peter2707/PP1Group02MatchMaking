<?php
class MatchmakingModel
{

	public function getJobPost($db)
	{
		require_once '../model/user_object.php';
		$jobposts = array();

		$query = "SELECT * FROM jobpost";
		$result = $db->query($query);
		$numResults = $result->num_rows;

		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$jobposts[$i] = new JobPost();
			$jobposts[$i]->salary = $row['salary'];
			$jobposts[$i]->location = $row['location'];
			$jobposts[$i]->type = $row['type'];
			$jobposts[$i]->job = $row['job'];
			$jobposts[$i]->employer = $row['employer'];
		}

		$result->free();
		

		return $jobposts;
	}

	public function setJobMatch($db, $employer, $jobseeker, $jobPost, $feedback)
	{
		$query = "INSERT INTO jobmatch (employer, jobseeker, jobPost, feedback) VALUES ('$employer', '$jobseeker', '$jobPost', '$feedback')";
		mysqli_query($db, $query);
	}

	public function getJobMatch($db, $jobseeker){
		require_once '../model/user_object.php';
		$jobposts = array();
		$query = "SELECT * FROM jobpost FULL OUTER JOIN jobmatch ON jobpost.employer=jobmatch.employer WHERE jobmatch.jobseeker = '$jobseeker'";
		$result = $db->query($query);
		$numResults = $result->num_rows;

		for ($i = 0; $i < $numResults; $i++) {
			$row = $result->fetch_assoc();
			$jobposts[$i] = new JobPost();
			$jobposts[$i]->salary = $row['salary'];
			$jobposts[$i]->location = $row['location'];
			$jobposts[$i]->type = $row['type'];
			$jobposts[$i]->job = $row['job'];
			$jobposts[$i]->employer = $row['employer'];
		}

		$result->free();
		$db->close();

		return $jobposts;
	}
}
