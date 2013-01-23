<?
header('Content-type: audio/mpeg');
header('Content-Disposition: attachment; filename="felvetel.mp3"');
readfile('levels/files/felvetel.mp3');
?>