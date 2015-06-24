
<?php
session_start();
include("includes/config.php");
require("includes/database.Class.php");
if( !($user->is_logged_in()) ){ header('Location: login.php'); } 
$db = Database::getInstance();
$mysqli = $db->getConnection();

$stdate=$_SESSION['stdate'];
$endate=$_SESSION['endate'];
$citydest=$_SESSION['citydest'];
$citiesName=$_SESSION['name'];
$memberid=$_SESSION['memberid'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta property="og:url"			content = "<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" />
	<meta property="fb:app_id"		content = "1583174165273843" />
	<meta property="og:type"		content = "place" />
	<meta property="og:title"		content = "Check out this trip!" />
	<meta property="og:description"	content = "I made this cool trip Itenerary, you should try it out!" />
	<meta property="og:image"		content="http://rkclose.com/COSC_426_Spring/css/images/day2.jpg" />
	
    <title><?php if(isset($title)){ echo $title; }?></title>
    <link rel="stylesheet" href="css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Patua+One' rel='stylesheet' type='text/css'>
	<script src="js/jquery.min.js"></script>
	<script src="js/populartrip.js"></script>
 
	<style>
	<?php
	$num = rand(0, 2);
	if(date('G') > 4 && date('G') < 18){ ?>
		body {
			background-image: url(css/images/day<?php echo $num; ?>.jpg);
			background-color: white;
		}
	<?php } else { ?>
		body {
			background-image: url(css/images/night<?php echo $num; ?>.jpg);
			background-color: black;
		}
	
	<?php }	?>
	</style>
</head>
<body>

<?php
require("includes/navbar.php");
?>
	<div id="populartrips">
	
	<div id="insidepopulartrip">
	<div>
		<br>
		<br>
		  Start Date:<input type="date" id="stdate"  style="width: 200px; height:30px; border:1px solid #333;" required >
		   <span class="error">* </span><br>
		  End Date:<input type="date" id="endate" style="width: 200px; height:30px; border:1px solid #333; margin-left:7px;"  required>
		  <span class="error">* </span><br>
		 <!-- <select id="citydest" class="destSelect" style="width: 200px; height:30px; border:1px solid #333; margin-left:81px;"  required>
		 
		  
			<?php
			
				$result = $mysqli->query("SELECT * FROM Cities");
				while($array = mysqli_fetch_array($result)){
					echo "<option value=".$array['cityID']." >".$array['name']."</option>";
	
				}
			?>
			</select><span class="error">* </span><br>--><br><br>
      </div>
      

	  
	  
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="utilities.js"></script>
</head>
<body >
 
<div id="tabs">
  <ul>
    <li><a href="#Salisbury">Salisbury</a></li>
	<li><a href="#OceanCity">Ocean City</a></li>
    <li><a href="#FruitLand">FruitLand</a></li>
  </ul>
  <div id="Salisbury">
	<div>
	<table class='puptrip1'><tr><th></th><th>Name</th><th>Description</th></tr>
		<?php
		
				$result = $mysqli->query("SELECT * FROM `preplannedtrip` WHERE `t_cityid`=1");
				
				
		
				while($array = mysqli_fetch_array($result)){
					$locIDstring = $array['items'];
					$t_id = $array["t_id"];
					//header("content-type:image/jpg");
					$pic = $array["t_pic"];
					$location = $array["t_location"];
					$t_name = $array["t_name"];
					$t_memberid=$array["memid"];
					$t_description=$array["t_description"];
					
					$locations=explode("*", $location);
					$locationsstring=implode($locations);
				
					echo "<tr class='poptriprow' id='$locationsstring' value='$t_name'><td>" ."<button class='testimageclass' id='testimageid' type='submit'><img src='data:image/jpeg;base64,".base64_encode($pic)." ' width='100px' height='100px/'></button>". "</td>
				
							<td>" . $t_name. " </td><td style=\"overflow: auto;\">" . $t_description. " </td></tr>";
						
				}	
				
		?>
	</table>
	
    </div>
	  
    </div>
  
    <div id="OceanCity">
	  <div>
	  
	  	<table class='puptrip1'><tr><th></th><th>Name</th><th>Description</th></tr>
	  <?php
				$result1 = $mysqli->query("SELECT * FROM `preplannedtrip` WHERE `t_memid`=6 AND `t_cityid`=4");
				
	
				while($array = mysqli_fetch_array($result1)){
					$locIDstring = $array['items'];
					$t_id = $array["t_id"];
					//header("content-type:image/jpg");
					$pic = $array["t_pic"];
					$location = $array["t_location"];
					$t_name = $array["t_name"];
					$t_memberid=$array["memid"];
					$t_description=$array["t_description"];
					
					$locations=explode("*", $location);
					$locationsstring=implode($locations);
				
					echo "<tr class='poptriprow' id='$locationsstring'><td>" ."<button class='testimageclass' id='testimageid' type='submit'><img src='data:image/jpeg;base64,".base64_encode($pic)." ' width='100px' height='100px/'></button>". "</td>
							<td>" . $t_name. " </td><td style=\"overflow: auto;\">" . $t_description. " </td></tr>";
				}	
		?>
			</table>
      </div>
    </div>
  <div id="FruitLand">
    <div>
	
		<table class='puptrip1'><tr><th></th><th>Name</th><th>Description</th></tr>
    	<?php
				$result2 = $mysqli->query("SELECT * FROM `preplannedtrip` WHERE `t_memid`=2 AND `t_cityid`=6");
				
				while($array = mysqli_fetch_array($result2)){
					$locIDstring = $array['items'];
					$t_id = $array["t_id"];
					//header("content-type:image/jpg");
					$pic = $array["t_pic"];
					$location = $array["t_location"];
					$t_name = $array["t_name"];
					$t_memberid=$array["memid"];
					$t_description=$array["t_description"];

					$locations=explode("*", $location);
					$locationsstring=implode($locations);
				
					echo "<tr class='poptriprow' id='$locationsstring'><td>" ."<button class='testimageclass' id='testimageid' type='submit'><img src='data:image/jpeg;base64,".base64_encode($pic)." ' width='100px' height='100px/'></button>". "</td>
							<td>" . $t_name. " </td><td style=\"overflow: auto;\">" . $t_description. " </td></tr>";
				}	
		?>
			</table>
      </div>
  </div>
</div>
</div>

</div>

 <?php
		    //require("includes/deal.php");
 ?>

 <?php
		    require("includes/footer.php");
 ?>
</body>
</html>
	  
	 
