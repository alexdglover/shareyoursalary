<?php

define("OPENSHIFT_DB", "shareyoursalary");

class Database{

	function __construct(){
		$this->get_db_connection();
	}

	function get_db_connection() {
		$host = $_ENV["OPENSHIFT_MONGODB_DB_HOST"];
		$user = $_ENV["OPENSHIFT_MONGODB_DB_USERNAME"];
		$passwd = $_ENV["OPENSHIFT_MONGODB_DB_PASSWORD"];
		$port = $_ENV["OPENSHIFT_MONGODB_DB_PORT"];
		$uri = "mongodb://" . $user . ":" . $passwd . "@" . $host . ":" . $port;
		$mongo = new MongoClient($uri);
		return $mongo;
	}
	
	function get_database($dbname) {
		$conn = $this->get_db_connection();
		return $conn->$dbname;
	}
	
	function get_collection($collection) {
		$db = $this->get_database(OPENSHIFT_DB);
		return $db->$collection;
	}
	
}

?>
