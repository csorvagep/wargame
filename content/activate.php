<?php
$msg = array();
try
{
	if(!isset($PARAM))
		tovabb("/fooldal");
	else
		$uid = $PARAM;
	if(isset($_GET['activate']) && $_GET['activate'] == 1 && isset($uid))
	{
		if(activate($uid,trim($_GET['kod'])))
		{
			login($uid,false);
			tovabb("/settings");
		}
		else
		{
			$msg[] = "Hiba történt!, Ellenőrizd a kódot, illetve, hogy megfelelő helyről kerültél-e ide.";	
		}
	}
	$tomb = rekord("activation", "user_id",$uid);
	if($tomb['active'] == 1)
		tovabb("/fooldal");
}
catch(Exception $ex)
{
	$msg[] = $ex->getMessage();
}

$CSS = array();
$SCRIPT = array();

$TITLE = "Aktiválás";

require("content/common/site_header.php");
require("content/common/site_menu.php");
?>
<div id="content">
  <h2>Aktiváció</h2>
  <?
foreach ($msg as $h)
{
	echo "<p class=\"warn\">$h</p>";
}
?>
  <p>Az aktiváló e-mailt elküldtük. Ha egy órán belül nem érkezne meg, akkor írj egy emailt ide: <a href="#">securiteam[kukac]sch.bme.hu</a></p>
  <form action="<? echo $_SERVER['REQUEST_URI']; ?>" method="get">
    <p>Aktiváló kód:
      <input type="text" name="kod" />
      <input type="submit" />
    </p>
    <input type="hidden" name="activate" value="1" />
    <input type="hidden" name="uid" value="<? echo $uid; ?>" />
  </form>
</div>
<?php
	require("content/common/site_footer.php");
?>