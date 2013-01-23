<?
if(isset($_REQUEST['megoldas']) && md5($_REQUEST['megoldas']) == "662bc1e3cf57f9ea0f70e18cfc138275")
{
	finish_level($level);
	$lvl = $level+1;
	$hiba[] = "Jó megoldás, sok sikert a következő pályán ;-P <a href=\"/level/$lvl\">Level $lvl</a>";
}
if(isset($_REQUEST['megoldas']) && md5($_REQUEST['megoldas']) != "662bc1e3cf57f9ea0f70e18cfc138275")
{
	$hiba[] = "Rossz megoldás, próbáld újra!";
}
?>