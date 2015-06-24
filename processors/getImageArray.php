<?php
$files = glob("../images/*.jpg");
$i = 0;
foreach($files as $file){
	$parse[$i] = basename($file);
	$i++;
}
echo json_encode($parse);
?>