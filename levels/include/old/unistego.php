<?
if(isset($_REQUEST['megoldas']) && md5($_REQUEST['megoldas']) == "8f492b1775085c922276ae0903676df1")
{
	finish_level($level);
	$lvl = $level+1;
	$hiba[] = "Jó megoldás, sok sikert a következő pályán ;-P <a href=\"/level/$lvl\">Level $lvl</a>";
}
if(isset($_REQUEST['megoldas']) && md5($_REQUEST['megoldas']) != "8f492b1775085c922276ae0903676df1")
{
	$hiba[] = "Rossz megoldás, próbáld újra!";
}
?>