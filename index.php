<?php
/* Set to 0 to disable site */
define("ENABLE_SITE", 1);

if(ENABLE_SITE)
{
	require ("content/includes/main_inc.php");
	$URL_MAPPING = array(
		"login" => "content/login.php",
		"fooldal" => "content/index.php",
//		"forum" => "content/forum.php",
//		"signup" => "content/reg.php",
//		"activate" => "content/activate.php",
		"logoff" => "content/logoff.php",
		"level_list" => "content/level_list.php",
		"level" => "levels/index.php",
//		"user" => "content/user.php",
//		"settings" => "content/settings.php",
		"upload" => "content/upload.php",
//		"stat" => "content/stat.php",
		"about-us" => "content/about.php",
//		"links" => "content/links.php",
		"rules" => "content/rules.php",
		"403" => "content/403.php",
		"404" => "content/404.php",
		"users" => "content/teams.php",

		//test
//		"proba" => "content/proba.php"
	);

	$DEFAULT = "fooldal";
	$ERROR_404 = "content/404.php";

	if(isset($_REQUEST['q']))
	{
		$q = $_REQUEST['q'];
		if(strpos($q, "/") !== false)
		{
			$PAGE = substr($q, 0, strpos($q, "/"));
			$PARAM = substr($q, strpos($q, "/") + 1);
		}
		else
		{
			$PAGE = $q;
		}
	}
	else
		$PAGE = $DEFAULT;

	try
	{
		if(array_key_exists($PAGE, $URL_MAPPING))
			require ($URL_MAPPING[$PAGE]);
		else
			require ($ERROR_404);
	}
	catch (Exception $e)
	{
		require ("content/error.php");
	}
}
else
{
	require ("content/index.php");
}
?>
