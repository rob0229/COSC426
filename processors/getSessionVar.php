<?php 
session_start();
$result = array();
array_push($result, $_SESSION['tripName']); 
array_push($result, $_SESSION['destCity']);
array_push($result, $_SESSION['startDate']);
array_push($result, $_SESSION['endDate']);
echo json_encode($result);
?>