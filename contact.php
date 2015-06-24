<?php
session_start();
require("includes/database.Class.php");
$db = Database::getInstance();
$mysqli = $db->getConnection();

require("includes/header.php");
require("includes/navbar.php");
?>
<div id="contactwrapper">
  <h2>Get in Touch With Us</h2>
  <p>We'd love to hear from you. You can either reach out to us as a whole and one of our awesome team members will get back to you, or if you have a specific question reach out to one of our staff. We love getting email <em>all day</em>.</p>
  <div id="divbody1" data-section>
  <h3 class="title"><a href="#panel1">Contact Our Company</a></h3>
    <div class=" " data-slug="panel1">
      <form>
        <div class=" ">
          <div class="">
            <label class=" ">Your Name</label>
          </div>
          <div class=" ">
            <input type="text" id="yourName" placeholder="Promise Ebinum">
          </div>
        </div>
        <div class="">
          <div class="">
            <label class=" "> Your Email</label>
          </div>
          <div class=" ">
            <input type="text" id="yourEmail" placeholder="pcebinum@yahoo.com">
          </div>
        </div>
        <label class=" ">Your Message</label><br>
        <textarea rows="4"></textarea><br>
        <button type="submit" class=" ">Submit</button>
      </form>
    </div>
    <div id="div_specific_person">
      <h3 class=" "><a href="#panel2">Specific Person</a></h3>
        <ul class="sec1">
          <li><a href="#">Rob Close<br><img src="http://www.clker.com/cliparts/g/l/R/7/h/u/teamstijl-person-icon-blue.svg" width="100" height="100"></a></li>
          <li><a href="#">Tay<br><img src="http://www.clker.com/cliparts/g/l/R/7/h/u/teamstijl-person-icon-blue.svg" width="100" height="100"></a></li>
          <li><a href="#">Zac<br><img src="http://www.clker.com/cliparts/g/l/R/7/h/u/teamstijl-person-icon-blue.svg" width="100" height="100"></a></li>
          <li><a href="#">Promise<br><img src="http://www.clipartbest.com/cliparts/pc5/eBn/pc5eBnKji.svg" width="100" height="100"></a></li>
        </ul>
      </div>
  </div>
</div>
<?php
require("includes/footer.php");
?>
