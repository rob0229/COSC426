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
//STEP 0 Query the database and select all the items from the $item array and group according to priority//									//
///////////////////////////////////////////////////////////////////////////////////////////////////////////

for($i = 0; $i<count($items); $i++ ){
	//get the info for all the locations
	$result = $mysqli->query("SELECT * FROM Location WHERE locID = ". $items[$i] );
	$array=mysqli_fetch_array($result);
	//echo "priority is ". $array['priority'] ;
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

//check for all items in priority 1 array
//for ($i=0; $i<count($priority1); $i++)
//{
	//create array for number of days per item
//	$numDaysEvent=explode("*", $priority1[$i][7]);
	
	//determine days for current item
//	$lowest=count($numDaysEvent);
	
	//compare to rest of items in priority 1 array
//	for ($z=$i+1; $z<count($priority1); $z++)
//	{
		//create array for number of days for all other items
//		$tempNumDays=explode("*", $priority1[$z][7]);
		
		//compare to the initial item, if the new item has less or equal days..
//		if ((count($tempNumDays)) <= $initLowest)
//		{
		
			//lowest days is now the for the item of the current index of z
//			$lowest=count($tempNumDays);
			//the item at the index of z now has the lowest days
//			$tempLowestItem=$priority1[$z];
//		}
		
//	}
	
	//after comparing initial item to all other items by number of days, if the lowest item is different than the first..
//	if ($priority1[$i] != $tempLowestItem)
//	{
			//assign the original item to temporary variable
//			$tempItem=$priority1[$i];
			//put lowest item in the index of i
//			$priority1[$i]=$priority1[$z];
			//move the original item into the index of z (swap the two items)
//			$priority1[$z]=$tempItem;
			
//	}	
//}

//for ($i=0; $i<count($priority2); $i++)
//{
//}

//for ($i=0; $i<count($priority3); $i++)
//{
//}

//for ($i=0; $i<count($priority4); $i++)
//{
//}

//**********
//**************************
//************************************************************^^^^^^^^^^^^^^^^^^^^^^^^^^^

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Iterate through each Priority 1 item and look for slots in the $tripDays array to schedule them. 									  //
	//If no slot is found return an error message and exit. 																			  //
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	for($row=0; $row < count($priority1); $row++){
		
		//this index is where the item will be scheduled
		$insertIndex;
		$foundHole = false;
		//gets the average time to schedule from the database
		$holeSize=$priority1[$row][12];
		//parse the date and time strings from the database 
	 	$times = explode("*", $priority1[$row][7]);
		$startTime = $times[0];
		$endTime = $times[1];
		//convert the times to indexes for the $dayTrips array
		$startIndex = ($startTime - "0800")/"100";
		$endIndex =  ($endTime - "0800")/"100";
		$itemLength = $endIndex - $startIndex;
		//creates an array populated with each date the item has in the database. 
		$dates = explode("*", $priority1[$row][8]);
		//Variable to allow the algorithm the flexability to shrink the size of the hole needed
		$adjustedHoleSize = $holeSize;
		
		//Var to store the intersection of item days with the trip days
		$overlapIndexes = array();



		$overlapIndexes = getOverlapIndexes($dates, $startDate, $endDate, $tripLength);
//echo "\n overlap: ".$overlapIndexes[0]."\n";
		//Var to determine which days in the overlapdDates have the least number of slots used in the $tripsArray 
		$daysLeastToGreatest = array();
		//echo "\n".$tripDays[0][0].", ".$tripDays[0][1].", ".$tripDays[0][2]."\n";
		$daysLeastToGreatest = getDaysLeastToGreatest($tripDays, $overlapIndexes);
		
		//echo "\n".$daysLeastToGreatest[0].", ".$daysLeastToGreatest[1].", ".$daysLeastToGreatest[3]."\n";
		$daysLeastToGreatestIter;

		//Check each day to find a hole the adjustedHoleSize until the adjustedHoleSize is to small or a hole is found
		while($foundHole == false && $adjustedHoleSize == $holeSize){
			//echo " adjustedHoleSize: $adjustedHoleSize, ";
			//start from the begining of the trip days in order of most slots to least
			$daysLeastToGreatestIter = 0;
			//check each day times for a hole big enough for adjustedHoleSize
			while($foundHole != true && ($daysLeastToGreatestIter != $tripLength - 1)){
				//echo " daysLeastToGreatest[$daysLeastToGreatestIter]: ". $daysLeastToGreatest[$daysLeastToGreatestIter].", ";
				//look for a hole in the given $daysLeastToGreatest[$daysLeastToGreatestIter] day.
				$insertIndex = findSlot($tripDays, $daysLeastToGreatest[$daysLeastToGreatestIter], $itemLength, $startIndex, $endIndex);
				//echo "PRI 1 item:". $priority1[$row][0].", dayIndex is: $daysLeastToGreatest[$daysLeastToGreatestIter],  insertTimeIndex: $insertIndex, itemLength is $itemLength, startIndex: $startIndex, endIndex: $endIndex,  ";
				//If a hole was found on that day, exit loops, else check the next day.
				if($insertIndex != -1){
					$foundHole = true;
				}
				else{
					$daysLeastToGreatestIter++;
				}
			}
			//check if a hole was found for the given adjustedHoleSize, if not, reduce by 1 slot
			if($foundHole == false){
				$adjustedHoleSize --;
			}
		}

		if($insertIndex == -1){
			echo json_encode(array(-1," No hole for priority1: " .$priority1[$row][2]));
	 		exit;
		}else{
			//convert the tripDay index into an actual date for the itinerary
			$itemScheduledDate = convertDate($startDate , $daysLeastToGreatest[$daysLeastToGreatestIter]); 

			//convert the insertIndex into a time 
			$itemStartTime = $insertIndex * "0100" + "0800";
			$itemEndTime = $itemStartTime + ($adjustedHoleSize*"0100");
			
			$newItem = array("locID" => $priority1[$row][0], "startTime" => $itemStartTime,"endTime" => $itemEndTime,"itemDate" => $itemScheduledDate);
			array_push($itinerary, $newItem);
			//Update the timeSlot tracker Array
			for($i = 0; $i < $itemLength; $i++){
				//Insert the number 2 to represent a priority 2 item is scheduled here
				$tripDays[$daysLeastToGreatest[$daysLeastToGreatestIter]][$insertIndex + $i] = 1;
			}
		}
	}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//STEP 2 Add Priority 2 items to the itinerary array.																							 //
//	Priority 2 itmes have set start and end times, limited date range and an average time people stay there, such as "The Good Beer Festival".   //
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Iterate through each Priority 2 item and look for slots in the $tripDays array to schedule them. 									  //
	//If no slot is found return an error message and exit																  //
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	for($row=0; $row < count($priority2); $row++){

		//this index is where the item will be scheduled
		$insertIndex;
		$foundHole = false;
		//gets the average time to schedule from the database
		$holeSize=$priority2[$row][12];
		//parse the date and time strings from the database 
	 	$times = explode("*", $priority2[$row][7]);
		$startTime = $times[0];
		$endTime = $times[1];
		//convert the times to indexes for the $dayTrips array
		$startIndex = ($startTime - "0800")/"100";
		$endIndex =  ($endTime - "0800")/"100";
		//creates an array populated with each date the item has in the database. 
		$dates = explode("*", $priority2[$row][8]);
		//Variable to allow the algorithm the flexability to shrink the size of the hole needed
		$adjustedHoleSize = $holeSize;
		
		//Var to store the intersection of item days with the trip days
		$overlapIndexes = array();
		$overlapIndexes = getOverlapIndexes($dates, $startDate, $endDate, $tripLength);
		$daysLeastToGreatest=array();

		$daysLeastToGreatest = getDaysLeastToGreatest($tripDays, $overlapIndexes);
		$daysLeastToGreatestIter;

		//Check each day to find a hole the adjustedHoleSize until the adjustedHoleSize is to small or a hole is found
		while($foundHole == false && $adjustedHoleSize > ($holeSize * .65)){

			//echo " adjustedHoleSize: $adjustedHoleSize, ";
			//start from the begining of the trip days in order of most slots to least
			$daysLeastToGreatestIter = 0;
			//check each day times for a hole big enough for adjustedHoleSize

			while($foundHole != true && ($daysLeastToGreatestIter != $tripLength - 1)){

				$insertIndex = findSlot($tripDays, $daysLeastToGreatest[$daysLeastToGreatestIter], $holeSize, $startIndex, $endIndex);
			//	echo "PRI 2 item:". $priority2[$row][0].", dayIndex is: $daysLeastToGreatest[$daysLeastToGreatestIter],  insertTimeIndex: $insertIndex, holeSize is $holeSize, startIndex: $startIndex, endIndex: $endIndex,  ";
				//echo " insertTimeIndex: $insertIndex, dayIndex is: $daysLeastToGreatest[$daysLeastToGreatestIter], ";
				//If a hole was found on that day, exit loops, else check the next day.
				if($insertIndex != -1){
					$foundHole = true;
				}
				else{
					$daysLeastToGreatestIter++;
				}
			}
			//check if a hole was found for the given adjustedHoleSize, if not, reduce by 1 slot
			if($foundHole == false){
				$adjustedHoleSize --;
			}

		}

		if($insertIndex == -1){
			echo json_encode(array(-1," No hole for priority2: " .$priority2[$row][2]));
	 		exit;
		}else{
			//convert the tripDay index into an actual date for the itinerary
			$itemScheduledDate = convertDate($startDate , $daysLeastToGreatest[$daysLeastToGreatestIter]); 

			//convert the insertIndex into a time 
			$itemStartTime = $insertIndex * "100" + "0800";
			$itemEndTime = $itemStartTime + ($adjustedHoleSize*"100");
			
			$newItem = array("locID" => $priority2[$row][0], "startTime" => $itemStartTime,"endTime" => $itemEndTime,"itemDate" => $itemScheduledDate);
			array_push($itinerary, $newItem);
			//echo " insertTimeIndex: $insertIndex, dayIndex is: $daysLeastToGreatest[$daysLeastToGreatestIter], ";
			//Update the timeSlot tracker Array
			for($i = 0; $i < $adjustedHoleSize; $i++){
				//Insert the number 2 to represent a priority 2 item is scheduled here
				$tripDays[$daysLeastToGreatest[$daysLeastToGreatestIter]][$insertIndex + $i] = 2;
			}
		}
	}

// ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// //STEP 3 (Add Priority3 item specific time constraint items ex. certain venues are open daily but have a "best time" option)//
// ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// 	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 	//Iterate through each Priority 2 item and look for slots in the $tripDays array to schedule them. 									  //
// 	//If no slot is found return an error message and exit																  //
// 	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

for($row=0; $row < count($priority3); $row++){
	//echo " item ".$priority3[$row][0].", ";
		//this index is where the item will be scheduled
		$insertIndex;
		$foundHole = false;
		//gets the average time to schedule from the database
		$holeSize=$priority3[$row][12];
		//parse the date and time strings from the database 
	 	$times = explode("*", $priority3[$row][7]);
		$startTime = $times[0];
		$endTime = $times[1];
		//convert the times to indexes for the $dayTrips array
		$startIndex = ($startTime - "0800")/"100";
		$endIndex =  ($endTime - "0800")/"100";
		//creates an array populated with each date the item has in the database. 
		$dates = explode("*", $priority3[$row][8]);
		//Variable to allow the algorithm the flexability to shrink the size of the hole needed
		$adjustedHoleSize = $holeSize;
		
		//Var to store the intersection of item days with the trip days
		$overlapIndexes = array();
		$overlapIndexes = getOverlapIndexes($dates, $startDate, $endDate, $tripLength);

		//Var to determine which days in the overlapdDates have the least number of slots used in the $tripsArray 
		$daysLeastToGreatest = array();

		$daysLeastToGreatest = getDaysLeastToGreatest($tripDays, $overlapIndexes);
		$daysLeastToGreatestIter;

		//Check each day to find a hole the adjustedHoleSize until the adjustedHoleSize is to small or a hole is found
		while($foundHole == false && $adjustedHoleSize > ($holeSize * .65)){
			//echo " adjustedHoleSize: $adjustedHoleSize, ";
			//start from the begining of the trip days in order of most slots to least
			$daysLeastToGreatestIter = 0;
			//check each day times for a hole big enough for adjustedHoleSize
			while($foundHole != true && ($daysLeastToGreatestIter != $tripLength - 1)){
				//echo " daysLeastToGreatest[$daysLeastToGreatestIter]: ". $daysLeastToGreatest[$daysLeastToGreatestIter].", ";
				//look for a hole in the given $daysLeastToGreatest[$daysLeastToGreatestIter] day.
				$insertIndex = findSlot($tripDays, $daysLeastToGreatest[$daysLeastToGreatestIter], $holeSize, $startIndex, $endIndex);
				//echo "PRI 3 item:". $priority3[$row][0].", dayIndex is: $daysLeastToGreatest[$daysLeastToGreatestIter],  insertTimeIndex: $insertIndex, itemLength is $itemLength, startIndex: $startIndex, endIndex: $endIndex,  ";
				//If a hole was found on that day, exit loops, else check the next day.
				if($insertIndex != -1){
					$foundHole = true;
				}
				else{
					$daysLeastToGreatestIter++;
				}
			}
			//check if a hole was found for the given adjustedHoleSize, if not, reduce by 1 slot
			if($foundHole == false){
				$adjustedHoleSize --;
			}

		}

		if($insertIndex == -1){
			echo json_encode(array(-1," No hole for priority3: " .$priority3[$row][2]));
	 		exit;
		}else{
			//convert the tripDay index into an actual date for the itinerary
			$itemScheduledDate = convertDate($startDate , $daysLeastToGreatest[$daysLeastToGreatestIter]); 

			//convert the insertIndex into a time 
			$itemStartTime = $insertIndex * "100" + "0800";
			$itemEndTime = $itemStartTime + ($adjustedHoleSize*"100");
			
			$newItem = array("locID" => $priority3[$row][0], "startTime" => $itemStartTime,"endTime" => $itemEndTime,"itemDate" => $itemScheduledDate);
			array_push($itinerary, $newItem);

			//Update the timeSlot tracker Array
			for($i = 0; $i < $adjustedHoleSize; $i++){
				//Insert the number 2 to represent a priority 2 item is scheduled here
				$tripDays[$daysLeastToGreatest[$daysLeastToGreatestIter]][$insertIndex + $i] = 3;
			}
		}
	}

// ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// //STEP 4 (Add Priority4 category specific time constraint items ex. restaurants should be scheduled during certain times of the day)//
// ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// 	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 	//Iterate through each Priority 2 item and look for slots in the $tripDays array to schedule them. 									  //
// 	//If no slot is found return an error message and exit																  //
// 	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
for($row=0; $row < count($priority4); $row++){
		//this index is where the item will be scheduled
		$insertIndex;
		$foundHole = false;
		//gets the average time to schedule from the database
		$holeSize=$priority4[$row][12];
		//parse the date and time strings from the database 
	 	$times = explode("*", $priority4[$row][7]);
		$startTime = $times[0];
		$endTime = $times[1];
		//convert the times to indexes for the $dayTrips array
		$startIndex = ($startTime - "0800")/"100";
		$endIndex =  ($endTime - "0800")/"100";
		//creates an array populated with each date the item has in the database. 
		$dates = explode("*", $priority4[$row][8]);
		//Variable to allow the algorithm the flexability to shrink the size of the hole needed
		$adjustedHoleSize = $holeSize;
		
		//Var to store the intersection of item days with the trip days
		$overlapIndexes = array();
		$overlapIndexes = getOverlapIndexes($dates, $startDate, $endDate, $tripLength);

		//Var to determine which days in the overlapdDates have the least number of slots used in the $tripsArray 
		$daysLeastToGreatest = array();

		$daysLeastToGreatest = getDaysLeastToGreatest($tripDays, $overlapIndexes);
		$daysLeastToGreatestIter;

		//Check each day to find a hole the adjustedHoleSize until the adjustedHoleSize is to small or a hole is found
		while($foundHole == false && $adjustedHoleSize > ($holeSize * .65)){
			//echo " adjustedHoleSize: $adjustedHoleSize, ";
			//start from the begining of the trip days in order of most slots to least
			$daysLeastToGreatestIter = 0;
			//check each day times for a hole big enough for adjustedHoleSize
			while($foundHole != true && ($daysLeastToGreatestIter != $tripLength - 1)){
				//echo " daysLeastToGreatest[$daysLeastToGreatestIter]: ". $daysLeastToGreatest[$daysLeastToGreatestIter].", ";
				//look for a hole in the given $daysLeastToGreatest[$daysLeastToGreatestIter] day.
				$insertIndex = findSlot($tripDays, $daysLeastToGreatest[$daysLeastToGreatestIter], $holeSize, $startIndex, $endIndex);
			//	echo "PRI 4 item:". $priority4[$row][0].", dayIndex is: $daysLeastToGreatest[$daysLeastToGreatestIter],  insertTimeIndex: $insertIndex, itemLength is $itemLength, startIndex: $startIndex, endIndex: $endIndex,  ";
				//If a hole was found on that day, exit loops, else check the next day.
				if($insertIndex != -1){
					$foundHole = true;
				}
				else{
					$daysLeastToGreatestIter++;
				}
			}
			//check if a hole was found for the given adjustedHoleSize, if not, reduce by 1 slot
			if($foundHole == false){
				$adjustedHoleSize --;
			}

		}

		if($insertIndex == -1){
			echo json_encode(array(-1," No hole for priority4: " .$priority4[$row][2]));
	 		exit;
		}else{
			//convert the tripDay index into an actual date for the itinerary
			$itemScheduledDate = convertDate($startDate , $daysLeastToGreatest[$daysLeastToGreatestIter]); 

			//convert the insertIndex into a time 
			$itemStartTime = $insertIndex * "100" + "0800";
			$itemEndTime = $itemStartTime + ($adjustedHoleSize*"100");
			
			$newItem = array("locID" => $priority4[$row][0], "startTime" => $itemStartTime,"endTime" => $itemEndTime,"itemDate" => $itemScheduledDate);
			array_push($itinerary, $newItem);

			//Update the timeSlot tracker Array
			for($i = 0; $i < $adjustedHoleSize; $i++){
				//Insert the number 2 to represent a priority 2 item is scheduled here
				$tripDays[$daysLeastToGreatest[$daysLeastToGreatestIter]][$insertIndex + $i] = 4;
			}
		}
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//STEP 6
//Return the trip id
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//If it gets to here the $itinerary has no conflicts and can be added to the User_Trip and Saved_Trips Tables.

	//Step 1
	//Add a new row in the User_Trips Table and get the auto-incremented tripID for use later
	$result = $mysqli->query("INSERT INTO User_Trips(memberID, tripName, startDate, endDate, destCity) VALUES( '".$_SESSION['memberID']."', '" .$tripName."', '".$startDate."', '".$endDate."', '".$destCity."')"); 
	//echo "INSERT INTO User_Trips(memberID, tripName, startDate, endDate, destCity) VALUES( '".$_SESSION['memberID']."', '" .$tripName."', '".$startDate."', '".$endDate."', '".$destCity."')";
	$tripID = $mysqli->insert_id;

	//inserts a row in the table for each item in the itinerary
	for($i = 0; $i<count($itinerary); $i++){
		$result = $mysqli->query("INSERT INTO SavedTrips(tripID, locID, startTime, endTime, itemDate) Values('$tripID', '".$itinerary[$i]["locID"]."', '".$itinerary[$i]["startTime"]."', '".$itinerary[$i]["endTime"]."', '".$itinerary[$i]["itemDate"]."')");	
 	}

 	//display the results test code
	// for ($h=0; $h<count($tripDays); $h++){
	// 	for ($c=0; $c<16; $c++){
	// 		if($tripDays[$h][$c]!=0){
	// 			echo " [$h][$c]: ".$tripDays[$h][$c]. ", ";
	// 		}
	// 	}
	// }


	//If all went well, the new trip should have been added to the tables and a new entry in the User_Trips table was created and not deleted.
	echo json_encode($tripID); 

		//Returns the slot index where a hole is found to schedule the item on the given dayIndex. 
		function findSlot($tripDaysArray, $dayIndex, $holeSize, $startIndex, $endIndex){
			$index = $startIndex;
			$count = 0;

			while($index <= $endIndex && $count < $holeSize){
				
				if($tripDaysArray[$dayIndex][$index] != 0){
					$count = 0; 
					$index ++;
				}else if($tripDaysArray[$dayIndex][$index] == 0){
					$count++;
					$index++;
				}
			}
			if($count >= $holeSize){
				return ($index - $count);
			}else{
				return -1;
			}
		}

		//Returns the length of the trip based on the user date range selection
		function getTripLength($startDate, $endDate){
			$adate;
			$bdate;
			//gets the length of the trip. Does not work if the trip spans into a new month!!!!!!!!!!!!
			$a = explode("-", $startDate);
			for($i =0; $i<count($a); $i++){
				$adate = $adate.$a[$i];
			}
			$adate = intval($adate);

			$b = explode("-", $endDate);

			for($i =0; $i<count($b); $i++){
				$bdate = $bdate.$b[$i];
			}
			$bdate = intval($bdate);

			return ($bdate - $adate + 1);

		}

		//Takes a date string (2105-03-09) and returns a date object of that date
		function convertDate($startDate, $dayOfTrip){
			$a = explode("-", $startDate);
			//echo " iter is ".$iter.", a is ". $a[0]." ".$a[1]." ".$a[2].", ";
			$newDate = date('Y-m-d', mktime(0, 0, 0, $a[1], $a[2]+$dayOfTrip, $a[0]));
			//echo " NEW DATE IS: ".$newDate.", ";
			return $newDate;
		}

		//returns an array of the indexes of the input array in least to greatest order
		function getSlotWeightArray($arr){
			$toDestroy = $arr;
			$temp = array();
			while(isset($toDestroy[0])){
				$min = 0;
				for($i=0; $i<count($toDestroy); $i++){
					if($temp[$i]<$temp[$min]){
						$min = $i;
					}
				}
				array_push($temp, $min);
				unset($toDestroy[$min]);
			}
		  return $temp;
		}

		// //Returns an array with the idexes that the item overlaps the trip 
		// //Example. The item is on 2015-03-10 and 2015-03-11 but the trip start/end days are 2015-03-09 -> 2015-03-12
		// //The $dayIndex[0] will be 1 (2015-03-10 = 2nd day of trip index in array is 1) and $dayIndex[1] == 2;
		function getOverlapIndexes($dates, $startDate, $endDate, $tripLength){

//echo "\n dates: ".$dates[0].", startd: ".$startDate.", endDate: ".$endDate.", triplng: ".$tripLength."\n";

			$dayIndex = array();
			//convert string to seconds for calculations
			$end = intval(strtotime($endDate)/86400);
			$start = intval(strtotime($startDate)/86400);

			//if the item is available for all days, return an array with all indexes for the trip
			if(strcmp($dates[0], "all")==0){
				//populate the array with an index for each day in the trip because the item is available for every day.
				for($i=0; $i<$tripLength;$i++){
					$dayIndex[$i] = $i;
				}
			}
			//scan each date in the $dates parameter and push its index into the $dayIndex array if it is within out trip range. Stop scanning once we pass the last day of our trip
			else{
				$iter = 0;
				$iterDate;
				//check each date to find its index when compared to our trip days
				while($dates[$iter] != NULL && (intval(strtotime($dates[$iter])/86400)) <= $end){
					$iterDate = intval(strtotime($dates[$iter])/86400);
					//The $iterDate date is before the trip start date. Just move to the next date
					if($start > $iterDate){
						$iter++;
					}
					//find the day index of this day
					else{
						$diff = $iterDate - $start;
						array_push($dayIndex, $diff);
						$iter++;
					}
				}
			}
			//echo "\n dayIndex[0] ".$dayIndex[0]."\n";
			return $dayIndex;
		}

		//if $tripDays[0] has 4 days form 0-3 and $overlapDates are index 1 and 2, the algorithm will return an array of the overlap dates in order of most slots avaialbe to least. 
		function getDaysLeastToGreatest($tripDays, $overlapDates){

			$newArray = array();
			$newArray=$overlapDates;
			$n = count($newArray);
			$swapped = true;
			$numZerosPerSlotArray = array();

			for ($i=0;$i<$n;$i++){
				$countA = 0;
				//count the number of 0's in each day 
					for($x=0; $x<16; $x++){
						//count the number of 0's in the trips array at index $newArray[$i][$x]
						if($tripDays[$newArray[$i]][$x] == 0 || $tripDays[$newArray[$i]][$x] == "0"){
							$countA++;
						}
					}
	
				//Store the number of 0's for that day in this array
				array_push($numZerosPerSlotArray, $countA);
				//for($e=0;$e<count($numZerosPerSlotArray);$e++){
					//echo " numzerosperslotarray $e ".$numZerosPerSlotArray[$e].", \n";
				//}

			}
					
			while($swapped == true){
				$swapped = false;
				for($i=0; $i<$n-1; $i++){
					$countA = $numZerosPerSlotArray[$i];
					$countB = $numZerosPerSlotArray[$i+1]; 
					
					//$day[i+1] has more 0's so swap
					if($countA < $countB){
						//swap the order of newArray and the numZeros tracker array
						$temp = $newArray[$i];
						$newArray[$i] = $newArray[$i+1];
						$newArray[$i+1] = $temp;

						$zeroTemp=$numZerosPerSlotArray[$i];
						$numZerosPerSlotArray[$i]=$numZerosPerSlotArray[$i+1];
						$numZerosPerSlotArray[$i+1]=$zeroTemp;

						$swapped = true;
					}
				}
			}
			return $newArray;
		}

?>
