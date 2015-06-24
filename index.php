<?php
session_start();
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

if(isset($_SESSION['tripName'])){
	$tripName=$_SESSION['tripName'];
	$name=$_SESSION['name'];
	$startDate=$_SESSION['startDate'];
	$endDate=$_SESSION['endDate'];
}

$memberID=$_SESSION['memberID'];
include("includes/config.php");
require("includes/database.Class.php");
$db = Database::getInstance();
$mysqli = $db->getConnection();
$title = "Travel Itinerary Generator";
$home = "selected";
require("includes/header.php");
require("includes/navbar.php");

?>
<div id="messageContainer">
	<div id="message"></div>
</div>
<div class="container">	

	<div id="formFields">
		<div id="formInfo">
			<label for="tripName">
			<div class="labelText">Trip Name</div>
			<input type="text" id="tripName" class="destSelect"  />
		</label>

		<label for="destCity">
			<div class="labelText">City</div>
			<select id="destCity" class="destSelect" >
			<?php
				$result = $mysqli->query("SELECT * FROM Cities");
				while($array = mysqli_fetch_array($result)){
					echo "<option value=".$array['cityID']." >".$array['name']."</option>";
				}
			?>
			</select>
		</label>
		<label for="startDate">
			<div class="labelText">Start</div>
			<input type="date" id="startDate" class="destSelect" />
		</label>
		<label for="endDate">
			<div class="labelText">End</div>
			<input type="date" id="endDate" class="destSelect" />
		</label>
		</div>
		<?php 
		if($user->is_logged_in() == true){
			echo "<div id=\"formSubmit\" class=\"btn\">Submit</div>";
		}else{
			echo "<div id=\"formSubmitNotLoggedin\" class=\"btn\">Submit</div>";		
		}
		?>

	</div>

	<div id="dropdownMenu">
		<div id="dropDownBtns">
			<div class="btn" id="generateItinBtn">Create</div>
			<div class="btn" id="dropdownBackBtn">Back</div>
		</div>
		<div class="dropdown" data-cat="dinning">
			Dining
		</div>
		<div class="dropdown" data-cat="entertainment"> 
			Entertainment
		</div>
		<div class="dropdown" data-cat="events"> 
			Events
		</div>
		<div class="dropdown" data-cat="outdoors"> 
			Outdoors
		</div>
		<div class="dropdown" data-cat="museums"> 
			Museums and Art
		</div>
		<div id="list">
		</div>
		<div id="desc">
		</div>
	 </div>
	 <div id="slideShow"></div>
</div>
<script> var controls = new controls() </script>
<?php
require("includes/footer.php");
?>

