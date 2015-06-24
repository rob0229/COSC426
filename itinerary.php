<?php

// <!-- 
// itinerary.php
// Programmer: Team "The Other Team" COSC 426 -SU
// Date: January 28th 2015
// Desc: Generated itinerary and map page
// -->

// <script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
// <script src="http://maps.googleapis.com/maps/api/js?key=####################&sensor=false" type="text/javascript"></script>

// <script src="http://google-maps-utility-library-v3.googlecode.com/svn/tags/markerwithlabel/1.1.9/src/markerwithlabel.js" type="text/javascript"></script>
// <script src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobubble/src/infobubble.js" type="text/javascript"></script>
session_start();

if(isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

$memberID=$_SESSION['memberID'];
require("includes/database.Class.php");
$db = Database::getInstance();
$mysqli = $db->getConnection();

$trips = "selected";
$i = 0;
require("includes/header.php");
require("includes/navbar.php");

$result = $mysqli->query("SELECT * FROM SavedTrips WHERE tripID='". $_GET['tripID'] ."' ORDER BY startTime ASC;");

while($array = mysqli_fetch_array($result)){
	$day = $array['itemDate'] ." ". date("l", strtotime($array['itemDate'])); 
	$results = $mysqli->query("SELECT * from Location WHERE locID='". $array['locID'] ."'");
	$loc = mysqli_fetch_array($results);
	
	if($array['startTime'] > 999){
		$hour = substr($array['startTime'], 0, 2);
		$min = substr($array['startTime'], 2, 2);
		$period = "am";
		if($hour >= 13){
			$period = "pm";
			$hour -= 12;
		} else if($hour == 12){
			$period = "pm";
		}
	} else {
		$hour = substr($array['startTime'], 0, 1);
		$min = substr($array['startTime'], 1, 2);
		$period = "am";
	}
	
	$location[$i] = array(
		"day" => strtotime($array['itemDate']),
		"html" => '<div class="point"><div class="time">'. $hour .':'. $min . $period .'</div><span class="loc" data-loc="' .$loc['locID'] .'" >'. $loc["name"] .'</span></div>'
	);
	$i++;
}

$day = array(
	$location[0]["day"] => array( 0 => $location[0]["html"])
);

for($i = 1; $i < count($location); $i++){
	if(isset($day[$location[$i]["day"]])) {
		array_push($day[$location[$i]["day"]], $location[$i]["html"]);
	} else {
		$day[$location[$i]["day"]] = array(0 => $location[$i]["html"]);
	}
}

ksort($day);

?>
<div id="loading"><div id="spinning"></div></div>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1583174165273843&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="container">
	<div id="itineraryBtn">
		<?php foreach($day as $key => $date){ ?>
			<div class="dropdown day" data-day="<?php echo date("m\/d", $key); ?>">
				<?php echo date("m\/d\/Y", $key) ."<br/>". date("l", $key); ?>
			</div>
		<?php } ?>
	</div>
	
	<?php foreach($day as $key => $date){ ?>
		<div class="timeline" data-day="<?php echo date("m\/d", $key); ?>">
			<div id="itinerary">
				<div class="btn editItinerary" style="float: none">Edit</div>
				<?php
					echo date("m\/d", $key) ." ". date("l", $key);
					foreach($date as $specific){
						echo $specific;
					}
				?>
			</div>	 
		</div>
	<?php } ?>
	<div id="map-canvas"></div>	
	<div style="float: right;" class="fb-share-button" data-href="http://rkclose.com/COSC_426_Spring/itinerary.php?tripID=<?php echo $_GET['tripID']; ?>" data-layout="button_count"></div>
	<div id="emailItineraryBtn" class="btn">Email</div>
</div>


<script> var itinerary = new itinerary() </script>


<?php
require("includes/footer.php");
?>

