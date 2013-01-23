<?
$TITLE = "404 - Not Found!";
require("content/common/site_rheader.php");
?>
<div id="content">
<h2>404</h2>
<p>A keresett oldal - <?php echo $_SERVER['REQUEST_URI']; ?> - nem található!</p>
</div>
<?
require("content/common/site_rfooter.php");
?>