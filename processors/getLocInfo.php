<?php

require("../includes/database.Class.php");



$db = Database::getInstance();

$mysqli = $db->getConnection();

$loc = $_GET['loc'];

$result = $mysqli->query("SELECT * from Location WHERE locID='$loc' ");

$loc = mysqli_fetch_array($result);

$hours = explode("*", $loc['hours']);

for($i = 0; $i < count($hours); $i++){

	if(substr($hours[$i], 0, 1) == "0"){

		$hours[$i] = substr($hours[$i], 1, 1) .":". substr($hours[$i], 2) ."am";

	} else if($hours[$i] < 1200){

		$hours[$i] = substr($hours[$i], 0, 2) .":". substr($hours[$i], 2) ."am";

	} else if($hours[$i] < 1300){

		$hours[$i] = substr($hours[$i], 0, 2) .":". substr($hours[$i], 2) ."pm";

	}

	

	if($hours[$i] >= 1300){

		$hours[$i] = $hours[$i] - 1200;

		if($hours[$i] < 1000){

			$hours[$i] = substr($hours[$i], 0, 1) .":". substr($hours[$i], 1) ."pm";

		} else if($hours[$i] <= 1200){

			$hours[$i] = substr($hours[$i], 0, 2) .":". substr($hours[$i], 2) ."pm";

		}

	}

}



$days = "<span class='locDay'>Sunday:</span>". $hours[0] ."-". $hours[1] ."<br/>

			<span class='locDay'>Monday:</span>". $hours[2] ."-". $hours[3] ."<br/>

			<span class='locDay'>Tuesday:</span>". $hours[4] ."-". $hours[5] ."<br/>

			<span class='locDay'>Wednesday:</span>". $hours[6] ."-". $hours[7] ."<br/>

			<span class='locDay'>Thursday:</span>". $hours[8] ."-". $hours[9] ."<br/>

			<span class='locDay'>Friday:</span>". $hours[10] ."-". $hours[11] ."<br/>

			<span class='locDay'>Saturday:</span>". $hours[12] ."-". $hours[13] ."<br/>";

echo '<div id="descImg" style="background-image: url(images/'. $loc['locID'] .'.jpg)" /></div>

		<span id="locName">'. $loc['name'] .'</span>

		<span id="locAddress">'. $loc['address'] .'</span>

		<span id="locPhone">'. $loc['phone'] .'</span>

		<span id="locHours">'. $days .'</span>

		<span id="locDesc">'. $loc['Description'] .'</span>';



?>