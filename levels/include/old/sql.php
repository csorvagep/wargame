<?
if(isset($_REQUEST['megoldas']) && md5($_REQUEST['megoldas']) == "531fbb00bb0f64cb9436012dd3c6e8aa")
{
	finish_level($level);
	$lvl = $level+1;
	$hiba[] = "Jó megoldás, sok sikert a következő pályán ;-P <a href=\"/level/$lvl\">Level $lvl</a>";
}
if(isset($_REQUEST['megoldas']) && md5($_REQUEST['megoldas']) != "531fbb00bb0f64cb9436012dd3c6e8aa")
{
	$hiba[] = "Rossz megoldás, próbáld újra!";
}
?>