<?php
session_start();
include("includes/config.php");
require("includes/database.Class.php");
$db = Database::getInstance();
$mysqli = $db->getConnection();
if( !($user->is_logged_in()) ){ header('Location: login.php'); } 
if(isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp


//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); } 
$memberID = $_SESSION['memberID'];

$query = "SELECT * FROM members WHERE memberID = '$memberID'";
$result = $mysqli->query($query);
$memberinfo = mysqli_fetch_array($result);

if(isset($_POST['userInfo_Update']) && $_POST['accountUpdateName']!="" && $_POST['accountUpdateEmail']!=""){
	$query = "UPDATE members set username = '".$_POST['accountUpdateName']."', email='".$_POST['accountUpdateEmail']."' WHERE memberID='$memberID'";
	$result = $mysqli->query($query);
	if($result){
		$query = "SELECT * FROM members WHERE memberID = '$memberID'";
		$result = $mysqli->query($query);
		$memberinfo = mysqli_fetch_array($result);
		$message = "Account Updated";
	}
}

require("includes/header.php");
require("includes/navbar.php");
?>

<div class="container userUpdate">	
	<h1>Update Account</h1>
	<form role="form" method="POST" action="" id="updateUser">
		<div>Username<input type="text" name="accountUpdateName" <?php echo "value=".$memberinfo['username']?> /></div>
		<div>Email<input type="text" name="accountUpdateEmail" <?php echo "value=".$memberinfo['email']?> /></div>
		<input type="submit" name="userInfo_Update" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;background-color: black; color: white;" value="Update">
	</form>
	<div class="savedTrips">
		<h2>Saved Trips</h2>
		<ul>
			<?php 
			$result = $mysqli->query("SELECT * FROM User_Trips WHERE memberID =".$_SESSION['memberID']);
				while($array = mysqli_fetch_array($result)){
					echo "<li><input type=\"submit\" value=\"Delete\" class=\"btn userInfoDelete btn-primary btn-block btn-lg\" id=\"".$array['tripName']."\" ><span class='name'>".$array['tripName']."</span></li>";
				}
			?>
		</ul>	
	</div>
</div>

<script> var controls = new controls() </script>
<?php
require("includes/footer.php");
?>
