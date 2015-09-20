<?php

require_once(LIB_PATH.DS.'database.php');

class Keywords {

	public function addUserKeyword($userid, $keyword) {
		global $database;

		$sql = "INSERT INTO keywords (userid, keyword) VALUES(:userid, :keyword)";
		$array = array(':userid' => $userid,
			':keyword' => $keyword);

		$database->query($sql, $array);

		if($database->rowCount() > 0) {

			$array = array('success' => true,
				'message' => 'Added keyword successfully for user');

			return json_encode($array);
		} else {
			$array = array('success' => false,
				'message' => 'Failed to add keyword for user');

			return json_encode($array);
		}
	}

	public function addJobKeyword($jobid, $keyword) {
		global $database;

		$sql = "INSERT INTO keywords (jobid, keyword) VALUES(:jobid, :keyword)";
		$array = array(':jobid' => $jobid,
			':keyword' => $keyword);

		$database->query($sql, $array);

		if($database->rowCount() > 0) {

			$array = array('success' => true,
				'message' => 'Added keyword successfully for job');

			return json_encode($array);
		} else {
			$array = array('success' => false,
				'message' => 'Failed to add keyword for job');

			return json_encode($array);
		}
	}

	public function getUserKeywords($userid) {
		global $database;

		$sql = "SELECT * FROM keywords WHERE userid = :userid";
		$array = array(':userid' => $userid);

		$database->query($sql, $array);

		if($database->rowCount() > 0) {
			$data = $database->jsonFetch();

			$array = array('success' => true,
				'keywords' => $data);

			return json_encode($array);
		} else {
			$array = array('success' => false,
				'message' => 'Did not find any keywords for this user');

			return json_encode($array);
		}

	}

	public function getJobKeywords($jobid) {
		global $database;

		$sql = "SELECT * FROM keywords WHERE jobid = :jobid";
		$array = array(':jobid' => $jobid);

		$database->query($sql, $array);

		if($database->rowCount() > 0) {
			$data = $database->jsonFetch();

			$array = array('success' => true,
				'keywords' => $data);

			return json_encode($array);
		} else {
			$array = array('success' => false,
				'message' => 'Did not find any keywords for this job');

			return json_encode($array);
		}
	}
	
	
}

$Keywords = new Keywords();

?>