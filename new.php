<?php
session_start();
$memberID=$_SESSION['memberID'];
//get database connection
require("includes/database.Class.php");
$db = Database::getInstance();
$mysqli = $db->getConnection();

$tripname = $_POST['tripname'];

/*
echo $memberID;

if(isset($_POST['loadbtn'])){

	$result = $mysqli->query("SELECT * FROM User_Trips WHERE tripname='$tripname' ");
	$result1 = $mysqli->query("SELECT * FROM SavedTrips ");
	$result2 = $mysqli->query("SELECT SavedTrips.tripID, User_Trips.tripname, SavedTrips.locID, SavedTrips.startTime, SavedTrips.endTime, SavedTrips.itemDate 
											  FROM SavedTrips, User_Trips 
											  WHERE SavedTrips.tripID = User_Trips.tripID AND User_Trips.memberID = '$memberID' ");
	$memberID = $array['memberID'];
	//$tripID = $array['tripID'];
	$tripname = $array['tripname'];
	$startDate = $array['startDate '];
	$endDate = $array['endDate '];
	
	//$tripID = $array['tripID'];
	$locID = $array['locID'];
	$startDate = $array['startTime'];
	$endDate = $array['endTime '];
	$itemDate = $array['ItemDate'];
	

	  if ($result->num_rows > 0) {
			 echo "<table><tr><th>Member ID</th><th>Trip ID</th><th>Trip Name</th><th>Start Date</th><th>End Date</th></tr>";
			 // output data of each row
			 while($row = $result->fetch_assoc()) {
						 echo "<tr><td>" . $row["memberID"]. "</td><td>" . $row["tripID"]. " </td><td>" . $row["tripname"]. "</td><td>" . $row["startDate"]. "</td><td>" . $row["endDate"]. "</td></tr>";
					 }		
						echo "</table>";
		} else {echo "<table><tr><th>Member ID</th><th>Trip ID</th><th>Trip Name</th><th>Start Date</th><th>End Date</th></tr>";}
		
		
		 
	if ($result1->num_rows > 0) {
							echo "<table><tr><th>Location ID</th><th>Trip ID</th><th>StartTime</th><th>EndTime</th><th>itemDate</th></tr>";
							// output data of each row
							while($row = $result1->fetch_assoc()) {
							echo "<tr><td>" . $row["locID"]. "</td><td>" . $row["tripID"]. " </td><td>" . $row["startTime"]. "</td><td>" . $row["endTime"]. "</td><td>" . $row["itemDate"]. "</td></tr>";
							}
					 echo "</table>";
					} else {echo "<table><tr><th>Location ID</th><th>Trip ID</th><th>StartTime</th><th>EndTime</th><th>ItemDate</th></tr>";}
					
					
					
			if ($result2->num_rows > 0) {
							echo "<table><tr><th>TripID</th><th>Trip Name</th><th>StartTime</th><th>EndTime</th><th>ItemDate</th></tr>";
							// output data of each row
							while($row = $result2->fetch_assoc()) {
							echo "<tr><td>" . $row["tripID"]. "</td><td>" . $row["tripname"]. " </td><td>" . $row["startTime"]. "</td><td>" . $row["endTime"]. "</td><td>" . $row["itemDate"]. "</td></tr>";
							}
					 echo "</table>";
					} else {echo "<table><tr><th>TripID</th><th>Trip Name</th><th>StartTime</th><th>EndTime</th><th>ItemDate</th></tr>";}
					
}
	
*/
?>
<html>
<head>
 <style>
#loadtripWrapper{
    width:400px;
    background-color:#F0F0F0;
}

.btn {
	padding: 2px 4px;
	background: grey;
	border: 1px solid black;
	border-radius: 2px;
	width: 100px;
	text-align: center;
}

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>
<body>
<div id="loadtripWrapper">
    <div id="loadForm">
		  Trip Name:<input type="text" id="tripname" name="tripname"  style="width: 200px; height:30px; border:1px solid #333;" required ><br>
	  <br><br>
	  <div class="btn" id="btnbutton">Load Trip</div>
 </div>
 <div id="tripInfo"></div>
  
</div>

	<script>
		$(document).ready(function(){
			$("#btnbutton").on("click",function(){
				$.post("processors/retrievetrip.php", {
				tripname: $("#tripname").val()
				}, function(e){
					$("#tripInfo").html(e);
					console.log(e);
				});
			})
		
		});
	
	</script>
</body>
</html>
