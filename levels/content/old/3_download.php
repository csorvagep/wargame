<?
header('Content-type: audio/mpeg');
header('Content-Disposition: attachment; filename="tv_theme_song.mp3"');
readfile('levels/files/tv_theme_song.mp3');
?>