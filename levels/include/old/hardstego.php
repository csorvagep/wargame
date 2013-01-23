<?
if(isset($_REQUEST['megoldas']) && md5($_REQUEST['megoldas']) == "eaa9b08c9718c9e944e8e09ccf855ef0")
{
	finish_level($level);
	$lvl = $level+1;
	$hiba[] = "Gratulálunk, megoldottad az össes feladatot! Nézz egy kis <a href=\"/stat\">statisztikát</a>.";
}
if(isset($_REQUEST['megoldas']) && md5($_REQUEST['megoldas']) != "eaa9b08c9718c9e944e8e09ccf855ef0")
{
	$hiba[] = "Rossz megoldás, próbáld újra!";
}
?>