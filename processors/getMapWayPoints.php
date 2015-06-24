<?php
session_start();
require("../includes/database.Class.php");
$db = Database::getInstance();
$mysqli = $db->getConnection();
$tripID = $_POST['tripID'];
$date = $_POST['date'];

$coordinates = array();
$d = explode("/", $date);
$date = "2015-".$d[0]."-".$d[1];
//get all the trip items for the selected trip from the saved table
$result = $mysqli->query("SELECT * FROM SavedTrips WHERE tripID = '$tripID' AND itemDate LIKE '$date'");
//echo "SELECT * FROM SavedTrips WHERE tripID = '$tripID' AND itemDate LIKE '$date'";
//add the items lat/long coordinates to the coordinate array
while($array = mysqli_fetch_array($result)){
	$results = $mysqli->query("SELECT name, lat, lng FROM Location WHERE locID = ".$array['locID']);
	
	$points = mysqli_fetch_array($results);
	array_push($coordinates, $points[0], $points[1], $points[2]);
}

//encode and return the points
echo json_encode($coordinates)

?>
