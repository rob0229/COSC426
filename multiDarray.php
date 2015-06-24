<?php
/*
itineraryGenerator.php
Programmer: Team "The Other Team" COSC 426
Date: February 13, 2015
Desc: This script creates an itinerary based on the users selected inputs
*/
session_start();
require("../includes/database.Class.php");
$db = Database::getInstance();
$mysqli = $db->getConnection();

$items = json_decode($_POST['items']);
$tripInfo = $_POST['tripInfo'];
$startDate = $tripInfo[0];
$endDate = $tripInfo[1];
$destCity = $tripInfo[2];
$tripName = $tripInfo[3];

$priority1=array();
$priority2=array();
$priority3=array();
$priority4=array();


//variable to hold the tripID
$tripID;
//array to hold the itinerary items
$itinerary = array();

//TODO: fix this
//gets the length of the trip. Does not work if the trip spans into a new month!!!!!!!!!!!!
$tripLength = getTripLength($startDate, $endDate);

//creates an array with 16 timeSlots with an initial value of 0 meaning it is available
$timeSlots = array(); 
$timeSlots = array_fill(0, 16, 0);

//creates and array to track the time slots of each day of the trip and fills each day with an empty 
//array with 16 timeSlots with an initial value of 0 meaning it is available
$tripDays = array_fill(0, $tripLength, array_fill(0, 16, 0));

///////////////////////////////////////////////////////////////////////////////////////////////////////////
//STEP 0 Query the database and select all the items from the $item array and group according to priority//											 //
///////////////////////////////////////////////////////////////////////////////////////////////////////////

for($i = 0; $i<count($items); $i++ ){
	//get the info for all the locations
	$result = $mysqli->query("SELECT * FROM Location WHERE locID = ". $items[$i] );
	$array=mysqli_fetch_array($result);
	echo "priority is ". $array['priority'] ;
	//add the row array to the priority array
	switch($array['priority']){
		case "1": 
			 array_push($priority1, $array);
			break;
		case "2": 
			array_push($priority2, $array);
			break;
		case "3": 
			array_push($priority3, $array);
			break;
		case "4": 
			array_push($priority4, $array);
			break;
		default:
			echo "error in priority sort";
	}
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//STEP 1: Add priority 1 items to the itinerary:      															//
//	Priority 1 items have a set start and end time, such as a concert. They may be available on multiple dates. //
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//************************************************************^^^^^^^^^^^^^^^^^^^^^^^^^
//**************************
//**********
//TODO: Sort the Priority 1 items in order of most days to least days. This will solve a logic problem with the schedule algorithm where if an item with 2 days available is scheduled and then an item with 1 day attempts to be scheduled, no hole will be found. If the item with day options is scheduled second, there will not be a conflict. We may want to do this for every Priority Level. Can we do this in the query?
//**********
//**************************
//************************************************************^^^^^^^^^^^^^^^^^^^^^^^^^^^

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Iterate through each Priority 1 item and look for slots in the $tripDays array to schedule them. 									  //
	//If no slot is found return an error message and exit. 																			  //
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>