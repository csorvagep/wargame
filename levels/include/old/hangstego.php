<?
if(isset($_REQUEST['megoldas']) && md5(strtolower($_REQUEST['megoldas'])) == "ec0e2603172c73a8b644bb9456c1ff6e")
{
	finish_level($level);
	$lvl = $level+1;
	$hiba[] = "Jó megoldás, sok sikert a következő pályán ;-P <a href=\"/level/$lvl\">Level $lvl</a>";
}
if(isset($_REQUEST['megoldas']) && md5(strtolower($_REQUEST['megoldas'])) != "ec0e2603172c73a8b644bb9456c1ff6e")
{
	$hiba[] = "Rossz megoldás, próbáld újra!";
}
?>