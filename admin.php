<?php
//get database connection
include("includes/config.php");
require("includes/database.Class.php");
if( !($user->is_logged_in()) ){ header('Location: login.php'); } 
$db = Database::getInstance();
$mysqli = $db->getConnection();

//Category Variables
$cat_id = $_POST['cat_id'];
$cat_name = $_POST['cat_name'];
// define erro variables and set to empty values
$cat_idErro = $cat_namErro= "";


//Cities Variables
$cityID = $_POST['cityID'];
$cityname = $_POST['cityname'];
$lat = $_POST['lat'];
$long = $_POST['long'];
//define erro variable and set to empty values
$cityIDErro = "";


//Location Variables
$locID = $_POST['locID'];
//already exist in category table
$name = $_POST['name'];
$cityid= $_POST['cityID'];
$address = $_POST['address'];
$phone= $_POST['phone'];
$website = $_POST['website'];
$hours = $_POST['hours'];
$dates= $_POST['dates'];
$lats = $_POST['lat'];
$lng = $_POST['lng'];
$priority= $_POST['priority'];
$avgtime=$_POST['avgtime'];
//define erro variable and set to empty values
$locIDErro ="";

//Member Variables
$memberID = $_POST['memberID'];
$username = $_POST['username'];
$password= $_POST['password'];
$email = $_POST['email'];
$active = $_POST['active'];
$resetToken = $_POST['resetToken'];
$resetComplete = $_POST['resetComplete'];
// define erro variable and set to empty values
$memberIDErro ="";

//savedtrips Variables
$tripID = $_POST['tripID'];
$locID = $_POST['locID'];
$startTime= $_POST['startTime'];
$endTime= $_POST['endTime'];
$startDate =$_POST['startDate'];
$endDate =$_POST['endDate'];
//define erro variables and set to empty values
$tripIDErro = $locIDErro="";

//user_trips Variables
$memberID = $_POST['memberID'];
$tripID= $_POST['tripID'];
$tripName = $_POST['tripName'];
// define erro variable and set to empty values
$memberIDErro ="";



//////////////////////////////////////////////
//Category Table Functions
//////////////////////////////////////////////
//Retrieve Function
if(isset($_POST['cat_Retrieve'])){
    if (empty($_POST["cat_id"])) {
    $cat_idErro = "Category Id is Required";
  } else {
	$result = $mysqli->query("SELECT * FROM Category WHERE cat_id = $cat_id");
	$array = mysqli_fetch_array($result);
	$cat_id = $array['cat_id'];
	$cat_name = $array['category_name'];
}

}
//Insert
if(isset($_POST['cat_Insert'])){
	$result = $mysqli->query("INSERT INTO `Category`(`cat_id`, `category_name`) VALUES ($cat_id,'$cat_name')");
	$array = mysqli_fetch_array($result);
	$cat_id = $array['cat_id'];
	$cat_name = $array['category_name'];
}
//Update
if(isset($_POST['cat_Update'])){
	$result = $mysqli->query("UPDATE `Category` SET `cat_id`='$cat_id',`category_name`='$cat_name' WHERE `cat_id`=$cat_id");
	$array = mysqli_fetch_array($result);
	$cat_id = $array['cat_id'];
	$cat_name = $array['category_name'];

}
//Delete
if(isset($_POST['cat_Delete'])){
	$result = $mysqli->query("DELETE FROM `Category` WHERE `cat_id`='$cat_id'");
	$array = mysqli_fetch_array($result);
	$cat_id = $array['cat_id'];
	$cat_name = $array['category_name'];

}


