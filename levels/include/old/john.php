<?
if(isset($_REQUEST['megoldas']) && md5(strtolower($_REQUEST['megoldas'])) == "61db4c23cef2a29204f5656a922ca0a3")
{
	finish_level($level);
	$lvl = $level+1;
	$hiba[] = "Jó megoldás, sok sikert a következő pályán ;-P <a href=\"/level/$lvl\">Level $lvl</a>";
}
if(isset($_REQUEST['megoldas']) && md5(strtolower($_REQUEST['megoldas'])) != "61db4c23cef2a29204f5656a922ca0a3")
{
	$hiba[] = "Rossz megoldás, próbáld újra!";
}
?>