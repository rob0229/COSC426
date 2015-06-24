<?php
session_start();
require("../includes/database.Class.php");
$db = Database::getInstance();
$mysqli = $db->getConnection();

$tripname = $_POST['tripname'];

$getUserIdQuery = "SELECT tripID FROM User_Trips WHERE memberID = '".$_SESSION['memberID']."' AND tripName='".$tripname."' ";
echo $getUserIdQuery."\n";
$result = $mysqli->query($getUserIdQuery);
$array = mysqli_fetch_array($result);
$tripID = $array['tripID'];

$query = "DELETE FROM User_Trips WHERE tripID='".$tripID."'";
$result = $mysqli->query($query);

	if($result != ""){
		$query2 = "DELETE FROM SavedTrips Where tripID ='".$tripID."'";
		$result = $mysqli->query($query2);
		echo $query . " ***,*** ".$query2 ;
	}
	else{
		echo "0";
	}

?>