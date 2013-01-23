<?
if(isset($_REQUEST['megoldas']) && md5(strtolower($_REQUEST['megoldas'])) == "12672e79b01e9ca7018105efb0ef871c")
{
	finish_level($level);
	$lvl = $level+1;
	$hiba[] = "Jó megoldás, sok sikert a következő pályán ;-P <a href=\"/level/$lvl\">Level $lvl</a>";
}
if(isset($_REQUEST['megoldas']) && md5(strtolower($_REQUEST['megoldas'])) != "12672e79b01e9ca7018105efb0ef871c")
{
	$hiba[] = "Rossz megoldás, próbáld újra!";
}
?>