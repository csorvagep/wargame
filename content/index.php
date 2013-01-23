<?php
	
	auth();
	
	$CSS = array();
	$CSS[] = "style/stat.css";
	$SCRIPT = array();
	
	$TITLE = "Főoldal";
	
	require("content/common/site_header.php");
	require("content/common/site_menu.php");
?>

<div id="content">
  <h3>Welcome!</h3>
  <p class="first-line">We would like to welcome you at the first annual wargame of 2012
This little game was created in order to walk You through some basic and more complex problems of information security.
You will receive a username and a password, which you can use to access the tasks.
Should you encounter any problems or difficulties, or find yourself in need for a hint, You may reach Us on Skype chat at securiteam_support.</p><p>
		Good luck and have fun!
	</p>
  <p class="sign">Securiteam</p>
  
</div>
<?php
	require("content/common/site_footer.php");
?>
