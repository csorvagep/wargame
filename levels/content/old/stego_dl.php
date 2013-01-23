<?
header('Content-type: image/bmp');
header('Content-Disposition: attachment; filename="profile.bmp"');
readfile('levels/files/profile.bmp');
?>