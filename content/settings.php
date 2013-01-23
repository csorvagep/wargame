<?php
$msg = array();
try
{
	if(!auth())
		tovabb("/login");
	if(isset($_POST['set']) && $_POST['set'] == "Elküld")
	{
		$b = isset($_POST['chgpass']) && $_POST['chgpass'];
		if(!$b)
			$_POST['pass']="";
		if($_POST['pass'] != $_POST['repass'] && $b)
			$msg[] = "A jelszavak nem egyeznek!";
		if(empty($_POST['fname']))
			$msg[] = "A teljes neved üres, írj be valamit!";
		if(!isset($_POST['koli']) || !$_POST['koli'])
		{
			$_POST['szoba']="";
			$_POST['koli']=0;
		}
		if(!count($msg))
		{
			$user = rekord("users", "user_id", $_SESSION['id']);
			if($_POST['oldpass'] != $user['pass'] && $b)
				$msg[] = "A megadott jelszó nem megfelelő!";
			else
			{
				settings($_POST['pass'],$_SESSION['id'],htmlspecialchars($_POST['fname']),$_POST['koli'],htmlspecialchars($_POST['szoba']),$_POST['sex']);
				tovabb("/user/".$_SESSION['id']);
			}
		}
	}
	if(isset($_GET['avatar']) && $_GET['avatar'] == "del")
	{
		$query = sprintf("SELECT file_path FROM images WHERE user_id = '%d'",$_SESSION['id']);	
		if(!$result = $mysqli->query($query))
			throw new Exception("Hiba történt! Próbáld újra!");
		$row = $result->fetch_row();
		$old_avatar = $row[0];
		unlink("/var/wargame/images/avatar/".$old_avatar);
		
		$query = sprintf("UPDATE images SET filename='%s', mime_type='%s', width='%d', height='%d', file_size='%d', file_path='%s' WHERE user_id='%d'", $mysqli->real_escape_string("nopic.png"), $mysqli->real_escape_string("image/png"), 100, 100, 4163, $mysqli->real_escape_string("avatar.png"), $_SESSION['id']);
		if(!$eredmeny = $mysqli->query($query))
			throw new Exception("Sikertelen törlés. Próbáld újra!".$mysqli->error);
		tovabb("/settings");
	}
	$user = rekord("userdata", "user_id", $_SESSION['id']);
	$avatar = rekord("images", "user_id", $_SESSION['id']);
}
catch(Exception $ex)
{
	$msg[] = $ex->getMessage();
}

$CSS = array();
$CSS[] = "style/settings.css";
$SCRIPT = array();
$SCRIPT[] = "/script/sha1.js";
$SCRIPT[] = "/script/settings.js";

$TITLE = "Beállítások";

require("content/common/site_header.php");
require("content/common/site_menu.php");

?>

<div id="content">
  <h3>Profil szerkesztés</h3>
  <?
foreach ($msg as $h)
{
	echo "<p class=\"warn\">$h</p>";
}
?>
  <div>
    <form method="post" action="<?=$_SERVER['REQUEST_URI'];?>" name="settings" id="setting_form">
      <div id="avatar"><img src="/images/avatar/<?=$avatar['file_path'];?>" />
        <p>Felbontás:
          <?=$avatar['width'];?>
          x
          <?=$avatar['height'];?>
        </p>
        <p>Típus:
          <?=$avatar['mime_type'];?>
        </p>
        <p>Méret: <? printf("%.2f",$avatar['file_size']/1024); ?> kB</p>
        <p><a href="upload" onclick="ujablak(); return false;">Avatar lecserélése</a></p>
        <p><a href="del">Avatar törlése</a></p>
      </div>
      <div class="input-row">
        <label for="fname">Becenév:</label>
        <input type="text" name="fname" id="fname" value="<?=$user['full_name'];?>" />
      </div>
     <div class="input-row">
        <label for="koli">Kollégista vagy?</label>
        <input type="checkbox" name="koli" id="koli" value="1"<?=($user['koli'])?" checked=\"checked\"":"";?> />
      </div>
      <div class="input-row">
        <label for="szoba">Szoba:</label>
        <input type="text" name="szoba" id="szoba" value="<?=$user['szoba'];?>" />
      </div>
      <div class="input-row">
        <label for="sex">Nem:</label>
        <select name="sex" id="sex">
          <option value="0"<?=(!$user['sex'])?" selected=\"selected\"":"";?>>Férfi</option>
          <option value="1"<?=($user['sex'])?" selected=\"selected\"":"";?>>Nő</option>
        </select>
      </div>
      <div class="input-row chpass">
        <label for="chgpass">Jelszó módosítása:</label>
        <input type="checkbox" name="chgpass" value="1" id="chgpass" />
      </div>
      <div class="input-row pw">
        <label for="oldpass">Régi jelszó:</label>
        <input type="password" name="oldpass" id="oldpass" />
      </div>
      <div class="input-row pw">
        <label for="pass">Új jelszó:</label>
        <input type="password" name="pass" id="pass" />
      </div>
      <div class="input-row pw">
        <label for="repass">Új jelszó újra:</label>
        <input type="password" name="repass" id="repass" />
      </div>
      <div class="input-row">
        <input type="submit" name="set" value="Elküld" />
      </div>
    </form>
  </div>
</div>
<?php
	require("content/common/site_footer.php");
?>
