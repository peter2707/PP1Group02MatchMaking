<?php
	class MatchmakingModel{

		public function getJobPost($db){
			require_once '../model/user_object.php';
			$jobposts = array();

			$query = "SELECT * FROM jobpost";
			$result = $db->query($query);
			$numResults = $result->num_rows;

			for($i = 0; $i <$numResults; $i++) {
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

		public function compareMatchmakingParams(){

		}

	
	}
?>