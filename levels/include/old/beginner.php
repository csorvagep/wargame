<?
if(isset($_REQUEST['megoldas']) && md5(strtolower($_REQUEST['megoldas'])) == "badd5b7cafd06cd7c425ebdb29b6f7ea")
{
	finish_level($level);
	$lvl = $level+1;
	$hiba[] = "Jó megoldás, sok sikert a következő pályán ;-P <a href=\"/level/$lvl\">Level $lvl</a>";
}
if(isset($_REQUEST['megoldas']) && md5(strtolower($_REQUEST['megoldas'])) != "badd5b7cafd06cd7c425ebdb29b6f7ea")
{
	$hiba[] = "Rossz megoldás, próbáld újra!";
}
?>