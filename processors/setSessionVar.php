<?php 
session_start();
$_SESSION['tripName'] = $_POST['tripName'];
$_SESSION['destCity'] = $_POST['destCity'];
$_SESSION['startDate'] = $_POST['startDate'];
$_SESSION['endDate'] = $_POST['endDate'];
?>