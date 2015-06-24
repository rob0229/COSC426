<?php

require("../includes/database.Class.php");

$db = Database::getInstance();
$mysqli = $db->getConnection();
$city = $_GET['city'];
$start = $_GET['start'];
$end = $_GET['end'];
$city = 1;



/*-- Dinning --*/
$result = $mysqli->query("SELECT * from Location WHERE cityID = '$city' AND cat_id = 1 ");
echo "<div id='dinning' class='list_sub'>";
while($array = mysqli_fetch_array($result)){
	if(checkDates($array, $start, $end)==true){
		echo "<span><input type=\"checkbox\" value=".$array['locID']." />".$array['name'] ."</span>";
	}
}
echo "</div>";

/*-- Entertainment --*/
$result = $mysqli->query("SELECT * from Location WHERE cityID = '$city' AND cat_id = 2 ");
echo "<div id='entertainment' class='list_sub'>";
while($array = mysqli_fetch_array($result)){
	if(checkDates($array, $start, $end)==true){
		echo "<span><input type=\"checkbox\" value=".$array['locID']." />".$array['name'] ."</span>";
	}
}
echo "</div>";
/*-- Events --*/
$result = $mysqli->query("SELECT * from Location WHERE cityID = '$city' AND cat_id = 3 ");

echo "<div id='events' class='list_sub'>";

	while($array = mysqli_fetch_array($result)){
		if(checkDates($array, $start, $end)==true){
			echo "<span><input type=\"checkbox\" value=".$array['locID']." />".$array['name'] ."</span>";
		}
}

echo "</div>";



/*-- Outdoors --*/

$result = $mysqli->query("SELECT * from Location WHERE cityID = '$city' AND cat_id = 4 ");

echo "<div id='outdoors' class='list_sub'>";

	while($array = mysqli_fetch_array($result)){
		if(checkDates($array, $start, $end)==true){
			echo "<span><input type=\"checkbox\" value=".$array['locID']." />".$array['name'] ."</span>";
		}
}

echo "</div>";



/*-- Museums And Art --*/

$result = $mysqli->query("SELECT * from Location WHERE cityID = '$city' AND cat_id = 5 ");

echo "<div id='museums' class='list_sub'>";

	while($array = mysqli_fetch_array($result)){
		if(checkDates($array, $start, $end)==true){
			echo "<span><input type=\"checkbox\" value=".$array['locID']." />".$array['name'] ."</span>";
		}
}

echo "</div>";

function checkDates($arr, $start, $end){
	$dates = $arr['dates'];
	$dateArray = explode("*",$dates);

	$startDate = intval(strtotime($start)/86400);
	$endDate = intval(strtotime($end)/86400);

	$overlap = false;

	//check to see if location dates overlap with trip dates
	for($i=0; $i<sizeof($dateArray); $i++){
		if(strcmp($dateArray[0], "all")==0){
			$overlap=true;
		}else{
			$curr = intval(strtotime($dateArray[$i])/86400);
			
			if($curr>= $startDate && $curr <= $endDate){
				$overlap=true;
			}
		}
	}

return $overlap;

}

?>