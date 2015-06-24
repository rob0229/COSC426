<!-- 
saveItinerary.php
Programmer: Team "The Other Team" COSC 426
Date: February 13, 2015
Desc: This script ctakes a json object containing the itinerary and stores it in the database table "SavedItineraries"


-->



<?php
session_start();
require("includes/database.Class.php");
$db = Database::getInstance();
$mysqli = $db->getConnection();

$itinerary = json_decode($_POST['items']);

//STEP 1 parse array 

//STEP 2 insert items into the savedItineraries table under the same tripID




?>