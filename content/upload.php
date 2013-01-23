<?php


$msg = array();
$kesz = "";

try
{
	if(!auth())
		throw new Exception("Nem vagy bejelentkezve!");
	if(isset($_POST['upload']) && $_POST['upload'] == "Kép feltöltése")
	{
		if (!array_key_exists('image', $_FILES))
		{
			throw new Exception('Nincs feltöltve fájl!');
		}
	
		$image = $_FILES['image'];
	
		//ellenőrzi hogy teljesen fel lett-e tölve
		valid_upload($image['error']);
	
		if (!is_uploaded_file($image['tmp_name']))
		{
			throw new Exception('Nem egy fájt töltöttél fel!');
		}
	
		$info = getimagesize($image['tmp_name']);
		if (!$info)
			throw new Exception('Nem kép!');
		
		if($info[0] > 500 || $info[1] > 500)
			throw new Exception('A kép mérete túl nagy! Maximum: 500x500!');
		
		if(count($msg) == 0)
		{
			$path = "/var/wargame/images/avatar";
			$username = get_uname_by_id($_SESSION['id']);
			$filename = $username."_".hash("crc32",$image['name'].$username.time());
			if(!move_uploaded_file($image['tmp_name'],"$path/$filename"))
				throw new Exception("Nem sikerült az áthelyezés! Próbáld újra!");
			
			$query = sprintf("SELECT file_path FROM images WHERE user_id = '%d'",$_SESSION['id']);	
			if(!$result = $mysqli->query($query))
				throw new Exception("Hiba történt! Próbáld újra!");
			$row = $result->fetch_row();
			$old_avatar = $row[0];
			
			$query = sprintf("UPDATE images SET filename='%s', mime_type='%s', width=%d, height=%d, file_size=%d, file_path='%s' WHERE user_id=%d",
			$mysqli->real_escape_string($image['name']),
            $mysqli->real_escape_string($info['mime']),$info[0],$info[1],
            $image['size'],
            $mysqli->real_escape_string($filename),$_SESSION['id']);

			$eredmeny = $mysqli->query($query);
			if(!$eredmeny)
				throw new Exception("SQL Upload error:".$mysqli->error);
			
			if(!count($msg))
			{
				if($old_avatar != "avatar.png")
					unlink($path."/".$old_avatar);	
				$kesz = "bakfitty";
			}
		}
	}
}
catch(Exception $ex)
{
	$msg[] = $ex->getMessage();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/style/style.css" rel="stylesheet" type="text/css" />
<title>Avatar feltöltése</title>
<style type="text/css">
#content {
	margin-left:0px;
	background:url(/images/design_05.png) no-repeat 0px 0px;
}
body {
	background-image:none;
	min-height:200px;
}
</style>
<script language="javascript">
<!--
function kilep(){
  setTimeout(function(){
	  window.opener.location.href='/settings';
	  window.close();
  	},1000);
  }
// -->
</script>
</head>

<body <? if($kesz=="bakfitty") echo "onload=\"kilep();\""; ?>>
<div id="content">
<?
foreach ($msg as $h)
{
	echo "<p class=\"warn\">$h</p>";
}
if($kesz!="bakfitty")
{
?>
  <form method="post" action="<?=$_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data">
    <input type="file" name="image" />
    <br />
    <input type="submit" value="Kép feltöltése" name="upload" />
    <input type="hidden" name="MAX_FILE_SIZE" value="50000" />
  </form>
  <? } else { ?>
  <p>A kép feltöltése sikeres!</p>
  <input type="button" value="Bezár" onclick="window.close();" />
  <? } ?>
</div>
</body>
</html>