<?php

require_once(LIB_PATH.DS.'database.php');

class Location {

	public function getLocation($locationid) {
		global $database;

		$sql = "SELECT * FROM locations WHERE locationid = :locationid";
		$array = array(':locationid' => $locationid);

		$database->query($sql, $array);

		if($database->rowCount() > 0) {
			$data = $database->jsonFetch();

			$array = array('success' => true,
				'location' => $data);

			return json_encode($array);
		} else {
			$array = array('success' => false,
				'message' => 'location not found');

			return json_encode($array); 
		}
	}

	public function addLocation($userid, $address, $latitude, $longitude) {
		global $database;

		$sql = "INSERT INTO locations (address, latitude, longitude) VALUES(:address, :latitude, :longitude)";
		$array = array(':address' => $address,
			':latitude' => $latitude,
			':longitude' => $longitude);

		$database->query($sql, $array);

		if($database->rowCount() > 0) {
			$id = $database->lastInsertedID();

			$sql = "UPDATE users SET locationid = :locationid WHERE userid = :userid";
			$array = array(':locationid' => $id,
				':userid' => $userid);

			$database->query($sql, $array);

			if($database->rowCount() > 0) {
				$array = array('success' => true,
					'message' => 'Added location successfully');
				return json_encode($array);
			} else {
				$array = array('success' => false,
					'message' => 'Failed to add location');
				return json_encode($array);
			}
		}
	}

	
}

$location = new Location();

?>