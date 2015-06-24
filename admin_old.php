<?php
session_start();
//include config
require_once('includes/config.php'); 
//if logged in redirect to members page
if( !($user->is_logged_in()) || $_SESSION['group_id'] != "2"){
	header("Location: login.php");
} 
//get database connection
require("includes/database.Class.php");
$db = Database::getInstance();
$mysqli = $db->getConnection();

//Category Variables
$cat_id = $_POST['cat_id'];
$cat_name = $_POST['cat_name'];

//Location Variables
$locID = $_POST['locID'];
//already exist in category table
$name = $_POST['name'];
$cityid= $_POST['cityID'];
$address = $_POST['address'];
$phone= $_POST['phone'];
$website = $_POST['website'];
$priority= $_POST['priority'];

//Member Variables
$memberID = $_POST['memberID'];
$username = $_POST['username'];
$password= $_POST['password'];
$email = $_POST['email'];
$active = $_POST['active'];
$resetToken = $_POST['resetToken'];
$resetComplete = $_POST['resetComplete'];


//////////////////////////////////////////////
//Category Table Functions
//////////////////////////////////////////////
//Retrieve Function
if(isset($_POST['cat_Retrieve'])){
	$result = $mysqli->query("SELECT * FROM Category WHERE cat_id = $cat_id");
	$array = mysqli_fetch_array($result);
	$cat_id = $array['cat_id'];
	$cat_name = $array['category_name'];
}
//Insert
if(isset($_POST['cat_Insert'])){
	$result = $mysqli->query("INSERT INTO `Category`(`cat_id`, `category_name`) VALUES ('$cat_id','$cat_name')");
	$array = mysqli_fetch_array($result);
	$cat_id = $array['cat_id'];
	$cat_name = $array['category_name'];

}
//Update
if(isset($_POST['cat_Update'])){
	$result = $mysqli->query("UPDATE `Category` SET `cat_id`=$cat_id,`category_name`='$cat_name' WHERE `cat_id`=$cat_id");
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
//Location Table Functions
//////////////////////////////////////////////
//Retrieve Function
if(isset($_POST['loc_Retrieve'])){
	$result = $mysqli->query("SELECT * FROM `Location` WHERE `locID` = '$locID' ");
	$array = mysqli_fetch_array($result);
	$locID = $array['locID'];
	$cat_id = $array['cat_id'];
	$name = $array['name'];
	$cityid= $array['cityID'];
	$address = $array['address'];
	$phone = $array['phone'];
	$website = $array['website'];
	$priority = $array['priority'];
}
//Insert
if(isset($_POST['loc_Insert'])){



	$result = $mysqli->query("INSERT INTO Location (locID, name, cityID,address,phone,website,priority)
VALUES ('$locID', '$name', '$cityID','$address','$phone','$website','$priority')");
	$array = mysqli_fetch_array($result);
   	$locID = $array['locID'];
   	$cat_id = $array['cat_id'];
	$name = $array['name'];
	$cityid= $array['cityID'];
	$address = $array['address'];
	$phone = $array['phone'];
	$website = $array['website'];
	$priority = $array['priority'];

}
//Update
if(isset($_POST['loc_Update'])){
	$result = $mysqli->query("UPDATE `Location` SET `locID`=$locID, `cat_id`=$cat_id , `name`='$name'  WHERE `locID`=$locID");
	$array = mysqli_fetch_array($result);
    $locID = $array['locID'];
   	$cat_id = $array['cat_id'];
	$name = $array['name'];
	$cityid= $array['cityID'];
	$address = $array['address'];
	$phone = $array['phone'];
	$website = $array['website'];
	$priority = $array['priority'];

}
//Delete
if(isset($_POST['loc_Delete'])){
	$result = $mysqli->query(" DELETE FROM `Location` WHERE `locID`='$locID'");
	$array = mysqli_fetch_array($result);
   	$locID = $array['locID'];
	$name = $array['name'];
	$cityid= $array['cityID'];
	$address = $array['address'];
	$phone = $array['phone'];
	$website = $array['website'];
	$priority = $array['priority'];

}



//////////////////////////////////////////////
//Members
//////////////////////////////////////////////
//Retrieve Function
if(isset($_POST['member_Retrieve'])){
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
require("includes/header.php");
require("includes/navbar.php");
?>

<div class = "admin_background">
    <ul id="tabs">
      <li><a href="#Category">Category</a></li>
      <li><a href="#Location">Location</a></li>
      <li><a href="#Member">Member</a></li>
    </ul>

    <div class="tabContent" id="Category">
	  <h2>Admin Category Page</h2>
	<div>
	  <form action="<?php echo "$PHP_SELF"?>" method="POST">
		  Category Id:<input type="text" name="cat_id"  style="width: 200px; height:30px; border:1px solid #333;" value=<?php echo $cat_id ?>><br>
		  Category Name:<input type="text" name="cat_name" style="width: 200px; height:30px; border:1px solid #333;"  value=<?php echo $cat_name ?>>
	  <br><br><br>
	  <input type="submit" name="cat_Insert" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;"  value="Insert">
	  <input type="submit" name="cat_Update" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;" value="Update">
	  <input type="submit" name="cat_Retrieve" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;" value="Retrieve">
	  <input type="submit" name="cat_Delete" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;" value="Delete">
	  </form>  
      </div>
    </div>

    <div class="tabContent" id="Location">
      <h2>Admin Location Page</h2>
    <div>
       <form action="<?php echo "$PHP_SELF"?>" method="post">
		  Location ID:<input type="text" name="locID"  style="width: 200px; height:30px; border:1px solid #333;" value=<?php echo $locID ?>><br>
		  Category ID:<input type="text" name="cat_id"  style="width: 200px; height:30px; border:1px solid #333;"value=<?php echo $cat_id ?>><br>
		  Name:<input type="text" name="name"  style="width: 200px; height:30px; border:1px solid #333;"value=<?php echo $name ?>><br>
		  City ID:<input type="text" name="cityid"  style="width: 200px; height:30px; border:1px solid #333;"value=<?php echo $cityid?>><br>
		  Address:<input type="text" name="address"  style="width: 200px; height:30px; border:1px solid #333;"value=<?php echo $address ?>><br>
		  Priority:<input type="text" name="priority"  style="width: 200px; height:30px; border:1px solid #333;"value=<?php echo $priority ?>><br>
		  Phone:<input type="text" name="phone"  style="width: 200px; height:30px; border:1px solid #333;"value=<?php echo $phone ?>><br>
		   Website:<input type="text" name="website"  style="width: 200px; height:30px; border:1px solid #333;"value=<?php echo $website ?>>
		  
		 
	  <br><br><br>
	  <input type="submit" name="loc_Insert" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;" value="Insert">
	  <input type="submit" name="loc_Update" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;"  value="Update">
	  <input type="submit" name="loc_Retrieve"  style="width:80px; height:30px; border:1px solid #333;cursor:pointer;" value="Retrieve">
	  <input type="submit" name="loc_Delete" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;"  value="Delete">
	  </form>  
      </div>
    </div>

    <div class="tabContent" id="Member">
      <h2>Admin Member Page</h2>
      <div>
        <form action="<?php echo "$PHP_SELF"?>" method="POST">
		  Member ID:<input type="text" name="memberID"  style="width: 200px; height:30px; border:1px solid #333;"value=<?php echo $memberID ?>><br>
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
	  <input type="submit" name="member_Delete" style="width:80px; height:30px; border:1px solid #333;cursor:pointer;" value="Delete">
	  </form>  
      </div>
    </div>
    <div id="adminBackBtn" class="btn" onclick="back();">Back</div>
 </div>
<?php
require("includes/footer.php");
?>




