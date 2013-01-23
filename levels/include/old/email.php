<?
if(isset($_REQUEST['megoldas']) && md5(strtolower($_REQUEST['megoldas'])) == "d302b8425d7e63486380fe091747d1a5")
{
	finish_level($level);
	$lvl = $level+1;
	$hiba[] = "Jó megoldás, sok sikert a következő pályán ;-P <a href=\"/level/$lvl\">Level $lvl</a>";
}
if(isset($_REQUEST['megoldas']) && md5(strtolower($_REQUEST['megoldas'])) != "d302b8425d7e63486380fe091747d1a5")
{
	$hiba[] = "Rossz megoldás, próbáld újra!";
}
?>