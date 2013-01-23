<?
if(isset($_REQUEST['megoldas']) && md5($_REQUEST['megoldas']) == "c822c1b63853ed273b89687ac505f9fa")
{
	finish_level($level);
	$lvl = $level+1;
	$hiba[] = "Jó megoldás, sok sikert a következő pályán ;-P <a href=\"/level/$lvl\">Level $lvl</a>";
}
if(isset($_REQUEST['megoldas']) && md5($_REQUEST['megoldas']) != "c822c1b63853ed273b89687ac505f9fa")
{
	$hiba[] = "Rossz megoldás, próbáld újra!";
}
?>