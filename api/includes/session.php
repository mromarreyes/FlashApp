<?php 
//A class to help with Sessions
//In our case, primarily to manage logging users in and out

class Session {
	private $logged_in = false;
	public $user_id;

	function __construct() {
		ini_set( 'session.cookie_httponly', 1 );//session is not accessible by javascript
		session_start();
	}

	public function regenerateID() {
		session_regenerate_id();
		//Update session id on database
	}

	//
	public function check() {
		//Check with database's sessionid and ip	
		global $database;
		$sql = "SELECT ip, phpsessionid FROM loginhistory WHERE userid=:userid";

		if(isset($_SESSION['userid']))
			$userid = $_SESSION['userid'];
		else
			$userid = null;

		$data = array(':userid' => $userid);
		$database->query($sql, $data);
		$fetch = $database->fetch_array();

		if($database->rowCount() > 0 && $fetch['phpsessionid'] === session_id()) {
			return true;
		} else {
			$this->logout();
			return false;
		}
	}

	public function isAdmin($usertypeid) {
		if($usertypeid == 1)
			return true; 
		else {
			$this->logout();
			return false;
		}

	}

	public function slimCheck() {
		$checkSlim = function() {
		    if(!$this->check()) {
		        redirect_to('../../../client_portal.php');
		    }
		};

		return $checkSlim;
	}

	public function login($userid, $usertypeid, $user, $firstname, $lastname) {
		$_SESSION['userid'] = $userid;
		$_SESSION['usertypeid'] = $usertypeid;
		$_SESSION['username'] = $user;
		$_SESSION['firstname'] = $firstname;
		$_SESSION['lastname'] = $lastname;
		
		$this->logged_in = true;
	}

	public function is_logged_in() {
		return $this->logged_in;
	}

	public function logout($user="") {
		//unset all $_SESSION data
		$_SESSION = array();
		//expire the session cookie
		if(ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(	session_name(), '',
				time() - 3600,
				$params["path"],
				$params["domain"],
				$params["secure"],
				$params["httponly"]
			);
		}

		unset($_SESSION['userid']);

		//destroy session
		session_destroy();

		$this->logged_in = false;
	}
}

$session = new Session();

?>