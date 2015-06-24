

<head>
<link rel="stylesheet" href="css/style.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/populartrip.js"></script>
</head>
<?php
session_start();

echo test;

$locations=explode("*", $_POST['loc']);

<script>
		console.log("test poptripFunc");
		var obj = <?php echo json_encode($locations); ?>;
		
</script>

?>
