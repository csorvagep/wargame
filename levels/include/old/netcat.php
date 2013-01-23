<?
if(isset($_POST['megold']) && $_POST['megold'])
{
	if (!array_key_exists('megoldas', $_FILES))
	{
		throw new Exception('Nincs feltöltve fájl!');
	}

	$image = $_FILES['megoldas'];

	//ellenőrzi hogy teljesen fel lett-e tölve
	valid_upload($image['error']);

	if (!is_uploaded_file($image['tmp_name']))
	{
		throw new Exception('Nem egy fájt töltöttél fel!(');
	}

	$info = getImageSize($image['tmp_name']);

	if (!$info)
	{
		throw new Exception('Nem megfelelő fájlformátum!');
	}
	
	$original = "/var/telnet/image.jpg";
	
	if(!file_is_same($original,$image['tmp_name']))
		$hiba[] = "Nem jó megoldás, próbáld újra!";
	
	if(count($hiba) == 0)
	{
		finish_level($level);
		$lvl = $level+1;
		$hiba[] = "Jó megoldás, sok sikert a következő pályán ;-P <a href=\"/level/$lvl\">Level $lvl</a>";
	}
}
?>