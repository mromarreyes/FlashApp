<?php

require_once(LIB_PATH.DS.'database.php');
require_once(LIB_PATH.DS.'hash.php');
require_once(LIB_PATH.DS.'session.php');

class User {


	public function login($user="", $pass="") {
		global $database;
		global $hash;
		global $session;

		$sql = "SELECT userid, email, password, locationid, usertypeid FROM users WHERE email=:user LIMIT 1";
		$array = array(':user' => $user);
		$database->query($sql, $array);

		$count = $database->rowCount();
		if($count > 0) {
			//Username exists

			$data = $database->fetch_array();

			$userid = $data['userid'];
			$email = $data['email'];
			$locationid = $data['locationid'];
			$usertypeid = $data['usertypeid'];

			$password = $data['password'];

			$valid = $hash->isValid($pass, $password);

			if($valid) {
				//Passwords match

				$arr = array(
				'success' => true,
				'userid' => $userid,
				'usertypeid' => $usertypeid,
				'email' => $email,
				'locationid' => $locationid
				);

				//Setting userid session id
				$session->login($userid, $usertypeid, $user, $firstname, $lastname);

				//Checking if userid already exists. If so then update else insert
				$sql = "SELECT loginid FROM loginhistory WHERE userid=:userid";
				$array = array(':userid' => $userid);
				$database->query($sql, $array);
				$data = $database->fetch_array();
				$loginid = $data['loginid'];
				$ip = $_SERVER['REMOTE_ADDR'];
      			$session = session_id();

				if($database->rowCount() > 0) {
					//userid exists
					$sql = "UPDATE loginhistory SET usertypeid=:usertypeid, ip=:ip, phpsessionid=:phpsessionid, logindate=NOW() WHERE loginid=:loginid";
					$array = array(':usertypeid' => $usertypeid, ':ip' => $ip, ':phpsessionid' => $session, ':loginid' => $loginid);
					$database->query($sql, $array);
				} else {
					//userid doesn't exist
					$sql = "INSERT INTO loginhistory (userid, usertypeid, ip, phpsessionid, logindate) VALUES (:userid, :usertypeid, :ip, :phpsessionid, NOW())";
					$array = array(':userid' => $userid, ':usertypeid' => $usertypeid, ':ip' => $ip, ':phpsessionid' => $session);
					$database->query($sql, $array);
				}

				return json_encode($arr);
			} else {
				//Passwords do not match

				$arr = array(
				'success' => false,
				'message' => 'Username or password do not match',
				);

				return json_encode($arr);
			}

		} else {
			//Username does not exist 

			$arr = array(
			'success' => false,
			'message' => 'Username or password do not match',
			);

			return json_encode($arr);
		}
	}

	public function logout() {
		global $session;

		$session->logout();
		redirect_to('../../../client_portal.php');
	}

	public function register($user, $pass, $pass2) {
		global $database;
		global $hash;

		//check if user exists
		$sql = "SELECT email FROM users WHERE email=:email";

		$array = array(':email' => $user);
		$database->query($sql, $array);

		$count = $database->rowCount();

		if($count > 0) {
			$arr = array(
				'success' => false,
				'user' => $user,
				'message' => 'Email already exists'
			);

			return json_encode($arr);
		} else {
			if($pass == $pass2) {
				$sql = "INSERT INTO users (email, password) VALUES (:email, :pass)";
				$array = array(
					':email' => $user, 
					':pass' => $hash->hash($pass)
					);
				$database->query($sql, $array);

				$arr = array(
					'success' => true,
					'userid' => $database->lastInsertedID(),
					'message' => 'Register successful'
				);

				return json_encode($arr);
			} else {
				$arr = array(
					'success' => false,
					'message' => 'Passwords do not match'
				);

				return json_encode($arr);
			}
		}
	}

	
}

$user = new User();

?>