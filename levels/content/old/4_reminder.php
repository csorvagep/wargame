<?
$msg = array();
try
{
	if(!auth())
		tovabb("/login");
		
	if(isset($_GET['xms-mail']))
	{
		//string escape mentesítés
		$mail = str_replace("\'","'",$_GET['xms-mail']);
		$mail = str_replace("\\\\","\\",$mail);
		
		//  --  Adatbázis kapcsolat  --  //
		mysql_close($kapcsolat);
		$kapcsolat = mysql_connect( "localhost","little", "l1ttl3");
		if (!$kapcsolat)
			throw new Exception("Nem lehet csatlakozni a MySQL-hez");
			
		if(!mysql_select_db("little", $kapcsolat))
			throw new Exception("Nem lehet megnyitni az adatbázist:".mysql_error());
		
		mysql_set_charset("utf8",$kapcsolat);
		//  --  Adatbázis kapcsolat  --  //
		
		$sql = "SELECT login_id, nick_name, passwd, full_name, email FROM little.members WHERE email = '$mail'";
			
		$eredmeny = mysql_query($sql, $kapcsolat);
		if(!$eredmeny)
			throw new Exception("SQL Error: ".mysql_error());
		
		if(!mysql_num_rows($eredmeny))
			$msg[] = "A megadott email nem szerepel az adatbázisban!";
		else
		{
			$tomb = mysql_fetch_array($eredmeny);
			$msg[] = "A belépési adatokat elküldtük erre az email címre: ".$tomb[4];
		}
		
		mysql_close($kapcsolat);
	}
}
catch(Exception $ex)
{
	$msg[] = $ex->getMessage();
}
$TITLE = "Jelszó emlékeztető";
require("content/common/site_rheader.php");
?>
<div id="content">
  <h2>Jelszó emlékeztető küldése:</h2>
<?
foreach ($msg as $h)
{
	echo "<p class=\"warn\">$h</p>\n";
}
?>
  <form action="<?=$_SERVER['REQUEST_URI'];?>" method="get">
    <p>E-mail cím: </p>
    <input type="text" name="xms-mail" width="300" />
    <input type="submit" />
  </form>
  <p><a href="/level/4/">Vissza a feladathoz!</a></p>
</div>
<?
require("content/common/site_rfooter.php");
?>