<?php
session_start();
require("includes/database.Class.php");
$db = Database::getInstance();
$mysqli = $db->getConnection();

require("includes/header.php");
require("includes/navbar.php");
?>

<html>
<head>
<style>
</style>
</head>
<head>
  <meta charset="utf-8">
  <title>jQuery UI Slider - Snap to increments</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  $(function() {
    $( "#slider" ).slider({
      value:100,
      min: 1,
      max: 1000,
      step: 1,
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.value );
      }
    });
    $( "#amount" ).val( "$" + $( "#slider" ).slider( "value" ) );
  });
  </script>
</head>
<body>

<div id="background">

<div id="divse">

<form action="" method="POST">
   <h2>1. Select DonationType</h2>
   <input type="radio" name="type1" value="One-Time">One-Time
   <input type="radio" name="type1" value="Monthly">Monthly
   <input type="radio" name="type1" value="Yearly">Yearly
   <br><br>
 <p>
  <label for="amount">Donation amount ($1 increments):</label>
  <input type="text" name="amount" id="amount" readonly style="border:2px; color:#39E360; font-weight:bold;">
</p>
 
<div id="slider"></div>
<hr>

</div>

<div id="divinfo">

<h2>2. Your Information (optional)</h2>
<table>
  <tr>
   <th>Salutation
    <select name="title">
      <option name="title" value="Mr">Mr</option>
      <option name="title" value="Mrs">Mrs</option>
      <option name="title" value="Miss">Miss</option>
      <option name="title" value="Dr">Dr</option>
    </select>
   </th>
 </tr>
 <tr>
     <th>First Name: <input type="text" name="fn"></th>
     <th>Last Name: <input type="text" name="ln"></th>
 </tr>
 <tr>
  <th>Address: <input type="text" name="ad"></th>
  <th>City: <input type="text" name="city"></th>
 </tr>
 <tr>
  <th>State: <input type="text" name="state"></th>
  <th>ZipCode: <input type="text" name="zip"></th>
  </tr>
  <tr>
  <th>Country: <input type="text" name="country"></th>
 </tr>
 <tr>
  <th>Email Address: <input type="text" name="email"></th>
 </tr>
  
</table>
</div>

<hr>

<div id="divpayment">
<h2>3. Payment Information</h2>
<table>
<tr>
     <th>First Name: <input type="text" name="fn1"></th>
     <th>Last Name: <input type="text" name="ln1"></th>
 </tr>
<tr>
     <th>Credit Card Number: <input type="text" name="ccn"></th>
     <th>CVV: <input type="text" name="cvv"></th>
 </tr>
<tr>
    <th>Expiration(mon-year)
  <input type="month" name="exp">
 </tr>
 <tr><th><input type="submit" name="submit"></tr>
 
</table>
</form>
</div>
</div>


 <?php
require("includes/footer.php");
?>


</body>
</html>