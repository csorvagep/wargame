<?
$admin = true;
if( !auth($admin))
    tovabb("/login");

$CSS = array();
$CSS[] = "style/level.css";
$SCRIPT = array();

$TITLE = "Feladatok";

require ("content/common/site_header.php");
require ("content/common/site_menu.php");

require ("content/common/level_round.php");
?>

<div id="content">
	<h1>Missions</h1>
<?
for($j=0; $j<$level_round; $j++)
{
?>
	<table class="level_list">
		<tr>
			<td colspan="5">Level <?=$j+1;?></td>
		</tr>
		<tr>
		<?
        $code = "";
		$pr_str = sprintf("%d-", $j+1);
        for($i = 0; $i < 10; $i++)
        {
            $prefix = "n";
            $class = "undone";
            $sql = sprintf("SELECT * FROM levelstat WHERE user_id='%d' AND level='%s' AND finish > 0", $_SESSION["id"], $mysqli->real_escape_string($pr_str . ($i + 1)));

            if( !$eredmeny = $mysqli->query($sql))
                throw new Exception("SQL Select error: " . $mysqli->error);
            if($eredmeny->num_rows)
            {
                $prefix = "";
                $class = "";
            }
            
            $sql = sprintf("SELECT COUNT(levelstat.id) FROM levelstat INNER JOIN users ON users.user_id = levelstat.user_id WHERE finish <> 0 AND admin = 0 AND level = '%s'", $mysqli->real_escape_string($pr_str . ($i + 1)));
            if( !$eredmeny = $mysqli->query($sql))
                throw new Exception("SQL Select error: " . $mysqli->error);
            $row = $eredmeny->fetch_row();
            

            if($i == 5)
                $code .= "</tr><tr class='even-row'>";
            
            $code .= "<td><a href='/level/". $pr_str . ($i + 1) . "' class='{$class}'>Level " . $pr_str . ($i + 1) . "</a><span><img src='/images/{$prefix}pipa.png' />{$row[0]}</span></td>";
        }
        echo $code;
		?>
		</tr>
	</table>
<? } ?>
</div>
<?
require ("content/common/site_footer.php");
?>
