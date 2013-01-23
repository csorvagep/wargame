<?
header('Content-type: text/plain');
header('Content-Disposition: attachment; filename="captured.dat"');
readfile('levels/files/captured.dat');
?>