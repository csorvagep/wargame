<?


/* Generate activation key */
$characters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
function purify($str)
{
    static $ekezet = array('á', 'Á', 'é', 'É', 'í', 'Í', 'ó', 'Ó', 'ö', 'Ö', 'ő', 'Ő', 'ú', 'Ú', 'ü', 'Ü', 'ű', 'Ű', ' ', '\'', '!', '+', '#', '(', ')', 'ä', ',');
    static $nelkul = array('a', 'a', 'e', 'e', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'u', 'u', '', '', '', '', '', '', '', 'a', '');

    $str = str_replace($ekezet, $nelkul, $str);
    $str = strtolower($str);

    return $str;
}

$CSS = array();
$CSS[] = "";
$SCRIPT = array();
$SCRIPT[] = "";

$TITLE = "Próba";

require ("content/common/site_header.php");
require ("content/common/site_menu.php");
?>
<div id="content">
	<?php
    /*  $lines = file("delta.txt", FILE_IGNORE_NEW_LINES);
     $str = "";
     foreach($lines as $line)
     {
     $t = explode("\t", $line);

     $random_string = "";
     for($i = 0; $i < 8; $i++)
     $random_string .= $characters[mt_rand(0, count($characters) - 1)];

     var_dump($user = purify($t[2]));
     var_dump($pass = $random_string);
     var_dump($email = $t[3]);
     var_dump($fname = $t[2]);
     echo "\n\n";

     //register($user, hash("sha256", $pass), $email, htmlspecialchars($fname));
     $str .= $line."\t".$user."\t".$pass."\r\n";
     }
     file_put_contents("delta_out.txt", $str);*/

     //statistics
     /*$sql = "SELECT COUNT(*), ROUND(time/3600) AS hour FROM `loginstat` GROUP BY
    hour";
     $result = $mysqli->query($sql);
     while($row = $result->fetch_row())
     echo date("Y. n. j.;G:i;",$row[1]*3600).$row[0]."<br />\r\n";*/
     
     $sql = "SELECT ip, username FROM `loginstat` INNER JOIN users ON users.user_id = loginstat.user_id GROUP BY loginstat.ip ";
	 $result = $mysqli->query($sql);
     while($row = $result->fetch_row())
     echo $row[0]."#".$row[1]."<br />\r\n";
	?>
	
	<div id="placeholder" style="width:600px;height:300px"></div>
</div>
<?php
require ("content/common/site_footer.php");
?>