<?php
ob_start();
session_start();
//set timezone
date_default_timezone_set('America/New_York');
//database credentials
define('DBHOST','localhost');
define('DBUSER','rkclosec_team');
define('DBPASS','TheOtherTeam425!!');
define('DBNAME','rkclosec_TravelPlanner');
//application address
define('DIR','http://rkclose.com/');
define('SITEEMAIL','noreply@rkclose.com');
try {
	//create PDO connection 
	$db = new PDO("mysql:host=".DBHOST.";port=8889;dbname=".DBNAME, DBUSER, DBPASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	//show error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}
//include the user class, pass in the database connection
include('includes/user.php');
$user = new User($db); 
?>