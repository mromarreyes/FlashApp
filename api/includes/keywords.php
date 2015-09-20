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

	public function getKeywords($userid, $usertypeid) {
		global $database;

		$sql = "SELECT keyword FROM keywords WHERE userid = :userid";
		$database->query($sql, array(':userid' => $userid));
		$keyword = $database->fetch_array();

		$mykeywords = array();
		foreach($keyword as $id) {
		    array_push($mykeywords, $id['keyword']);
		}

		if($usertypeid == 1) {//Look for job
			//Get all job id's
			/*$sql = "SELECT keyword FROM keywords WHERE jobid = 5";
			$database->query($sql, null);
			$keyword = $database->fetch_array();

			$keywordArray = array();
			foreach($keyword as $id) {
			    array_push($keywordArray, $id['keyword']);
			}

			$array = array('success' => true,
				'jobs' => array('jobid' => 5, 'keywords' => $keywordArray),
				'mykeywords' => $mykeywords);
			return json_encode($array);*/

			$sql = "SELECT j.jobid, j.name, j.phone, k.keyword FROM jobs j, keywords k WHERE j.userid = 1 AND k.jobid = j.jobid";
			$database->query($sql, null);
			$data = $database->fetch_array();

			$array = array('success' => true,
				'mykeywords' => $mykeywords,
				'jobs' => $data);

			return json_encode($array);

		} else {//Look for users
			$sql = "SELECT keyword FROM keywords WHERE userid = 3";

			$database->query($sql, null);
			$keyword = $database->fetch_array();

			$keywordArray = array();
			foreach($keyword as $id) {
			    array_push($keywordArray, $id['keyword']);
			}

			$array = array('success' => true,
				'users' => array('userid' => 3, 'keywords' => $keywordArray)/*,
				'mykeywords' => $mykeywords*/);
			return json_encode($array);
		}
	}
	
	
}

$Keywords = new Keywords();

?>