<?php
$msg = array();

try
{
	/* Uncomment the following line to diasble the registration */
	//$msg[] = "A regisztráció jelen pillanatban nincs engedélyezve!";

	if(isset($_POST['reg']) && $_POST['reg'] == "Elküld")
	{
		if(!isset($_POST['reg_name']) || empty($_POST['reg_name']))
			$msg[] = "Nem adtál meg felhasználó nevet!";

		if(strlen($_POST['reg_name']) > 25 || strlen($_POST['reg_name']) <= 3)
			$msg[] = "A felhasználónév 4-25 karakter hosszú lehet!";

		if(preg_match('/[^0-9A-Za-z]/', $_POST['reg_name']))
			$msg[] = "Nem érvényes felhasználó név, csak betűt és számot tartalmazhat!";

		if(!isset($_POST['reg_pass']) || empty($_POST['reg_pass']))
			$msg[] = "Nem adtál meg jelszót!";

		if($_POST['reg_pass'] != $_POST['repass'])
			$msg[] = "A jelszavak nem egyeznek!";

		if(!isset($_POST['email']) || empty($_POST['email']))
			$msg[] = "Nem adtál meg e-mail címet!";

		if(strlen($_POST['email']) > 32)
			$msg[] = "Túl hosszú email cím! Maximum 32 karakter!";

		if(!preg_match('/^[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i', trim($_POST['email'])))
			$msg[] = "Nem érvényes e-mail cím!";

		if(!count($msg))
		{
			$tomb1 = rekord("users", "username", $_POST['reg_name']);
			$tomb2 = rekord("users", "email", $_POST['email']);
			if(!empty($tomb1))
				$msg[] = "A megadott felhasználói név foglalt, válassz másikat!";
			//else if(!empty($tomb2))
			//	$msg[] = "A megadott email már regisztrálva van!";
			else
			{
				$user_id = register($_POST['reg_name'], $_POST['reg_pass'], $_POST['email']);
				tovabb("activate/$user_id");
			}
		}
	}
}
catch(Exception $ex)
{
	$msg[] = $ex->getMessage();
}

$CSS = array();
$SCRIPT = array();
$SCRIPT[] = "/script/sha1.js";
$SCRIPT[] = "/script/reg.js";

$TITLE = "Regisztráció";

require ("content/common/site_header.php");
require ("content/common/site_menu.php");
?>
<div id="content">
	<h3>Regisztráció</h3>
	<?
	foreach($msg as $h)
	{
		echo "<p class=\"warn\">$h</p>";
	}
	?>
	<form method="post" action="<?=$_SERVER['REQUEST_URI'] ?>" name="register" id="reg">
	<p class="input_row">Felhasználó név:
	<input type="text" name="reg_name" <?php
	if(isset($_POST['reg_name']))
		echo "value=\"" . htmlentities($_POST['reg_name']) . "\"";
	?> />
	</p>
	<p class="descrip">(a többiek ezt fogják látni, fórumon ezzel a névvel fogsz szerepelni, 4-12 karakter között, csak betű vagy szám)</p>
	<p class="input_row">Jelszó:
	<input type="password" name="reg_pass" id="pass" />
	</p>
	<p class="descrip">(ezzel a jelszóval tudsz belépni, min. 4, max. 12 karakter)</p>
	<p class="input_row">Jelszó újra:
	<input type="password" name="repass" id="repass" />
	</p>
	<p class="descrip">(add meg újra ellenőrzésként)</p>
	<p class="input_row">Email cím:
	<input type="text" name="email"<?php
	if(isset($_POST['email']))
		echo "value=\"" . htmlentities($_POST['email']) . "\"";
	?>  />
	</p>
	<p class="descrip">(ezen a címen érünk el, ha valami probléma adódna, vagy éppen olyan jól teljesítesz) </p>
	<p>
	<input type="submit" name="reg" value="Elküld" />
	</p>
	</form>
</div>
<?php
require ("content/common/site_footer.php");
?>