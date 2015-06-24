<?
/*----------------------------------------------------*/
//	Programmer: Team "The Other Team" COSC 426 -SU
//	Date:		January 28th 2015
//	Description: 	Database Class for connecting to
//					our mySQL DB
/*----------------------------------------------------*/
class database {

	private $_connection;
	private static $_instance; //The single instance
	private $_host = "localhost";
	private $_username = "rkclosec_team";
	private $_password = "TheOtherTeam425!!";
	private $_database = "rkclosec_TravelPlanner";
 
	/*
	Get an instance of the Database
	@return Instance
	*/
	public static function getInstance() {
		// If no instance then make one
		if(!self::$_instance) 
		{ 
			self::$_instance = new self();
		}
		return self::$_instance;
	}
 
	// Constructor
	private function __construct() {
		$this->_connection = new mysqli($this->_host, $this->_username, $this->_password, $this->_database);
		// Error handling
		if(mysqli_connect_error()) {
			trigger_error("Failed to conencto to MySQL: " . mysqli_connect_error(), E_USER_ERROR);
		}
	}
 
	// Magic method clone is empty to prevent duplication of connection
	private function __clone() { }
 
	// Get mysqli connection
	public function getConnection() {
		return $this->_connection;
	}

}
