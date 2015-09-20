<?php

require_once(LIB_PATH.DS.'database.php');

class Jobs {
	public function addJob($userid, $name, $about) {
		global $database;

		$sql = "INSERT INTO aboutme SET info = :info";
		$array = array(':info' => $about);

		$database->query($sql, $array);

		if($database->rowCount() > 0) {
			$id = $database->lastInsertedID();

			$sql = "INSERT INTO jobs (userid, name, aboutid) VALUES (:userid, :name, :aboutid)";
			$array = array(':userid' => $userid,
				':name' => $name,
				':aboutid' => $id);

			$database->query($sql, $array);

			if($database->rowCount() > 0) {
				$jobid = $database->lastInsertedID();

				$array = array('success' => true,
					'jobid' => $jobid);

				return json_encode($array);
			} else {
				$array = array('success' => false,
					'message' => 'failed to add job');

				return json_encode($array);
			}
		} else {
			$array = array('success' => false,
				'message' => 'failed to add job');
			return json_encode($array);
		}
	}

	public function getJobs($userid) {
		global $database;

		$sql = "SELECT * FROM jobs  WHERE userid = :userid";
		$array = array(':userid' => $userid);

		$database->query($sql, $array);

		if($database->rowCount() > 0) {
			$data = $database->jsonFetch();

			$array = array('success' => true,
				'jobs' => $data);
			return json_encode($array);
		} else {
			$array = array('success' => false,
				'message' => 'Did not find any jobs');
			return json_encode($array);
		}
	}
	
}

$jobs = new Jobs();

?>