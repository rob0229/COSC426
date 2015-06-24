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
    <script src="js/controls.js"></script>
	<script src="js/itinerary.js"></script>
    <script src="js/jquery.min.js"></script>
   
	<!--script src="https://maps.googleapis.com/maps/api/js"></script>-->
    <script src="https://maps.gstatic.com/maps-api-v3/api/js/20/4/main.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>



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
