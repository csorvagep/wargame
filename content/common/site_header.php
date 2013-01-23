<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$TITLE;?></title>
<link rel="shortcut icon" href="/images/favicon.ico"> 
<link href="/style/style.css" rel="stylesheet" type="text/css" />
<?php
	foreach($CSS as $file)
		echo "<link href=\"/$file\" rel=\"stylesheet\" type=\"text/css\" />\n";
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {
    if($(document).height() <= $(window).height())
    {
        $('#content').height($(window).height()-$('#top').height()-110);
        $('#menu').height($(window).height()-$('#top').height()-30);
    }
    else
    {
        $('#menu').height($(document).height()-$('#top').height()-100);
    }
});
</script>
<?php
	foreach($SCRIPT as $file)
		echo "<script language=\"javascript\" type=\"text/javascript\" src=\"$file\"></script>\n";
?>
</head>
<body>
<div id="page">
<div id="top">
  <div id="bagrad"> </div>
  <div id="ba" onclick="location.href='/fooldal'" title="Securiteam Wargame"> </div>
</div>
<div id="bottom">