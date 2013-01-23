<?php
if(isset($_POST["pws"]) && $_POST["pws"] == "belkin54g")
{
	die("OK");
} else
{
	$r = '								<input type="submit" value="Submit" style="{width:120px;}" class="submitBtn">';
	$x = "\r\n";
	$d = "								<br>";
	echo str_replace($r, "$r$x$d$x$d$x" . '								<font face="Arial" size="3" color="RED"><b>Incorrect Password</b><br>Please confirm your password and try again.</font>', file_get_contents("login.html"));
}
?>