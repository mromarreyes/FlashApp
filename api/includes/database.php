<?php
require_once(LIB_PATH.DS."config.php");

class Database {
	public $last_query;

	//Database Handle
	private $dbh;
	//Statement Handle
	private $sth;


	function __construct() {
		$this->open_connection();
	}

	public function open_connection() {
		try {
			$this->dbh = new PDO(DATABASE.":host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS);
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function close_connection() {
		$this->dbh = null;
	}

	/*public function query($sql) {
		$this->last_query = $sql;
		$this->sth = $this->dbh->query($sql);
		$this->confirm_query($this->sth);

		return $this->sth;
	}*/


	private function confirm_query($result) {
		if(!$this->sth) {
			$output = "Database query failed: " . $this->dbh->errorInfo() . "<br/><br/>";
			$output .= "Last SQL query: " . $this->last_query;

			die(output);
		}
	}

	public function insertSuccessful() {
		if(!$this->sth) 
			return false;
		else 
			return true;
	}

	public function fetch_array() {
		$this->sth->setFetchMode(PDO::FETCH_ASSOC);
		if($this->sth->rowCount() > 1)
			return $this->sth->fetchAll();
		else
			return $this->sth->fetch();
	}

	public function jsonFetch() {
		$this->sth->setFetchMode(PDO::FETCH_ASSOC);
		return $this->sth->fetchAll();
	}

	public function getDBH() {
		return $this->dbh;
	}

	public function getSTH() {
		return $this->sth;
	}

	public function query($sql, $dataArray) {
		$this->sth = $this->dbh->prepare($sql);
		$this->sth->execute($dataArray);
	}

	//Returns the auto incremented id of the last inserted row by that connection
	public function lastInsertedID() {
		return $this->dbh->lastInsertId();
	}

	//Returns an integer indicating the number of rows affected by an operation
	public function rowCount() {
		return $this->sth->rowCount();
	}
}

//$database variable will be used by other php files
$database = new Database();

/*
Queries I tend to use a lot. 

Reset primary key:
SELECT pg_catalog.setval(pg_get_serial_sequence('lang', 'langid'), (SELECT MAX(langid) FROM lang));

Delete range:
delete from page_elements_detail where pedid >= 32 and pedid <= 35;
*/

?>