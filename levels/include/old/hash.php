<?
if(isset($_REQUEST['megoldas']) && md5($_REQUEST['megoldas']) == "070ddf3dc3a9497bcdcf6e3d3473664d")
{
	finish_level($level);
	$lvl = $level+1;
	$hiba[] = "Jó megoldás, sok sikert a következő pályán ;-P <a href=\"/level/$lvl\">Level $lvl</a>";
}
if(isset($_REQUEST['megoldas']) && md5($_REQUEST['megoldas']) != "070ddf3dc3a9497bcdcf6e3d3473664d")
{
	$hiba[] = "Rossz megoldás, próbáld újra!";
}
?>