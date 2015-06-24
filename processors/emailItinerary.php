<?php
/*
emailitinerary.php
*/
session_start();
if(!isset($_SESSION['memberID'])){
  header("Location: ../login.php");
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
require("../includes/database.Class.php");
$db = Database::getInstance();
$mysqli = $db->getConnection();

$tripID = $_POST['tripID'];
$memberID = $_SESSION['memberID'];

$query = "SELECT * FROM members WHERE memberID = '".$memberID."'";
//echo json_encode($query." \n");
$result = $mysqli->query($query);
$memberArray = mysqli_fetch_array($result);

$query = "SELECT * FROM User_Trips WHERE tripID = '".$tripID."'";
$result = $mysqli->query($query);
//echo json_encode($query." \n");
$tripInfo = mysqli_fetch_array($result);
$tripName = $tripInfo['tripName'];
$city = $tripInfo['destCity'];
$startDate = $tripInfo['startDate'];
$endDate = $tripInfo['endDate'];

$query = "SELECT * FROM SavedTrips S, Location L WHERE L.locID = S.locID AND tripID = '".$tripID."' GROUP BY L.locID ORDER BY itemDate, startTime";
$result = $mysqli->query($query);
//echo json_encode($query." \n");

$username = $memberArray['username'];
$email = $memberArray['email'];
$subject = "Your Trip Itinerary for TripName: ".$tripName;

//echo json_encode($subject.", memberID is: ".$memberID.", tripID is: ".$tripID.", ");

$email_msg = "<div style=\"text-align:center; font-weight:bold; font-size:20px\">".$memberArray['username']."
			, thank you for using the Travel Assitance and Advising Planner. Here is your trip itinerary!</div><p>
			<table border=\"1px\" align=\"center\" width=\"400px\">";
			$sorted_array = array();

			while($tripDetails = mysqli_fetch_array($result)){
				array_push($sorted_array, $tripDetails);
			}

			$sepDate = $sorted_array[0]['itemDate'];
			$email_msg.="<tr><th colspan=\"2\" font-size=\"24px\"> ".date("l", strtotime($sepDate))." ".$sepDate."</th></tr><tr><th width=\"100px\">Time</th><th width=\"300px\">Location Name</th></tr>";
			for($i=0; $i < sizeof($sorted_array); $i++){ 
				//Check if it is a new day
				if ($sepDate != $sorted_array[$i]['itemDate']){
					$email_msg.="</table>";
					$email_msg.="</p><p>";
					$sepDate = $sorted_array[$i]['itemDate'];	
					$email_msg.="<table border=\"1px\" align=\"center\" width=\"400px\">";
					$email_msg.="<tr><th colspan=\"2\" font-size=\"24px\"> ".date("l", strtotime($sepDate)).", ".$sepDate."</th></tr>
					<tr><th width=\"100px\">Time</th><th width=\"300px\">Location Name</th></tr>";
				}
				//display each item. if the time is 4 digits (800) the add the leading '0' or the .date function will error
				if(strlen($sorted_array[$i]['startTime'])<4){
					$email_msg.="<tr><td>".date("g:i a", strtotime("0".$sorted_array[$i]['startTime']))."</td><td> ".$sorted_array[$i]['name']."</td></tr>";
				}else{
					$email_msg.="<tr><td>".date("g:i a", strtotime($sorted_array[$i]['startTime']))."</td><td> ".$sorted_array[$i]['name']."</td></tr>";
				}
			}
			$email_msg.="</table></p>";

		//content-type
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: <travelplanner@rkclose.com>' . "\r\n";
		$headers .= 'Cc: rob0229@gmail.com' . "\r\n";
		mail($email, $subject, $email_msg, $headers);
?>