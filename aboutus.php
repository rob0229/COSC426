<?php
session_start();
require("includes/database.Class.php");
$db = Database::getInstance();
$mysqli = $db->getConnection();


require("includes/header.php");
require("includes/navbar.php");
?>
<div id="container" style="overflow-y: auto; height: 89vh;">
	<div id="div2">
		<h1>Welcome to TravelPlanner</h1>
		<p>Travel Planner is a leading worldwide online travel company 
		that applies advanced engineering to enable leisure and business 
		travelers to search for, plan and book a wide range of travel products
		and services including airline tickets, hotels, auto rentals, cruises,
		and vacation packages. Travel Planner gives users the power to 
		make their dream vacation plan from the best categories each 
		city has to offer without logging in or being a member of the website. 
		 </p>
		 
		  <p>
		  TravelPlanner make it easy to plan your next business or 
		  leisure trip. Explore our site and Facebook page to 
		  discover destination ideas, get information about your trip. 
		  We help everyone, everywhere, plan and purchase everything
		  in travel. We do all the heavy lifting to make your trip planning 
		  easier.
		 </p>
	</div>
	
	<div id="div3">
		<h1>About Us</h1>
		<p>Travel Planner offers customers the fastest, easiest way
		to plan travel. The site saves you time by comparing top travel
		sites so you don't have to. The unique layout makes it easy to
		visually compare results, and pick out what's best for you. 
		Travel Planner offers the most comprehensive travel search,
		bringing in travel options ranging from commercial flights to 
		trains to charter flights and accommodations ranging from
		big hotels to home and apartment leases.
		 </p>
		 </p>
	</div>
</div>
<?php
require("includes/footer.php");
?>