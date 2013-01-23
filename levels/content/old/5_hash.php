<?
//kiszedi az ékezeteket, kisbetűsít
function purgalo($cucc){
	$ekezet=array('á','é','í','ó','ö','ő','ú','ü','ű','Á','É','Í','Ó','Ö','Ő','Ú','Ü','Ű',' ');
	$nelkul=array('a','e','i','o','o','o','u','u','u','A','E','I','O','O','O','U','U','U','');
	$kimenet=strtolower(str_replace($ekezet,$nelkul,$cucc));
	$kimenet = preg_replace("/[^\w]+/i", "", $kimenet );
	return $kimenet;
}
//megfordítja a sztringet
function fordit($cucc){
	return strrev($cucc);
}
//megduplázza a karaktereket
function duplaz($cucc){
	$kimenet="";
	for($i=0;$i<strlen($cucc);$i++){
		$kimenet=$kimenet.$cucc[$i].$cucc[$i];
	}
	return $kimenet;
}
//beszúr egy random karaktert
function beszur($cucc,$szam){
	$kimenet="";
	$y=1;
	for($i=0;$i<strlen($cucc);$i++){
		$x=ord($cucc[$i]);
		if($szam==$y){
		$kimenet=$kimenet.chr(rand(97,122));
		$y=0;
		}
		$y++;
		$kimenet=$kimenet.chr($x);
	}
	return $kimenet;
}
//ceasar kódolás
function caesar($cucc,$mennyi){
	$kimenet="";
	$flag=true;
	for($i=0;$i<strlen($cucc);$i++){
		$x=ord($cucc[$i]);
		if($flag){
			$flag=false;
			$x=$x+$mennyi;
			}
			else{
			$flag=true;
			$x=$x+$mennyi*2;
			}
		if($x>122)
			$x-=26;
		if($x<97 && $x>57)
			$x-=10;
		$kimenet=$kimenet.chr($x);
	}
	return $kimenet;
}
if(isset($_POST['text2']))$text2=$_POST['text2']; else $text2="";

$TITLE = "AHG";
require("content/common/site_rheader.php");
?>
<div id="content">
<h2>Atomated Hash Generator</h2>
<p>
<form method="POST" action="<?=$_SERVER['REQUEST_URI'];?>">
	<input type="text" name="text2" value="<?=$text2;?>" />
	<input type="submit" value="menjen" />
</form>
</p>
<p>
<?php
if($text2 != "") echo "<b>Hash:</b> ".caesar(beszur(duplaz(fordit(purgalo($text2))),3),2);
?>
</p>
</div>
<?
require("content/common/site_rfooter.php");
?>