//////////////////////////////////////////////
//Cities Table Functions
//////////////////////////////////////////////
//Retrieve Function
if(isset($_POST['cit_Retrieve'])){
 if (empty($_POST["cityID"])) {
    $cityIDErro = "City Id is Required";
  } else {
	$result = $mysqli->query("SELECT * FROM `Cities` WHERE `cityID`=$cityID");
	$array = mysqli_fetch_array($result);
	$cityID = $array['cityID'];
	$cityname = $array['name'];
	$lat= $array['lat'];
	$long = $array['long'];
  }
}
//Insert
if(isset($_POST['cit_Insert'])){
	$result = $mysqli->query("INSERT INTO Cities (cityID, name, lat, `long`)
VALUES ($cityID, '$cityname', $lat, $long);");
	$array = mysqli_fetch_array($result);
	$cityID = $array['cityID'];
	$cityname= $array['name'];
	$lat= $array['lat'];
	$long = $array['long'];

}
//Update
if(isset($_POST['cit_Update'])){
	$result = $mysqli->query("UPDATE Cities SET cityID='$cityID', name='$cityname', lat ='$lat', `long`='$long' WHERE cityID='$cityID'");
	$array = mysqli_fetch_array($result);
	$cityID = $array['cityID'];
	$cityname = $array['name'];
	$lat= $array['lat'];
	$long = $array['long'];

}
//Delete
if(isset($_POST['cit_Delete'])){
	$result = $mysqli->query("DELETE FROM `Cities` WHERE `cityID`='$cityID'");
	$array = mysqli_fetch_array($result);
	$cityID = $array['cityID'];
	$cityname= $array['name'];
	$lat= $array['lat'];
	$long = $array['long'];

}


//////////////////////////////////////////////
//Location Table Functions
//////////////////////////////////////////////
//Retrieve Function
if(isset($_POST['loc_Retrieve'])){
 if (empty($_POST["locID"])) {
    $locIDErro = "Location Id is Required";
  } else {
	$result = $mysqli->query("SELECT * FROM `Location` WHERE `locID` = '$locID' ");
	$array = mysqli_fetch_array($result);
	$locID = $array['locID'];
	$cat_id = $array['cat_id'];
	$name = $array['name'];
	$cityid= $array['cityID'];
	$address = $array['address'];
	$phone = $array['phone'];
	$website = $array['website'];
	$hours = $array['hours'];
	$dates = $array['dates'];
	$lats = $array['lat'];
	$lng = $array['lng'];
	$priority = $array['priority'];
	$avgtime=$array['avgtime'];
  }	
}

//Insert
if(isset($_POST['loc_Insert'])){
	$result = $mysqli->query("INSERT INTO Location (locID, name, cityID,address,phone,website,hours,dates,lat,lng,priority,avgtime)
VALUES ('$locID', '$name', '$cityID','$address','$phone','$website','$hours','$dates','$lats','$lng','$priority','$avgtime')");
	$array = mysqli_fetch_array($result);
  $locID = $array['locID'];
	$cat_id = $array['cat_id'];
	$name = $array['name'];
	$cityid= $array['cityID'];
	$address = $array['address'];
	$phone = $array['phone'];
	$website = $array['website'];
	$hours = $array['hours'];
	$dates = $array['dates'];
	$lats = $array['lat'];
	$lng = $array['lng'];
	$priority = $array['priority'];
	$avgtime=$array['avgtime'];
	
	
	
	

}
//Update
if(isset($_POST['loc_Update'])){
	$result = $mysqli->query("UPDATE `Location` SET `locID`=$locID, `cat_id`=$cat_id , `name`='$name' , cityID='$cityID', address='$address', phone='$phone', website='$website', hours='$hours', dates='$dates', lat='$lat', lng='$lng', priority='$priority', avgtime='$avgtime' WHERE `locID`=$locID");
	$array = mysqli_fetch_array($result);
   $locID = $array['locID'];
	$cat_id = $array['cat_id'];
	$name = $array['name'];
	$cityid= $array['cityID'];
	$address = $array['address'];
	$phone = $array['phone'];
	$website = $array['website'];
	$hours = $array['hours'];
	$dates = $array['dates'];
	$lats = $array['lat'];
	$lng = $array['lng'];
	$priority = $array['priority'];
	$avgtime=$array['avgtime'];

}
//Delete
if(isset($_POST['loc_Delete'])){
	$result = $mysqli->query(" DELETE FROM `Location` WHERE `locID`='$locID'");
	$array = mysqli_fetch_array($result);
   $locID = $array['locID'];
	$cat_id = $array['cat_id'];
	$name = $array['name'];
	$cityid= $array['cityID'];
	$address = $array['address'];
	$phone = $array['phone'];
	$website = $array['website'];
	$hours = $array['hours'];
	$dates = $array['dates'];
	$lats = $array['lat'];
	$lng = $array['lng'];
	$priority = $array['priority'];
	$avgtime=$array['avgtime'];
}



//////////////////////////////////////////////
//Members
//////////////////////////////////////////////
//Retrieve Function
if(isset($_POST['member_Retrieve'])){
if (empty($_POST["memberID"])) {
    $memberIDErro = "Member Id is Required";
  } else {
	$result = $mysqli->query("SELECT * FROM `members` WHERE `memberID`=$memberID");
	$array = mysqli_fetch_array($result);
	$memberID = $array['memberID'];
	$username = $array['username'];
	$password= $array['password'];
	$email = $array['email'];
	$active = $array['active'];
	$resetToken = $array['resetToken'];
	$resetComplete = $array['resetComplete'];
  }	
}
//Insert
if(isset($_POST['member_Insert'])){
$result = $mysqli->query("INSERT INTO members (memberID, username, password,email,active,resettoken,resetcomplete)
VALUES ('$memberID', '$username', '$password','$email','$active','$resetToken','$resetComplete')");
	//$result = $mysqli->query("INSERT INTO `members`(`memberID`, `username`, `password`, `email`, `active`, `resetToken`, `resetComplete`) VALUES ($memberID,$username,$password,$email,$active,$resettoken,$resetcomplete)");
	$array = mysqli_fetch_array($result);
	$memberID = $array['memberID'];
	$username = $array['username'];
	$password= $array['password'];
	$email = $array['email'];
	$active = $array['active'];
	$resetToken = $array['resetToken'];
	$resetComplete = $array['resetComplete'];

}
//Update
if(isset($_POST['member_Update'])){
	$result = $mysqli->query("UPDATE `members` SET `memberID`=$memberID,`username`='$username' WHERE `memberID`=$memberID");
	$array = mysqli_fetch_array($result);
	$memberID = $array['memberID'];
	$username = $array['username'];
	$password= $array['password'];
	$email = $array['email'];
	$active = $array['active'];
	$resetToken = $array['resetToken'];
	$resetComplete = $array['resetComplete'];

}
//Delete
if(isset($_POST['member_Delete'])){
	$result = $mysqli->query("DELETE FROM `members` WHERE `memberID`=$memberID");
	$array = mysqli_fetch_array($result);
	$memberID = $array['memberID'];
	$username = $array['username'];
	$password= $array['password'];
	$email = $array['email'];
	$active = $array['active'];
	$resetToken = $array['resetToken'];
	$resetcomplete = $array['resetComplete'];

}


//////////////////////////////////////////////
//SavedTrips Table Functions                  //
/////////////////////////////////////////////
//Retrieve Function
if(isset($_POST['savedtrip_Retrieve'])){
 if (empty($_POST["tripID"])) {
    $tripIDErro =" Trip Id is Required";
	if(empty($_POST["locID"])) {
	 $locIDErro ="Location Id is Required";
	}
  } else {
	$result = $mysqli->query("SELECT * FROM `SavedTrips` WHERE `tripID`=$tripID AND `locID`=$locID");
	$array = mysqli_fetch_array($result);
	$tripID= $array['tripID'];
	$locID = $array['locID'];
	$startTime= $array['startTime'];
	$endTime = $array['endTime'];
	$startDate= $array['startDate'];
	$endDate = $array['endDate'];
  }
}


//Insert
if(isset($_POST['cit_Insert'])){
	$result = $mysqli->query("INSERT INTO `SavedTrips`(`tripID`, `locID`,startTime,endTime,startDate,endDate) VALUES ($tripID,$locID,$startTime,$endTime,$startDate,$endDate)");
	$array = mysqli_fetch_array($result);
	$tripID= $array['tripID'];
	$locID = $array['locID'];
	$startTime= $array['startTime'];
	$endTime = $array['endTime'];
	$startDate= $array['startDate'];
	$endDate = $array['endDate'];

}
//Update
if(isset($_POST['cit_Update'])){
	$result = $mysqli->query("UPDATE `SavedTrips` SET `tripID`='$tripID',`locID`='$locID',`startTime`='$starttime',`endTime`=$endTime,`startDate`='$startDate',`endDate`='$endDate' WHERE `tripID`='$tripID' AND `locID`='$locID'");
	$array = mysqli_fetch_array($result);
    $tripID= $array['tripID'];
	$locID = $array['locID'];
	$startTime= $array['startTime'];
	$endTime = $array['endTime'];
	$startDate= $array['startDate'];
	$endDate = $array['endDate'];

}
//Delete
if(isset($_POST['cit_Delete'])){
	$result = $mysqli->query("DELETE FROM `SavedTrips` WHERE `tripID`='$tripID'");
	$array = mysqli_fetch_array($result);
	$tripID= $array['tripID'];
	$locID = $array['locID'];
	$startTime= $array['startTime'];
	$endTime = $array['endTime'];
	$startDate= $array['startDate'];
	$endDate = $array['endDate'];

}

//////////////////////////////////////////////
//User_Trips Table Functions
//////////////////////////////////////////////
//Retrieve Function
if(isset($_POST['usertrip_Retrieve'])){
	$result = $mysqli->query("SELECT * FROM User_Trips WHERE memberID = '$memberID'");
	$array = mysqli_fetch_array($result);
	$memberID = $array['memberID'];
	$tripID = $array['tripID'];
	$tripName = $array['tripName'];
}
//Insert
if(isset($_POST['usertrip_Insert'])){
	$result = $mysqli->query("INSERT INTO `User_Trips`(`memberID`, `tripID`,'tripName') VALUES ('$memberID','$tripID','$tripName')");
	$array = mysqli_fetch_array($result);
	$memberID = $array['memberID'];
	$tripID = $array['tripID'];
	$tripName = $array['tripName'];

}
//Update
if(isset($_POST['usertrip_Update'])){
	$result = $mysqli->query("UPDATE `User_Trips` SET `memberID`='$memberID',`tripID`='$tripID', 'tripName ='$tripName' WHERE `memberID`='$memberID' AND `tripID`='$tripID'");
	$array = mysqli_fetch_array($result);
	$memberID = $array['memberID'];
	$tripID = $array['tripID'];
	$tripName = $array['tripName'];

}
//Delete
if(isset($_POST['usertrip_Delete'])){
	$result = $mysqli->query("DELETE FROM `User_Trips` WHERE `memberID`='$memberID'");
	$array = mysqli_fetch_array($result);
	$memberID = $array['memberID'];
	$tripID = $array['tripID'];
	$tripName = $array['tripName'];

}

require("includes/header.php");
require("includes/navbar.php");
?>



<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Administration Page</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <style>  
  #tabs{
  position:relative;
  background: rgba(0, 0, 0, .7);
  width: 80%;
  height: 90%;
  margin: 0 auto;
  border: none;
  border-radius: 0;
  top: 0;
  overflow: auto;
  }
  
  .ui-widget-header {
	background: transparent;
	border: none;
  }
  
  #tabs ul li {
	  border: none;
	  padding: 0;
  }
  
  .ui-tabs .ui-tabs-nav .ui-tabs-anchor, .ui-state-active a, .ui-state-active a:link, .ui-state-active a:visited {
	background: black;
	color: white;
  }
  
  .ui-widget-content {
	  color: white;
  }
  
  td {
	  background-color: transparent;
  }
  
  a {
	  cursor: pointer;
  }
  
  .ui-tabs .ui-tabs-nav li.ui-tabs-active .ui-tabs-anchor, .ui-tabs .ui-tabs-nav li.ui-state-disabled .ui-tabs-anchor, .ui-tabs .ui-tabs-nav li.ui-tabs-loading .ui-tabs-anchor {
	  cursor: pointer;
  }
  
.error {
color: #FF0000;
}
  </style>
  <script src="utilities.js"></script>
</head>
<body>
 
<div id="tabs">
  <ul>
    <li><a href="#Category">Category</a></li>
	<li><a href="#Cities">Cities</a></li>
    <li><a href="#Location">Location</a></li>
    <li><a href="#Member">Member</a></li>
    <li><a href="#savedtrips">Saved Trips</a></li>
    <li><a href="#user_trips">User Trips</a></li>
  </ul>
  <div id="Category">
   <h2>Admin Category Page</h2>
	<div>
	  <form name="catForm" action="#Category"   method="POST" >
		  Category Id:<input type="text" name="cat_id"  style="width: 200px; height:30px; border:1px solid #333;" value=<?php echo $cat_id ?>>
		   <span class="error"> <?php echo $cat_idErro;?></span><br>
		  Category Name:<input type="text" name="cat_name" style="width: 200px; height:30px; border:1px solid #333;"  value=<?php echo $cat_name ?>>
		 
	  <br><br><br>
	  <input type="submit" name="cat_Insert" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;"  value="Insert">
	  <input type="submit" name="cat_Update" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;" value="Update">
	  <input type="submit" name="cat_Retrieve" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;" value="Retrieve">
	  <input type="submit" name="cat_Delete" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;" value="Delete">
	  </form>  
      </div>
	  <?php
	$result = $mysqli->query("SELECT * FROM Category");

	 if ($result->num_rows > 0) {
     	echo "<table><tr><th>Category ID</th><th>Category Name</th></tr>";
	     // output data of each row
	     while($row = $result->fetch_assoc()) {
	         echo "<tr><td>" . $row["cat_id"]. "</td><td>" . $row["category_name"]. " </td></tr>";
	     }
     	echo "</table>";
	} else {
      echo "<table><tr><th>Category ID</th><th>Category Name</th></tr>";
 }
 ?>
  </div>
  
  
  <div id="Cities">
   <h2>Admin Cities Page</h2>
	<div>
	  <form action="#Cities"   method="POST" >
		  City Id:<input type="text" name="cityID"  style="width: 200px; height:30px; border:1px solid #333;" value=<?php echo $cityID ?>>
		   <span class="error"> <?php echo $cityIDErro;?></span><br>
		  name:<input type="text" name="cityname" style="width: 200px; height:30px; border:1px solid #333;"  value=<?php echo $cityname?>><br>
		  Latitude:<input type="text" name="lat" style="width: 200px; height:30px; border:1px solid #333;"  value=<?php echo $lat ?>><br>
		  Longitude:<input type="text" name="long" style="width: 200px; height:30px; border:1px solid #333;"  value=<?php echo $long ?>>
	  <br><br><br>
	  <input type="submit" name="cit_Insert" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;"  value="Insert">
	  <input type="submit" name="cit_Update" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;" value="Update">
	  <input type="submit" name="cit_Retrieve" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;" value="Retrieve">
	  <input type="submit" name="cit_Delete" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;" value="Delete">
	  </form>  
      </div>
	   <?php
   
	$result = $mysqli->query("SELECT * FROM Cities");
	$array = mysqli_fetch_array($result);
	$cityID = $array['cityID'];
	$cityname = $array['name'];
	$lat= $array['lat'];
	$long = $array['long'];
	  if ($result->num_rows > 0) {
     echo "<table><tr><th>City ID</th><th>Name</th><th>Latitude</th><th>Longitude</th></tr>";
     // output data of each row
     while($row = $result->fetch_assoc()) {
         echo "<tr><td>" . $row["cityID"]. "</td><td>" . $row["name"]. " </td><td>" . $row["lat"]. " </td><td>" . $row["long"]. " </td></tr>";
     }
     echo "</table>";
	} else {
           echo "<table><tr><th>City ID</th><th>Name</th><th>Latitude</th><th>Longitude</th></tr>";
 }
 ?>
  </div>
  
  <div id="Location">
   <h2>Admin Location Page</h2>
    <div align="center">
    	<table>
       <form action="#Location " method="post">

		<tr><td>Location ID:</td><td><input type="text" name="locID"  style="width: 300px; height:30px; border:1px solid #333;" value=<?php echo $locID ?>></td><td class="error">*<?php echo $locIDErro;?></td></tr>
		  <tr><td>Category ID:</td><td><input type="text" name="cat_id"  style="width: 300px; height:30px; border:1px solid #333;"value=<?php echo $cat_id ?>></td></tr>
		  <tr><td>Name:</td><td><input type="text" name="name" value="<?php echo "$name"; ?>" style="width: 300px; height:30px; border:1px solid #333;"></td></tr>
		  <tr><td>City ID:</td><td><input type="text" name="cityid"  style="width: 300px; height:30px; border:1px solid #333;"value=<?php echo $cityid?>></td></tr>
		  <tr><td>Address:</td><td><input type="text" name="address"  style="width: 300px; height:30px; border:1px solid #333;"value=<?php echo $address ?>></td></tr>
		  <tr><td>Phone:</td><td><input type="text" name="phone"  style="width: 300px; height:30px; border:1px solid #333;"value=<?php echo $phone ?>></td></tr>
		   <tr><td>Website:</td><td><input type="text" name="website"  style="width: 300px; height:30px; border:1px solid #333;"value=<?php echo $website ?>></td></tr>
		  <tr><td>Hours:</td><td><input type="text" name="hours"  style="width: 300px; height:30px; border:1px solid #333;"value=<?php echo $hours ?>></td></tr>
		   <tr><td>Dates:</td><td><input type="text" name="dates"  style="width: 300px; height:30px; border:1px solid #333;"value=<?php echo $dates ?>></td></tr>
		   <tr><td>Latitude:</td><td><input type="text" name="lat"  style="width: 300px; height:30px; border:1px solid #333;"value=<?php echo $lats ?>></td></tr>
		   <tr><td>Longitude:</td><td><input type="text" name="lng"  style="width: 300px; height:30px; border:1px solid #333;"value=<?php echo $lng ?>></td></tr>
		   <tr><td>Priority:</td><td><input type="text" name="priority"  style="width: 300px; height:30px; border:1px solid #333;"value=<?php echo $priority ?>></td></tr>
		   <tr><td>Avgtime:</td><td><input type="text" name="avgtime"  style="width: 300px; height:30px; border:1px solid #333;"value=<?php echo $avgtime ?>>
	  <tr><td colspan="4"><input type="submit" name="loc_Insert" style="margin:10px; width:90px; height:30px; border:1px solid #333;cursor:pointer;" value="Insert"><input type="submit" name="loc_Update" style="margin:10px; width:90px; height:30px; border:1px solid #333;cursor:pointer;"  value="Update"><input type="submit" name="loc_Retrieve"  style="margin:10px; width:90px; height:30px; border:1px solid #333;cursor:pointer;" value="Retrieve"><input type="submit" name="loc_Delete" style="margin:10px; width:90px; height:30px; border:1px solid #333;cursor:pointer;"  value="Delete"></td></tr>
	  </form>  
	</table>
      </div>
	  <div style="position:relative;">
	  	<div style=" height:400px; overflow:auto; margin-top:20px;">
	  <?php
   
	$result = $mysqli->query("SELECT * FROM Location");
	$array = mysqli_fetch_array($result);
	$locID = $array['locID'];
	$cat_id = $array['cat_id'];
	$name = $array['name'];
	$cityid= $array['cityID'];
	$address = $array['address'];
	$phone = $array['phone'];
	$website = $array['website'];
	$hours = $array['hours'];
	$dates = $array['dates'];
	$lats = $array['lat'];
	$lng = $array['lng'];
	$priority = $array['priority'];
	$avgtime=$array['avgtime'];
	  if ($result->num_rows > 0) {
     echo "<table style=\" width:100%;\"><tr><th>LocID</th><th>CatID</th><th>Name</th><th>CityID</th><th>Phone</th><th>Address</th><th>Website</th><th>Hours</th><th>Dates</th><th>Latitude</th><th>Longitude</th><th>Priority</th><th>Average Time</th></tr>";
     // output data of each row
     while($row = $result->fetch_assoc()) {
         echo "<tr style=\"display:table-row\"><td>" . $row["locID"]. "</td><td>" . $row["cat_id"]. " </td><td>" . $row["name"]. " </td><td>" . $row["cityID"]. " </td><td>" . $row["address"]. "</td><td>" . $row["phone"]. "</td><td>" . $row["website"]. "</td><td style=\"max-width: 200px; overflow: auto;\" >" . $row["hours"]. "</td><td>" . $row["dates"]. " </td><td>" . $row["lat"]. " </td><td>" . $row["lng"]. " </td><td>" . $row["priority"]. "</td><td>" . $row["avgtime"]. "</td></tr>";
     }
     echo "</table>";
	} else {
          echo "<table><tr><th>Location ID</th><th>Category ID</th><th>Name</th><th>City ID</th><th>Phone</th><th>Address</th><th>Website</th><th>Hours</th><th>dates</th><th>Latitude</th><th>Longitude</th><th>Priority</th><th>Average Time</th></tr>";
 }
 ?>
  </div>
  </div>
</div>
  
  <div id="Member">
<h2>Admin Member Page</h2>
      <div>
        <form name="memberForm" action="#Member" method="POST">
		  Member ID:<input type="text" name="memberID"  style="width: 200px; height:30px; border:1px solid #333;" value=<?php echo $memberID ?>>
		   <span class="error"> <?php echo $memberIDErro;?></span><br>
		  Username:<input type="text" name="username"   style="width: 200px; height:30px; border:1px solid #333;"value=<?php echo $username ?>><br>
		  Password:<input type="password" name="password"  style="width: 200px; height:30px; border:1px solid #333;" value=<?php echo $password?>><br>
		  Email:<input type="text" name="email"  style="width: 200px; height:30px; border:1px solid #333;" value=<?php echo $email ?>><br>
		  Active:<input type="text" name="active"  style="width: 200px; height:30px; border:1px solid #333;" value=<?php echo $active ?>><br>
		  ResetToken:<input type="text" name="resetToken"  style="width: 200px; height:30px; border:1px solid #333;"value=<?php echo $resetToken ?>><br>
		  Resetcomplete:<input type="text" name="resetComplete"  style="width: 200px; height:30px; border:1px solid #333;"value=<?php echo $resetComplete ?>><br>
	  <br><br><br>
	  <input type="submit" name="member_Insert" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;" value="Insert">
	  <input type="submit" name="member_Update" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;" value="Update">
	  <input type="submit" name="member_Retrieve" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;" value="Retrieve">
	    <!--<input type="button" name="member_Retrieve" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;" value="Retrieve" onclick="putInfo();">  -->
	  <input type="submit" name="member_Delete" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;" value="Delete">
	  </form>  
      </div>
	  
	   <?php
	$result = $mysqli->query("SELECT * FROM members");
	$array = mysqli_fetch_array($result);
	$memberID = $array['memberID'];
	$username = $array['username'];
	$password= $array['password'];
	$email = $array['email'];
	$active = $array['active'];
	$resetToken = $array['resetToken'];
	$resetComplete = $array['resetComplete'];
	  if ($result->num_rows > 0) {
     echo "<table><tr><th>MemberID</th><th>Username</th><th>Password</th><th>Email</th><th>Active</th><th>ResetToken</th><th>Resetcomplete</th></tr>";
     // output data of each row
     while($row = $result->fetch_assoc()) {
         echo "<tr><td>" . $row["memberID"]. "</td><td>" . $row["username"]. " </td><td>" . $row["password"]. " </td><td>" . $row["email"]. " </td><td>" . $row["active"]. "</td><td>" . $row["resetToken`"]. "</td><td>" . $row["resetComplete"]. "</td></tr>";
     }
     echo "</table>";
	} else {
            echo "<table><tr><th>MemberID</th><th>Username</th><th>Password</th><th>Email</th><th>Active</th><th>ResetToken</th><th>Resetcomplete</th></tr>";
 }
 ?>
  </div>
  
  <div id="savedtrips">
   <h2>Admin Saved Trips Page</h2>
	<div>
	  <form action="#savedtrips"   method="POST" >
		  Trip Id:<input type="text" name="tripID"  style="width: 200px; height:30px; border:1px solid #333;" value=<?php echo $tripID ?>>
		  <span class="error"> <?php echo $cat_idErro;?></span><br>
		  Loc Id:<input type="text" name="locID" style="width: 200px; height:30px; border:1px solid #333;" value=<?php echo $locID ?>>
		  <span class="error"> <?php echo $cat_idErro;?></span><br>
		  startTime:<input type="text" name="startTime" style="width: 200px; height:30px; border:1px solid #333;"  value=<?php echo $startTime ?>><br>
		  endTime:<input type="text" name="endTime" style="width: 200px; height:30px; border:1px solid #333;"  value=<?php echo $endTime ?>><br>
		  startDate:<input type="text" name="startDate" style="width: 200px; height:30px; border:1px solid #333;"  value=<?php echo $startDate ?>><br>
		  endDate:<input type="text" name="endDate" style="width: 200px; height:30px; border:1px solid #333;"  value=<?php echo $endDate ?>>
	  <br><br><br>
	  <input type="submit" name="savedtrip_Insert" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;"  value="Insert">
	  <input type="submit" name="savedtrip_Update" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;" value="Update">
	  <input type="submit" name="savedtrip_Retrieve" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;" value="Retrieve">
	  <input type="submit" name="savedtrip_Delete" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;" value="Delete">
	  </form>  
      </div>
	  
	  <?php
	$result = $mysqli->query("SELECT * FROM SavedTrips");
	$array = mysqli_fetch_array($result);
	$tripID= $array['tripID'];
	$locID = $array['locID'];
	$startTime= $array['startTime'];
	$endTime = $array['endTime'];
	$startDate= $array['startDate'];
	$endDate = $array['endDate'];
	  if ($result->num_rows > 0) {
     echo "<table><tr><th>TripID</th><th>Location ID</th><th>Start Time</th><th>EndTIme</th><th>StartDate</th><th>EndDate</th></tr>";
     // output data of each row
     while($row = $result->fetch_assoc()) {
         echo "<tr><td>" . $row["tripID"]. "</td><td>" . $row["locID"]. " </td><td>" . $row["startTime"]. " </td><td>" . $row["endTime"]. " </td><td>" . $row["startDate"]. "</td><td>" . $row["endDate`"]. "</td></tr>";
     }
     echo "</table>";
	} else {
            echo "<table><tr><th>TripID</th><th>Location ID</th><th>Start Time</th><th>EndTIme</th><th>StartDate</th><th>EndDate</th></tr>";
 }
 ?>
  </div>
  
  
    <div id="user_trips">
   <h2>Admin User Trips Page</h2>
	<div>
	  <form action="#user_trips"   method="POST" >
		  Member ID:<input type="text" name="memberID"  style="width: 200px; height:30px; border:1px solid #333;" value=<?php echo $memberID ?>>
		  <span class="error"> <?php echo $cat_idErro;?></span><br>
		  Trip ID:<input type="text" name="tripID" style="width: 200px; height:30px; border:1px solid #333;" value=<?php echo $tripID ?>>
		  <span class="error"> <?php echo $cat_idErro;?></span><br>
		  Trip Name:<input type="text" name="tripName" style="width: 200px; height:30px; border:1px solid #333;" value=<?php echo $tripName?>>
	  <br><br><br>
	  <input type="submit" name="usertrip_Insert" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;"  value="Insert">
	  <input type="submit" name="usertrip_Update" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;" value="Update">
	  <input type="submit" name="usertrip_Retrieve" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;" value="Retrieve">
	  <input type="submit" name="usertrip_Delete" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;" value="Delete">
	  </form>  
      </div>
	   <?php
	$result = $mysqli->query("SELECT * FROM User_Trips");
	$array = mysqli_fetch_array($result);
	$memberID = $array['memberID'];
	$tripID = $array['tripID'];
	$tripName = $array['tripName'];
	  if ($result->num_rows > 0) {
     echo "<table><tr><th>Member ID</th><th>Trip ID</th><th>Trip Name</th></tr>";
     // output data of each row
     while($row = $result->fetch_assoc()) {
         echo "<tr><td>" . $row["memberID"]. "</td><td>" . $row["tripID"]. " </td><td>" . $row["tripName"]. "</td></tr>";
     }
     echo "</table>";
	} else {
       echo "<table><tr><th>Member ID</th><th>Trip ID</th><th>Trip Name</th></tr>";
 }
 ?>
  </div>
  
</div>
</body>
</html>

<!---- -------------------------------    End of code  --------------------------------->



