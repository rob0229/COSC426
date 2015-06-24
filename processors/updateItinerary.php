<?php
require("../includes/database.Class.php");
if(!isset($_SESSION['user_id'])){
  header("Location: ../login.php");
}
$db = Database::getInstance();
$mysqli = $db->getConnection();

$tripID=$_POST['tripID'];
$locID=$_POST['locID'];
$date = $_POST['date'];
$time = $_POST['time'];


//echo "tripID: ".$tripID.", locID: ".$locID.", date: ".$date.", time: ".$time;

$query = "UPDATE SavedTrips SET startTime='$time', itemDate='$date' WHERE tripID='$tripID' AND locID='$locID'";
$result = $mysqli->query($query);
echo $result;

?>