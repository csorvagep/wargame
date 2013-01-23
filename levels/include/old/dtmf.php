<?
if(isset($_REQUEST['megoldas']) && md5($_REQUEST['megoldas']) == "ae5ada272bed0f5624764682c396fdfb")
{
	finish_level($level);
	$lvl = $level+1;
	$hiba[] = "Jó megoldás, sok sikert a következő pályán ;-P <a href=\"/level/$lvl\">Level $lvl</a>";
}
if(isset($_REQUEST['megoldas']) && md5($_REQUEST['megoldas']) != "ae5ada272bed0f5624764682c396fdfb")
{
	$hiba[] = "Rossz megoldás, próbáld újra!";
}
?>