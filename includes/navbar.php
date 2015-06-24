<?php
$memberID=$_SESSION['memberID'];
?>
 
<div class="slidemenu">

<script src="js/nav.js"></script>

	<div class="icon-close">
	 <img src="http://s3.amazonaws.com/codecademy-content/courses/ltp2/img/uber/close.png">
	</div>
	
	<!-- Menu -->
	<ul>
	<a href="http://rkclose.com/COSC_426_Spring/index.php" class="menuBtn"><li>Home</li></a>
	<a href="http://rkclose.com/COSC_426_Spring/populartrip.php"class="menuBtn"><li>Popular Trips</li></a>
	 
	<?php 
	if(isset($_SESSION['loggedin'])){ ?>
	<a href="http://rkclose.com/COSC_426_Spring/accountinfo.php" class="menuBtn" ><li>Your Account Info</li></a>
	 <li><a class="menuBtn">Your Saved Trips</a>
		<ul>
			<?php
				$result = $mysqli->query("SELECT * FROM User_Trips WHERE memberID = $memberID");
				while($array = mysqli_fetch_array($result)){
					echo "<a href='itinerary.php?tripID=".$array['tripID']."' ><li>".$array['tripName']."</li></a>";
				}
			?>
		</ul>
	 </li>
	<?php } ?>
	<a href="http://rkclose.com/COSC_426_Spring/aboutus.php" class="menuBtn"><li>About Us</li></a>
	<a href="http://rkclose.com/COSC_426_Spring/contact.php"class="menuBtn"><li>Contact</li></a>
	<a href="http://rkclose.com/COSC_426_Spring/donate.php" class="menuBtn"><li>Donations</li></a>
	<a href="http://rkclose.com/COSC_426_Spring/admin.php" class="menuBtn"><li>Admin</li></a>
	 
	</ul>
</div>

<div id="title">
	<div id="webIcon"></div>
	
	<div class="icon-menu">
 	 Menu
 	</div>

	<div id="navIcon"><a href="index.php">TRAVEL PLANNER</a></div>
	<?php 
	if(isset($_SESSION['loggedin'])){ ?>
		<a href="logout.php" class="titleTab">Logout</a>
		<?php
		if($_SESSION['group_id'] == "2"){ 
			echo "<div style='margin-right: 6px;' id=\"adminLink\" class=\"titleTab\">Admin</div>";
		}
		?>
	<?php
	} else{ ?>
		<a id="loginTab" class="titleTab" href="login.php" style="margin-right: 6px;">Log In</a>
		<a id="Register" class="titleTab" href="register.php">Register</a>
		
	<?php }
?>
</div>
