<?php
/* Include level related functions and variables */
require ("content/includes/levels.php");
require ("content/common/level_round.php");

/* Check if the user is admin */
$admin = true;
if(!auth($admin))
	tovabb("/login");

/* Check the level parameter */
if(!isset($PARAM) || empty($PARAM))
	tovabb("/level_list");

/* Cut the ending slash */
if($PARAM[strlen($PARAM) - 1] == "/")
	$PARAM = substr($PARAM, 0, strlen($PARAM) - 1);

/* Explode the parameter string */
$query = explode("/", $PARAM);
$level = $query[0];

/* Check if valid level paramter */
$gyufa = array();
if(!preg_match("/^(\d)-(\d+)$/", $level, $gyufa))
	tovabb("/level_list");

$group = $gyufa[1];
$levelno = $gyufa[2];

/* Check if the user has the privilige to do the level */
if(!$admin && $level_round < $group)
	tovabb("/level_list");

/* Initialize the error array */
$hiba = array();

/* Start the level counter if already not started */
$solved = FALSE;
if($level_status = start_level($level))
	$solved = TRUE;

/* Load level related data */
$row = rekord("levels", "level", $level);

/* Check the brute force attempt */
$sql = sprintf("SELECT COUNT(*) FROM loginstat
				WHERE user_id = %d
					AND url LIKE '/level/%s?megoldas=%%'
					AND time > %d", $_SESSION['id'], $level, time() - 300);
if(!$result = $mysqli->query($sql))
	throw new Exception("SQL Error: " . $mysqli->error);
$row2 = $result->fetch_row();

if($row2[0] < 25)
{
	/* Check for solution */
	if(isset($_REQUEST['megoldas']))
	{
		if(md5(strtolower(trim($_REQUEST['megoldas'])) . "asdf") == $row["hash"])
		{
			finish_level($level);
			$hiba[] = "Jó megoldás, sok sikert a következő pályán ;-P <a href=\"/level_list\">Feladatok</a>";
			$solved = TRUE;
		}
		else
		{
			$hiba[] = "Rossz megoldás, próbáld újra!";
		}
	}
}
else
{
	$hiba[] = "5 percenként csak 25 próbálkozásod lehet! Ha küldtél be megoldást, az NEM lett ellenőrizve!";
}
/* Include the level HTML code */
require ("levels/level.php");
?>