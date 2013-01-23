<?
$CSS = array();
$CSS[] = "style/level.css";
$SCRIPT = array();

$TITLE = "Level $level";

require ("content/common/site_header.php");
require ("content/common/site_menu.php");
?>
<div id="content">
	<h1>Level
	<?=$level; ?> </h1>
<?
if($solved)
	echo "<p class='solved'>[megoldva]</p>";
?>
	
	<?php
	foreach($hiba as $h)
	{
		echo "<p class=\"warn\">$h</p>";
	}
	print_feladat($level);
	
	$file_name = sprintf("levels/content/%s/%s.php",$group,$level);
	if(file_exists($file_name))
		require ("levels/content/{$group}/" . $level . ".php");
?>
	<form action="<?=$_SERVER['REQUEST_URI'] ?>" method="get">
	<p id="megoldas">
	Solution:
	<input type="text" name="megoldas" />
	<input type="submit" value="Send" />
	</p>
	</form>
</div>
<?
require ("content/common/site_footer.php");
?>